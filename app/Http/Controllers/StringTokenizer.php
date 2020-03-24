<?php

namespace App\Http\Controllers;

use App\Jobs\StoreDrafts;
use EUAutomation\GraphQL\Client;
use Illuminate\Support\Facades\Hash;
use Soundasleep\Html2Text;
use Auth;
use Illuminate\Http\Request;

class StringTokenizer extends Controller
{
    public $gResponse;
    public $graphQLURL = "";
    public $client;
    protected $query = "query
                    CleanText(\$input: String!) {
                        clean(text:\$input) {
                                analytics
                                timestamp
                        }
                        cleanPreserve(text:\$input) {
                            analytics
                        }
                        cleanMinimal(text:\$input) {
                                analytics
                        }
                        cleanAscii(text:\$input) {
                                analytics
                        }
                }";
    protected $queryOneR = "query RhetoricalMoves(\$input: String!, \$parameters:String) {
                          moves(text:\$input,parameters:\$parameters) {
                            analytics
                            message
                            timestamp
                            querytime
                          }
                        }";
    protected $queryMoves = "query RhetoricalMoves(\$input: String, \$parameters:String) {
                          moves(text:\$input,parameters:\$parameters) {
                            analytics
                            message
                            timestamp
                            querytime
                          }
                        }";
    protected $queryOneA = "query RhetoricalMoves(\$input: String!) {
                          moves(text:\$input,parameters:{\"grammar\": \"analytic\"}) {
                            analytics
                            message
                            timestamp
                            querytime
                          }
                        }";
    protected $qm       = "query Metrics(\$input: String!) {
                            metrics(text:\$input) {
                                analytics {
                                    wordCount
                    }
                    timestamp
                  }
                }";
    protected $queryTwo = "query Vocab(\$input: String!) {
                        vocabulary(text:\$input){
                                analytics {
                                    unique
                                        terms {
                                            term
                                            count
                                        }
                                }
                                timestamp
                            }
                        }";
    protected $queryTokenise = "query Tokenise(\$input: String!) {
                                    annotations(text:\$input) {
                                        analytics {
                                            original
                                            idx
                                            start
                                            end
                                            length
                                            tokens {
                                                idx
                                                term
                                                lemma
                                                postag
                                            }
                                        }
                                    }
                                }";
    protected $queryMetrics = "query Metrics(\$input: String!) {
                                  metrics(text:\$input) {
                                      analytics {
                                            sentences
                                            tokens
                                            words
                                            characters
                                            punctuation
                                            whitespace
                                            sentWordCounts
                                            averageSentWordCount
                                            wordLengths
                                            averageWordLength
                                            averageSentWordLength
                                      }
                                      timestamp
                                  }
                                }";
    protected $queryExpressions = "query Expressions(\$input: String!) {
                                    expressions(text:\$input) {
                                        analytics {
                                            sentIdx
                                            # AI/2019-06-25: Removing affect analysis
                                            # affect {
                                            #    text
                                            # }
                                            epistemic {
                                                text
                                                startIdx
                                                endIdx
                                            }
                                            modal {
                                                text
                                            }
                                        }
                                    }
                                }";
    // AI/2019-06-25: Removing affect analysis
    // protected $queryAffectExpression = "query Affect(\$input: String, \$parameters:String) {
    //                                 affectExpressions(text:\$input,parameters:\$parameters) {
    //                                     message
    //                                     timestamp
    //                                     querytime
    //                                     analytics {
    //                                         affect {
    //                                             text
    //                                             valence
    //                                             arousal
    //                                             dominance
    //                                             startIdx
    //                                             endIdx
    //                                         }
    //                                     }
    //                                 }
    //                             }";

    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->graphQLURL = env('TAP_API', '') . "/graphql";
        $this->client = new Client($this->graphQLURL);
    }

    public function process(Request $request)
    {
        $results = new \stdClass();
        $draft = new \stdClass;
        if ($request["action"] == 'athanor') {
            $results->athanor = array();
            $tokenisedText = $this->tapTokeniser($request);
            if (count($tokenisedText) > 0) {
                //now go through each text and analyse
                foreach ($tokenisedText as $txt) {
                    $responseTxt = new \stdClass;
                    $responseTxt->str = $txt->original;
                    $tags = $this->rethoMoves($txt->original, $request['grammar']);
                    $responseTxt->raw_tags = count($tags) > 0 ? $tags : array();
                    $responseTxt->tags = implode(', ', $tags);
                    $results->athanor[] = $responseTxt;
                }
            }
        }
        if ($request["action"] == 'tokenise') {
            $tokenisedText = $this->tapTokeniser($request);
            foreach ($tokenisedText as $txt) {
                $results->tokenised[] = $txt->original;
            }
        }
        if ($request["action"] == 'vocab') {
            $results->vocab = $this->analyseVocab($request);
        }
        if ($request["action"] == 'qathanor') {
            $results->athanor = $this->qanalyseAthanor($request);
        }
        if ($request["action"] == 'auto') {
            $results->auto = $this->analyseAuto($request);
            $draft->response = $results->auto;
            $draft->original_text = $request["txt"];
            $draft->feature = '1';
            $draft->document_id = $request["document_id"];
            $draft->user_id = Auth::user()->id;
            StoreDrafts::dispatch($draft)->onConnection('redis');
        }
        return response()->json($results);
    }

    //full text analysis
    protected function analyseAthanor(Request $request)
    {
        $apiResponse = new \StdClass();
        $collection = collect($request['txt']);
        $unique = $collection->unique();
        $unique->values()->all();
        $queryTxt = strip_tags($unique->last());
        $variables = new \stdClass();
        $variables->input = $queryTxt;
        //$split = preg_split('/$\R?^/m', $queryTxt);
        $split = explode('\n', $queryTxt);
        $originalHash = Hash::make($queryTxt);
        $responseHash = '';
        if ($originalHash != $responseHash) {
            //get athanor
            $this->gResponse = $this->client->response($this->queryOneR, $variables);
            if ($this->gResponse->hasErrors()) {
                dd($this->gResponse->errors());
            } else {
                $res = $this->gResponse->moves->analytics;
                $apiResponse = $this->aggregateData($split, $res);
            }
        }
        return $apiResponse;
    }

    protected function analyseAuto(Request $request)
    {
        $apiResponse = new \StdClass();
        //$queryTxt = strip_tags($request['txt']);
        $queryTxt = $this->cleanText($request['txt']);
        $variables = new \stdClass();
        $variables->input = $queryTxt;
        //get athanor
        $this->gResponse = $this->client->response($this->queryOneR, $variables);
        if ($this->gResponse->hasErrors()) {
            dd($this->gResponse->errors());
        } else {
            $apiResponse = $this->gResponse->moves->analytics;
        }
        return $apiResponse;
    }

    protected function analyseVocab(Request $request)
    {
        $apiResponse = new \StdClass();
        $collection = collect($request['txt']);
        $unique = $collection->unique();
        $unique->values()->all();
        // $queryTxt = strip_tags($unique->last());
        $queryTxt = $this->cleanText($unique->last());
        $variables = new \stdClass();
        $variables->input = $queryTxt;
        $split = preg_split('/[.]/', $queryTxt);
        $originalHash = Hash::make($queryTxt);
        $responseHash = '';
        if ($originalHash != $responseHash) {
            //get vocabulary
            $this->gResponse = $this->client->response($this->queryTwo, $variables);
            if ($this->gResponse->hasErrors()) {
                dd($this->gResponse->errors());
            } else {
                $apiResponse = $this->gResponse->vocabulary->analytics;
            }
        }
        return $apiResponse;
    }

    //quick sentence by sentence
    protected function qanalyseAthanor(Request $request)
    {
        $apiResponse = new \StdClass();
        //$queryTxt = strip_tags($request['txt']);
        $queryTxt = $this->cleanText($request['txt']);
        $variables = new \stdClass();
        $variables->input = $queryTxt;
        //get athanor
        $this->gResponse = $this->client->response($this->queryOneR, $variables);
        if ($this->gResponse->hasErrors()) {
            dd($this->gResponse->errors());
        } else {
            $res = $this->gResponse->moves->analytics;
            foreach ($res as $rest) {
                $apiResponse->str = $queryTxt;
                $apiResponse->raw_tags = count($rest) > 0 ? $rest : array();
                $apiResponse->tags = implode(", ", $rest);
            }
        }
        return $apiResponse;
    }

    protected function aggregateData(array $original, array $res)
    {
        $result = new \stdClass();
        $result->responseTxt = [];
        $result->status = false;
        if (!is_array($original) || !is_array($res)) {
            return $result;
        } elseif (count($original) == 0 || count($res) == 0) {
            return $result;
        } else {
            foreach ($original as $key => $txt) {
                $tempTxt = new \stdClass();
                if ($txt != "") {
                    $tempTxt->str = $txt;
                    $tempTxt->tags = "";
                    if (isset($res[$key])) {
                        $tempTxt->tags = $res[$key] != "" ? (implode(", ", $res[$key])) : "";
                    }
                    $result->responseTxt[] = $tempTxt;
                    $result->status = true;
                }
            }
            return $result;
        }
    }

    //full text analyer based on tap tokening and then send it via analyser
    protected function tapTokeniser($request)
    {
        $splitTxt = array();
        $variables = new \stdClass();
        //$variables->input = strip_tags($request['txt']);
        //$replace = str_replace("</p>","\n",trim($request['txt']));
        $variables->input = $this->cleanText($request['txt']);
        //$variables->input = $request['txt'];
        $this->gResponse = $this->client->response($this->queryTokenise, $variables);
        if ($this->gResponse->hasErrors()) {
            dd($this->gResponse->errors());
        } else {
            $splitTxt = $this->gResponse->annotations->analytics;
        }
        return $splitTxt;
    }

    //modified sentence level based on updated tokeniser query
    protected function rethoMoves($text, $grammar)
    {
        $apiResponse = new \StdClass();
        $variables = new \stdClass();
        // $variables->input = strip_tags($text);
        $variables->input = $this->cleanText($text);
        $params = new \StdClass();
        $tags = array();
        //get athanor rethmoves
        if ($grammar == 'reflective') {
            $params->grammar = "reflective";
            $variables->parameters = json_encode($params);
            $this->gResponse = $this->client->response($this->queryMoves, $variables);
        } elseif ($grammar == 'analytical') {
            $params->grammar = "analytic";
            $variables->parameters = json_encode($params);
            $this->gResponse = $this->client->response($this->queryMoves, $variables);

            //$this->gResponse = $this->client->response($this->queryOneA, $variables);
        }

        //$this->gResponse = $this->client->response($this->queryMoves, $variables);

        if ($this->gResponse->hasErrors()) {
            dd($this->gResponse->errors());
        } else {
            $raw_tags = $this->gResponse->moves->analytics;
            foreach ($raw_tags as $tag) {
                $tags = $tag;
            }
        }

        return $tags;
    }

    /*
     * Used to retrive sentence level metrics
     * input: string single sentence
     */
    public function metrics($string)
    {
        $apiResponse = new \StdClass();
        $variables = new \stdClass();
        //$variables->input = strip_tags($string);
        $variables->input = $this->cleanText($string);
        $apiResponse = new \stdClass();
        //get  metrics
        $this->gResponse = $this->client->response($this->queryMetrics, $variables);
        if ($this->gResponse->hasErrors()) {
            $apiResponse = $this->gResponse->errors();
        } else {
            $apiResponse = $this->gResponse->metrics->analytics;
        }
        return $apiResponse;
    }

    /*
     * Used to retrive sentence level metrics
     * input: string single sentence
     */
    public function vocab($string)
    {
        $apiResponse = new \StdClass();
        $variables = new \stdClass();
        //$variables->input = strip_tags($string);
        $variables->input = $this->cleanText($string);
        //get  metrics
        $this->gResponse = $this->client->response($this->queryTwo, $variables);
        if ($this->gResponse->hasErrors()) {
            $apiResponse = $this->gResponse->errors();
        } else {
            $apiResponse = $this->gResponse->vocabulary->analytics;
        }
        return $apiResponse;
    }

    //quick sentence by sentence
    /*
        * Used retrive tags
        * input: string single sentence
        * normally only used for reflective feedback
        * output is an array
    */
    public function quickTapMoves($data)
    {
        $apiResponse = new \StdClass();
        //$queryTxt = $this->cleanText($data['txt']);
        $queryTxt = $data['txt'];
        $variables = new \stdClass();
        $variables->input = $queryTxt;
        //get athanor
        if ($data['grammar'] == 'analytical') {
            $this->gResponse = $this->client->response($this->queryOneA, $variables);
        } elseif ($data['grammar'] == 'reflective') {
            $this->gResponse = $this->client->response($this->queryOneR, $variables);
        }
        if ($this->gResponse->hasErrors()) {
            $apiResponse = $this->gResponse->errors();
        } else {
            $res = $this->gResponse->moves->analytics;
            foreach ($res as $rest) {
                $apiResponse->str = $queryTxt;
                $apiResponse->raw_tags = count($rest) > 0 ? $rest : array();
                $apiResponse->tags = implode(", ", $rest);
            }
        }
        return $apiResponse;
    }

    public function preProcess($data)
    {
        $results = array();
        $tokenisedText = $this->tapTokeniser($data);
        $alreadyTapped = isset($data['currentFeedback']['tap']) ? $data['currentFeedback']['tap'] : array();
        $loop = count($alreadyTapped) > 0 ? true : false;
        $key = false;
        if (count($tokenisedText) > 0) {
            //now go through each text and analyse
            foreach ($tokenisedText as $txt) {
                $responseTxt = new \stdClass;
                $responseTxt->str = $txt->original;
                if ($loop) {
                    $key = array_search($responseTxt->str, array_column($alreadyTapped, 'str'));
                }
                if ($key) {
                    $responseTxt->raw_tags = $alreadyTapped[$key]['raw_tags'];
                    $responseTxt->tags = $alreadyTapped[$key]['tags'];
                } else {
                    $tags = $this->rethoMoves($txt->original, $data['extra']['grammar']);
                    $responseTxt->raw_tags = count($tags) > 0 ? $tags : array();
                    $responseTxt->tags = implode(', ', $tags);
                }
                $results[] = $responseTxt;
            }
        }

        return $results;
    }

    protected function cleanText($string)
    {
        //$pattern = array('/<\/p>/' , '/<br\ \/>/', '/&nbsp;/');
        //$replace = array('\n', '\n', '');
        //$replace = preg_replace($pattern, "\n", $string);
        $replace = Html2Text::convert($string, true);

        $output = str_replace("\n", "[&]", $replace);

        return $output;
    }
}
