"""
Business logic classes
"""
from typing import List, Dict, Set, Union, Optional
from django.db.models.base import ModelBase
from django.db.models.query import RawQuerySet
from django.http.response import HttpResponse
from mainapp.models import (
    Department,
    Site,
    Building,
    Room,
    Rack,
    Device,
)
import qrcode
import os
from django.conf import settings
import csv
from mainapp.data import ReportHeaders
import datetime


def date():
    """
    Current date
    """
    return datetime.datetime.today().strftime("%Y-%m-%d")


class RackLayoutService:
    """
    Services for rendering a single rack
    """

    @staticmethod
    def get_start_list(pk: int, direction: bool) -> List[int]:
        """
        Units list
        """
        rack_amount = Rack.objects.get_rack(pk).rack_amount
        if not direction:
            return list(range(1, int(rack_amount) + 1))
        else:
            return list(range(1, int(rack_amount) + 1))[::-1]

    @staticmethod
    def get_first_units(pk: int,
                        direction: bool,
                        side: bool
                        ) -> Dict[int, int]:
        """
        First units for each device
        """
        first_units: Dict = {}
        devices = Device.objects.get_devices_for_side(pk, side)
        for device in devices:
            last_unit = device.last_unit
            first_unit = device.first_unit
            if direction:
                if last_unit > first_unit:
                    first_unit = device.last_unit
                first_units[device.id] = first_unit
            else:
                if last_unit < first_unit:
                    first_unit = device.last_unit
                first_units[device.id] = first_unit
        return first_units

    @staticmethod
    def get_rowspans(pk: int, side: bool) -> Dict[int, int]:
        """
        Rowspans for each device
        """
        rowspans: Dict = {}
        devices = Device.objects.get_devices_for_side(pk, side)
        for device in devices:
            last_unit = device.last_unit
            first_unit = device.first_unit
            if last_unit < first_unit:
                first_unit = device.last_unit
                last_unit = device.first_unit
            rowspans[device.id] = last_unit - first_unit + 1
        return rowspans


class UserCheckService:
    """
    Services for checking user permission
    For add|update|delete user must be in group with the same name
    as object department affiliation
    """

    @staticmethod
    def get_department_raw_query(pk: int,
                                 model: ModelBase
                                 ) -> RawQuerySet:
        """
        Department raw query (get department name from join)
        """
        if model == Department:
            department_raw_query = Department.objects \
                .get_department_name_for_department(pk)
        elif model == Site:
            department_raw_query = Department.objects \
                .get_department_name_for_site(pk)
        elif model == Building:
            department_raw_query = Department.objects \
                .get_department_name_for_building(pk)
        elif model == Room:
            department_raw_query = Department.objects \
                .get_department_name_for_room(pk)
        elif model == Rack:
            department_raw_query = Department.objects \
                .get_department_name_for_rack(pk)
        elif model == Device:
            department_raw_query = Department.objects \
                .get_department_name_for_device(pk)
        else:
            raise ValueError('model: ModelBase must be'
                             'Department|Site|Building|Room|Rack|Device')
        return department_raw_query

    @staticmethod
    def check_for_groups(user_groups: List[str],
                         pk: int,
                         model: ModelBase
                         ) -> bool:
        """
        Check user permission
        """
        department_raw_query = UserCheckService \
            .get_department_raw_query(pk, model)
        department_name = str([department_name
                              for department_name
                              in department_raw_query][0])
        if department_name in user_groups:
            return True
        return False


class UniqueCheckService:
    """
    Services for unique names checking (in the same area)
    """

    @staticmethod
    def get_unique_object_names_list(key: Optional[int],
                                     model: ModelBase
                                     ) -> Set[str]:
        """
        Names of building, rooms and racks can be repeated
        within the area of responsibility of one department
        """
        if key:
            if model == Site:
                names_list = {building.building_name for building
                              in Building.objects.get_buildings_for_site(key)}
            elif model == Building:
                names_list = {room.room_name for room
                              in Room.objects.get_rooms_for_building(key)}
            elif model == Room:
                names_list = {rack.rack_name for rack
                              in Rack.objects.get_racks_for_rooms(key)}
            else:
                raise ValueError("model: ModelBase must be Site|Building|Room")
            return names_list
        else:
            raise ValueError("key must be not None")

    @staticmethod
    def get_unique_device_vendors() -> List[str]:
        """
        Vendors list (for devices)
        """
        vendors = list(Device.objects.get_device_vendors().distinct())
        vendors.sort()
        return vendors

    @staticmethod
    def get_unique_device_models() -> List[str]:
        """
        Models list (for devices)
        """
        models = list(Device.objects.get_device_models().distinct())
        models.sort()
        return models

    @staticmethod
    def get_unique_rack_vendors() -> List[str]:
        """
        Vendors list (for racks)
        """
        vendors = list(Rack.objects.get_rack_vendors().distinct())
        vendors.sort()
        return vendors

    @staticmethod
    def get_unique_rack_models() -> List[str]:
        """
        Models list (for racks)
        """
        models = list(Rack.objects.get_rack_models().distinct())
        models.sort()
        return models


