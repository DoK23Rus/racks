from django.db.models.query import QuerySet
from mainapp.models import (Building,
                            Department,
                            Device,
                            Rack,
                            Region,
                            Room,
                            Site)
from typing import List, Optional, Set, NamedTuple


class RegionRepository:

    @staticmethod
    def get_instance(pk):
        return Region.objects.get(id=pk)

    @staticmethod
    def get_all_regions() -> QuerySet:
        """
        Get all regions

        Returns:
            all_regions (QuerySet): All regions queryset
        """
        return Region.objects.get_all_regions()


class DepartmentRepository:

    @staticmethod
    def get_instance(pk):
        return Department.objects.get(id=pk)

    @staticmethod
    def get_department_name(pk):
        return Department.objects.get(id=pk) \
            .department_name

    @staticmethod
    def get_all_departments() -> QuerySet:
        """
        Get all departments

        Returns:
            all_departments (QuerySet): All departments queryset
        """
        return Department.objects.get_all_departments()


class SiteRepository:

    @staticmethod
    def get_instance(pk):
        return Site.objects.get(id=pk)

    @staticmethod
    def get_department_name(pk):
        return Site.objects.get_site_department(pk) \
            .department_id \
            .department_name

    @staticmethod
    def get_all_sites() -> QuerySet:
        """
        Get all sites

        Returns:
            all_sites (QuerySet): All sites queryset
        """
        return Site.objects.get_all_sites()


class BuildingRepository:

    @staticmethod
    def get_instance(pk):
        return Building.objects.get(id=pk)

    @staticmethod
    def get_department_name(pk):
        return Building.objects.get_building_department(pk) \
            .site_id \
            .department_id \
            .department_name

    @staticmethod
    def get_unique_object_names_list(key):
        return {building.building_name for building
                in Building.objects.get_buildings_for_site(key)}

    @staticmethod
    def get_all_buildings() -> QuerySet:
        """
        Get all buildings

        Returns:
            all_buildings (QuerySet): All buildings queryset
        """
        return Building.objects.get_all_buildings()


class RoomRepository:

    @staticmethod
    def get_instance(pk):
        return Room.objects.get(id=pk)

    @staticmethod
    def get_department_name(pk):
        return Room.objects.get_room_department(pk) \
            .building_id \
            .site_id \
            .department_id \
            .department_name

    @staticmethod
    def get_unique_object_names_list(key):
        return {room.room_name for room
                in Room.objects.get_rooms_for_building(key)}

    @staticmethod
    def get_all_rooms():
        """
        Get all rooms

        Returns:
            all_rooms (QuerySet): All rooms queryset
        """
        return Room.objects.get_all_rooms()


class RackRepository:

    @staticmethod
    def get_instance(pk):
        return Rack.objects.get(id=pk)

    @staticmethod
    def get_department_name(pk):
        return Rack.objects.get_rack_department(pk) \
            .room_id \
            .building_id \
            .site_id \
            .department_id \
            .department_name

    @staticmethod
    def get_rack_amount(rack_id):
        return int(Rack.objects.get_rack(rack_id).rack_amount)

    @staticmethod
    def get_unique_object_names_list(key):
        return {rack.rack_name for rack
                in Rack.objects.get_racks_for_room(key)}

    @staticmethod
    def get_report_data():
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
    def get_all_racks():
        """
        Get all racks

        Returns:
            all_racks (QuerySet): All racks queryset
        """
        return Rack.objects.get_all_racks()

    @staticmethod
    def get_rack_room_name(pk) -> str:
        """
        Get room name for a particular rack

        Args:
            pk (int): Primary key

        Raises:
            ValueError ("pk cannot be None")

        Returns:
            rack_room_name (str): Room name for particular rack
        """
        return Rack.objects.get_rack_room(pk) \
            .room_id \
            .room_name

    @staticmethod
    def get_all_racks_partial():
        """
        Get all racks partial

        Returns:
            all_racks (QuerySet): All racks partial queryset
        """
        return Rack.objects.get_all_racks_partial()

    @staticmethod
    def get_rack_building_name(pk) -> str:
        """
        Get building name for a particular rack

        Args:
            pk (int): Primary key

        Raises:
            ValueError ("pk cannot be None")

        Returns:
            rack_building_name (str): Building name for particular rack
        """
        return Rack.objects.get_rack_building(pk) \
            .room_id \
            .building_id \
            .building_name

    @staticmethod
    def get_rack_site_name(pk) -> str:
        """
        Get building name for a particular rack

        Args:
            pk (int): Primary key

        Raises:
            ValueError ("pk cannot be None")

        Returns:
            rack_site_name (str): Site name for particular rack
        """
        return Rack.objects.get_rack_site(pk) \
            .room_id \
            .building_id \
            .site_id \
            .site_name

    @staticmethod
    def get_rack_department_name(pk) -> str:
        """
        Get department name for a particular rack

        Args:
            pk (int): Primary key

        Raises:
            ValueError ("pk cannot be None")

        Returns:
            rack_department_name (str): Department name for particular rack
        """
        return Rack.objects.get_rack_department(pk) \
            .room_id \
            .building_id \
            .site_id \
            .department_id \
            .department_name

    @staticmethod
    def get_rack_region_name(pk) -> str:
        """
        Get region name for a particular rack

        Args:
            pk (int): Primary key

        Raises:
            ValueError ("pk cannot be None")

        Returns:
            rack_region_name (str): Region name for particular rack
        """
        return Rack.objects.get_rack_region(pk) \
            .room_id \
            .building_id \
            .site_id \
            .department_id \
            .region_id \
            .region_name


