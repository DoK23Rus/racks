import qrcode
import os
from django.conf import settings
from .services import ( 
    _device,
    _rack,
)


def _img_name(pk, device):
    """
    Имя файла
    """
    if device == True:
        img_name = '/device_qr/d-' + str(pk) + '.png'
    else:
        img_name = '/rack_qr/r-' + str(pk) + '.png'
    return img_name


def _create_qr(data, pk, device):
    """
    Сгенерировать QR-код
    """
    qr = qrcode.QRCode(
        version=1,
        box_size=2,
        error_correction=qrcode.constants.ERROR_CORRECT_M,
        border=1)
    qr.add_data(data)
    qr.make(fit=True)
    img = qr.make_image(fill='black', back_color='white')
    img.save(settings.BASE_DIR + '/mainapp/static' + _img_name(pk, device))


def _remove_qr(pk, device):
    """
    Удалить QR-код
    """
    img_name = settings.BASE_DIR + '/mainapp/static' + _img_name(pk, device)
    if os.path.isfile(img_name):
        os.remove(img_name)


def _show_qr(data, pk, device):
    """
    Показать(создать/обновить) QR-код
    """
    _create_qr(data, pk, device)
    return _img_name(pk, device)


def _qr_data(pk, device):
    """
    Данные для QR-кода
    """
    if device == True:
        return 'http://127.0.0.1:80001/device_detail/' + str(pk) + \
            '\nОзТО: ' + _device(pk).responsible + \
            '\nМОЛ: ' + _device(pk).financially_responsible_person + \
            '\nИнв: ' + _device(pk).device_inventory_number + \
            '\nОС: ' + _device(pk).main_asset
    else:
        return 'http://127.0.0.1:80001/rack_detail/' + str(pk) + \
            '\nОзТО: ' + _rack(pk).responsible + \
            '\nМОЛ: ' + _rack(pk).rack_financially_responsible_person + \
            '\nИнв: ' + _rack(pk).rack_inventory_number + \
            '\nОС: ' + _rack(pk).main_asset