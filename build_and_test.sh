#!/bin/bash

# Before running, make sure $USER is a member of the docker group
docker-compose -p racks down
docker-compose -p racks --profile test build &&
docker-compose -p racks --profile test up &

# Wait for build
docker inspect e2e-tests > /dev/null 2>/dev/null
while [ $? -eq 1 ]
do  
    sleep 1
    docker inspect e2e-tests > /dev/null 2>/dev/null
done

# Wait for the last service to start
while [[ $(docker inspect e2e-tests --format='{{.State.Running}}') == 'false' ]]
do
	sleep 1
done

# Wait for last service to stop
while [[ $(docker inspect e2e-tests --format='{{.State.Running}}') == 'true' ]]
do
	sleep 1
done

LINTER=$(docker inspect django-linter --format='{{.State.ExitCode}}')
TYPING=$(docker inspect django-typing --format='{{.State.ExitCode}}')
UNITS=$(docker inspect django-unit-tests --format='{{.State.ExitCode}}') 
E2E=$(docker inspect e2e-tests --format='{{.State.ExitCode}}')

# Compose down
docker-compose -p racks down
docker-compose ps | grep Up > /dev/null 2>/dev/null
while [ $? -eq 0 ]
do
    sleep 1
    docker-compose ps | grep Up > /dev/null 2>/dev/null
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