class DeviceCheckService:
    """
    Services for checking capabilities to add or update devices
    """

    @staticmethod
    def get_old_units(pk: int) -> Dict[str, int]:
        """
        Already filled units
        """
        units: Dict = {}
        first_unit = Device.objects.get_device(pk).first_unit
        last_unit = Device.objects.get_device(pk).last_unit
        units['old_first_unit'] = first_unit
        units['old_last_unit'] = last_unit
        if units['old_first_unit'] > units['old_last_unit']:
            units['old_last_unit'] = first_unit
            units['old_first_unit'] = last_unit
        return units

    @staticmethod
    def get_new_units(first_unit: int, last_unit: int) -> Dict[str, int]:
        """
        Units for newly added device
        """
        units: Dict = {}
        units['new_first_unit'] = first_unit
        units['new_last_unit'] = last_unit
        if units['new_first_unit'] > units['new_last_unit']:
            units['new_last_unit'] = first_unit
            units['new_first_unit'] = last_unit
        return units

    @staticmethod
    def get_all_units(pk: int) -> Dict[str, int]:
        """
        Total units per rack
        """

        units: Dict = {}
        units['all_units'] = int(Rack.objects.get_rack(pk).rack_amount)
        return units

    @staticmethod
    def check_unit_exist(units: Dict[str, int]) -> bool:
        """
        Are there any such units?
        """
        new_device_range = range(units['new_first_unit'],
                                 units['new_last_unit'] + 1)
        all_units_ramge = range(1, units['all_units'] + 1)
        if not set(new_device_range).issubset(all_units_ramge):
            return True
        else:
            return False

    @staticmethod
    def check_unit_busy(side: bool,
                        units: Dict[str, int],
                        pk: int,
                        update: bool
                        ) -> bool:
        """
        Are units busy? (adding, updating)
        """
        filled_list: List = []
        queryset_devices = Device.objects.get_devices_for_side(pk, side)
        if len(list(queryset_devices)) > 0:
            for device in queryset_devices:
                first_unit = device.first_unit
                last_unit = device.last_unit
                if first_unit > last_unit:
                    first_unit = device.last_unit
                    last_unit = device.first_unit
                one_device_list = list(range(first_unit, last_unit + 1))
                filled_list.extend(one_device_list)
        if update:
            device_old_range = range(units['old_first_unit'],
                                     units['old_last_unit'] + 1)
            filled_list = list(set(filled_list) - set(device_old_range))
        device_new_range = range(units['new_first_unit'],
                                 units['new_last_unit'] + 1)
        if any(unit in set(device_new_range) for unit in filled_list):
            return True
        else:
            return False


class QrService:
    """
    Services for generate|delete|show QRs
    """

    @staticmethod
    def get_img_name(pk: int, is_device: bool) -> str:
        """
        File name
        """
        if is_device:
            img_name = f'/device_qr/d-{str(pk)}.png'
        else:
            img_name = f'/rack_qr/r-{str(pk)}.png'
        return img_name

    @staticmethod
    def create_qr(data: str, pk: int, is_device: bool) -> None:
        """
        Generate QR
        """
        qr = qrcode.QRCode(version=1,
                           box_size=2,
                           error_correction=qrcode.constants.ERROR_CORRECT_M,
                           border=1)
        qr.add_data(data)
        qr.make(fit=True)
        img = qr.make_image(fill='black', back_color='white')
        img.save(f'{settings.BASE_DIR}'
                 f'/mainapp/static{QrService.get_img_name(pk, is_device)}')

    @staticmethod
    def remove_qr(pk: int, is_device: bool) -> None:
        """
        Delete QR
        """
        img_name = (f'{settings.BASE_DIR}'
                    f'/mainapp/static{QrService.get_img_name(pk, is_device)}')
        if os.path.isfile(img_name):
            os.remove(img_name)

    @staticmethod
    def show_qr(data: str, pk: int, is_device: bool) -> str:
        """
        Show (create/update) QR
        """
        QrService.create_qr(data, pk, is_device)
        return QrService.get_img_name(pk, is_device)

    @staticmethod
    def get_qr_data(pk: int, is_device: bool, url: str) -> str:
        """
        QR data
        """
        if is_device:
            return f'{url}device_detail/{str(pk)}'
        else:
            return f'{url}rack_detail/{str(pk)}'


