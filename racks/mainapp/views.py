from django.views.generic import DetailView, View
from .utils import (
    AuthMixin,
    TreeDataMixin,
    UnitsDataMixin,
    BaseAddMixin,
    BaseUpdateMixin,
    BaseDeleteMixin,
    BaseQrMixin,
    QrListMixin,
    UnitsPrintMixin,
    BaseReportMixin,
    GotoMixin,
    RackDetailApiViewMixin,
    DeviceDetailApiViewMixin,
    RackListApiViewMixin,
    DeviceListApiViewMixin,
)
from .forms import (
    SiteForm,
    BuildingForm,
    RoomForm,
    RackForm,
    DeviceForm,
)
from rest_framework.views import APIView
from .models import (
    Department,
    Site,
    Building,
    Room,
    Rack,
    Device,
)
from rest_framework import permissions
from rest_framework.generics import ListAPIView
from .serializers import RackSerializer, DeviceSerializer
from rest_framework.permissions import BasePermissionMetaclass
from rest_framework.serializers import SerializerMetaclass
from django.db.models.base import ModelBase
from typing import List
from django.forms import Form


class TreeView(AuthMixin, TreeDataMixin, View):
    """
    Racks map
    """
    template_name: str = 'tree.html'


class UnitsView(AuthMixin, UnitsDataMixin, View):
    """
    Display rack layout with filled units
    """
    template_name: str = 'units.html'


class RackView(AuthMixin, DetailView):
    """
    Rack detail view
    """
    model: ModelBase = Rack
    template_name: str = 'rack_detail.html'
    pk_url_kwarg: str = 'pk'


class DeviceView(AuthMixin, DetailView):
    """
    Device detail view
    """
    model: ModelBase = Device
    template_name: str = 'device_detail.html'
    pk_url_kwarg: str = 'pk'


class SiteAddView(AuthMixin, BaseAddMixin, View):
    """
    Site add view
    """
    form_class: Form = SiteForm
    model: ModelBase = Department
    template_name: str = 'add.html'
    log_info: str = 'ADD SITE:'
    success_message: str = 'Site added'
    pk_name: str = 'department_id'
    checks_list: List[str] = ['check_user']


class SiteUpdateView(AuthMixin, BaseUpdateMixin, View):
    """
    Site update view
    """
    form_class: Form = SiteForm
    model: ModelBase = Site
    template_name: str = 'update.html'
    log_info: str = 'UPDATE SITE:'
    success_message: str = 'Site information changed'
    checks_list: List[str] = ['check_user']
    fk_model: ModelBase = Department


class SiteDeleteView(AuthMixin, BaseDeleteMixin, View):
    """
    Site delete view
    """
    model: ModelBase = Site
    template_name: str = 'delete.html'
    log_info: str = 'DELETE SITE:'
    success_message: str = 'Site deleted'
    checks_list: List[str] = ['check_user']
    model_name: str = 'site'


class BuildingAddView(AuthMixin, BaseAddMixin, View):
    """
    Building add view
    """
    form_class: Form = BuildingForm
    model: ModelBase = Site
    template_name: str = 'add.html'
    log_info: str = 'ADD BUILDING:'
    success_message: str = 'Building added'
    error_message: str = 'A building with the same name already exists'
    pk_name: str = 'site_id'
    checks_list: List[str] = ['check_user', 'check_unique']


class BuildingUpdateView(AuthMixin, BaseUpdateMixin, View):
    """
    Building update view
    """
    form_class: Form = BuildingForm
    model: ModelBase = Building
    fk_model: ModelBase = Site
    template_name: str = 'update.html'
    log_info: str = 'UPDATE BUILDING:'
    success_message: str = 'Building information changed'
    error_message: str = 'A building with the same name already exists'
    checks_list: List[str] = ['check_user', 'check_unique']


class BuildingDeleteView(AuthMixin, BaseDeleteMixin, View):
    """
    Building delete view
    """
    model: ModelBase = Building
    template_name: str = 'delete.html'
    log_info: str = 'DELETE BUILDING:'
    success_message: str = 'Building deleted'
    checks_list: List[str] = ['check_user']
    model_name: str = 'building'


class RoomAddView(AuthMixin, BaseAddMixin, View):
    """
    Room add view
    """
    form_class: Form = RoomForm
    model: ModelBase = Building
    template_name: str = 'add.html'
    log_info: str = 'ADD ROOM:'
    success_message: str = 'Room added'
    error_message: str = 'A room with the same name already exists'
    pk_name: str = 'building_id'
    checks_list: List[str] = ['check_user', 'check_unique']


