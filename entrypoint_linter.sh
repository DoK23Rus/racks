#!/bin/sh

FLAKE8_LOG="${LOGS_DIR}flake8_$(date +'%Y-%m-%d_%I-%M-%S').log"
touch $FLAKE8_LOG &&
chmod 666 $FLAKE8_LOG &&
flake8 ./mainapp > $FLAKE8_LOG 2>&1 &&

exec "$@"