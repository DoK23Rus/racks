"""
Repository for querysets and primitives
"""
from typing import List, Optional, Union, Type

from django.db.models.base import ModelBase
from django.db.models.query import QuerySet, RawQuerySet

from mainapp.models import (Building,
                            Department,
                            Device,
                            Rack,
                            Region,
                            Room,
                            Site)


class RegionRepository:
    """
    Region repository
    """

    @staticmethod
    def get_instance(pk: int) -> ModelBase:
        """
        Get region instance

        Args:
            pk (int): Primary key

        Returns:
            (ModelBase): Region instance
        """

        return Region.objects.get(id=pk)

    @staticmethod
    def get_all_regions() -> QuerySet:
        """
        Get all regions

        Returns:
            (QuerySet): All regions queryset
        """
        return Region.objects.get_all_regions()


class DepartmentRepository:
    """
    Department repository
    """

    @staticmethod
    def get_instance(pk: int) -> ModelBase:
        """
        Get department instance

        Args:
            pk (int): Primary key

        Returns:
            (ModelBase): Department instance
        """
        return Department.objects.get(id=pk)

    @staticmethod
    def get_department_name(pk: int) -> str:
        """
        Get department name

        Args:
            pk (int): Primary key

        Returns:
            (str): Department name
        """
        return Department.objects.get(id=pk) \
            .department_name

    @staticmethod
    def get_all_departments() -> QuerySet:
        """
        Get all departments

        Returns:
            (QuerySet): All departments queryset
        """
        return Department.objects.get_all_departments()

    @staticmethod
    def get_departments_for_region(pk: int) -> ModelBase:
        return Department.objects.get_departments_for_region(pk)


class SiteRepository:
    """
    Site repository
    """

    @staticmethod
    def get_instance(pk: int) -> ModelBase:
        """
        Get site instance

        Args:
            pk (int): Primary key

        Returns:
            (site): Site instance
        """
        return Site.objects.get(id=pk)

    @staticmethod
    def get_department_name(pk: int) -> str:
        """
        Get department name

        Args:
            pk (int): Primary key

        Returns:
            (str): Department name
        """
        return Site.objects.get_site_department(pk) \
            .department_id \
            .department_name

    @staticmethod
    def get_all_sites() -> QuerySet:
        """
        Get all sites

        Returns:
            (QuerySet): All sites queryset
        """
        return Site.objects.get_all_sites()


class BuildingRepository:
    """
    Building repository
    """

    @staticmethod
    def get_instance(pk: int) -> ModelBase:
        """
        Get building instance

        Args:
            pk (int): Primary key

        Returns:
            (ModelBase): Building instance
        """
        return Building.objects.get(id=pk)

    @staticmethod
    def get_department_name(pk: int) -> str:
        """
        Get department name

        Args:
            pk (int): Primary key

        Returns:
            (str): Department name
        """
        return Building.objects.get_building_department(pk) \
            .site_id \
            .department_id \
            .department_name

    @staticmethod
    def get_unique_object_names_list(key: int) -> set:
        """
        Get building names set

        Args:
            pk (int): Primary key

        Returns:
            (set): Building names set
        """
        return {building.building_name for building
                in Building.objects.get_buildings_for_site(key)}

    @staticmethod
    def get_all_buildings() -> QuerySet:
        """
        Get all buildings

        Returns:
            (QuerySet): All buildings queryset
        """
        return Building.objects.get_all_buildings()


class RoomRepository:
    """
    Room repository
    """

    @staticmethod
    def get_instance(pk: int) -> ModelBase:
        """
        Get room instance

        Args:
            pk (int): Primary key

        Returns:
            (ModelBase): Room instance
        """
        return Room.objects.get(id=pk)

    @staticmethod
    def get_department_name(pk: int) -> str:
        """
        Get department name

        Args:
            pk (int): Primary key

        Returns:
            (str): Department name
        """
        return Room.objects.get_room_department(pk) \
            .building_id \
            .site_id \
            .department_id \
            .department_name

    @staticmethod
    def get_unique_object_names_list(key: int) -> set:
        """
        Get room names set

        Args:
            pk (int): Primary key

        Returns:
            (set): room names set
        """
        return {room.room_name for room
                in Room.objects.get_rooms_for_building(key)}

    @staticmethod
    def get_all_rooms() -> QuerySet:
        """
        Get all rooms

        Returns:
            all_rooms (QuerySet): All rooms queryset
        """
        return Room.objects.get_all_rooms()


