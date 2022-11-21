"""
Repository for serialized data and primitives
"""
from typing import List, Union

from mainapp.models import Building, Department, Device, Rack, Room, Site


class DepartmentRepository:
    """
    Department repository
    """

    @staticmethod
    def get_department_name(pk: int) -> str:
        """
        Get department name from department id

        Args:
            pk (int): Primary key

        Returns:
            department_name (str): Department name from department id
        """
        return Department.objects.get(id=pk) \
            .department_name


class SiteRepository:
    """
    Site repository
    """

    @staticmethod
    def get_department_name(pk: int) -> str:
        """
        Get department name from site id

        Args:
            pk (int): Primary key

        Returns:
            department_name (str): Department name from site id
        """
        return Site.objects.get_site_department(pk) \
            .department_id \
            .department_name


class BuildingRepository:
    """
    Building repository
    """

    @staticmethod
    def get_department_name(pk: int) -> str:
        """
        Get department name from building id

        Args:
            pk (int): Primary key

        Returns:
            department_name (str): Department name from building id
        """
        return Building.objects.get_building_department(pk) \
            .site_id \
            .department_id \
            .department_name


class RoomRepository:
    """
    Room repository
    """

    @staticmethod
    def get_department_name(pk: int) -> str:
        """
        Get department name from room id

        Args:
            pk (int): Primary key

        Returns:
            department_name (str): Department name from room id
        """
        return Room.objects.get_room_department(pk) \
            .building_id \
            .site_id \
            .department_id \
            .department_name


class RackRepository:
    """
    Rack repository
    """

    @staticmethod
    def get_amount(pk: int) -> int:
        """
        Get rack amount

        Args:
            pk (int): Primary key

        Returns:
            amount (int): Rack amount
        """
        return Rack.objects.get_rack(pk).rack_amount

    @staticmethod
    def get_room_name(pk: int) -> str:
        """
        Get room name from rack id

        Args:
            pk (int): Primary key

        Returns:
            room_name (str): Room name from rack id
        """
        return Rack.objects.get_rack_room(pk) \
            .room_id \
            .room_name

    @staticmethod
    def get_building_name(pk: int) -> str:
        """
        Get building name from rack id

        Args:
            pk (int): Primary key

        Returns:
            building_name (str): Building name from rack id
        """
        return Rack.objects.get_rack_building(pk) \
            .room_id \
            .building_id \
            .building_name

    @staticmethod
    def get_site_name(pk: int) -> str:
        """
        Get site name from rack id

        Args:
            pk (int): Primary key

        Returns:
            site_name (str): Site name from rack id
        """
        return Rack.objects.get_rack_site(pk) \
            .room_id \
            .building_id \
            .site_id \
            .site_name

    @staticmethod
    def get_department_name(pk: int) -> str:
        """
        Get department name from rack id

        Args:
            pk (int): Primary key

        Returns:
            department_name (str): Department name from rack id
        """
        return Rack.objects.get_rack_department(pk) \
            .room_id \
            .building_id \
            .site_id \
            .department_id \
            .department_name

    @staticmethod
    def get_region_name(pk: int) -> str:
        """
        Get region name from rack id

        Args:
            pk (int): Primary key

        Returns:
            region_name (str): Region name from rack id
        """
        return Rack.objects.get_rack_region(pk) \
            .room_id \
            .building_id \
            .site_id \
            .department_id \
            .region_id \
            .region_name

    @staticmethod
    def get_unique_rack_vendors() -> List[Union[str, None]]:
        """
        Get list of rack vendors

        Returns:
            unique_rack_vendors (list): List of rack vendors
        """
        return list(Rack.objects.get_rack_vendors().distinct())

    @staticmethod
    def get_unique_rack_models() -> List[Union[str, None]]:
        """
        Get list of rack models

        Returns:
            unique_rack_models (list): List of rack models
        """
        return list(Rack.objects.get_rack_models().distinct())


class DeviceRepository:
    """
    Device repository
    """

    @staticmethod
    def get_first_unit(pk: int) -> int:
        """
        Get device first unit

        Args:
            pk (int): Primary key

        Returns:
            first_unit (int): Device first unit
        """
        return Device.objects.get_device(pk).first_unit

    @staticmethod
    def get_rack_id(pk: int) -> int:
        """
        Get rack id for device

        Args:
            pk (int): Primary key

        Returns:
            rack_id (int): Rack id for device
        """
        return Device.objects.get_device(pk).rack_id_id

    @staticmethod
    def get_last_unit(pk: int) -> int:
        """
        Get device last unit

        Args:
            pk (int): Primary key

        Returns:
            last_unit (int): Device last unit
        """
        return Device.objects.get_device(pk).last_unit

    @staticmethod
    def get_rack_name(pk: int) -> str:
        """
        Get rack name from device id

        Args:
            pk (int): Primary key

        Returns:
            rack_name (str): Rack name from device id
        """
        return Device.objects.get_device_rack(pk) \
            .rack_id \
            .rack_name

    @staticmethod
    def get_room_name(pk: int) -> str:
        """
        Get room name from device id

        Args:
            pk (int): Primary key

        Returns:
            room_name (str): Room name from device id
        """
        return Device.objects.get_device_room(pk) \
            .rack_id \
            .room_id \
            .room_name

    @staticmethod
    def get_building_name(pk: int) -> str:
        """
        Get building name from device id

        Args:
            pk (int): Primary key

        Returns:
            building_name (str): Building name from device id
        """
        return Device.objects.get_device_building(pk) \
            .rack_id \
            .room_id \
            .building_id \
            .building_name

    @staticmethod
    def get_site_name(pk: int) -> str:
        """
        Get site name from device id

        Args:
            pk (int): Primary key

        Returns:
            site_name (str): Site name from device id
        """
        return Device.objects.get_device_site(pk) \
            .rack_id \
            .room_id \
            .building_id \
            .site_id \
            .site_name

    @staticmethod
    def get_department_name(pk: int) -> str:
        """
        Get department name from device id

        Args:
            pk (int): Primary key

        Returns:
            department_name (str): Department name from device id
        """
        return Device.objects.get_device_department(pk) \
            .rack_id \
            .room_id \
            .building_id \
            .site_id \
            .department_id \
            .department_name

    @staticmethod
    def get_region_name(pk: int) -> str:
        """
        Get region name from device id

        Args:
            pk (int): Primary key

        Returns:
            region_name (str): Region name from device id
        """
        return Device.objects.get_device_region(pk) \
            .rack_id \
            .room_id \
            .building_id \
            .site_id \
            .department_id \
            .region_id \
            .region_name

    @staticmethod
    def get_device_vendors() -> List[Union[str, None]]:
        """
        Get list of device vendors

        Returns:
            device_vendors (list): List of device vendors
        """
        return list(Device.objects.get_device_vendors().distinct())

    @staticmethod
    def get_device_models() -> List[Union[str, None]]:
        """
        Get list of device models

        Returns:
            device_models (list): List of device models
        """
        return list(Device.objects.get_device_models().distinct())

    @staticmethod
    def get_devices_power_w(pk: int) -> List[Union[int, None]]:
        """
        Get devices W for single rack

        Returns:
            devices_power_w (list): List of devices W for single rack
        """
        return list(Device
                    .objects
                    .filter(rack_id_id=pk)
                    .values_list('power_w', flat=True))
