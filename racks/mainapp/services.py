"""
Business logic classes
"""
import datetime
from typing import List, Optional, Set, NamedTuple

from django.db.models.base import ModelBase
from django.db.models.query import QuerySet

from mainapp.models import (Building,
                            Department,
                            Device,
                            Rack,
                            Region,
                            Room,
                            Site)
from mainapp.repository import (BuildingRepository,
                                DepartmentRepository,
                                DeviceRepository,
                                RackRepository,
                                RoomRepository,
                                SiteRepository)


def date():
    """
    Current date
    """
    return datetime.datetime.today().strftime("%Y-%m-%d")


class OldUnits(NamedTuple):
    old_first_unit: int
    old_last_unit: int


class NewUnits(NamedTuple):
    new_first_unit: int
    new_last_unit: int


class DeviceCheckService:
    """
    Services for checking capabilities to add or update devices
    """

    @staticmethod
    def get_old_units(pk: int) -> OldUnits:
        """
        Get dict with already filled units
        """
        first_unit = DeviceRepository.get_first_unit(pk)
        last_unit = DeviceRepository.get_last_unit(pk)
        if first_unit > last_unit:
            return OldUnits(last_unit, first_unit)
        return OldUnits(first_unit, last_unit)

    @staticmethod
    def get_new_units(first_unit: int, last_unit: int) -> NewUnits:
        """
        Get dict with units for newly added device
        """
        if first_unit > last_unit:
            return NewUnits(last_unit, first_unit)
        return NewUnits(first_unit, last_unit)

    @staticmethod
    def check_unit_exist(units: NewUnits, rack_id: int) -> bool:
        """
        Units exist check
        Are there any such units?
        """
        new_device_range = range(units.new_first_unit, units.new_last_unit + 1)
        all_units_ramge = range(1, int(RackRepository.get_amount(rack_id)) + 1)
        if not set(new_device_range).issubset(all_units_ramge):
            return True
        else:
            return False

    @staticmethod
    def check_unit_busy(side: bool,
                        pk: int,
                        new_units: NewUnits,
                        old_units: Optional[OldUnits]
                        ) -> bool:
        """
        Units busy check
        Are units busy? (adding, updating)
        """
        filled_list: list = []
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
        if old_units:
            device_old_range = range(old_units.old_first_unit,
                                     old_units.old_last_unit + 1)
            filled_list = list(set(filled_list) - set(device_old_range))
        device_new_range = range(new_units.new_first_unit,
                                 new_units.new_last_unit + 1)
        if any(unit in set(device_new_range) for unit in filled_list):
            return True
        else:
            return False


class UserCheckService:
    """
    Services for checking user permission
    For add|update|delete user must be in group with the same name
    as object department affiliation
    """

    @staticmethod
    def check_for_groups(user_groups: List[str],
                         pk: int,
                         model: ModelBase
                         ) -> bool:
        """
        Checks user permission
        """
        if model == Department:
            department_name = DepartmentRepository \
                .get_department_name(pk)
        elif model == Site:
            department_name = SiteRepository \
                .get_department_name(pk)
        elif model == Building:
            department_name = BuildingRepository \
                .get_department_name(pk)
        elif model == Room:
            department_name = RoomRepository \
                .get_department_name(pk)
        elif model == Rack:
            department_name = RackRepository \
                .get_department_name(pk)
        elif model == Device:
            department_name = DeviceRepository \
                .get_department_name(pk)
        else:
            raise ValueError('model: ModelBase must be'
                             'Department|Site|Building|Room|Rack|Device')
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
        Get unique objects names list
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


class DataProcessingService:
    """
    Services for operations with data
    """

    @staticmethod
    def get_devices_power_w_sum(pk: int) -> int:
        """
        Get total power for single rack
        """
        power_w_list = DeviceRepository.get_devices_power_w(pk)
        return sum(power_w for power_w in power_w_list if power_w is not None)

    @staticmethod
    def update_rack_amount(data: dict, pk: int) -> dict:
        """
        Update rack_amount (prevent changing)
        """
        if data.get('rack_amount'):
            data['rack_amount'] = RackRepository.get_amount(pk)
            return data
        return data

    @staticmethod
    def get_key_name(data: dict, model_name: str) -> str:
        """
        Get key name for different models
        """
        key_name = data.get(f"{model_name}_name")
        if key_name:
            return key_name
        key_name = f"device " \
            f"{str(data.get('device_vendor') or 'unspecified vendor')}, " \
            f"{str(data.get('device_model') or 'unspecified model')}"
        return key_name

    @staticmethod
    def get_instance_name(pk: int, model: ModelBase, model_name: str) -> str:
        """
        Get instance name for different models
        """
        if model != Device:
            instance_name = getattr(model.objects.get(id=pk),
                                    f"{model_name}_name")
            return instance_name
        device = Device.objects.get_device(pk)
        device_vendor = device.device_vendor \
            if device.device_vendor != '' else 'unspecified vendor'
        device_model = device.device_model \
            if device.device_model != '' else 'unspecified model'
        instance_name = f"device {device_vendor}, {device_model}"
        return instance_name


