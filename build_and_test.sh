#!/bin/bash

PROFILES_ARR=("test-alt-front", "test")

if [[ "${PROFILES_ARR[*]}" =~ "${1}" ]]
then
    profile=$1
else
    echo -e "No such profile in build-and-test script"
    exit 1
fi

case $profile in
  test)
    test_container="e2e-tests"
    ;;
  test-alt-front)
    test_container="e2e-tests-alternative"
    ;;
  *)
    echo -e "Unknown profile case"
    exit 1
    ;;
esac

# Before running, make sure $USER is a member of the docker group
docker compose -p racks down
docker compose -p racks --profile $profile build &&
docker compose -p racks --profile $profile up &

# Wait for build
docker inspect $test_container > /dev/null 2>/dev/null
while [ $? -eq 1 ]
do  
    sleep 1
    docker inspect $test_container > /dev/null 2>/dev/null
done

# Wait for the last service to start
while [[ $(docker inspect $test_container --format='{{.State.Running}}') == 'false' ]]
do
	sleep 1
done

# Wait for last service to stop
while [[ $(docker inspect $test_container --format='{{.State.Running}}') == 'true' ]]
do
	sleep 1
done

LINTER=$(docker inspect django-linter --format='{{.State.ExitCode}}')
TYPING=$(docker inspect django-typing --format='{{.State.ExitCode}}')
UNITS=$(docker inspect django-unit-tests --format='{{.State.ExitCode}}') 
E2E=$(docker inspect $test_container --format='{{.State.ExitCode}}')

# Compose down
docker compose -p racks down
docker compose ps | grep Up > /dev/null 2>/dev/null
while [ $? -eq 0 ]
do
    sleep 1
    docker compose ps | grep Up > /dev/null 2>/dev/null
done

CODE_ARR=($LINTER, $TYPING, $UNITS, $E2E)

if [[ "${CODE_ARR[*]}" =~ "1" ]]
then
    echo -e "============================================================\n"\
    "-----FAIL-----\n"\
    "============================================================\n"\
    "Linter check status code - $LINTER\n"\
    "Type check status code - $TYPING\n"\
    "Unit tests status code - $UNITS\n"\
    "E2E tests status code - $E2E\n"\
    "============================================================\n"
    exit 1
else
    echo -e "============================================================\n"\
    "-----SUCCEED-----\n"\
    "============================================================\n"\
    "Linter check status code - $LINTER\n"\
    "Type check status code - $TYPING\n"\
    "Unit tests status code - $UNITS\n"\
    "E2E tests status code - $E2E\n"\
    "============================================================\n"
fi
exit 0
