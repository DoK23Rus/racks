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


class RackPartialSerializer(serializers.ModelSerializer):
    """
    Rack partial serializer (for tree view)
    """
    class Meta:
        model = Rack
        fields = [
            'id',
            'rack_name',
            'rack_amount',
            'numbering_from_bottom_to_top',
            'room_id'
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
        power_w_list = DeviceRepository.get_devices_power_list(obj.id)
        return DataProcessingService.get_devices_power_w_sum(power_w_list)

    class Meta:
        model = Rack
        fields = [
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
            'room_name',
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
            'building_name',
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
            'site_name',
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
            'department_name',
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
            'region_name',
            'children',
        ]
        read_only_fields = ['children']


class TreeRackSerializer(serializers.ModelSerializer):
    """
    Tree rack serializer
    """

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

    class Meta:
        model = Room
        fields = '__all__'


class TreeBuildingSerializer(serializers.ModelSerializer):
    """
    Tree building serializer
    """
    children = TreeRoomSerializer(many=True)

    class Meta:
        model = Building
        fields = '__all__'


class TreeSiteSerializer(serializers.ModelSerializer):
    """
    Tree site serializer
    """
    children = TreeBuildingSerializer(many=True)

    class Meta:
        model = Site
        fields = '__all__'


class TreeDepartmentSerializer(serializers.ModelSerializer):
    """
    Tree department serializer
    """
    children = TreeSiteSerializer(many=True)

    class Meta:
        model = Department
        fields = '__all__'


class TreeRegionSerializer(serializers.ModelSerializer):
    """
    Tree region serializer
    """
    children = TreeDepartmentSerializer(many=True)

    class Meta:
        model = Region
        fields = '__all__'