class RackRepository:

    @staticmethod
    def get_instance(pk: int) -> ModelBase:
        """
        Get rack instance

        Args:
            pk (int): Primary key

        Returns:
            (ModelBase): Rack instance
        """
        return Rack.objects.get(id=pk)

    @staticmethod
    def get_department_name(pk: int) -> str:
        """
        Get department name

        Args:
            pk (int): Primary key

        Returns:
            (str): Department name
        """
        return Rack.objects.get_rack_department(pk) \
            .room_id \
            .building_id \
            .site_id \
            .department_id \
            .department_name

    @staticmethod
    def get_rack_amount(rack_id: int) -> int:
        """
        Get rack amount

        Args:
            rack_id (int): Rack id

        Returns:
            (int): Rack amount
        """
        return int(Rack.objects.get_rack(rack_id).rack_amount)

    @staticmethod
    def get_unique_object_names_list(key: int) -> set:
        """
        Get unique names list

        Args:
            Key (int): Key

        Returns:
            (set): Set of unique rack names
        """
        return {rack.rack_name for rack
                in Rack.objects.get_racks_for_room(key)}

    @staticmethod
    def get_report_data() -> RawQuerySet:
        """
        Get rack report data

        Returns:
            (RawQuerySet): Rack report data
        """
        return Rack.objects.get_racks_report()

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

    @staticmethod
    def get_all_racks() -> QuerySet:
        """
        Get all racks

        Returns:
            (QuerySet): All racks queryset
        """
        return Rack.objects.get_all_racks()

    @staticmethod
    def get_rack_room_name(pk: int) -> str:
        """
        Get room name for a particular rack

        Args:
            pk (int): Primary key

        Returns:
            (str): Room name for particular rack
        """
        return Rack.objects.get_rack_room(pk) \
            .room_id \
            .room_name

    @staticmethod
    def get_all_racks_partial() -> QuerySet:
        """
        Get all racks partial

        Returns:
            (QuerySet): All racks partial queryset
        """
        return Rack.objects.get_all_racks_partial()

    @staticmethod
    def get_rack_building_name(pk: int) -> str:
        """
        Get building name for a particular rack

        Args:
            pk (int): Primary key

        Returns:
            (str): Building name for particular rack
        """
        return Rack.objects.get_rack_building(pk) \
            .room_id \
            .building_id \
            .building_name

    @staticmethod
    def get_rack_site_name(pk: int) -> str:
        """
        Get building name for a particular rack

        Args:
            pk (int): Primary key

        Returns:
            (str): Site name for particular rack
        """
        return Rack.objects.get_rack_site(pk) \
            .room_id \
            .building_id \
            .site_id \
            .site_name

    @staticmethod
    def get_rack_department_name(pk: int) -> str:
        """
        Get department name for a particular rack

        Args:
            pk (int): Primary key

        Returns:
            (str): Department name for particular rack
        """
        return Rack.objects.get_rack_department(pk) \
            .room_id \
            .building_id \
            .site_id \
            .department_id \
            .department_name

    @staticmethod
    def get_rack_region_name(pk: int) -> str:
        """
        Get region name for a particular rack

        Args:
            pk (int): Primary key

        Returns:
            (str): Region name for particular rack
        """
        return Rack.objects.get_rack_region(pk) \
            .room_id \
            .building_id \
            .site_id \
            .department_id \
            .region_id \
            .region_name