class DraftService:
    """
    Services for rack drafts (for print)
    """

    @staticmethod
    def get_side_name(front_side: bool) -> str:
        """
        Rack side
        """
        return 'FRONT SIDE' if front_side else 'BACK SIDE'

    @staticmethod
    def get_font_size(rack_size: int) -> str:
        """
        Font size
        """
        if rack_size <= 32:
            return '100'
        elif rack_size > 32 and rack_size <= 42:
            return '75'
        else:
            return '50'


class ReportService:
    """
    Services for generating csv reports
    """

    @staticmethod
    def get_header_list(instance_name: str) -> List[str]:
        """
        Header for csv table
        """
        if instance_name == 'device':
            return ReportHeaders.devices_header_list
        elif instance_name == 'rack':
            return ReportHeaders.racks_header_list
        else:
            raise ValueError('instance_name: str must be device|rack')

    @staticmethod
    def get_devices_data(address: str) -> List[List[str]]:
        """
        Data for devices
        """
        raw_device_report = Device.objects.get_all_devices_report()
        devices_data: List = []
        for device in raw_device_report:
            devices_data.append([
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
                device.fixed_asset,
                device.link,
                device.first_unit,
                device.last_unit,
                'Yes' if device.frontside_location else 'No',
                device.device_type,
                device.device_hostname,
                device.ip,
                ReportService.get_device_stack(f'{settings.START_PAGE_URL}'
                                               f'{address}',
                                               device.device_stack),
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
                settings.START_PAGE_URL + address + str(device.id),
            ])
        return devices_data

    @staticmethod
    def get_racks_data(address: str) -> List[List[str]]:
        """
        Data for racks
        """
        raw_rack_report = Rack.objects.get_all_racks_report()
        racks_data: List = []
        for rack in raw_rack_report:
            racks_data.append([
                rack.id,
                rack.rack_name,
                rack.rack_amount,
                rack.rack_vendor,
                rack.rack_model,
                rack.rack_description,
                'Yes' if rack.numbering_from_bottom_to_top else 'No',
                rack.responsible,
                rack.rack_financially_responsible_person,
                rack.rack_inventory_number,
                rack.fixed_asset,
                rack.link,
                rack.row,
                rack.place,
                rack.rack_height,
                rack.rack_width,
                rack.rack_depth,
                rack.rack_unit_width,
                rack.rack_unit_depth,
                rack.rack_type,
                rack.rack_frame,
                rack.rack_palce_type,
                rack.max_load,
                rack.power_sockets,
                rack.power_sockets_ups,
                'Yes' if rack.external_ups else 'No',
                'Yes' if rack.cooler else 'No',
                DataProcessingService.get_devices_power_w_sum(int(rack.id)),
                rack.updated_by,
                rack.updated_at,
                rack.room_name,
                rack.building_name,
                rack.site_name,
                rack.department_name,
                rack.region_name,
                f'{settings.START_PAGE_URL}{address}{str(rack.id)}',
            ])
        return racks_data

    @staticmethod
    def get_device_stack(device_link: str,
                         device_stack: int
                         ) -> Union[str, None]:
        """
        Link to backup device
        """
        if device_stack is not None:
            return f'{device_link}{str(device_stack)}'
        return None

    @staticmethod
    def get_responce(header_list: List[str],
                     report_data: List[List[str]],
                     file_name: str
                     ) -> HttpResponse:
        """
        Get response
        """
        response = HttpResponse(content_type='text/csv')
        response.write(u'\ufeff'.encode('utf8'))
        writer = csv.writer(response, delimiter=';', dialect='excel')
        writer.writerow(header_list)
        for row in report_data:
            writer.writerow(row)
        response['Content-Disposition'] = f'attachment; filename="{file_name}"'
        return response


class DataProcessingService:
    """
    Services for operations with data
    """

    @staticmethod
    def get_devices_power_w_sum(pk: int) -> int:
        power_w_list = Device.objects.get_devices_power_w(pk)
        return sum(power_w for power_w in power_w_list if power_w is not None)
