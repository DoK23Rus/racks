"""
Business logic classes
"""
import datetime
import os
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


def date() -> str:
    """
    Current date

    Returns:
        date (str): Date in y-m-d format
    """
    return datetime.datetime.today().strftime("%Y-%m-%d_%H-%M-%S")


class OldUnits(NamedTuple):
    """
    Named tuple for old units pair (for data update)
    """
    old_first_unit: int
    old_last_unit: int


class NewUnits(NamedTuple):
    """
    Named tuple for old units pair (for data update)
    """
    new_first_unit: int
    new_last_unit: int


class DeviceCheckService:
    """
    Services for checking capabilities to add or update devices
    """

    @staticmethod
    def get_old_units(pk: Optional[int]) -> OldUnits:
        """
        Get tuple with already filled units

        Args:
            pk (int): Primary key

        Raises:
            ValueError ("pk cannot be None")

        Returns:
            OldUnits (tuple): First and last unit in named tuple (ordered)
        """
        if pk is None:
            raise ValueError("pk cannot be None")
        first_unit = Device.objects.get_device(pk).first_unit
        last_unit = Device.objects.get_device(pk).last_unit
        if first_unit > last_unit:
            return OldUnits(last_unit, first_unit)
        return OldUnits(first_unit, last_unit)

    @staticmethod
    def get_new_units(first_unit: int, last_unit: int) -> NewUnits:
        """
        Get tuple with units for newly added device

        Args:
            first_unit (int): First unit number
            last_unit (int): Last unit number

        Returns:
            NewUnits (tuple): First and last unit in named tuple (ordered)
        """
        if first_unit > last_unit:
            return NewUnits(last_unit, first_unit)
        return NewUnits(first_unit, last_unit)

    @staticmethod
    def check_unit_exist(units: NewUnits, rack_id: Optional[int]) -> bool:
        """
        Units exist check
        Are there any such units?

        Args:
            units (tuple): Pair of units in tuple
            rack_id (int): Rack id

        Raises:
            ValueError ("rack_id cannot be None")

        Returns:
            True (bool): units pair are in range of all rack units
            False (bool): units pair are outside of the rack
        """
        if rack_id is None:
            raise ValueError("rack_id cannot be None")
        new_device_range = range(units.new_first_unit, units.new_last_unit + 1)
        all_units_ramge = range(1, int(Rack
                                .objects.get_rack(rack_id).rack_amount) + 1)
        if not set(new_device_range).issubset(all_units_ramge):
            return True
        else:
            return False

    @staticmethod
    def check_unit_busy(side: bool,
                        pk: Optional[int],
                        new_units: NewUnits,
                        old_units: Optional[OldUnits]
                        ) -> bool:
        """
        Units busy check
        Are units busy? (adding, updating)

        Args:
            side (bool): Rack side (True - front, False - back)
            pk (int): Primary key
            new_units (tuple): Pair of new units
            old_units (tuple): Pair of old units (update only)

        Raises:
            ValueError ("pk cannot be None")

        Returns:
            True (bool): Units are busy
            False (bool): Units not busy
        """
        if pk is None:
            raise ValueError("pk cannot be None")
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
                         pk: Optional[int],
                         model: ModelBase
                         ) -> bool:
        """
        Checks user permission

        Args:
            user_groups (list): List of current user group names
            pk (int): Primary key
            model (ModelBase): Current object model

        Raises:
            ValueError ("pk cannot be None")
            ValueError ('model: ModelBase must be'
                        'Department|Site|Building|Room|Rack|Device'):
                Method only for Department|Site|Building|Room|Rack|Device.

        Returns:
            True (bool): Changes allowed
            False (bool): Changes are prohibited
        """
        if pk is None:
            raise ValueError("pk cannot be None")
        if model == Department:
            department_name = Department.objects.get(id=pk) \
                .department_name
        elif model == Site:
            department_name = Site.objects.get_site_department(pk) \
                .department_id \
                .department_name
        elif model == Building:
            department_name = Building.objects.get_building_department(pk) \
                .site_id \
                .department_id \
                .department_name
        elif model == Room:
            department_name = Room.objects.get_room_department(pk) \
                .building_id \
                .site_id \
                .department_id \
                .department_name
        elif model == Rack:
            department_name = Rack.objects.get_rack_department(pk) \
                .room_id \
                .building_id \
                .site_id \
                .department_id \
                .department_name
        elif model == Device:
            department_name = Device.objects.get_device_department(pk) \
                .rack_id \
                .room_id \
                .building_id \
                .site_id \
                .department_id \
                .department_name
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

        Args:
            key (int): Object id
            model (ModelBase): Foreign key object model

        Raises:
            ValueError (model: ModelBase must be Site|Building|Room):
                Method only for Site|Building|Room models.
                Region|Department|Site objects - unique=True
            ValueError (key must be not None): Typing plug

        Returns:
            names_list (set): Set of object names
                for particular foreign key object
        """
        if key is None:
            raise ValueError("key must be not None")
        if model == Site:
            names_set = {building.building_name for building
                         in Building.objects.get_buildings_for_site(key)}
        elif model == Building:
            names_set = {room.room_name for room
                         in Room.objects.get_rooms_for_building(key)}
        elif model == Room:
            names_set = {rack.rack_name for rack
                         in Rack.objects.get_racks_for_room(key)}
        else:
            raise ValueError("model: ModelBase must be Site|Building|Room")
        return names_set


class DataProcessingService:
    """
    Services for operations with data
    """

    @staticmethod
    def get_devices_power_w_sum(pk: int) -> int:
        """
        Get total power for single rack

        Args:
            pk (int): Primary key

        Returns:
            devices_power_w_sum (int): Summary power of all rack devices
        """
        power_w_list = list(Device
                            .objects
                            .filter(rack_id_id=pk)
                            .values_list('power_w', flat=True))
        return sum(power_w for power_w in power_w_list if power_w is not None)

    @staticmethod
    def update_rack_amount(data: dict, pk: Optional[int]) -> dict:
        """
        Update rack_amount (prevent changing)

        Args:
            data (dict): New data set
            pk (int): Primary key

        Raises:
            ValueError ("pk cannot be None")

        Returns:
            data (dict): Same data set with old rack amount
        """
        if pk is None:
            raise ValueError("pk cannot be None")
        if data.get('rack_amount'):
            data['rack_amount'] = Rack.objects.get_rack(pk).rack_amount
            return data
        return data

    @staticmethod
    def get_key_name(data: dict, model_name: str) -> str:
        """
        Get key name for different models

        Args:
            data (dict): New data set
            model_name (str): Object model name

        Returns:
            key_name (str): Key name for an object
                (devices has no name, only vendor and model)
        """
        key_name = data.get(f"{model_name}_name")
        if key_name:
            return key_name
        key_name = f"device " \
            f"{str(data.get('device_vendor') or 'unspecified vendor')}, " \
            f"{str(data.get('device_model') or 'unspecified model')}"
        return key_name

    @staticmethod
    def get_instance_name(pk: Optional[int],
                          model: ModelBase,
                          model_name: str
                          ) -> str:
        """
        Get instance name for different models

        Args:
            pk (int): Primary key
            model (ModelBase): Object model
            model_name (str): Object model name

        Raises:
            ValueError ("pk cannot be None")

        Returns:
            instance_name (str): Instance name for an object
                (only vendor and model for devices)
        """
        if pk is None:
            raise ValueError("pk cannot be None")
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
    Service for a model layer calls
    """

    @staticmethod
    def get_instance(model: ModelBase, pk: Optional[int]) -> ModelBase:
        """
        Get model instance

        Args:
            model (ModelBase): Object model
            pk (int): Primary key

        Raises:
            ValueError ("pk cannot be None")

        Returns:
            instance (ModelBase): Model instance
        """
        if pk is None:
            raise ValueError("pk cannot be None")
        return model.objects.get(id=pk)

    @staticmethod
    def get_devices_for_rack(pk: Optional[int]) -> QuerySet:
        """
        Get devices for single rack

        Args:
            pk (int): Primary key

        Raises:
            ValueError ("pk cannot be None")

        Returns:
            devices_for_rack (QuerySet): Devices queryset (for single rack)
        """
        if pk is None:
            raise ValueError("pk cannot be None")
        return Device.objects.get_devices_for_rack(pk)

    @staticmethod
    def get_all_racks() -> QuerySet:
        """
        Get all racks

        Returns:
            all_racks (QuerySet): All racks queryset
        """
        return Rack.objects.get_all_racks()

    @staticmethod
    def get_all_rooms() -> QuerySet:
        """
        Get all rooms

        Returns:
            all_rooms (QuerySet): All rooms queryset
        """
        return Room.objects.get_all_rooms()

    @staticmethod
    def get_all_buildings() -> QuerySet:
        """
        Get all buildings

        Returns:
            all_buildings (QuerySet): All buildings queryset
        """
        return Building.objects.get_all_buildings()

    @staticmethod
    def get_all_sites() -> QuerySet:
        """
        Get all sites

        Returns:
            all_sites (QuerySet): All sites queryset
        """
        return Site.objects.get_all_sites()

    @staticmethod
    def get_all_departments() -> QuerySet:
        """
        Get all departments

        Returns:
            all_departments (QuerySet): All departments queryset
        """
        return Department.objects.get_all_departments()

    @staticmethod
    def get_all_regions() -> QuerySet:
        """
        Get all regions

        Returns:
            all_regions (QuerySet): All regions queryset
        """
        return Region.objects.get_all_regions()

    @staticmethod
    def get_rack_room_name(pk: Optional[int]) -> str:
        """
        Get room name for a particular rack

        Args:
            pk (int): Primary key

        Raises:
            ValueError ("pk cannot be None")

        Returns:
            rack_room_name (str): Room name for particular rack
        """
        if pk is None:
            raise ValueError("pk cannot be None")
        return Rack.objects.get_rack_room(pk) \
            .room_id \
            .room_name

    @staticmethod
    def get_rack_building_name(pk: Optional[int]) -> str:
        """
        Get building name for a particular rack

        Args:
            pk (int): Primary key

        Raises:
            ValueError ("pk cannot be None")

        Returns:
            rack_building_name (str): Building name for particular rack
        """
        if pk is None:
            raise ValueError("pk cannot be None")
        return Rack.objects.get_rack_building(pk) \
            .room_id \
            .building_id \
            .building_name

    @staticmethod
    def get_rack_site_name(pk: Optional[int]) -> str:
        """
        Get building name for a particular rack

        Args:
            pk (int): Primary key

        Raises:
            ValueError ("pk cannot be None")

        Returns:
            rack_site_name (str): Site name for particular rack
        """
        if pk is None:
            raise ValueError("pk cannot be None")
        return Rack.objects.get_rack_site(pk) \
            .room_id \
            .building_id \
            .site_id \
            .site_name

    @staticmethod
    def get_rack_department_name(pk: Optional[int]) -> str:
        """
        Get department name for a particular rack

        Args:
            pk (int): Primary key

        Raises:
            ValueError ("pk cannot be None")

        Returns:
            rack_department_name (str): Department name for particular rack
        """
        if pk is None:
            raise ValueError("pk cannot be None")
        return Rack.objects.get_rack_department(pk) \
            .room_id \
            .building_id \
            .site_id \
            .department_id \
            .department_name

    @staticmethod
    def get_rack_region_name(pk: Optional[int]) -> str:
        """
        Get region name for a particular rack

        Args:
            pk (int): Primary key

        Raises:
            ValueError ("pk cannot be None")

        Returns:
            rack_region_name (str): Region name for particular rack
        """
        if pk is None:
            raise ValueError("pk cannot be None")
        return Rack.objects.get_rack_region(pk) \
            .room_id \
            .building_id \
            .site_id \
            .department_id \
            .region_id \
            .region_name

    @staticmethod
    def get_device_rack_name(pk: Optional[int]) -> str:
        """
        Get rack name for a particular device

        Args:
            pk (int): Primary key

        Raises:
            ValueError ("pk cannot be None")

        Returns:
            device_rack_name (str): Rack name for particular device
        """
        if pk is None:
            raise ValueError("pk cannot be None")
        return Device.objects.get_device_rack(pk) \
            .rack_id \
            .rack_name

    @staticmethod
    def get_device_room_name(pk: Optional[int]) -> str:
        """
        Get room name for a particular device

        Args:
            pk (int): Primary key

        Raises:
            ValueError ("pk cannot be None")

        Returns:
            device_room_name (str): Room name for particular device
        """
        if pk is None:
            raise ValueError("pk cannot be None")
        return Device.objects.get_device_room(pk) \
            .rack_id \
            .room_id \
            .room_name

    @staticmethod
    def get_device_building_name(pk: Optional[int]) -> str:
        """
        Get building name for a particular device

        Args:
            pk (int): Primary key

        Raises:
            ValueError ("pk cannot be None")

        Returns:
            device_building_name (str): Building name for particular device
        """
        if pk is None:
            raise ValueError("pk cannot be None")
        return Device.objects.get_device_building(pk) \
            .rack_id \
            .room_id \
            .building_id \
            .building_name

    @staticmethod
    def get_device_site_name(pk: Optional[int]) -> str:
        """
        Get site name for a particular device

        Args:
            pk (int): Primary key

        Raises:
            ValueError ("pk cannot be None")

        Returns:
            device_site_name (str): Site name for particular device
        """
        if pk is None:
            raise ValueError("pk cannot be None")
        return Device.objects.get_device_site(pk) \
            .rack_id \
            .room_id \
            .building_id \
            .site_id \
            .site_name

    @staticmethod
    def get_device_department_name(pk: Optional[int]) -> str:
        """
        Get department name for a particular device

        Args:
            pk (int): Primary key

        Raises:
            ValueError ("pk cannot be None")

        Returns:
            device_department_name (str): Site name for particular device
        """
        if pk is None:
            raise ValueError("pk cannot be None")
        return Device.objects.get_device_department(pk) \
            .rack_id \
            .room_id \
            .building_id \
            .site_id \
            .department_id \
            .department_name

    @staticmethod
    def get_device_region_name(pk: Optional[int]) -> str:
        """
        Get region name for a particular device

        Args:
            pk (int): Primary key

        Raises:
            ValueError ("pk cannot be None")

        Returns:
            device_region_name (str): Region name for particular device
        """
        if pk is None:
            raise ValueError("pk cannot be None")
        return Device.objects.get_device_region(pk) \
            .rack_id \
            .room_id \
            .building_id \
            .site_id \
            .department_id \
            .region_id \
            .region_name

    @staticmethod
    def get_device_rack_id(pk: Optional[int]) -> int:
        """
        Get rack id for a particular device

        Args:
            pk (int): Primary key

        Raises:
            ValueError ("pk cannot be None")

        Returns:
            device_rack_id (int): Rack id for particular device
        """
        if pk is None:
            raise ValueError("pk cannot be None")
        return Device.objects.get_device(pk).rack_id_id

    @staticmethod
    def get_device_vendors() -> List[Optional[str]]:
        """
        Get list of unique and sorted device vendors

        Returns:
            device_vendors (list): Sorted list of unique device vendors
        """
        device_vendors = list(Device.objects.get_device_vendors().distinct())
        device_vendors.sort()
        return device_vendors

    @staticmethod
    def get_device_models() -> List[Optional[str]]:
        """
        Get list of unique and sorted device models

        Returns:
            device_models (list): Sorted list of unique device models
        """
        device_models = list(Device.objects.get_device_models().distinct())
        device_models.sort()
        return device_models

    @staticmethod
    def get_rack_vendors() -> List[Optional[str]]:
        """
        Get list of unique and sorted rack vendors

        Returns:
            rack_vendors (list): Sorted list of unique rack vendors
        """
        rack_vendors = list(Rack.objects.get_rack_vendors().distinct())
        rack_vendors.sort()
        return rack_vendors

    @staticmethod
    def get_rack_models() -> List[Optional[str]]:
        """
        Get list of unique and sorted rack vendors

        Returns:
            rack_models (list): Sorted list of unique rack models
        """
        rack_models = list(Rack.objects.get_rack_models().distinct())
        rack_models.sort()
        return rack_models


class ReportService:
    """
    Service for generating reports
    """

    @staticmethod
    def get_devices_data() -> List[List[str]]:
        """
        Get data for devices report (all devices data)

        Returns:
            devices_data (list): List of lists with devices data
        """
        devices_data: List = []
        for device in Device.objects.get_devices_report():
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
                f"{os.environ.get('DEVICE_REPORT_LINK')}"
                f"{str(device.device_stack)}" if device.device_stack
                is not None else None,
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
                f"{os.environ.get('DEVICE_REPORT_LINK')}{str(str(device.id))}",
            ])
        return devices_data

    @staticmethod
    def get_racks_data() -> List[List[str]]:
        """
        Get data for racks report (all racks data)

        Returns:
            racks_data (list): List of lists with racks data
        """
        racks_data: List = []
        for rack in Rack.objects.get_racks_report():
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
                rack.updated_by,
                rack.updated_at,
                rack.room_name,
                rack.building_name,
                rack.site_name,
                rack.department_name,
                rack.region_name,
                f"{os.environ.get('RACK_REPORT_LINK')}{str(str(rack.id))}",
            ])
        return racks_data
