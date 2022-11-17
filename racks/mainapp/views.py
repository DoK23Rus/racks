from typing import List

from django.db.models.base import ModelBase
from rest_framework import permissions
from rest_framework.generics import ListAPIView
from rest_framework.serializers import SerializerMetaclass
from rest_framework.views import APIView

from mainapp.mixins import (BaseApiAddMixin,
                            BaseApiDeleteMixin,
                            BaseApiGetMixin,
                            BaseApiUpdateMixin,
                            BuildingListApiMixin,
                            DepartmentListApiMixin,
                            DeviceListApiViewMixin,
                            DeviceModelsApiMixin,
                            DeviceVendorsApiMixin,
                            RackDevicesApiMixin,
                            RackListApiViewMixin,
                            RackModelsApiMixin,
                            RackVendorsApiMixin,
                            RegionListApiMixin,
                            RoomListApiMixin,
                            SiteListApiMixin,
                            UserApiMixin)
from mainapp.models import (Building,
                            Department,
                            Device,
                            Rack,
                            Region,
                            Room,
                            Site)
from mainapp.serializers import (BuildingSerializer,
                                 DepartmentSerializer,
                                 DeviceSerializer,
                                 RackSerializer,
                                 RegionSerializer,
                                 RoomSerializer,
                                 SiteSerializer)


class SiteDetailApiView(BaseApiGetMixin, APIView):
    """
    Site detail API view
    """
    model: ModelBase = Site
    serializer_class: SerializerMetaclass = SiteSerializer
    permission_classes = [
        permissions.IsAuthenticated
    ]


class BuildingDetailApiView(BaseApiGetMixin, APIView):
    """
    Site detail API view
    """
    model: ModelBase = Building
    serializer_class: SerializerMetaclass = BuildingSerializer
    permission_classes = [
        permissions.IsAuthenticated
    ]


class RoomDetailApiView(BaseApiGetMixin, APIView):
    """
    Site detail API view
    """
    model: ModelBase = Room
    serializer_class: SerializerMetaclass = RoomSerializer
    permission_classes = [
        permissions.IsAuthenticated
    ]


class RackDetailApiView(BaseApiGetMixin, APIView):
    """
    Rack detail API view
    """
    model: ModelBase = Rack
    serializer_class: SerializerMetaclass = RackSerializer
    permission_classes = [
        permissions.IsAuthenticated
    ]


class DeviceDetailApiView(BaseApiGetMixin, APIView):
    """
    Device detail API view
    """
    model: ModelBase = Device
    serializer_class: SerializerMetaclass = DeviceSerializer
    permission_classes = [
        permissions.IsAuthenticated
    ]


class RackListApiView(RackListApiViewMixin, ListAPIView):
    """
    Rack list API view
    """
    model: ModelBase = Rack
    serializer_class: SerializerMetaclass = RackSerializer


class DeviceListApiView(DeviceListApiViewMixin, ListAPIView):
    """
    Device list API view
    """
    model: ModelBase = Device
    serializer_class: SerializerMetaclass = DeviceSerializer


class SiteAddApiView(BaseApiAddMixin, APIView):
    """
    Site add API view
    """
    model: ModelBase = Department
    serializer_class: SerializerMetaclass = SiteSerializer
    pk_name: str = 'department_id'
    model_name: str = 'site'
    checks_list: List[str] = ['check_user']
    permission_classes = [
        permissions.IsAuthenticated
    ]


class SiteUpdateApiView(BaseApiUpdateMixin, APIView):
    """
    Site update API view
    """
    model: ModelBase = Site
    fk_model: ModelBase = Department
    serializer_class: SerializerMetaclass = SiteSerializer
    fk_name: str = 'department_id'
    model_name: str = 'site'
    checks_list: List[str] = ['check_user']
    permission_classes = [
        permissions.IsAuthenticated
    ]


class SiteDeleteApiView(BaseApiDeleteMixin, APIView):
    """
    Site delete API view
    """
    model: ModelBase = Site
    model_name: str = 'site'
    checks_list: List[str] = ['check_user']
    permission_classes = [
        permissions.IsAuthenticated
    ]


class BuildingAddApiView(BaseApiAddMixin, APIView):
    """
    Building add API view
    """
    model: ModelBase = Site
    serializer_class: SerializerMetaclass = BuildingSerializer
    pk_name: str = 'site_id'
    model_name: str = 'building'
    checks_list: List[str] = ['check_user', 'check_unique']
    permission_classes = [
        permissions.IsAuthenticated
    ]


class BuildingUpdateApiView(BaseApiUpdateMixin, APIView):
    """
    Building update API view
    """
    model: ModelBase = Building
    fk_model: ModelBase = Site
    serializer_class: SerializerMetaclass = BuildingSerializer
    fk_name: str = 'site_id'
    model_name: str = 'building'
    checks_list: List[str] = ['check_user', 'check_unique']
    permission_classes = [
        permissions.IsAuthenticated
    ]


class BuildingDeleteApiView(BaseApiDeleteMixin, APIView):
    """
    Building delete API view
    """
    model: ModelBase = Building
    model_name: str = 'building'
    checks_list: List[str] = ['check_user']
    permission_classes = [
        permissions.IsAuthenticated
    ]


