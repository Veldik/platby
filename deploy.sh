#!/bin/sh
if [ -f .env ]; then
  export $(echo $(cat .env | sed 's/#.*//g'| xargs) | envsubst)
fi

echo "Deploying $APP_NAME"

# Enter maintenance mode
(docker exec $APP_NAME php artisan down --message 'Platby prochází updatem. Vyzkoušejte to znovu za minutu.') || true
    # Update codebase
    git fetch origin main
    git reset --hard origin/main

    # Install dependencies based on lock file
    docker exec $APP_NAME /usr/local/bin/composer install

    # Migrate database
    docker exec $APP_NAME php artisan migrate --force
# Exit maintenance mode
docker exec $APP_NAME php artisan up

echo "Application $APP_NAME deployed!"
