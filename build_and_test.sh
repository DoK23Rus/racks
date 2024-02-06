#!/bin/bash

# ENVs for docker-compose.test
PHP_UID="$(id -u)"
PHP_GID="$(id -g)"
NET=0.0.0.0
PHPSTAN_MEM_LIMIT="512M"
BACKEND_TESTING_PORT=81
FRONTEND_TESTING_PORT=8081
SE_EVENT_BUS_PUBLISH_PORT=4442
SE_EVENT_BUS_SUBSCRIBE_PORT=4443
SELENIUM_HUB_PORT=4444
API_VERSION="v1"
NUMBER_OF_THREADS=2
SHM_SIZE="1gb"
SELENIUM_USER="selenium"
SELENIUM_PASS="sel_testing"
SUITE_NAME="Smoke_tests"

export PHP_UID
export PHP_GID
export NET
export PHPSTAN_MEM_LIMIT
export BACKEND_TESTING_PORT
export FRONTEND_TESTING_PORT
export SE_EVENT_BUS_PUBLISH_PORT
export SE_EVENT_BUS_SUBSCRIBE_PORT
export SELENIUM_HUB_PORT
export SE_INSTANCES
export SELENIUM_USER
export SELENIUM_PASS
export NUMBER_OF_THREADS
export SUITE_NAME
export SHM_SIZE
export API_VERSION

TEST_CONTAINER="e2e-tests"

# Before running, make sure $USER is a member of the docker group
docker compose -f docker-compose.test.yml -p racks down
docker compose -f docker-compose.test.yml -p racks --profile test build --progress=plain 2>&1 | tee ./logs/run.log &&
docker compose -f docker-compose.test.yml -p racks --profile test up 2>&1 | tee -a ./logs/run.log &

# Wait for build
docker inspect "$TEST_CONTAINER" > /dev/null 2>/dev/null
while [ $? -eq 1 ]
do
    sleep 1
    docker inspect "$TEST_CONTAINER" > /dev/null 2>/dev/null
done

# Wait for the last service to start
while [[ $(docker inspect "$TEST_CONTAINER" --format='{{.State.Running}}') == 'false' ]]
do
	sleep 1
done

# Wait for last service to stop
while [[ $(docker inspect "$TEST_CONTAINER" --format='{{.State.Running}}') == 'true' ]]
do
	sleep 1
done

PINT=$(docker inspect pint --format='{{.State.ExitCode}}')
PHPSTAN=$(docker inspect phpstan --format='{{.State.ExitCode}}')
PHPUNIT=$(docker inspect phpunit --format='{{.State.ExitCode}}')
E2E=$(docker inspect "$TEST_CONTAINER" --format='{{.State.ExitCode}}')

# Compose down
docker compose -p racks down
docker compose ps | grep Up > /dev/null 2>/dev/null
while [ $? -eq 0 ]
do
    sleep 1
    docker compose ps | grep Up > /dev/null 2>/dev/null
done

# Sorting logs
grep "pint" ./logs/run.log > ./logs/pint.log
grep "phpstan" ./logs/run.log > ./logs/phpstan.log
grep "phpunit" ./logs/run.log > ./logs/phpunit.log
grep "$TEST_CONTAINER" ./logs/run.log > ./logs/e2e.log

CODE_ARR=("$E2E" "$PHPSTAN" "$PINT" "$PHPUNIT")

if [[ "${CODE_ARR[*]}" =~ "1" ]]
then
    echo -e "\n ============================================================\n"\
    "-----FAIL-----\n"\
    "============================================================\n"\
    "PINT status code - $PINT\n"\
    "PHPstan status code - $PHPSTAN\n"\
    "PHPunit status code - $PHPUNIT\n"\
    "E2E tests status code - $E2E\n"\
    "============================================================\n" | tee -a ./logs/run.log
    exit 1
else
    echo -e "\n ============================================================\n"\
    "-----SUCCEED-----\n"\
    "============================================================\n"\
    "PINT status code - $PINT\n"\
    "PHPstan status code - $PHPSTAN\n"\
    "PHPunit status code - $PHPUNIT\n"\
    "E2E tests status code - $E2E\n"\
    "============================================================\n" | tee -a ./logs/run.log
fi
exit 0