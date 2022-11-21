from typing import List

from django.db.models.base import ModelBase
from rest_framework import serializers

from mainapp.models import (Building,
                            Department,
                            Device,
                            Rack,
                            Region,
                            Room,
                            Site)
from mainapp.services import DataProcessingService, RepoService


class RegionSerializer(serializers.ModelSerializer):
    """
    Region serializer
    """
    class Meta:
        model: ModelBase = Region
        fields: List = [
            'id',
            'region_name'
        ]


class DepartmentSerializer(serializers.ModelSerializer):
    """
    Department serializer
    """
    class Meta:
        model: ModelBase = Department
        fields: List = [
            'id',
            'department_name',
            'region_id'
        ]


class SiteSerializer(serializers.ModelSerializer):
    """
    Site serializer
    """
    class Meta:
        model: ModelBase = Site
        fields: List = [
            'id',
            'site_name',
            'updated_by',
            'updated_at',
            'department_id'
        ]


class BuildingSerializer(serializers.ModelSerializer):
    """
    Building serializer
    """
    class Meta:
        model: ModelBase = Building
        fields: List = [
            'id',
            'building_name',
            'updated_by',
            'updated_at',
            'site_id'
        ]


class RoomSerializer(serializers.ModelSerializer):
    """
    Room serializer
    """
    class Meta:
        model: ModelBase = Room
        fields: List = [
            'id',
            'room_name',
            'updated_by',
            'updated_at',
            'building_id'
        ]


class RackSerializer(serializers.ModelSerializer):
    """
    Rack serializer
    """
    rack_amount = serializers.IntegerField(allow_null=False)
    total_power_w = serializers.SerializerMethodField('get_total_power_w')
    room_name = serializers.SerializerMethodField('get_room_name')
    building_name = serializers.SerializerMethodField('get_building_name')
    site_name = serializers.SerializerMethodField('get_site_name')
    department_name = serializers.SerializerMethodField('get_department_name')
    region_name = serializers.SerializerMethodField('get_region_name')

    def get_total_power_w(self, obj: Rack) -> int:
        """
        Get total power for single rack

        Args:
            obj (Rack): Object

        Returns:
            total_power_w (int): Total power for single rack
        """
        return DataProcessingService.get_devices_power_w_sum(obj.id)

    def get_room_name(self, obj: Rack) -> str:
        """
        Get room name for rack

        Args:
            obj (Rack): Object

        Returns:
            room_name (str): Room name for rack
        """
        return RepoService.get_rack_room_name(obj.id)

    def get_site_name(self, obj: Rack) -> str:
        """
        Get site name for rack

        Args:
            obj (Rack): Object

        Returns:
            site_name (str): Site name for rack
        """
        return RepoService.get_rack_site_name(obj.id)

    def get_building_name(self, obj: Rack) -> str:
        """
        Get building name for rack

        Args:
            obj (Rack): Object

        Returns:
            building_name (str): Building name for rack
        """
        return RepoService.get_rack_building_name(obj.id)

    def get_department_name(self, obj: Rack) -> str:
        """
        Get department name for rack

        Args:
            obj (Rack): Object

        Returns:
            department_name (str): Department name for rack
        """
        return RepoService.get_rack_department_name(obj.id)

    def get_region_name(self, obj: Rack) -> str:
        """
        Get region name for rack

        Args:
            obj (Rack): Object

        Returns:
            region_name (str): Region name for rack
        """
        return RepoService.get_rack_region_name(obj.id)

    class Meta:
        model: ModelBase = Rack
        fields: List = [
            'id',
            'rack_name',
            'rack_amount',
            'rack_vendor',
            'rack_model',
            'rack_description',
            'numbering_from_bottom_to_top',
            'responsible',
            'rack_financially_responsible_person',
            'rack_inventory_number',
            'fixed_asset',
            'link',
            'row',
            'place',
            'rack_height',
            'rack_width',
            'rack_depth',
            'rack_unit_width',
            'rack_unit_depth',
            'rack_type',
            'rack_frame',
            'rack_palce_type',
            'max_load',
            'power_sockets',
            'power_sockets_ups',
            'external_ups',
            'cooler',
            'total_power_w',
            'updated_by',
            'updated_at',
            'room_id',
            'room_name',
            'site_name',
            'building_name',
            'department_name',
            'region_name'
        ]


class DeviceSerializer(serializers.ModelSerializer):
    """
    Device serializer
    """
    frontside_location = serializers.BooleanField(required=True)
    rack_name = serializers.SerializerMethodField('get_rack_name')
    room_name = serializers.SerializerMethodField('get_room_name')
    building_name = serializers.SerializerMethodField('get_building_name')
    site_name = serializers.SerializerMethodField('get_site_name')
    department_name = serializers.SerializerMethodField('get_department_name')
    region_name = serializers.SerializerMethodField('get_region_name')

    def get_rack_name(self, obj: Device) -> str:
        """
        Get rack name for device

        Args:
            obj (Device): Object

        Returns:
            rack_name (str): Rack name for device
        """
        return RepoService.get_device_rack_name(obj.id)

    def get_room_name(self, obj: Device) -> str:
        """
        Get room name for device

        Args:
            obj (Device): Object

        Returns:
            room_name (str): Room name for device
        """
        return RepoService.get_device_room_name(obj.id)

    def get_site_name(self, obj: Device) -> str:
        """
        Get site name for device

        Args:
            obj (Device): Object

        Returns:
            site_name (str): Site name for device
        """
        return RepoService.get_device_site_name(obj.id)

    def get_building_name(self, obj: Device) -> str:
        """
        Get building name for device

        Args:
            obj (Device): Object

        Returns:
            building_name (str): Building name for device
        """
        return RepoService.get_device_building_name(obj.id)

    def get_department_name(self, obj: Device) -> str:
        """
        Get department name for device

        Args:
            obj (Device): Object

        Returns:
            department_name (str): Department name for device
        """
        return RepoService.get_device_department_name(obj.id)

    def get_region_name(self, obj: Device) -> str:
        """
        Get region name for device

        Args:
            obj (Device): Object

        Returns:
            region_name (str): Region name for devic
        """
        return RepoService.get_device_region_name(obj.id)

    class Meta:
        model: ModelBase = Device
        fields: List = [
            'id',
            'first_unit',
            'last_unit',
            'frontside_location',
            'status',
            'device_type',
            'device_vendor',
            'device_model',
            'device_hostname',
            'ip',
            'device_stack',
            'ports_amout',
            'version',
            'power_type',
            'power_w',
            'power_v',
            'power_ac_dc',
            'device_serial_number',
            'device_description',
            'project',
            'ownership',
            'responsible',
            'financially_responsible_person',
            'device_inventory_number',
            'fixed_asset',
            'link',
            'updated_by',
            'updated_at',
            'rack_id',
            'rack_name',
            'room_name',
            'site_name',
            'building_name',
            'department_name',
            'region_name'
        ]
