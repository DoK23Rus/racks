"""
Users and group for e2e testing
"""
from dataclasses import dataclass
import os


@dataclass
class TestUser:
    """
    User for tests
    """
    username: str
    password: str


group_name: str = os.environ.get('SELENIUM_GROUP')

users: tuple = (
    TestUser(os.environ.get('SELENIUM_USER'), os.environ.get('SELENIUM_PASS')),
)
