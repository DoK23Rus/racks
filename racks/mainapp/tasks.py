import os
from django.core.management import call_command
from mainapp.services import date
from celery import shared_task


@shared_task
def db_backup_task() -> str:
    """
    Database dump

    Raises:
        ValueError: BACKUP_DIR in .env file is None

    Returns:
        (str): 'Backup done' if success
        (str): string with exception if fail
    """
    backup_dir = os.environ.get('BACKUP_DIR')
    if backup_dir is None:
        raise ValueError("BACKUP_DIR in .env cant be None")
    try:
        dump_path = os.path.join(backup_dir,
                                 f"{date()}_db_dump.json")
        call_command('dumpdata',
                     'mainapp',
                     indent=2,
                     format='json',
                     output=dump_path)
        return 'Backup done'
    except Exception as ex:
        return str(ex)


@shared_task
def user_backup_task() -> str:
    """
    Users dump

    Raises:
        ValueError: BACKUP_DIR in .env file is None

    Returns:
        (str): 'Backup done' if success
        (str): string with exception if fail
    """
    backup_dir = os.environ.get('BACKUP_DIR')
    if backup_dir is None:
        raise ValueError("BACKUP_DIR in .env cant be None")
    try:
        dump_path = os.path.join(backup_dir,
                                 f"{date()}_user_dump.json")
        call_command('dumpdata',
                     'auth',
                     indent=2,
                     format='json',
                     output=dump_path)
        return 'Backup done'
    except Exception as ex:
        return str(ex)
