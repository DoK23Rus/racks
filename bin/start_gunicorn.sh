#!/bin/bash
source /home/slunk/code/racks/env/bin/activate
exec gunicorn -c "/home/slunk/code/racks/racks/gunicorn_config.py" racks.wsgi
