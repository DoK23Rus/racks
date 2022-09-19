from django import template
from typing import List
from mainapp.services import UniqueCheckService


register = template.Library()


@register.simple_tag()
def get_rack_vendors() -> List[str]:
    return UniqueCheckService.get_unique_rack_vendors()


@register.simple_tag()
def get_rack_models() -> List[str]:
    return UniqueCheckService.get_unique_rack_models()


@register.simple_tag()
def get_device_vendors() -> List[str]:
    return UniqueCheckService.get_unique_device_vendors()


@register.simple_tag()
def get_device_models() -> List[str]:
    return UniqueCheckService.get_unique_device_models()
