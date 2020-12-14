#!/bin/bash

set -euo pipefail  # Bash strict mode

if ! [ -x "$(command -v docker-compose)" ]; then
  echo 'Error: docker-compose is not installed.' >&2
  exit 1
fi

domains=(acawriter.juridisk.net)
rsa_key_size=4096
data_path="/etc/letsencrypt"
email="drift@ub.uio.no" # Adding a valid address is strongly recommended

echo "### Starting nginx in HTTP-only mode ..."
NGINX_SITE=http-only docker-compose up --force-recreate -d nginx
echo
sleep 2

echo "### Requesting Let's Encrypt certificate for $domains ..."
#Join $domains to -d args
domain_args=""
for domain in "${domains[@]}"; do
  domain_args="$domain_args -d $domain"
done

# Select appropriate email arg
case "$email" in
  "") email_arg="--register-unsafely-without-email" ;;
  *) email_arg="--email $email" ;;
esac

docker-compose run --rm certbot certonly --webroot -w /var/www/certbot \
    $email_arg \
    $domain_args \
    --rsa-key-size $rsa_key_size \
    --agree-tos \
    --keep-until-expiring
echo

echo "### Reloading nginx ..."
docker-compose up --force-recreate -d nginx
