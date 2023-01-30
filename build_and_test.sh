#!/bin/bash

# Before running, make sure $USER is a member of the docker group
docker-compose down
docker-compose --profile test build &&
docker-compose --profile test up &

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

# Stop other e2e testing containers
docker stop chrome
docker stop vue-testing

LINTER=$(docker inspect django-linter --format='{{.State.ExitCode}}')
TYPING=$(docker inspect django-typing --format='{{.State.ExitCode}}')
UNITS=$(docker inspect django-unit-tests --format='{{.State.ExitCode}}') 
E2E=$(docker inspect e2e-tests --format='{{.State.ExitCode}}')

CODE_ARR=($LINTER, $TYPING, $UNITS, $E2E)

if [[ "${CODE_ARR[*]}" =~ "1" ]]
then
    docker-compose down
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