class RoomUpdateView(AuthMixin, BaseUpdateMixin, View):
    """
    Room update view
    """
    form_class: Form = RoomForm
    model: ModelBase = Room
    fk_model: ModelBase = Building
    template_name: str = 'update.html'
    log_info: str = 'UPDATE ROOM:'
    success_message: str = 'Room information changed'
    error_message: str = 'A room with the same name already exists'
    checks_list: List[str] = ['check_user', 'check_unique']


class RoomDeleteView(AuthMixin, BaseDeleteMixin, View):
    """
    Room delete view
    """
    model: ModelBase = Room
    template_name: str = 'delete.html'
    log_info: str = 'DELETE ROOM:'
    success_message: str = 'Room deleted'
    checks_list: List[str] = ['check_user']
    model_name: str = 'room'


class RackAddView(AuthMixin, BaseAddMixin, View):
    """
    Rack add view
    """
    form_class: Form = RackForm
    model: ModelBase = Room
    template_name: str = 'add.html'
    log_info: str = 'ADD RACK:'
    success_message: str = 'Rack added'
    error_messagev: str = 'A rack with the same name already exists'
    pk_name: str = 'room_id'
    checks_list: List[str] = ['check_user', 'check_unique']


class RackUpdateView(AuthMixin, BaseUpdateMixin, View):
    """
    Rack update view
    """
    form_class: Form = RackForm
    model: ModelBase = Rack
    fk_model: ModelBase = Room
    template_name: str = 'update.html'
    log_info: str = 'UPDATE RACK:'
    success_message: str = 'Rack information changed'
    error_message: str = 'A rack with the same name already exists'
    checks_list: List[str] = ['check_user', 'check_unique']


class RackDeleteView(AuthMixin, BaseDeleteMixin, View):
    """
    Rack delete view
    """
    model: ModelBase = Rack
    template_name: str = 'delete.html'
    log_info: str = 'DELETE RACK:'
    success_message: str = 'Rack deleted'
    checks_list: List[str] = ['check_user']
    model_name: str = 'rack'


class DeviceAddView(AuthMixin, BaseAddMixin, View):
    """
    Device add view
    """
    form_class: Form = DeviceForm
    model: ModelBase = Rack
    template_name: str = 'add.html'
    log_info: str = 'ADD DEVICE:'
    success_message: str = 'Device added'
    pk_name: str = 'rack_id'
    checks_list: List[str] = ['check_user', 'check_device_for_add']


class DeviceUpdateView(AuthMixin, BaseUpdateMixin, View):
    """
    Device update view
    """
    form_class: Form = DeviceForm
    model: ModelBase = Device
    fk_model: ModelBase = Rack
    template_name: str = 'update.html'
    log_info: str = 'UPDATE DEVICE:'
    success_message: str = 'Device information changed'
    checks_list: List[str] = ['check_user', 'check_device_for_update']


class DeviceDeleteView(AuthMixin, BaseDeleteMixin, View):
    """
    Device delete view
    """
    model: ModelBase = Device
    template_name: str = 'delete.html'
    log_info: str = 'DELETE DEVICE:'
    success_message: str = 'Device deleted'
    checks_list: List[str] = ['check_user']
    model_name: str = 'device'


class DeviceQrView(AuthMixin, BaseQrMixin, View):
    """
    Device QR view
    """
    template_name: str = 'device_qr.html'
    model_name: str = 'device'


class RackQrView(AuthMixin, BaseQrMixin, View):
    """
    Rack QR view
    """
    template_name: str = 'rack_qr.html'
    model_name: str = 'rack'


class QrListView(AuthMixin, QrListMixin, View):
    """
    QR list view (rack QR + all devices QRs)
    """
    template_name: str = 'qr_list.html'


class FrontUnitsPrintView(AuthMixin, UnitsPrintMixin, View):
    """
    Front side units print view
    """
    template_name: str = 'print.html'
    front_side: bool = True


class BackUnitsPrintView(AuthMixin, UnitsPrintMixin, View):
    """
    Back side units print view
    """
    template_name: str = 'print.html'
    front_side: bool = False


class ExportDevicesView(AuthMixin, BaseReportMixin, View):
    """
    Export devices.csv view
    """
    model_name: str = 'device'


class ExportRacksView(AuthMixin, BaseReportMixin, View):
    """
    Export racks.csv view
    """
    model_name: str = 'rack'


class GotoView(AuthMixin, GotoMixin, View):
    """
    Go to view
    """
    pass


class RackDetailApiView(RackDetailApiViewMixin, APIView):
    """
    Rack detail API view
    """
    permission_classes: List[BasePermissionMetaclass] = [
        permissions.IsAuthenticated
    ]


class DeviceDetailApiView(DeviceDetailApiViewMixin, APIView):
    """
    Device detail API view
    """
    permission_classes: List[BasePermissionMetaclass] = [
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
