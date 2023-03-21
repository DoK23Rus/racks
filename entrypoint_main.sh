#!/bin/sh

# Disable server logging to console for pdb debugging
grep -nr --exclude-dir=entrypoints "breakpoint()"
if [ $? -eq 0 ]
then
    sed -i "s/'disable_existing_loggers': False/'disable_existing_loggers': True/g" ./racks/settings.py
fi

python manage.py flush --no-input &&
python manage.py makemigrations &&
python manage.py migrate &&
python manage.py collectstatic --noinput &&
python manage.py createsuperuser \
    --noinput \
    --username $DJANGO_SUPERUSER_USERNAME \
    --email $DJANGO_SUPERUSER_EMAIL &&
# Create user for e2e testing
python manage.py shell < create_users.py &&
echo "--------USERS-CREATED--------" &&
# Create mock data for e2e testing
python manage.py shell < mock_database.py &&
echo "--------MOCK-DATA-ADDED--------" &&

python manage.py runserver 0.0.0.0:$BACKEND_PORT

exec "$@"