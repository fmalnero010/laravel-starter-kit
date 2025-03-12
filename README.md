alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'

docker run --rm -v $(pwd):/app -w /app laravelsail/php82-composer:latest composer install
