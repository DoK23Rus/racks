#!/bin/bash
source /home/slunk/code/racks_project/env/bin/activate
exec gunicorn -c "/home/slunk/code/racks_project/racks/gunicorn_config.py" racks.wsgi