class DeviceRepository:
    """
    Device repository
    """

    @staticmethod
    def get_instance(pk: int) -> ModelBase:
        """
        Get device instance

        Args:
            pk (int): Primary key

        Returns:
            (ModelBase): Device instance
        """
        return Device.objects.get(id=pk)

    @staticmethod
    def get_device_rack_id(pk) -> int:
        """
        Get rack id for a particular device

        Args:
            pk (int): Primary key

        Returns:
            (int): Rack id for particular device
        """
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
    def get_devices_for_side(pk: int, side: bool) -> QuerySet:
        """
        Get devices for side

        Args:
            pk (int): Primary key
            side (bool): Rack side

        Returns:
            (QuerySet): Devices for side queryset
        """
        return Device.objects.get_devices_for_side(pk, side)

    @staticmethod
    def get_devices_for_rack(pk: int) -> QuerySet:
        """
        Get devices for single rack

        Args:
            pk (int): Primary key

        Returns:
            (QuerySet): Devices queryset (for single rack)
        """
        return Device.objects.get_devices_for_rack(pk)

    @staticmethod
    def get_first_unit(pk: int) -> int:
        """
        Get device first unit

        Args:
            pk (int): Primary key

        Returns:
            (int): Device first unit
        """
        return Device.objects.get_device(pk).first_unit

    @staticmethod
    def get_last_unit(pk: int) -> int:
        """
        Get device last unit

        Args:
            pk (int): Primary key

        Returns:
            (int): Device last unit
        """
        return Device.objects.get_device(pk).last_unit

    @staticmethod
    def get_department_name(pk: int) -> str:
        """
        Get department name

        Args:
            pk (int): Primary key

        Returns:
            (str): Department name
        """
        return Device.objects.get_device_department(pk) \
            .rack_id \
            .room_id \
            .building_id \
            .site_id \
            .department_id \
            .department_name

    @staticmethod
    def get_devices_power_list(pk: int) -> list:
        """
        Get devices power list

        Args:
            pk (int): Primary key

        Returns:
            (list): Devices power list
        """
        return list(Device
                    .objects
                    .filter(rack_id_id=pk)
                    .values_list('power_w', flat=True))

    @staticmethod
    def get_report_data() -> RawQuerySet:
        """
        Get report data

        Returns:
            (RawQuerySet): Devices report data
        """
        return Device.objects.get_devices_report()

    @staticmethod
    def get_device_rack_name(pk: int) -> str:
        """
        Get rack name for a particular device

        Args:
            pk (int): Primary key

        Returns:
            (str): Rack name for particular device
        """
        return Device.objects.get_device_rack(pk) \
            .rack_id \
            .rack_name

    @staticmethod
    def get_device_room_name(pk: int) -> str:
        """
        Get room name for a particular device

        Args:
            pk (int): Primary key

        Returns:
            (str): Room name for particular device
        """
        return Device.objects.get_device_room(pk) \
            .rack_id \
            .room_id \
            .room_name

    @staticmethod
    def get_device_building_name(pk: int) -> str:
        """
        Get building name for a particular device

        Args:
            pk (int): Primary key

        Returns:
            (str): Building name for particular device
        """
        return Device.objects.get_device_building(pk) \
            .rack_id \
            .room_id \
            .building_id \
            .building_name

    @staticmethod
    def get_device_site_name(pk: int) -> str:
        """
        Get site name for a particular device

        Args:
            pk (int): Primary key

        Returns:
            (str): Site name for particular device
        """
        return Device.objects.get_device_site(pk) \
            .rack_id \
            .room_id \
            .building_id \
            .site_id \
            .site_name

    @staticmethod
    def get_device_department_name(pk: int) -> str:
        """
        Get department name for a particular device

        Args:
            pk (int): Primary key

        Returns:
            (str): Site name for particular device
        """
        return Device.objects.get_device_department(pk) \
            .rack_id \
            .room_id \
            .building_id \
            .site_id \
            .department_id \
            .department_name

    @staticmethod
    def get_device_region_name(pk: int) -> str:
        """
        Get region name for a particular device

        Args:
            pk (int): Primary key

        Returns:
            (str): Region name for particular device
        """
        return Device.objects.get_device_region(pk) \
            .rack_id \
            .room_id \
            .building_id \
            .site_id \
            .department_id \
            .region_id \
            .region_name


Repository_Type = Union[Type[DeviceRepository],
                        Type[RackRepository],
                        Type[RoomRepository],
                        Type[SiteRepository],
                        Type[BuildingRepository],
                        Type[DepartmentRepository],
                        Type[RegionRepository]]


class RepositoryHelper:
    """
    Repository helper
    """

    @staticmethod
    def get_model_repository(model):
        """
        Get repository based on model

        Args:
            model (BaseModel): Model

        Raises:
           raise ValueError('model: ModelBase must be Site|Building|Room')

        Returns:
            (repository): Repository class
        """
        repository = {
            Region: RegionRepository,
            Department: DepartmentRepository,
            Site: SiteRepository,
            Building: BuildingRepository,
            Room: RoomRepository,
            Rack: RackRepository,
            Device: DeviceRepository,
        }.get(model, lambda *args: False)()
        if not repository:
            raise ValueError('model: ModelBase must be Site|Building|Room')
        return repository
