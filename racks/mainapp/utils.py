"""
Some utils
"""
from dataclasses import dataclass


@dataclass
class Result:
    """
    Class for check result objects
    """
    success: bool
    message: str
