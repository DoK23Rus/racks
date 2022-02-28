import qrcode
import os
from django.conf import settings
from .services import ( 
    _device,
    _rack,
)


def _img_name(pk, device):
    """
    File name
    """
    if device == True:
        img_name = '/device_qr/d-' + str(pk) + '.png'
    else:
        img_name = '/rack_qr/r-' + str(pk) + '.png'
    return img_name


def _create_qr(data, pk, device):
    """
    Generate QR
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
    Delete QR
    """
    img_name = settings.BASE_DIR + '/mainapp/static' + _img_name(pk, device)
    if os.path.isfile(img_name):
        os.remove(img_name)


def _show_qr(data, pk, device):
    """
    Show (create/update) QR
    """
    _create_qr(data, pk, device)
    return _img_name(pk, device)


def _qr_data(pk, device):
    """
    QR data
    """
    if device == True:
        return 'http://127.0.0.1:80001/device_detail/' + str(pk) + \
            '\nResp: ' + _device(pk).responsible + \
            '\nFResp: ' + _device(pk).financially_responsible_person + \
            '\nInv: ' + _device(pk).device_inventory_number + \
            '\nAsset: ' + _device(pk).fixed_asset
    else:
        return 'http://127.0.0.1:80001/rack_detail/' + str(pk) + \
            '\nResp: ' + _rack(pk).responsible + \
            '\nFResp: ' + _rack(pk).rack_financially_responsible_person + \
            '\nInv: ' + _rack(pk).rack_inventory_number + \
            '\nAsset: ' + _rack(pk).fixed_asset
