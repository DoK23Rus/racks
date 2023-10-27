from rest_framework import serializers

from mainapp.models import (Building,
                            Department,
                            Device,
                            Rack,
                            Region,
                            Room,
                            Site)
from mainapp.repository import DeviceRepository
from mainapp.services import DataProcessingService


class DeviceSerializer(serializers.ModelSerializer):
    """
    Device serializer
    """
    frontside_location = serializers.BooleanField(required=True)

    class Meta:
        model = Device
        fields = [
            'id',
            'first_unit',
            'last_unit',
            'frontside_location',
            'status',
            'type',
            'vendor',
            'model',
            'hostname',
            'ip',
            'stack',
            'ports_amout',
            'version',
            'power_type',
            'power_w',
            'power_v',
            'power_ac_dc',
            'serial_number',
            'description',
            'project',
            'ownership',
            'responsible',
            'financially_responsible_person',
            'inventory_number',
            'fixed_asset',
            'link',
            'updated_by',
            'updated_at',
            'rack_id',
        ]


class RackPartialSerializer(serializers.ModelSerializer):
    """
    Rack partial serializer (for tree view)
    """
    class Meta:
        model = Rack
        fields = [
            'id',
            'name',
            'amount',
            'numbering_from_bottom_to_top',
            'room_id'
        ]


class RackSerializer(serializers.ModelSerializer):
    """
    Rack serializer
    """
    amount = serializers.IntegerField(allow_null=False)
    total_power_w = serializers.SerializerMethodField('get_total_power_w')

    def get_total_power_w(self, obj: Rack) -> int:
        """
        Get total power for single rack

        Args:
            obj (Rack): Object

        Returns:
            total_power_w (int): Total power for single rack
        """
        power_w_list = DeviceRepository.get_devices_power_list(obj.id)
        return DataProcessingService.get_devices_power_w_sum(power_w_list)

    class Meta:
        model = Rack
        fields = [
            'id',
            'name',
            'amount',
            'vendor',
            'model',
            'description',
            'numbering_from_bottom_to_top',
            'responsible',
            'financially_responsible_person',
            'inventory_number',
            'fixed_asset',
            'link',
            'row',
            'place',
            'height',
            'width',
            'depth',
            'unit_width',
            'unit_depth',
            'type',
            'frame',
            'place_type',
            'max_load',
            'power_sockets',
            'power_sockets_ups',
            'external_ups',
            'cooler',
            'total_power_w',
            'updated_by',
            'updated_at',
            'room_id'
        ]


class RoomSerializer(serializers.ModelSerializer):
    """
    Room serializer
    """

    class Meta:
        model = Room
        fields = [
            'id',
            'name',
            'children',
            'updated_by',
            'updated_at',
            'building_id'
        ]
        read_only_fields = ['children']


class BuildingSerializer(serializers.ModelSerializer):
    """
    Building serializer
    """

    class Meta:
        model = Building
        fields = [
            'id',
            'name',
            'children',
            'updated_by',
            'updated_at',
            'site_id'
        ]
        read_only_fields = ['children']


class SiteSerializer(serializers.ModelSerializer):
    """
    Site serializer
    """

    class Meta:
        model = Site
        fields = [
            'id',
            'name',
            'children',
            'updated_by',
            'updated_at',
            'department_id'
        ]
        read_only_fields = ['children']


class DepartmentSerializer(serializers.ModelSerializer):
    """
    Department serializer
    """

    class Meta:
        model = Department
        fields = [
            'id',
            'name',
            'children',
            'region_id',
        ]
        read_only_fields = ['children']


class RegionSerializer(serializers.ModelSerializer):
    """
    Region serializer
    """

    class Meta:
        model = Region
        fields = [
            'id',
            'name',
            'children',
        ]
        read_only_fields = ['children']


class TreeRackSerializer(serializers.ModelSerializer):
    """
    Tree rack serializer
    """
    rack_name = serializers.CharField(source='name')

    class Meta:
        model = Rack
        fields = [
            'id',
            'rack_name'
        ]


class TreeRoomSerializer(serializers.ModelSerializer):
    """
    Tree room serializer
    """
    children = TreeRackSerializer(many=True)
    room_name = serializers.CharField(source='name')

    class Meta:
        model = Room
        fields = [
            'id',
            'room_name',
            'children',
            'building_id'
        ]


class TreeBuildingSerializer(serializers.ModelSerializer):
    """
    Tree building serializer
    """
    children = TreeRoomSerializer(many=True)
    building_name = serializers.CharField(source='name')

    class Meta:
        model = Building
        fields = [
            'id',
            'building_name',
            'children',
            'site_id'
        ]


class TreeSiteSerializer(serializers.ModelSerializer):
    """
    Tree site serializer
    """
    children = TreeBuildingSerializer(many=True)
    site_name = serializers.CharField(source='name')

    class Meta:
        model = Site
        fields = fields = [
            'id',
            'site_name',
            'children',
            'department_id'
        ]


class TreeDepartmentSerializer(serializers.ModelSerializer):
    """
    Tree department serializer
    """
    children = TreeSiteSerializer(many=True)
    department_name = serializers.CharField(source='name')

    class Meta:
        model = Department
        fields = fields = [
            'id',
            'department_name',
            'children',
            'region_id'
        ]


class TreeRegionSerializer(serializers.ModelSerializer):
    """
    Tree region serializer
    """
    children = TreeDepartmentSerializer(many=True)
    region_name = serializers.CharField(source='name')

    class Meta:
        model = Region
        fields = fields = [
            'id',
            'region_name',
            'children'
        ]
