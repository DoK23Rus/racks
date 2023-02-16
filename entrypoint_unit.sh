#!/bin/sh

UNITTESTS_LOG="${BASE_APP_DIR}${LOGS_PATH}unittest_$(date +'%Y-%m-%d_%I-%M-%S').log"
touch $UNITTESTS_LOG &&
chmod 666 $UNITTESTS_LOG &&
coverage run manage.py test > $UNITTESTS_LOG 2>&1 &&
python -m coverage report >> $UNITTESTS_LOG 2>&1 &&
python -m coverage html --directory=static/ &&

exec "$@"