class RoomAddApiView(BaseApiAddMixin, APIView):
    """
    Room add API view
    """
    model: ModelBase = Building
    serializer_class: SerializerMetaclass = RoomSerializer
    pk_name: str = 'building_id'
    model_name: str = 'room'
    checks_list: List[str] = ['check_user', 'check_unique']
    permission_classes = [
        permissions.IsAuthenticated
    ]


class RoomUpdateApiView(BaseApiUpdateMixin, APIView):
    """
    Room update API view
    """
    model: ModelBase = Room
    fk_model: ModelBase = Building
    serializer_class: SerializerMetaclass = RoomSerializer
    fk_name: str = 'building_id'
    model_name: str = 'room'
    checks_list: List[str] = ['check_user', 'check_unique']
    permission_classes = [
        permissions.IsAuthenticated
    ]


class RoomDeleteApiView(BaseApiDeleteMixin, APIView):
    """
    Room delete API view
    """
    model: ModelBase = Room
    model_name: str = 'room'
    checks_list: List[str] = ['check_user']
    permission_classes = [
        permissions.IsAuthenticated
    ]


class RackAddApiView(BaseApiAddMixin, APIView):
    """
    Rack add API view
    """
    model: ModelBase = Room
    serializer_class: SerializerMetaclass = RackSerializer
    pk_name: str = 'room_id'
    model_name: str = 'rack'
    checks_list: List[str] = ['check_user', 'check_unique']
    permission_classes = [
        permissions.IsAuthenticated
    ]


class RackUpdateApiView(BaseApiUpdateMixin, APIView):
    """
    Rack update API view
    """
    model: ModelBase = Rack
    fk_model: ModelBase = Room
    serializer_class: SerializerMetaclass = RackSerializer
    fk_name: str = 'room_id'
    model_name: str = 'rack'
    checks_list: List[str] = ['check_user', 'check_unique']
    permission_classes = [
        permissions.IsAuthenticated
    ]


class RackDeleteApiView(BaseApiDeleteMixin, APIView):
    """
    Rack delete API view
    """
    model: ModelBase = Rack
    model_name: str = 'rack'
    checks_list: List[str] = ['check_user']
    permission_classes = [
        permissions.IsAuthenticated
    ]


class DeviceAddApiView(BaseApiAddMixin, APIView):
    """
    Device add API view
    """
    model: ModelBase = Rack
    serializer_class: SerializerMetaclass = DeviceSerializer
    pk_name: str = 'rack_id'
    model_name: str = 'device'
    checks_list: List[str] = ['check_user', 'check_device_for_add']
    permission_classes = [
        permissions.IsAuthenticated
    ]


class DeviceUpdateApiView(BaseApiUpdateMixin, APIView):
    """
    Device update API view
    """
    model: ModelBase = Device
    fk_model: ModelBase = Rack
    serializer_class: SerializerMetaclass = DeviceSerializer
    fk_name: str = 'rack_id'
    model_name: str = 'device'
    checks_list: List[str] = ['check_user', 'check_device_for_update']
    permission_classes = [
        permissions.IsAuthenticated
    ]


class DeviceDeleteApiView(BaseApiDeleteMixin, APIView):
    """
    Device delete API view
    """
    model: ModelBase = Device
    model_name: str = 'device'
    checks_list: List[str] = ['check_user']
    permission_classes = [
        permissions.IsAuthenticated
    ]


class RegionListApiView(RegionListApiMixin, ListAPIView):
    """
    Regions list API view
    """
    model: ModelBase = Region
    serializer_class: SerializerMetaclass = RegionSerializer


class DepartmentListApiView(DepartmentListApiMixin, ListAPIView):
    """
    Departments list API view
    """
    model: ModelBase = Department
    serializer_class: SerializerMetaclass = DepartmentSerializer


class SiteListApiView(SiteListApiMixin, ListAPIView):
    """
    Sites list API view
    """
    model: ModelBase = Site
    serializer_class: SerializerMetaclass = SiteSerializer


class BuildingListApiView(BuildingListApiMixin, ListAPIView):
    """
    Buildings list API view
    """
    model: ModelBase = Building
    serializer_class: SerializerMetaclass = BuildingSerializer


class RoomListApiView(RoomListApiMixin, ListAPIView):
    """
    Rooms list API view
    """
    model: ModelBase = Room
    serializer_class: SerializerMetaclass = RoomSerializer


class UserApiView(UserApiMixin, APIView):
    """
    User API view
    """
    permission_classes = [
        permissions.IsAuthenticated
    ]


class DeviceVendorsApiView(DeviceVendorsApiMixin, APIView):
    """
    Device vendors API view
    """
    permission_classes = [
        permissions.IsAuthenticated
    ]


class DeviceModelsApiView(DeviceModelsApiMixin, APIView):
    """
    Device models API view
    """
    permission_classes = [
        permissions.IsAuthenticated
    ]


class RackVendorsApiView(RackVendorsApiMixin, APIView):
    """
    Rack vendors API view
    """
    permission_classes = [
        permissions.IsAuthenticated
    ]


class RackModelsApiView(RackModelsApiMixin, APIView):
    """
    Rack models API view
    """
    permission_classes = [
        permissions.IsAuthenticated
    ]


class RackDevicesApiView(RackDevicesApiMixin, APIView):
    """
    Rack devices API view
    """
    permission_classes = [
        permissions.IsAuthenticated
    ]
