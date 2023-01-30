#!/bin/sh

python manage.py flush --no-input &&
python manage.py migrate &&
python manage.py collectstatic --noinput &&
# Create user for e2e testing
python manage.py shell < user_check.py &&
echo "--------USERS-CREATED--------" &&
# Create mock data for e2e testing
python manage.py shell < mock_database.py &&
echo "--------MOCK-DATA-ADDED--------" &&
python manage.py runserver 0.0.0.0:8000

exec "$@"