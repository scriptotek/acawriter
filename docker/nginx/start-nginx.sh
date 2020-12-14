#!/bin/sh

set -euo pipefail  # Bash Strict Mode

NGINX_SITE="${NGINX_SITE:=https}"
CERTBOT_DIR=/etc/letsencrypt

echo "Starting nginx using $NGINX_SITE.conf"

if [ ! -f $CERTBOT_DIR/options-ssl-nginx.conf ]; then
  echo Fetching options-ssl-nginx.conf
  curl -s https://raw.githubusercontent.com/certbot/certbot/master/certbot-nginx/certbot_nginx/_internal/tls_configs/options-ssl-nginx.conf > $CERTBOT_DIR/options-ssl-nginx.conf
fi

if [ ! -f $CERTBOT_DIR/ssl-dhparams.pem ]; then
  echo Fetching ssl-dhparams.pem
  curl -s https://raw.githubusercontent.com/certbot/certbot/master/certbot/certbot/ssl-dhparams.pem > $CERTBOT_DIR/ssl-dhparams.pem
fi

# Activate site
rm -f /etc/nginx/conf.d/default.conf
ln -s /etc/nginx/conf.available/$NGINX_SITE.conf /etc/nginx/conf.d/default.conf

exec nginx -g 'daemon off;'

