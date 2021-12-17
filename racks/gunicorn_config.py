command = '/home/slunk/code/racks_project/env/bin/gunicorn'
pythonpath = '/home/slunk/code/racks_project/racks'
bind = '127.0.0.1:8001'
workers = 5
user = 'slunk'
limit_request_fields = 32000
limit_request_field_size = 0
raw_enw = 'DJANGO_SETTINGS_MODULE=racks.settings'
