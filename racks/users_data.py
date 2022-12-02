import os

from typing import Dict

group_name: str = os.environ.get('SELENIUM_GROUP')

users: Dict = [
    {
        'username': os.environ.get('SELENIUM_USER'),
        'password': os.environ.get('SELENIUM_PASS'),
    },
]
