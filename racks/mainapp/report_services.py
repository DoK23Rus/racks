from django.http import HttpResponse
from django.db import models
import csv
from .services import ( 
    _device_stack,
    _frontside_location,
    _numbering,
    _external_ups,
    _cooler,
)
from .models import (
    Region, 
    Department, 
    Site, 
    Building, 
    Room, 
    Rack, 
    Device,
)


def export_devices():
    """
    Отчет по устройствам
    """
    device_link = 'http://127.0.0.1:80001/device_detail/'
    response = HttpResponse(content_type='text/csv')
    response.write(u'\ufeff'.encode('utf8'))
    writer = csv.writer(response, delimiter=';', dialect='excel')
    writer.writerow([
        '№'
        'Номер устройства', 
        'Статус',
        'Вендор', 
        'Модель', 
        'Серийный номер', 
        'Описание', 
        'Проект', 
        'Зона ответственности', 
        'МОЛ', 
        'Инвентарный номер', 
        'Ответственный за ТО', 
        'Основное средство', 
        'Ссылка на ресурс', 
        'Первый юнит', 
        'Последний юнит', 
        'Расположено на фронтальной части', 
        'Тип оборудования',
        'Hostname',
        'IP-адрес',
        'Stack/Резерв',
        'Портовая ёмкость',
        'Версия ПО (прошивка/дистрибутив)',
        'Подключение к электросети',
        'Потребляемая мощность (Вт)',
        'Рабочее напряжение (В)',
        'AC/DC',
        'Обновлено сотрудник', 
        'Обновлено дата', 
        'Стойка', 
        'Помещение', 
        'Здание', 
        'Узел', 
        'Отдел', 
        'Регион',
        'Ссылка на устройство',
    ])
    raw_report =  Device.objects.raw("""select device.id as id,
                                     device.*,
                                     rack.rack_name, 
                                     room.room_name, 
                                     building.building_name, 
                                     site.site_name, 
                                     department.department_name, 
                                     region.region_name 
                                     from device 
                                     join rack on 
                                     rack.id = 
                                     device.rack_id_id 
                                     join room on 
                                     room.id = 
                                     rack.room_id_id 
                                     join building on 
                                     building.id = 
                                     room.building_id_id 
                                     join site on 
                                     site.id = 
                                     building.site_id_id 
                                     join department on 
                                     department.id = 
                                     site.department_id_id 
                                     join region on 
                                     region.id = 
                                     department.region_id_id;""")
    for device in raw_report:
        writer.writerow([
            device.id,
            device.status,
            device.device_vendor, 
            device.device_model, 
            device.device_serial_number,
            device.device_description,
            device.project,
            device.ownership,
            device.financially_responsible_person,
            device.device_inventory_number,
            device.responsible,
            device.main_asset,
            device.link,
            device.first_unit,
            device.last_unit,
            _frontside_location(device.frontside_location), 
            device.device_type, 
            device.device_hostname, 
            device.ip,
            _device_stack(device_link, device.device_stack),
            device.ports_amout,
            device.version,
            device.power_type,
            device.power_w, 
            device.power_v, 
            device.power_ac_dc,
            device.updated_by,
            device.updated_at,
            device.rack_name,
            device.room_name,
            device.building_name,
            device.site_name,
            device.department_name,
            device.region_name,
            device_link + str(device.id),
        ])
    response['Content-Disposition'] = 'attachment; filename="devices.csv"'
    return response


def export_racks():
    """
    Отчет по стойкам
    """
    rack_link = 'http://127.0.0.1:80001/rack_detail/'
    response = HttpResponse(content_type='text/csv')
    response.write(u'\ufeff'.encode('utf8'))
    writer = csv.writer(response, delimiter=';', dialect='excel')
    writer.writerow([
        'Номер стойки',
        'Наименование', 
        'Вместимость стойки', 
        'Фирма производитель', 
        'Модель', 
        'Описание', 
        'Нумерация снизу вверх', 
        'Ответственный', 
        'МОЛ', 
        'Инвентарный номер', 
        'Ответственный за ТО', 
        'Основное средство', 
        'Ссылка на ресурс', 
        'Ряд', 
        'Место', 
        'Высота стойки (мм)',
        'Ширина стойки (мм)',
        'Глубина стойки (мм)',
        'Полезная ширина стойки (дюймы)',
        'Полезная глубина стойки (мм)',
        'Вариант исполнения',
        'Тип расположения',
        'Максимальная нагрузка (кг)',
        'Свободных электророзеток',
        'Свободных электророзеток UPS',
        'Внешняя система резервного электроснабжения',
        'Активная вентиляция',
        'Обновлено сотрудник', 
        'Обновлено дата', 
        'Помещение', 
        'Здание', 
        'Узел', 
        'Отдел', 
        'Регион',
        'Ссылка на стойку',
    ])
    raw_report =  Rack.objects.raw("""select rack.id as id, 
                                   rack.*, 
                                   room.room_name, 
                                   building.building_name, 
                                   site.site_name, 
                                   department.department_name, 
                                   region.region_name 
                                   from rack  
                                   join room on 
                                   room.id = 
                                   rack.room_id_id 
                                   join building on 
                                   building.id = 
                                   room.building_id_id 
                                   join site on 
                                   site.id = 
                                   building.site_id_id 
                                   join department on 
                                   department.id = 
                                   site.department_id_id 
                                   join region on 
                                   region.id = 
                                   department.region_id_id;""")
    for rack in raw_report:
        writer.writerow([
            rack.id,
            rack.rack_name, 
            rack.rack_amount,
            rack.rack_vendor, 
            rack.rack_model, 
            rack.rack_description,  
            _numbering(rack.numbering_from_bottom_to_top), 
            rack.responsible, 
            rack.rack_financially_responsible_person, 
            rack.rack_inventory_number,
            rack.responsible,
            rack.main_asset,
            rack.link, 
            rack.row, 
            rack.place, 
            rack.rack_height,
            rack.rack_width,
            rack.rack_depth, 
            rack.rack_unit_width,
            rack.rack_unit_depth,
            rack.rack_type,
            rack.rack_palce_type,
            rack.max_load,
            rack.power_sockets,
            rack.power_sockets_ups,
            _external_ups(rack.external_ups),
            _cooler(rack.cooler),
            rack.updated_by, 
            rack.updated_at, 
            rack.room_name,
            rack.building_name,
            rack.site_name,
            rack.department_name,
            rack.region_name,
            rack_link + str(rack.id),
        ])
    response['Content-Disposition'] = 'attachment; filename="racks.csv"'
    return response
