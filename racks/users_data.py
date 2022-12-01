import os

from typing import Dict

group_name: str = 'Test department'

users: Dict = [
    {
        'username': os.environ.get('SELENIUM_USER'),
        'password': os.environ.get('SELENIUM_PASS'),
    },
]