class DeviceRepository:

    @staticmethod
    def get_instance(pk):
        return Device.objects.get(id=pk)

    @staticmethod
    def get_device_rack_id(pk) -> int:
        """
        Get rack id for a particular device

        Args:
            pk (int): Primary key

        Raises:
            ValueError ("pk cannot be None")

        Returns:
            device_rack_id (int): Rack id for particular device
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
    def get_devices_for_side(pk, side):
        return Device.objects.get_devices_for_side(pk, side)

    @staticmethod
    def get_devices_for_rack(pk):
        """
        Get devices for single rack

        Args:
            pk (int): Primary key

        Raises:
            ValueError ("pk cannot be None")

        Returns:
            devices_for_rack (QuerySet): Devices queryset (for single rack)
        """
        return Device.objects.get_devices_for_rack(pk)

    @staticmethod
    def get_first_unit(pk):
        return Device.objects.get_device(pk).first_unit

    @staticmethod
    def get_last_unit(pk):
        return Device.objects.get_device(pk).last_unit

    @staticmethod
    def get_department_name(pk):
        return Device.objects.get_device_department(pk) \
            .rack_id \
            .room_id \
            .building_id \
            .site_id \
            .department_id \
            .department_name

    @staticmethod
    def get_devices_power_list(pk):
        return list(Device
                    .objects
                    .filter(rack_id_id=pk)
                    .values_list('power_w', flat=True))

    @staticmethod
    def get_report_data():
        return Device.objects.get_devices_report()

    @staticmethod
    def get_device_rack_name(pk) -> str:
        """
        Get rack name for a particular device

        Args:
            pk (int): Primary key

        Raises:
            ValueError ("pk cannot be None")

        Returns:
            device_rack_name (str): Rack name for particular device
        """
        return Device.objects.get_device_rack(pk) \
            .rack_id \
            .rack_name

    @staticmethod
    def get_device_room_name(pk) -> str:
        """
        Get room name for a particular device

        Args:
            pk (int): Primary key

        Raises:
            ValueError ("pk cannot be None")

        Returns:
            device_room_name (str): Room name for particular device
        """
        return Device.objects.get_device_room(pk) \
            .rack_id \
            .room_id \
            .room_name

    @staticmethod
    def get_device_building_name(pk) -> str:
        """
        Get building name for a particular device

        Args:
            pk (int): Primary key

        Raises:
            ValueError ("pk cannot be None")

        Returns:
            device_building_name (str): Building name for particular device
        """
        return Device.objects.get_device_building(pk) \
            .rack_id \
            .room_id \
            .building_id \
            .building_name

    @staticmethod
    def get_device_site_name(pk) -> str:
        """
        Get site name for a particular device

        Args:
            pk (int): Primary key

        Raises:
            ValueError ("pk cannot be None")

        Returns:
            device_site_name (str): Site name for particular device
        """
        return Device.objects.get_device_site(pk) \
            .rack_id \
            .room_id \
            .building_id \
            .site_id \
            .site_name

    @staticmethod
    def get_device_department_name(pk) -> str:
        """
        Get department name for a particular device

        Args:
            pk (int): Primary key

        Raises:
            ValueError ("pk cannot be None")

        Returns:
            device_department_name (str): Site name for particular device
        """
        return Device.objects.get_device_department(pk) \
            .rack_id \
            .room_id \
            .building_id \
            .site_id \
            .department_id \
            .department_name

    @staticmethod
    def get_device_region_name(pk) -> str:
        """
        Get region name for a particular device

        Args:
            pk (int): Primary key

        Raises:
            ValueError ("pk cannot be None")

        Returns:
            device_region_name (str): Region name for particular device
        """
        return Device.objects.get_device_region(pk) \
            .rack_id \
            .room_id \
            .building_id \
            .site_id \
            .department_id \
            .region_id \
            .region_name


class RepositoryHelper:

    @staticmethod
    def get_repository(model):
        repository = {
            Region: RegionRepository,
            Department: DepartmentRepository,
            Site: SiteRepository,
            Building: BuildingRepository,
            Room: RoomRepository,
            Rack: RackRepository,
            Device: DeviceRepository,
        }.get(model)()
        if not repository:
            raise ValueError("model: ModelBase must be Site|Building|Room")
        return repository

    @staticmethod
    def get_child_model_repository(model):
        child_repository = {
            Region: DepartmentRepository,
            Department: SiteRepository,
            Site: BuildingRepository,
            Building: RoomRepository,
            Room: RackRepository,
            Rack: DeviceRepository,
        }.get(model)()
        if not child_repository:
            raise ValueError("model: ModelBase must be Site|Building|Room")
        return child_repository
