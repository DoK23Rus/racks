"""
Checking and setuping users for E2E testing
"""
from django.contrib.auth.models import User, Group
from typing import Tuple
from rest_framework.authtoken.models import Token
from users_data import users, group_name, TestUser
globals().update(locals())


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

    def __init__(self, group_name: str, group_id: int, user: TestUser) -> None:
        self.group_name = group_name
        self.group_id = group_id
        self.user = user
        self.username = user.username
        self.password = user.password

    def __repr__(self) -> str:
        return (f'{self.__class__.__name__}('
                f'{self.group_name!r}, {self.group_id!r}), {self.user!r})')

    def get_user(self) -> User:
        """
        Get or create user

        Returns:
            some_user (User): User
        """
        try:
            some_user = User.objects.get(username=self.username)
            some_user.save()
        except User.DoesNotExist:
            some_user = User.objects.create_user(username=self.username,
                                                 password=self.password)
            Token.objects.get_or_create(user=some_user)
        return some_user

    def add_group(self) -> None:
        """
        Add group and create token
        """
        some_user = self.get_user()
        if not some_user.groups.filter(name=self.group_name).exists():
            some_user.groups.add(self.group_id)


globals().update(locals())


def check_users(users: Tuple[TestUser]) -> None:
    """
    Final user check
    """
    group_id = get_group_id(group_name)
    for user in users:
        some_user = CheckUser(group_name, group_id, user)
        some_user.get_user()
        some_user.add_group()


check_users(users)
