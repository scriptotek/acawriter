<?php

namespace App\Console\Components\Tap;

use Illuminate\Console\Command;
use App\Services\Analyser;
use EUAutomation\GraphQL\Exceptions\GraphQLMissingData;

class TapLoadTest extends Command
{

    protected $signature = 'dashboard:tap-load-test';

    protected $description = 'Perform TAP load test';

    protected $analyser;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->_testTAP();
    }

    protected function _testTAP()
    {
        $examples = array(
            array(
                'action' => 'fetch',
                'extra' => array(
                    'feature' => 7,
                    'feedbackOpt' => 'a_01',
                    'grammar' => 'analytical',
                    'initFeedback' => false,
                    'storeDraftJobRef' => 'en3p1'
                ),
                'txt' => '<p><strong>What does ‘performance’ mean for Lululemon?</strong></p><p><br></p><p><u>EXECUTIVE SUMMARY</u></p><p><br></p><p>Lululemon Athletica (‘Lululemon’) is an athletic apparel brand that produces high-end products and has expanded globally since its establishment in 1998. Commercial performance is important for the company however Lululemon’s success relies on providing a “consistent, high quality product and guest experience” (Lululemon Athletica 2017 p.5). Therefore, performance for Lululemon can be defined by two factors: </p><p>1. producing high quality merchandise </p><p>2. continuous innovation </p><p><br></p><p><u>I INTRODUCTION </u></p><p><br></p><p>Lululemon is a premium fitness brand that designs and retails ‘healthy lifestyle inspired’ athletic apparel for women, men and children (Lululemon Athletica 2017). Lululemon is a commercial success as attested to in its current operation of 406 stories in over 12 countries. This global expansion has resulted in the continuous increase of net revenue in recent years, with FY17 seeing a 15% rise to $2.3bn from FY16 (Lululemon Athletica 2017). However, academic theory holds that while financial measures are important, organisational performance can be defined through a range of methods as organisations will have different objectives (Rasula, Vuksic &amp; Stemberger 2012). Therefore, to effectively measure ‘performance’ for the Canadian Head Office of Lululemon it is essential to consider how the transformational self-improvement ethos of the company is achieved by analysing non-traditional metrics. The report will first examine Lululemon’s overall objectives and how the company achieves these through business strategies and activities. Drawing from the company’s objective, the report will then define performance for Lululemon using non-traditional metrics. Ultimately, the report will comment on why the aforementioned definition of performance is appropriate for Lululemon.</p><p><br></p><p><u>II ORGANISATIONAL ANALYSIS </u></p><p><br></p><p>Lululemon’s organisational objective is to “produce products which create transformational experiences for people to live happy, healthy, fun lives” (Lululemon Athletica 2017 p.2). This aim is achieved by a threefold competitive strategy of differentiation through quality, innovation and supply chain sustainability. These strategies are achieved through the company’s corporate strategy of a single business with a vertical retail and distribution structure. Additionally, the decentralised leadership model allows store managers to connect with the brand and increase autonomy over individual stores to best implement the company’s objective (Lululemon Athletica 2017; Lululemon Athletica 2018a). Here, retail staff (‘educators’) are under control of store managers, who themselves report to the Retail Executive Vice President. Figure 1 details the organisational structure [Figure removed for AcaWriter].</p><p><br></p><p>Lululemon’s first strategy is the creation of high-quality products. To achieve this strategy it is essential that the fabric, performance and craftsmanship of each product meets a certain standard. Lululemon can meet its quality expectations by increasing internal controls to ensure each product is of a high standard. Further, Lululemon conducts routine quality control inspections to assess if the manufactured product adheres to its quality standards (WWD Staff 2014). The second strategy is Lululemon’s continuous product innovation through a ‘design-led’ vision. Lululemon’s design is a point of differentiation as all fashion-forward products contain ‘innovative functional features’ (Lululemon Athletica 2017). Lululemon’s design team continually conducts market research and seeks inspiration from customers to ensure the products address the needs of users (Lululemon Athletica 2017). This ensures product lines are improved and appealing to customers who value the ‘technical rigor and premium quality’ of the products (Lululemon Athletica 2017).</p><p><br></p><p>Lululemon’s final strategy focuses on improving its supply chain sustainability to retain its position as a market leader with a favourable reputation as this allows the company to create ‘transformational experiences’. Lululemon requires that manufacturers adhere to a code of ethics to ensure practices are environmentally and socially sustainable (Lululemon Athletica 2017). These requirements maintain product quality as unethically produced garments could be of lower quality, damage its reputation and ultimately contradict the company’s objective.</p><p><br></p>'
            ),
            array(
                'action' => 'fetch',
                'extra' => array(
                    'feature' => 6,
                    'feedbackOpt' => 'a_01',
                    'grammar' => 'analytical',
                    'initFeedback' => false,
                    'storeDraftJobRef' => 'sm25eg'
                ),
                'txt' => '<p>Technology is an enabler in providing greater access to justice through its ability to connect people with legal needs to legal assistance, information, and advice. With the increasing popularity of internet-enabled hand held devices and laptop computers, there is a tendency to assume that even the socio-economically vulnerable in our society have access to technology and the skills to use online services with confidence. This is not necessarily the case. </p><p><br></p><p>Examples of the application of technology to provide legal information and assistance include case studies, guides and virtual legal advice clinics. The 2012 Review does not address the role of courts in serving the legal needs of the community. The court system is not regarded as a part of the wider legal assistance services. This omission questions the role of the court in facilitating access to its services, including dispute resolution and trials. It also identified uses of technology to expand the delivery of services, many of which are transferable to an online court. These services include e-access for remote communities, availability outside of business hours, interactive processes and virtual appearances. This essay will discuss uses of technology to expand the delivery of services, many of which are transferable to an online court.</p>'
            ),
            array(
                'action' => 'fetch',
                'extra' => array(
                    'feature' => 10,
                    'feedbackOpt' => 'a_01',
                    'grammar' => 'analytical',
                    'initFeedback' => false,
                    'storeDraftJobRef' => 'x20c1f'
                ),
                'txt' => '<p>It is now widely accepted that timely, actionable feedback is essential for effective learning. In response to this, data science is now impacting the education sector, with a growing number of commercial products and research prototypes providing “learning dashboards”, aiming to provide real time progress indicators. From a human-centred computing perspective, the end-user’s interpretation of these visualisations is a critical challenge to design for, with empirical evidence already showing that ‘usable’ visualisations are not necessarily effective from a learning perspective. Since an educator’s interpretation of visualised data is essentially the construction of a narrative about student progress, we draw on the growing body of work on Data Storytelling (DS) as the inspiration for a set of enhancements that could be applied to data visualisations to improve their communicative power. We present a pilot study that explores the effectiveness of these DS elements based on educators’ responses to paper prototypes.</p>'
            ),
            array(
                'action' => 'fetch',
                'extra' => array(
                    'feature' => 5,
                    'feedbackOpt' => 'a_01',
                    'grammar' => 'analytical',
                    'initFeedback' => false,
                    'storeDraftJobRef' => '6f0l0e'
                ),
                'txt' => '<p><em>Pate, Russell, R., Flynn, Jennifer I., Dowda, M. (2016). Policies for promotion of physical activity and prevention of obesity in adolescence. Journal of Exercise Science &amp; Fitness, 14(2), 47-53.</em></p><p><em>Open Access: </em><a href="https://www.sciencedirect.com/science/article/pii/S1728869X1630154X" target="_blank"><em>https://www.sciencedirect.com/science/article/pii/S1728869X1630154X</em></a></p><p>&nbsp;</p><p>Physical activity provides a wide range of health benefits to children and adolescents. It is clearly documented that higher levels of physical activity are associated with better physical fitness, body composition, bone health, and cardiometabolic risk status in young people. Substantial evidence suggests that physical activity promotes good mental health as well as improved cognition and school performance. Accordingly, public health authorities around the world have adopted physical activity guidelines for children and adolescents, and these recommendations typically call for young people to be active for 60 minutes per day at intensities in the moderate-to-vigorous range.&nbsp;Despite the extensive evidence that physical activity provides adolescents with important health benefits, most children and adolescents in developed nations do not meet the accepted physical activity guideline.</p><p><br></p><p>Concern regarding the physical activity behaviour of young people has been heightened by a remarkable increase in the prevalence of childhood obesity. It is clear that obesity rates are highest in the same nations that manifest the lowest compliance with physical activity guidelines, and mounting evidence shows that low physical activity is a consistent predictor of increased risk for development of overweight and obesity in young people. It seems likely that both low physical activity and high obesity rates in children and adolescents are related to fundamental changes in societies that have had the effect of reducing the demand for physical activity and presenting barriers that reduce physical activity levels. These changes include reductions in active transport, increased time spent using digital devices, and restructuring of the home/family environment. These societal changes represent challenges that will have to be overcome if physical activity levels of contemporary children and adolescents are to be increased.</p><p><br></p><p>This article is intended to present a set of evidence-based initiatives that could be launched as part of a comprehensive public health approach to promoting physical activity and preventing obesity in young people.</p>'
            ),
            array(
                'action' => 'fetch',
                'extra' => array(
                    'feature' => 1,
                    'feedbackOpt' => 'a_01',
                    'grammar' => 'analytical',
                    'initFeedback' => false,
                    'storeDraftJobRef' => 't1q9a'
                ),
                'txt' => '<p>Deakin Crick, R., S. Huang, A. Ahmed-Shafi and C. Goldspink (2015). Developing Resilient Agency in Learning: The Internal Structure of Learning Power.&nbsp;<em>British Journal of Educational Studies,</em>&nbsp;63, (2), pp. 121- 160. Open Access: <a href="http://dx.doi.org/10.1080/00071005.2015.1006574" target="_blank">http://dx.doi.org/10.1080/00071005.2015.1006574</a></p><p><br></p><p>Developing Resilient Agency in Learning: The Internal Structure of Learning Power</p><p> </p><p>Ruth Deakin Crick, Shaofu Huang, Adeela Ahmed Shafi &amp; Chris Goldspink</p><p>ABSTRACT</p><p>Understanding students learning dispositions has been a focus for research in education for many years. A range of alternative approaches to conceptualising and measuring this broad construct have been developed. Traditional psychometric measures aim to produce scales that satisfy the requirements for research; however, such measures have an additional use  to provide formative feedback to the learner. In this article we reanalyse 15 years of data derived from the Effective Lifelong Learning Inventory. We explore patterns and relationships within its practical measures and generate a more robust, parsimonious measurement model, strengthening its research attributes and its practical value. We show how the constructs included in the model link to relevant research and how it serves to integrate a number of ideas that have hitherto been treated as separate. The new model suggests a view of learning that is an embodied and relational process through which we regulate the flow of energy and information over time in order to achieve a particular purpose. Learning dispositions reflect the ways in which we develop resilient agency in learning by regulating this flow of energy and information in order to engage with challenge, risk and uncertainty and to adapt and change positively.</p><p>Keywords: learning dispositions, mindful agency, resilience, learning power</p>'
            ),
            array(
                'action' => 'fetch',
                'extra' => array(
                    'feature' => 8,
                    'feedbackOpt' => 'r_01',
                    'grammar' => 'reflective',
                    'initFeedback' => false,
                    'storeDraftJobRef' => 'vqo86w'
                ),
                'txt' => '<p>As a student and future pharmacist, the past 13 weeks of clinical placement have allowed me to experience many opportunities and provided me with a steep learning curve. One that continues grow even after the completion of Clinical Practice 1. Over the semester, I have learned to overcome personal barriers put up by myself in a new work environment, and external barriers which pharmacists face on a day to day basis with patients are other healthcare professionals. Whilst every problem comes with its own set of obstacles, maintaining and extending professional practice (Domain1, Standard 4 of Standards of Competence) and effective communication (Domain 2, Standard 3 of Standards of Competence) is of utmost importance to a present pharmacist and future pharmacist like myself. Earlier this semester, I reflected on the need to improve on my communication skills especially during counselling sessions to ensure customers satisfaction with services received within the pharmacy. There have been two key events since then where my communication and professionalism were again tested.</p><p>The first incident involved a middle-aged lady asking for a packet of Mersyndol night strength in the 40 pack, which was being used for headaches when Panadol wasn’t therapeutically beneficial. Mersyndol despite being a Schedule 3 (Pharmacist Only) product and one that I have counselled many patients on prior to this incident, the Pharmacist allowed me to counsel the patient provided I relayed the conversation between the patient and I to the pharmacist at the end. During this counselling session, she had mentioned that she was currently on Hormone Replacement Therapy (HRT) and hadn’t been back to the doctors in the past 4 months for a review. Of course, having no therapeutic knowledge I hadn’t realised the importance of this piece of information and failed to relay it onto the supervising pharmacist. The pharmacist, overlooking my counselling from afar, was quick to pick up on my mistake and had mentioned it to me before coming forward and speaking to the patient directly. The patient was told that she could take the Mersyndol for the headaches, however her local doctor was to be consulted for a blood test to ensure her HRT was adequately treating the condition as an imbalance of hormones can cause headaches. Upon reflection, communication was lacking more so than professionalism. There have been many times in the past where I have counselled patients and relayed the information to the pharmacist, which raised many questions in my mind, ones revolving around the thought of whether I too missed relaying vital information in those patient’s cases as well. Being a first-year student, one with limited therapeutic knowledge at this stage, my supervising pharmacist was pleased with my counselling session and brushed off the incident with ease. Whilst the situation wouldn’t have placed the patient in direct harm’s way, to me the feeling was a constant reminder in all my future counselling sessions since that day. Whilst the learning curve is still quite steep, these small situations have pointing out my flaws in communication and the importance in further developing my skill set, especially when relaying messages between staff members. This is an essential skill set to master as a future pharmacist between staff members and patients to ensure the business and protocols run smoothly. While I understand, the process of strengthening and mastering my communication skills won’t occur overnight, with persistence and practice in every aspect of my life, not just work, I hope in the future I can shape myself to become the ideal pharmacist.</p><p>	The second incident was one that tested my professionalism more than my communication. A gentleman had walked into the pharmacy while it was quite busy, with a script for a prescription item that wasn’t covered by PBS. The general protocol for such scripts is to always check the price with the pharmacist and let the customer know to avoid complications, like cancelling of scripts if the product is too expensive, prior to dispensing. I checked the price with the gentleman and asked if that was okay to dispense. The gentleman made quick cynical remarks, which was quite upsetting considering I was following protocol and already quite flustered from the previous high volume influx of customers. At this stage, I was annoyed and frustrated, and hoping that I had controlled my dismay enough for the gentleman not to realise. Following the processing of the script, the gentleman handed me a bag of loose medication and 2 Webster packs. He proceeded to tell me that his father was in hospital near the late stages, and wanted the Webster packs to be put on hold until further notice. Immediately, my face dropped and I tried to comfort him with words and assured him that I’d let the pharmacist know of such matters. I felt bad for the gentleman and terrible that I jumped to conclusions and assumed the worst of him. It was a situation that hit close to home, and reminded me of the time when emotions were running high for my family and I when a close family member was in a critical condition at hospital only a few years ago. During times of emotional stress, feelings become overwhelming and rash behaviours have a way of coming out unfiltered. At the time, whilst I tried to remain composed and professional in front of the man, jumping to conclusions was something I couldn’t help but do. It also took me back to the Aboriginal Health Lecture in Introduction to Pharmacy, where the lecturers were discussing how a lot of things are assumed by the public and health professionals in terms of Aboriginal patients and the way they use the health system. A few points they had made during this lecture, was to always start a conversation. Communicate. Be professional. This isn’t restricted to Indigenous people, but rather a lesson for everyone. One that benefits every individual in every profession. Relating back to the situation I faced with the gentleman, there were certain improvements I could’ve made, like perhaps ignore the comments and continue with the task at hand if it’s the right thing to do. It is human to make assumptions, but to learn from them and trying not do it again, is something I need to work on in order to become a best practice health practitioner. This improvement is not something I hope to fix just at work, but rather in all aspects of my life. Looking back on the whole situation, there are so many point of views to draw on and pick up both positive and negative aspects of the interaction. Positive being I was doing my job, as per the protocols set by the pharmacy and negative being the way I handled the situation in my head. Both points have vital learning points as a future pharmacist, which I hope to carry on and improve in my future endeavour as a student and a professional pharmacist.&nbsp;</p><p>	Conclusively, both the positive and negative experiences throughout the semester have allowed me to change my perceptions and to leave room for justifications of each patient’s situation and behaviour on any given day. As health professionals, it is our job and duty to ensure patients are able to confide in us to assist them with all their medical and health-related needs. In order to do this effectively, pharmacists are required to closely follow the Standard of Competencies. For myself, I hope to maintain and extend professional practice in any given situation, good or bad, and engage in effective communication to benefit the delivery of patient care. Overall, Clinical Practice 1 has come with its highs and very little lows in comparison which is why I am excited to see what Clinical Practice 2. 3 and 4 will behold.</p>'
            ),
            array(
                'action' => 'fetch',
                'extra' => array(
                    'feature' => 8,
                    'feedbackOpt' => 'r_01',
                    'grammar' => 'reflective',
                    'initFeedback' => false,
                    'storeDraftJobRef' => 'flderq'
                ),
                'txt' => '<p>Prior to starting my clinical placement, I honestly had no idea what sort of challenges I would have to face in a Community Pharmacy setting. It has essentially provided me with a perspective of the expectations of a pharmacist as a health care professional. I personally saw it as a journey which exposed my strengths and weaknesses. I saw my preceptor as someone who guided me to help address my weaknesses. However, I began to realise that this was only to a certain extent. The most important thing I learnt from these experiences is that I can only develop my skills if I actively contribute to the pharmacy by demonstrating initiative. This initiative was a product of my inner passion and motivation to practise as a pharmacist in future. Various encounters along my journey proved to me that every day presents with a new challenge. I initially could not comprehend just how diverse the members of the community were, particularly in regards to their health issues and understanding of their condition. I found that my clinical placement allowed me to see things from a perspective that I would never have imagined. In order to illustrate these notions, I have decided to reflect upon two major ideas.</p><p>Effective patient communication was a skill I had significantly developed during my clinical placement. A specific example was when I dispensed rosuvastatin for a patient. It was one of the first weeks of clinical placement and by this time I had become quite efficient at the dispensing process. A female patient came in with a script for rosuvastatin. Once I had dispensed this medication, I literally just handed it to her without counselling her as I felt extremely nervous. She told me that she was a bit concerned because this was the first time she was about to start taking a cholesterol-lowering drug. I immediately felt embarrassed and unprofessional. I immediately froze as I dwelled upon the fact that I didn’t take a patient-centred approach. I had previously learnt in the subject Introduction to Pharmacy that the profession is evolving to put a strong emphasis on patient-centred care and disease state management (DSM) to ensure optimal therapeutic outcomes. However, at this moment I recall feeling quite disappointed. At this stage, my preceptor took over and was counselling the patient. I observed how he had established rapport with the patient through use of an empathetic tone, appropriate hand gestures and active listening. I recall feeling quite impressed by this counselling session as I noticed a complete change in the patient’s demeanour.&nbsp;</p><p>Thus, I discovered that the mixed feelings I had experienced ultimately had a strong impact on my learning experience. The fact that I had felt embarrassed and disappointed made me realise that I should always demonstrate empathy and effective communication with a patient. Moreover, the fact that I had felt impressed by my preceptor’s professional skills had strongly motivated me to work my way towards becoming an effective communicator. My previous experience working in a supermarket encouraged me to take a profit-based perspective. The main emphasis was selling a specific product for the gain of the organisation, not the consumer. However, I came to a realisation that this perspective is extremely inappropriate as a pharmacist. What I can safely say is that when taking this into consideration, I have arrived at a new perspective. I now realise that having a profit-based perspective in a community pharmacy setting can potentially be detrimental to a patient’s health and well-being. If in future, I didn’t address a concerned patient who had just started taking a new medication, it may have possibly affected their understanding of why they are taking their medication and also their adherence. This would have ultimately limited the potential for optimal therapeutic outcomes for the patient. Thus, this experience taught me that in future, I must take a patient-centred approach. I must spend time addressing the patients concerns and demonstrate excellent communication with them so they can fully understand their clinical picture and history. This relates to Domain 2: Communication and Collaboration, Standard 4: Apply Interpersonal Communication Skills to Address Problems, which is a standard in the National Competency Standards Framework for Pharmacists in Australia (2016). The incident has taught me to use a whole range of communication techniques when counselling a patient. It gave me the opportunity to practice this sort of behaviour in my subsequent weeks of clinical placement. It has strongly encouraged me to shift my perspective to one that focuses more on patient-centred care. I personally think that this is crucial in ensuring that a patient’s health objectives are met. This standard I have obtained is important for any practising pharmacist.</p><p>Another major concept that my clinical placement taught me was to comply with certain ethical principles for pharmacists. To illustrate this, I have decided to reflect upon a certain ethical dilemma which had occurred in my second last week of clinical placement. A 20-year-old male patient previously came in for a script for fluoxetine. The mother had come in a few days later and wanted to discuss her son’s issue with the pharmacist as she was unaware that her son was taking this medication. However, the pharmacist mentioned that there was a confidentiality issue with her request as her son was above the age of 18. He demonstrated some empathy towards the mother of the patient and suggested possible strategies around this issue, which still ensured there was no ethical misconduct. However, the mother of the patient left dissatisfied from the encounter. I initially felt quite sorry and concerned for the mother of the patient. I also recall thinking that this was an unfair decision made by the pharmacist as the mother had a right to know as this was her son.&nbsp;I had never previously given thought to this idea, as I thought a patient’s medications and medical conditions are fine to discuss with other family members. These feelings really challenged my beliefs and made me think deeply about whether or not my initial views were correct. I previously held a view that patients would want to let their family members know about their condition. I had probably developed this view as my mother suffers from chronic pain, and she personally doesn’t have any problem with her family members knowing.&nbsp;What I had learnt from this experience is that each patient has a set of rights, including the right to keep their clinical picture private. On a more fundamental level, when I compared my previous set of knowledge with the new knowledge obtained, I had come to a realisation that each patient is unique and has their own personal thoughts and opinions. If I didn’t experience this event, I may not have considered confidentiality on an individual level, and thus could have easily breached someone’s privacy. Thus, this could have potentially lead to ethical misconduct and inappropriate practice as a pharmacist. This experience has taught me to always ensure that I practice ethically and not make any assumptions about patients. It also has motivated me to protect the patient’s privacy and respect their rights. I should never discuss a patient’s certain clinical picture with anyone besides the patient themselves and other health care professionals who are also treating the patient. This relates to Domain 1: Professionalism and Ethics, Standard 2: Observe and Promote Ethical Standards, which is a standard in the National Competency Standards Framework for Pharmacists in Australia (2016). I should always maintain a high degree of privacy with patients as this is a fundamental right that they have. Failing to do so is an ultimate breach of their confidentiality, and thus holds a pharmacist accountable for improper practice.</p><p>My journey has helped me to develop professional and ethical behaviour and effective communication skills. I believe that these new standards I have obtained will ultimately help me to develop into a pharmacist that complies with specific expectations that encompass behaviours of health care professionals. Moreover, it has given me the groundwork to further enhance my knowledge, skills and perspectives in order to comply with the evolving profession of Pharmacy.</p>'
            ),
            array(
                'action' => 'fetch',
                'extra' => array(
                    'feature' => 2,
                    'feedbackOpt' => 'r_01',
                    'grammar' => 'reflective',
                    'initFeedback' => false,
                    'storeDraftJobRef' => '4xc3ta'
                ),
                'txt' => '<p>The overall objective of the project was to get real life experience related to load calculations of practical situations. Latent and sensible load had to be calculated including all the real-world possibilities and safety factors. In this project, the calculations of heating and cooling loads of a newly built building are performed. The building comprises of two floors. Ground floor has three sections and first floor has two sections. VRV (Variable Refrigerant Volume) units as air-conditioning were chosen for each level. Other than this, a couple of suggestions were made on reduction of load and increasing the air-conditioning capacity.</p><p><span style="background-color: transparent; color: rgb(0, 0, 0);">-----Engineering copy from </span><a href="https://www.ukessays.com/essays/engineering/reflective-essay-engineering-4683.php" target="_blank" style="background-color: transparent; color: rgb(17, 85, 204);">https://www.ukessays.com/essays/engineering/reflective-essay-engineering-4683.php</a></p><p><br></p>'
            ),
            array(
                'action' => 'fetch',
                'extra' => array(
                    'feature' => 2,
                    'feedbackOpt' => 'r_01',
                    'grammar' => 'reflective',
                    'initFeedback' => false,
                    'storeDraftJobRef' => 'j0g67'
                ),
                'txt' => '<p><span style="background-color: transparent;">Firstly, the most obvious thing that I discovered was the advantage of working as part of a group. I learned that good teamwork is the key to success in design activities when time and resources are limited. As everyone had their own point of view, many different ideas could be produced and I found the energy of group participation made me feel more energetic about contributing something.</span></p><p><span style="background-color: transparent;">Secondly I discovered that even the simplest things on earth could be turned into something amazing if we put enough creativity and effort into working on them. With the Impromptu Design activities we used some simple materials such as straws, string, and balloons, but were still able to create some \'cool stuff\'. I learned that every design has its weaknesses and strengths and working with a group can help discover what they are. We challenged each other\'s preconceptions about what would and would not work. We could also see the reality of the way changing a design actually affected its performance.</span></p><p><span style="background-color: transparent; color: rgb(0, 0, 0);">-----Engineering Design Report copy from </span><a href="https://student.unsw.edu.au/examples-reflective-writing" target="_blank" style="background-color: transparent; color: rgb(17, 85, 204);">https://student.unsw.edu.au/examples-reflective-writing</a></p>'
            ),
        );

        $this->analyser = new Analyser();
        $count = 0;
        while ($count < 10) {
            $start_batch = microtime(true);
            foreach ($examples as $example) {
                $start = microtime(true);
                try {
                    $this->analyser->preProcess($example);
                }
                catch (GraphQLMissingData $e) {
                    print "Error: {$e->getMessage()}\n";
                }
                $end = microtime(true);
                $time = number_format(($end - $start), 2);
                print "Completed in {$time}\n";
            }
            $end_batch = microtime(true);
            $time = number_format(($end_batch - $start_batch) / 9, 2);
            print "AVERAGE: {$time}\n";
            $count++;
        }
    }

    protected function _testAthanor()
    {
        $start = microtime(true);
        //The url you wish to send the POST request to
        $url = 'http://athanor.utscic.edu.au/v2/analyse/text/rhetorical?grammar=reflective';

        $text = "As a student and future pharmacist, the past 13 weeks of clinical placement have allowed me to experience many opportunities and provided me with a steep learning curve>
        One that continues grow even after the completion of Clinical Practice 1.
        Over the semester, I have learned to overcome personal barriers put up by myself in a new work environment, and external barriers which pharmacists face on a day to day basis with patients are other healthcare professionals.
        Whilst every problem comes with its own set of obstacles, maintaining and extending professional practice (Domain1, Standard 4 of Standards of Competence) and effective communication (Domain 2, Standard 3 of Standards of Competence) is of utmost importance to a present pharmacist and future pharmacist like myself.
        Earlier this semester, I reflected on the need to improve on my communication skills especially during counselling sessions to ensure customers satisfaction with services received within the pharmacy.
        There have been two key events since then where my communication and professionalism were again tested.";

        $text = str_repeat($text, 8);

        $strings = array($text);
        //$strings = explode('.', $text);

        foreach ($strings as $string) {
            //open connection
            $ch = curl_init();

            //set the url, number of POST vars, POST data
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $string);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));

            //So that curl_exec returns the contents of the cURL; rather than echoing it
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            //execute post
            $result = curl_exec($ch);
            echo $result . "\n";
        }

        $end = microtime(true);
        $time = number_format(($end - $start), 2);
        print "Completed in {$time}\n";
    }
}
