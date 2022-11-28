#!/bin/sh

if [ "$DATABASE" = "postgres" ]
then
    echo "Waiting for postgres..."
    while ! nc -z $SQL_HOST $SQL_PORT; do
        sleep 0.1
    done
    echo "PostgreSQL started"
fi

LOG_FILE="/home/app/web/logs/racks_log.log"
touch $LOG_FILE &&
chmod 666 $LOG_FILE &&
echo "\n--------$(date)-COMPOSE-RELOAD--------\n" >> $LOG_FILE &&
python manage.py test &&
flake8 ./mainapp &&
mypy ./mainapp &&
python manage.py flush --no-input &&
python manage.py migrate &&
# Create user for e2e testing
python manage.py shell < user_check.py &&
echo "--------USERS-CREATED--------"
# Create mock data for e2e testing
python manage.py shell < mock_database.py &&
echo "--------MOCK-DATA-ADDED--------"

exec "$@"