#!/bin/sh

UNITTESTS_LOG="${LOGS_DIR}unittest_$(date +'%Y-%m-%d_%I-%M-%S').log"
touch $UNITTESTS_LOG &&
chmod 666 $UNITTESTS_LOG &&
coverage run manage.py test > $UNITTESTS_LOG 2>&1 &&
python -m coverage report >> $UNITTESTS_LOG 2>&1 &&
python -m coverage html --directory=static/

exec "$@"