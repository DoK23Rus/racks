"""
Celery tasks
"""
import csv
import os

from typing import List
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


@shared_task
def generate_report_task(file_path: str,
                         header: List[str],
                         data: List[List[str]]
                         ) -> str:
    """
    Generate file with report data

    Args:
        file_path (str): path to report file
        header (list): list with header data
        data (list): list with report data
    Returns:
        file_path (str): path to report file
    """
    with open(file_path, "w+") as file:
        writer = csv.writer(file, dialect=csv.excel)
        writer.writerow(header)
        for row in data:
            writer.writerow(row)
    return file_path


@shared_task
def delete_report_task(file_path: str) -> None:
    """
    Delete report file

    Args:
        file_path (str): path to report file
    """
    if os.path.exists(file_path):
        os.remove(file_path)
