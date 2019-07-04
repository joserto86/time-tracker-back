#!/bin/sh

SYMFONY_COMMAND="/opt/symfony/bin/console cache:clear"
DOCKER_NAME="skeleton-fpm"

echo "php-fpm is Up ?"

docker ps | grep $DOCKER_NAME > /dev/null 2>&1
if [ $? -eq 0 ]
then
    for i in $(docker ps | grep $DOCKER_NAME | awk '{print $1}')
    do
        echo "php-fpm is " $i
        docker ps | grep php-fpm | awk '{print $1}' > /dev/null 2>&1
        if [ $? -eq 0 ]
        then
            echo "#####################################"
            echo "Command started in: " $i
            docker exec $i bash -c "php -d memory_limit=-1 $SYMFONY_COMMAND"
            echo "#####################################"
        else
            echo "PHP-FPM container died or not running now. Exiting..."
        fi
    done
else
    echo "$DOCKER_NAME not found. Exiting..."
    exit;
fi
