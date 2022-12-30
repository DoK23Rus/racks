from typing import List

from django.db.models.base import ModelBase
from rest_framework.generics import ListAPIView
from rest_framework.serializers import SerializerMetaclass
from rest_framework.views import APIView

from mainapp.mixins import (BaseApiAddMixin,
                            BaseApiDeleteMixin,
                            BaseApiGetMixin,
                            BaseApiUpdateMixin,
                            BuildingListApiMixin,
                            DepartmentListApiMixin,
                            DeviceLocationMixin,
                            DeviceModelsApiMixin,
                            DeviceVendorsApiMixin,
                            DevicesReportMixin,
                            PermissionsMixin,
                            RackDevicesApiMixin,
                            RackListApiViewMixin,
                            RackLocationMixin,
                            RackModelsApiMixin,
                            RackVendorsApiMixin,
                            RacksReportMixin,
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


class SiteDetailApiView(BaseApiGetMixin, PermissionsMixin, APIView):
    """
    Site detail API view
    """
    model: ModelBase = Site
    serializer_class: SerializerMetaclass = SiteSerializer


class BuildingDetailApiView(BaseApiGetMixin, PermissionsMixin, APIView):
    """
    Site detail API view
    """
    model: ModelBase = Building
    serializer_class: SerializerMetaclass = BuildingSerializer


class RoomDetailApiView(BaseApiGetMixin, PermissionsMixin, APIView):
    """
    Site detail API view
    """
    model: ModelBase = Room
    serializer_class: SerializerMetaclass = RoomSerializer


class RackDetailApiView(BaseApiGetMixin, PermissionsMixin, APIView):
    """
    Rack detail API view
    """
    model: ModelBase = Rack
    serializer_class: SerializerMetaclass = RackSerializer


class DeviceDetailApiView(BaseApiGetMixin, PermissionsMixin, APIView):
    """
    Device detail API view
    """
    model: ModelBase = Device
    serializer_class: SerializerMetaclass = DeviceSerializer


class RackListApiView(RackListApiViewMixin, PermissionsMixin, ListAPIView):
    """
    Rack list API view
    """
    model: ModelBase = Rack
    serializer_class: SerializerMetaclass = RackSerializer


class SiteAddApiView(BaseApiAddMixin, PermissionsMixin, APIView):
    """
    Site add API view
    """
    model: ModelBase = Department
    serializer_class: SerializerMetaclass = SiteSerializer
    pk_name: str = 'department_id'
    model_name: str = 'site'
    checks_list: List[str] = ['check_user']


class SiteUpdateApiView(BaseApiUpdateMixin, PermissionsMixin, APIView):
    """
    Site update API view
    """
    model: ModelBase = Site
    fk_model: ModelBase = Department
    serializer_class: SerializerMetaclass = SiteSerializer
    fk_name: str = 'department_id'
    model_name: str = 'site'
    checks_list: List[str] = ['check_user']


class SiteDeleteApiView(BaseApiDeleteMixin, PermissionsMixin, APIView):
    """
    Site delete API view
    """
    model: ModelBase = Site
    model_name: str = 'site'
    checks_list: List[str] = ['check_user']


class BuildingAddApiView(BaseApiAddMixin, PermissionsMixin, APIView):
    """
    Building add API view
    """
    model: ModelBase = Site
    serializer_class: SerializerMetaclass = BuildingSerializer
    pk_name: str = 'site_id'
    model_name: str = 'building'
    checks_list: List[str] = ['check_user', 'check_unique']


class BuildingUpdateApiView(BaseApiUpdateMixin, PermissionsMixin, APIView):
    """
    Building update API view
    """
    model: ModelBase = Building
    fk_model: ModelBase = Site
    serializer_class: SerializerMetaclass = BuildingSerializer
    fk_name: str = 'site_id'
    model_name: str = 'building'
    checks_list: List[str] = ['check_user', 'check_unique']


class BuildingDeleteApiView(BaseApiDeleteMixin, PermissionsMixin, APIView):
    """
    Building delete API view
    """
    model: ModelBase = Building
    model_name: str = 'building'
    checks_list: List[str] = ['check_user']


class RoomAddApiView(BaseApiAddMixin, PermissionsMixin, APIView):
    """
    Room add API view
    """
    model: ModelBase = Building
    serializer_class: SerializerMetaclass = RoomSerializer
    pk_name: str = 'building_id'
    model_name: str = 'room'
    checks_list: List[str] = ['check_user', 'check_unique']


class RoomUpdateApiView(BaseApiUpdateMixin, PermissionsMixin, APIView):
    """
    Room update API view
    """
    model: ModelBase = Room
    fk_model: ModelBase = Building
    serializer_class: SerializerMetaclass = RoomSerializer
    fk_name: str = 'building_id'
    model_name: str = 'room'
    checks_list: List[str] = ['check_user', 'check_unique']


class RoomDeleteApiView(BaseApiDeleteMixin, PermissionsMixin, APIView):
    """
    Room delete API view
    """
    model: ModelBase = Room
    model_name: str = 'room'
    checks_list: List[str] = ['check_user']


class RackAddApiView(BaseApiAddMixin, PermissionsMixin, APIView):
    """
    Rack add API view
    """
    model: ModelBase = Room
    serializer_class: SerializerMetaclass = RackSerializer
    pk_name: str = 'room_id'
    model_name: str = 'rack'
    checks_list: List[str] = ['check_user', 'check_unique']


class RackUpdateApiView(BaseApiUpdateMixin, PermissionsMixin, APIView):
    """
    Rack update API view
    """
    model: ModelBase = Rack
    fk_model: ModelBase = Room
    serializer_class: SerializerMetaclass = RackSerializer
    fk_name: str = 'room_id'
    model_name: str = 'rack'
    checks_list: List[str] = ['check_user', 'check_unique']


class RackDeleteApiView(BaseApiDeleteMixin, PermissionsMixin, APIView):
    """
    Rack delete API view
    """
    model: ModelBase = Rack
    model_name: str = 'rack'
    checks_list: List[str] = ['check_user']


class DeviceAddApiView(BaseApiAddMixin, PermissionsMixin, APIView):
    """
    Device add API view
    """
    model: ModelBase = Rack
    serializer_class: SerializerMetaclass = DeviceSerializer
    pk_name: str = 'rack_id'
    model_name: str = 'device'
    checks_list: List[str] = ['check_user', 'check_device_for_add']


class DeviceUpdateApiView(BaseApiUpdateMixin, PermissionsMixin, APIView):
    """
    Device update API view
    """
    model: ModelBase = Device
    fk_model: ModelBase = Rack
    serializer_class: SerializerMetaclass = DeviceSerializer
    fk_name: str = 'rack_id'
    model_name: str = 'device'
    checks_list: List[str] = ['check_user', 'check_device_for_update']


class DeviceDeleteApiView(BaseApiDeleteMixin, PermissionsMixin, APIView):
    """
    Device delete API view
    """
    model: ModelBase = Device
    model_name: str = 'device'
    checks_list: List[str] = ['check_user']


class RegionListApiView(RegionListApiMixin, PermissionsMixin, ListAPIView):
    """
    Regions list API view
    """
    model: ModelBase = Region
    serializer_class: SerializerMetaclass = RegionSerializer


class DepartmentListApiView(DepartmentListApiMixin,
                            PermissionsMixin,
                            ListAPIView):
    """
    Departments list API view
    """
    model: ModelBase = Department
    serializer_class: SerializerMetaclass = DepartmentSerializer


class SiteListApiView(SiteListApiMixin, PermissionsMixin, ListAPIView):
    """
    Sites list API view
    """
    model: ModelBase = Site
    serializer_class: SerializerMetaclass = SiteSerializer


class BuildingListApiView(BuildingListApiMixin, PermissionsMixin, ListAPIView):
    """
    Buildings list API view
    """
    model: ModelBase = Building
    serializer_class: SerializerMetaclass = BuildingSerializer


class RoomListApiView(RoomListApiMixin, PermissionsMixin, ListAPIView):
    """
    Rooms list API view
    """
    model: ModelBase = Room
    serializer_class: SerializerMetaclass = RoomSerializer


class UserApiView(UserApiMixin, PermissionsMixin, APIView):
    """
    User API view
    """
    pass


class DeviceVendorsApiView(DeviceVendorsApiMixin, PermissionsMixin, APIView):
    """
    Device vendors API view
    """
    pass


class DeviceModelsApiView(DeviceModelsApiMixin, PermissionsMixin, APIView):
    """
    Device models API view
    """
    pass


class RackVendorsApiView(RackVendorsApiMixin, PermissionsMixin, APIView):
    """
    Rack vendors API view
    """
    pass


class RackModelsApiView(RackModelsApiMixin, PermissionsMixin, APIView):
    """
    Rack models API view
    """
    pass


class RackDevicesApiView(RackDevicesApiMixin, PermissionsMixin, APIView):
    """
    Rack devices API view
    """
    pass


class RacksReportApiView(RacksReportMixin, PermissionsMixin, APIView):
    """
    Racks report API view
    """
    pass


class DevicesReportApiView(DevicesReportMixin, PermissionsMixin, APIView):
    """
    Devices report API view
    """
    pass


class DeviceLocationApiView(DeviceLocationMixin, PermissionsMixin, APIView):
    """
    Device location API view
    """
    pass


class RackLocationApiView(RackLocationMixin, PermissionsMixin, APIView):
    """
    Rack location API view
    """
    pass
