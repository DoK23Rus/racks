#!/bin/sh

MYPY_LOG="${LOGS_DIR}mypy_log.log"
FLAKE8_LOG="${LOGS_DIR}flake8_log.log"
UNITTESTS_LOG="${LOGS_DIR}unittests_log.log"
touch $MYPY_LOG $FLAKE8_LOG $UNITTESTS_LOG &&
chmod 666 $FLAKE8_LOG $MYPY_LOG $MYPY_LOG &&
echo "\n--------$(date)-COMPOSE-RELOAD--------\n" | tee -a $MYPY_LOG $FLAKE8_LOG $UNITTESTS_LOG &&
coverage run manage.py test >> $UNITTESTS_LOG 2>&1 &&
python -m coverage report >> $UNITTESTS_LOG 2>&1 &&
python -m coverage html --directory=static/ &&
flake8 ./mainapp >> $FLAKE8_LOG 2>&1 &&
mypy ./mainapp >> $MYPY_LOG 2>&1 &&
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