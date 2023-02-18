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
                            RackDevicesApiMixin,
                            RackListApiViewMixin,
                            RackPartialListApiViewMixin,
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
                                 RackPartialSerializer,
                                 RegionSerializer,
                                 RoomSerializer,
                                 SiteSerializer)
from mainapp.utils import (CheckUser,
                           CheckUnique,
                           CheckDeviceForAddOrUpdate,
                           Checks_List_Type)


class SiteDetailApiView(BaseApiGetMixin, APIView):
    """
    Site detail API view
    """
    model: ModelBase = Site
    serializer_class: SerializerMetaclass = SiteSerializer


class BuildingDetailApiView(BaseApiGetMixin, APIView):
    """
    Site detail API view
    """
    model: ModelBase = Building
    serializer_class: SerializerMetaclass = BuildingSerializer


class RoomDetailApiView(BaseApiGetMixin, APIView):
    """
    Site detail API view
    """
    model: ModelBase = Room
    serializer_class: SerializerMetaclass = RoomSerializer


class RackDetailApiView(BaseApiGetMixin, APIView):
    """
    Rack detail API view
    """
    model: ModelBase = Rack
    serializer_class: SerializerMetaclass = RackSerializer


class DeviceDetailApiView(BaseApiGetMixin, APIView):
    """
    Device detail API view
    """
    model: ModelBase = Device
    serializer_class: SerializerMetaclass = DeviceSerializer


class SiteAddApiView(BaseApiAddMixin, APIView):
    """
    Site add API view
    """
    model: ModelBase = Site
    fk_model: ModelBase = Department
    serializer_class: SerializerMetaclass = SiteSerializer
    checks_list: Checks_List_Type = [CheckUser]


class SiteUpdateApiView(BaseApiUpdateMixin, APIView):
    """
    Site update API view
    """
    model: ModelBase = Site
    fk_model: ModelBase = Department
    serializer_class: SerializerMetaclass = SiteSerializer
    checks_list: Checks_List_Type = [CheckUser]


class SiteDeleteApiView(BaseApiDeleteMixin, APIView):
    """
    Site delete API view
    """
    model: ModelBase = Site
    checks_list: Checks_List_Type = [CheckUser]


class BuildingAddApiView(BaseApiAddMixin, APIView):
    """
    Building add API view
    """
    model: ModelBase = Building
    fk_model: ModelBase = Site
    serializer_class: SerializerMetaclass = BuildingSerializer
    checks_list: Checks_List_Type = [CheckUser, CheckUnique]


class BuildingUpdateApiView(BaseApiUpdateMixin, APIView):
    """
    Building update API view
    """
    model: ModelBase = Building
    fk_model: ModelBase = Site
    serializer_class: SerializerMetaclass = BuildingSerializer
    checks_list: Checks_List_Type = [CheckUser, CheckUnique]


class BuildingDeleteApiView(BaseApiDeleteMixin, APIView):
    """
    Building delete API view
    """
    model: ModelBase = Building
    checks_list: Checks_List_Type = [CheckUser]


class RoomAddApiView(BaseApiAddMixin, APIView):
    """
    Room add API view
    """
    model: ModelBase = Room
    fk_model: ModelBase = Building
    serializer_class: SerializerMetaclass = RoomSerializer
    checks_list: Checks_List_Type = [CheckUser, CheckUnique]


class RoomUpdateApiView(BaseApiUpdateMixin, APIView):
    """
    Room update API view
    """
    model: ModelBase = Room
    fk_model: ModelBase = Building
    serializer_class: SerializerMetaclass = RoomSerializer
    checks_list: Checks_List_Type = [CheckUser, CheckUnique]


class RoomDeleteApiView(BaseApiDeleteMixin, APIView):
    """
    Room delete API view
    """
    model: ModelBase = Room
    checks_list: Checks_List_Type = [CheckUser]


class RackAddApiView(BaseApiAddMixin, APIView):
    """
    Rack add API view
    """
    model: ModelBase = Rack
    fk_model: ModelBase = Room
    serializer_class: SerializerMetaclass = RackSerializer
    checks_list: Checks_List_Type = [CheckUser, CheckUnique]


class RackUpdateApiView(BaseApiUpdateMixin, APIView):
    """
    Rack update API view
    """
    model: ModelBase = Rack
    fk_model: ModelBase = Room
    serializer_class: SerializerMetaclass = RackSerializer
    checks_list: Checks_List_Type = [CheckUser, CheckUnique]


class RackDeleteApiView(BaseApiDeleteMixin, APIView):
    """
    Rack delete API view
    """
    model: ModelBase = Rack
    checks_list: Checks_List_Type = [CheckUser]


class DeviceAddApiView(BaseApiAddMixin, APIView):
    """
    Device add API view
    """
    model: ModelBase = Device
    fk_model: ModelBase = Rack
    serializer_class: SerializerMetaclass = DeviceSerializer
    checks_list: Checks_List_Type = [CheckUser, CheckDeviceForAddOrUpdate]


class DeviceUpdateApiView(BaseApiUpdateMixin, APIView):
    """
    Device update API view
    """
    model: ModelBase = Device
    fk_model: ModelBase = Rack
    serializer_class: SerializerMetaclass = DeviceSerializer
    checks_list: Checks_List_Type = [CheckUser, CheckDeviceForAddOrUpdate]


class DeviceDeleteApiView(BaseApiDeleteMixin, APIView):
    """
    Device delete API view
    """
    model: ModelBase = Device
    checks_list: Checks_List_Type = [CheckUser]


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


class RackListApiView(RackListApiViewMixin, ListAPIView):
    """
    Rack list API view
    """
    model: ModelBase = Rack
    serializer_class: SerializerMetaclass = RackSerializer


class RackPartialListApiView(RackPartialListApiViewMixin, ListAPIView):
    """
    Rack partial list API view
    """
    model: ModelBase = Rack
    serializer_class: SerializerMetaclass = RackPartialSerializer


class UserApiView(UserApiMixin, APIView):
    """
    User API view
    """
    pass


class DeviceVendorsApiView(DeviceVendorsApiMixin, APIView):
    """
    Device vendors API view
    """
    pass


class DeviceModelsApiView(DeviceModelsApiMixin, APIView):
    """
    Device models API view
    """
    pass


class RackVendorsApiView(RackVendorsApiMixin, APIView):
    """
    Rack vendors API view
    """
    pass


class RackModelsApiView(RackModelsApiMixin, APIView):
    """
    Rack models API view
    """
    pass


class RackDevicesApiView(RackDevicesApiMixin, APIView):
    """
    Rack devices API view
    """
    pass


class RacksReportApiView(RacksReportMixin, APIView):
    """
    Racks report API view
    """
    pass


class DevicesReportApiView(DevicesReportMixin, APIView):
    """
    Devices report API view
    """
    pass


class DeviceLocationApiView(DeviceLocationMixin, APIView):
    """
    Device location API view
    """
    pass


class RackLocationApiView(RackLocationMixin, APIView):
    """
    Rack location API view
    """
    pass
