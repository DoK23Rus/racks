"""
Checking and setuping users for E2E and API testing
"""
from django.contrib.auth.models import User, Group
from typing import List, Dict
globals().update(locals())


group_name: str = 'Test department'
users: Dict = [
    {
        'username': 'selenium',
        'password': 'sel_testing',
        'first_name': 'Selenium',
        'last_name': 'Tester'
    },
    {
        'username': 'api',
        'password': 'api_testing',
        'first_name': 'Api',
        'last_name': 'Tester'
    },
]


def get_group_id(group_name: str) -> int:
    """
    Get group id by name (create if not exist)
    """
    Group.objects.get_or_create(name=group_name)
    group_id = Group.objects.filter(name=group_name).first().id
    return group_id


class CheckUser:
    """
    Checking users (creating and adding groups)
    """

    def __init__(self, group_name: str, group_id: int, user: Dict):
        self.group_name = group_name
        self.group_id = group_id
        self.user = user
        self.username = user['username']
        self.password = user['password']
        self.first_name = user['first_name']
        self.last_name = user['last_name']

    def __repr__(self) -> str:
        return (f'{self.__class__.__name__}('
                f'{self.group_name!r}, {self.group_id!r}), {self.user!r})')

    def get_user(self) -> User:
        """
        Get or create user
        """
        try:
            some_user = User.objects.get(username=self.username)
            some_user.first_name = self.first_name
            some_user.last_name = self.last_name
            some_user.save()
        except User.DoesNotExist:
            some_user = User.objects.create_user(username=self.username,
                                                 password=self.password,
                                                 first_name=self.first_name,
                                                 last_name=self.last_name)
        return some_user

    def add_group(self) -> None:
        """
        Add group
        """
        some_user = self.get_user()
        if not some_user.groups.filter(name=self.group_name).exists():
            some_user.groups.add(self.group_id)


globals().update(locals())


def check_users(users: List[Dict]) -> None:
    """
    Final user check
    """
    group_id = get_group_id(group_name)
    for user in users:
        some_user = CheckUser(group_name, group_id, user)
        some_user.get_user()
        some_user.add_group()


check_users(users)
