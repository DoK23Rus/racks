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
from mainapp.services import DataProcessingService


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

    def get_total_power_w(self, obj: Rack) -> int:
        """
        Get total power for single rack

        Args:
            obj (Rack): Object

        Returns:
            total_power_w (int): Total power for single rack
        """
        return DataProcessingService.get_devices_power_w_sum(obj.id)

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
        ]


class DeviceSerializer(serializers.ModelSerializer):
    """
    Device serializer
    """
    frontside_location = serializers.BooleanField(required=True)

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
        ]