class RepoService:
    """
    Service for repository layer calls and not serialized data(or primitives)
    """

    @staticmethod
    def get_instance(model: ModelBase, pk: int) -> ModelBase:
        """
        Get model instance
        """
        return model.objects.get(id=pk)

    @staticmethod
    def get_devices_for_rack(pk: int) -> QuerySet:
        """
        Get devices for single rack
        """
        return Device.objects.get_devices_for_rack(pk)

    @staticmethod
    def get_all_racks() -> QuerySet:
        """
        Get all racks
        """
        return Rack.objects.get_all_racks()

    @staticmethod
    def get_all_devices() -> QuerySet:
        """
        Get all devices
        """
        return Device.objects.get_all_devices()

    @staticmethod
    def get_all_rooms() -> QuerySet:
        """
        Get all rooms
        """
        return Room.objects.get_all_rooms()

    @staticmethod
    def get_all_buildings() -> QuerySet:
        """
        Get all buildings
        """
        return Building.objects.get_all_buildings()

    @staticmethod
    def get_all_sites() -> QuerySet:
        """
        Get all sites
        """
        return Site.objects.get_all_sites()

    @staticmethod
    def get_all_departments() -> QuerySet:
        """
        Get all departments
        """
        return Department.objects.get_all_departments()

    @staticmethod
    def get_all_regions() -> QuerySet:
        """
        Get all regions
        """
        return Region.objects.get_all_regions()

    @staticmethod
    def get_rack_room_name(pk: int) -> str:
        """
        Get room name for a particular rack
        """
        return RackRepository.get_room_name(pk)

    @staticmethod
    def get_rack_building_name(pk: int) -> str:
        """
        Get building name for a particular rack
        """
        return RackRepository.get_building_name(pk)

    @staticmethod
    def get_rack_site_name(pk: int) -> str:
        """
        Get building name for a particular rack
        """
        return RackRepository.get_site_name(pk)

    @staticmethod
    def get_rack_department_name(pk: int) -> str:
        """
        Get department name for a particular rack
        """
        return RackRepository.get_department_name(pk)

    @staticmethod
    def get_rack_region_name(pk: int) -> str:
        """
        Get region name for a particular rack
        """
        return RackRepository.get_region_name(pk)

    @staticmethod
    def get_device_rack_name(pk: int) -> str:
        """
        Get rack name for a particular device
        """
        return DeviceRepository.get_rack_name(pk)

    @staticmethod
    def get_device_room_name(pk: int) -> str:
        """
        Get room name for a particular device
        """
        return DeviceRepository.get_room_name(pk)

    @staticmethod
    def get_device_building_name(pk: int) -> str:
        """
        Get building name for a particular device
        """
        return DeviceRepository.get_building_name(pk)

    @staticmethod
    def get_device_site_name(pk: int) -> str:
        """
        Get site name for a particular device
        """
        return DeviceRepository.get_site_name(pk)

    @staticmethod
    def get_device_department_name(pk: int) -> str:
        """
        Get department name for a particular device
        """
        return DeviceRepository.get_department_name(pk)

    @staticmethod
    def get_device_region_name(pk: int) -> str:
        """
        Get region name for a particular device
        """
        return DeviceRepository.get_region_name(pk)

    @staticmethod
    def get_device_rack_id(pk: int) -> int:
        """
        Get rack id for a particular device
        """
        return DeviceRepository.get_rack_id(pk)

    @staticmethod
    def get_device_vendors() -> List[Optional[str]]:
        """
        Get list of unique and sorted device vendors
        """
        device_vendors = DeviceRepository.get_device_vendors()
        device_vendors.sort()
        return device_vendors

    @staticmethod
    def get_device_models() -> List[Optional[str]]:
        """
        Get list of unique and sorted device models
        """
        device_models = DeviceRepository.get_device_models()
        device_models.sort()
        return device_models

    @staticmethod
    def get_rack_vendors() -> List[Optional[str]]:
        """
        Get list of unique and sorted rack vendors
        """
        rack_vendors = RackRepository.get_unique_rack_vendors()
        rack_vendors.sort()
        return rack_vendors

    @staticmethod
    def get_rack_models() -> List[Optional[str]]:
        """
        Get list of unique and sorted rack vendors
        """
        rack_models = RackRepository.get_unique_rack_models()
        rack_models.sort()
        return rack_models
