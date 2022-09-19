from abc import ABC, abstractmethod
from django.contrib.auth.mixins import LoginRequiredMixin
from typing import List, Optional
from django.conf import settings
from django.shortcuts import render, redirect
from django.http import Http404, HttpRequest, HttpResponse
from django.db.models.base import ModelBase
from django.db.models.query import QuerySet
from django.forms import Form
from .serializers import RackSerializer, DeviceSerializer
from rest_framework.response import Response
from rest_framework import status
from .services import (
    RackLayoutService,
    UserCheckService,
    UniqueCheckService,
    DeviceCheckService,
    QrService,
    DraftService,
    ReportService,
    date,
)
from .forms import (
    SiteForm,
    BuildingForm,
    RoomForm,
    RackForm,
    DeviceForm,
    GotoForm,
)
from .models import (
    Region,
    Department,
    Site,
    Building,
    Room,
    Rack,
    Device,
)
import logging


logger = logging.getLogger(__name__)


class AbstractMixin(ABC):
    """
    Abstract mixin
    """

    @property
    def form_class(self) -> ModelBase:
        """
        Form class
        """
        raise NotImplementedError

    @property
    def model(self) -> ModelBase:
        """
        Model
        """
        raise NotImplementedError

    @property
    def fk_model(self) -> ModelBase:
        """
        Foreign key model
        """
        raise NotImplementedError

    @property
    def template_name(self) -> str:
        """
        Template name
        """
        raise NotImplementedError

    @property
    def log_info(self) -> str:
        """
        Log info (ADD|DELETE|UPDATE)
        """
        raise NotImplementedError

    @property
    def success_message(self) -> str:
        """
        Success messages
        """
        raise NotImplementedError

    @property
    def error_message(self) -> str:
        """
        Error message
        """
        raise NotImplementedError

    @property
    def checks_list(self) -> List[str]:
        """
        List of check names
        """
        raise NotImplementedError

    @property
    def pk_name(self) -> str:
        """
        Primary key name
        """
        raise NotImplementedError

    @property
    def model_name(self) -> str:
        """
        Model name
        """
        raise NotImplementedError

    @property
    def permission_alert(self) -> str:
        """
        Permission alert
        """
        raise NotImplementedError

    @property
    def units_exist_message(self) -> str:
        """
        Message if units exists
        """
        raise NotImplementedError

    @property
    def units_busy_message(self) -> str:
        """
        Message if units are busy
        """
        raise NotImplementedError

    @property
    def front_side(self) -> bool:
        """
        Front or back side
        """
        raise NotImplementedError


class AbstractViewMixin(AbstractMixin):
    """
    Abstract view mixin
    """

    @abstractmethod
    def get(self,
            request: HttpRequest,
            pk: int,
            ) -> HttpResponse:
        raise NotImplementedError

    @abstractmethod
    def post(self,
             request: HttpRequest,
             pk: int,
             ) -> HttpResponse:
        raise NotImplementedError


class FormMixin(AbstractMixin):
    """
    Form mixin
    """

    def get_form_update_for_add(self,
                                request: HttpRequest,
                                pk: int
                                ) -> ModelBase:
        """
        Get updated form for add views
        """
        updated_by = request.user.get_full_name()
        return self.form_class(request.POST or None, initial={
            "updated_by": updated_by,
            self.pk_name: pk,
        })

    def get_form_update_for_update(self,
                                   request: HttpRequest,
                                   form: Form,
                                   ) -> ModelBase:
        """
        Get updated form for update views
        """
        new_form = form.save(commit=False)
        new_form.updated_by = request.user.get_full_name()
        return new_form

    def get_old_form(self, instance: ModelBase) -> ModelBase:
        """
        Get old form (for logging)
        """
        return self.form_class(instance=instance)


class InstanceMixin(AbstractMixin):
    """
    Instance mixin
    """

    def get_model_instance(self, pk: int) -> ModelBase:
        """
        Get model instance
        """
        if self.model == Site:
            return self.model.objects.get_site(pk)
        elif self.model == Building:
            return self.model.objects.get_building(pk)
        elif self.model == Room:
            return self.model.objects.get_room(pk)
        elif self.model == Rack:
            return self.model.objects.get_rack(pk)
        elif self.model == Device:
            return self.model.objects.get_device(pk)
        else:
            raise ValueError('model: ModelBase must be'
                             'Site|Building|Room|Rack|Device')

    def get_fk(self, pk: int) -> int:
        """
        Get foreign key
        """
        if self.model == Site:
            return self.get_model_instance(pk).department_id_id
        elif self.model == Building:
            return self.get_model_instance(pk).site_id_id
        elif self.model == Room:
            return self.get_model_instance(pk).building_id_id
        elif self.model == Rack:
            return self.get_model_instance(pk).room_id_id
        elif self.model == Device:
            return self.get_model_instance(pk).rack_id_id
        else:
            raise ValueError('model: ModelBase must be'
                             'Site|Building|Room|Rack|Device')

    def get_instance_name(self, pk: int) -> str:
        """
        Get instance name
        """
        if self.model == Site:
            return self.get_model_instance(pk).site_name
        elif self.model == Building:
            return self.get_model_instance(pk).building_name
        elif self.model == Room:
            return self.get_model_instance(pk).room_name
        elif self.model == Rack:
            return self.get_model_instance(pk).rack_name
        elif self.model == Device:
            return (f'{self.get_model_instance(pk).device_vendor} '
                    f'{self.get_model_instance(pk).device_model}')
        else:
            raise ValueError('model: ModelBase must be'
                             'Site|Building|Room|Rack|Device')

    def get_form_instance_name(self, form: Form) -> str:
        """
        Get form instance name
        """
        if self.form_class == SiteForm:
            return form.instance.site_name
        elif self.form_class == BuildingForm:
            return form.instance.building_name
        elif self.form_class == RoomForm:
            return form.instance.room_name
        elif self.form_class == RackForm:
            return form.instance.rack_name
        elif self.form_class == DeviceForm:
            return form.instance.device_model
        else:
            raise ValueError('form_class: Form must be'
                             'SiteForm|BuildingForm|'
                             'RoomForm|RackForm|DeviceForm')


class RenderMixin(AbstractMixin):
    """
    Render mixin
    """

    def get_add_render(self,
                       request: HttpRequest,
                       form: Optional[Form],
                       message: Optional[str]
                       ) -> HttpResponse:
        """
        Render for add views
        """
        return render(request, self.template_name, {
            'form': form,
            'message': message,
        })

    def get_update_render(self,
                          request: HttpRequest,
                          form: Form,
                          message: Optional[str]
                          ) -> HttpResponse:
        """
        Render for update views
        """
        return render(request, self.template_name, {
            'form': form,
            'message': message,
        })

    def get_delete_render(self,
                          request: HttpRequest,
                          instance: ModelBase
                          ) -> HttpResponse:
        """
        Render for delete views
        """
        return render(request, self.template_name, {
            self.model_name: instance,
            'object': self.model_name,
        })

    def get_info_render(self,
                        request: HttpRequest,
                        message: str
                        ) -> HttpResponse:
        """
        Render for info template
        """
        return render(request, 'info.html', {
            'info': message,
        })

    def get_qr_render(self,
                      request: HttpRequest,
                      queryset: ModelBase, data: str,
                      image: str
                      ) -> HttpResponse:
        """
        Render for QR views
        """
        return render(request, self.template_name, {
            'date': date(),
            self.model_name: queryset,
            'image': image,
        })


class LoggingMixin(AbstractMixin):
    """
    Logging mixin
    """

    def get_create_log(self, request: HttpRequest, form: Form) -> None:
        """
        Logging for add views
        """
        return logger.info(f'{date()} '
                           f'{request.user.username} '
                           f'{self.log_info} '
                           f'{str(form)}')

    def get_update_log(self,
                       request: HttpRequest,
                       old_form: Form,
                       form: Form
                       ) -> None:
        """
        Logging for update views
        """
        return logger.info(f'{date()} '
                           f'{request.user.username} '
                           f'{self.log_info} '
                           f'OLD_FORM: {str(old_form)} '
                           f'NEW_FORM: {str(form)}')

    def get_delete_log(self, request: HttpRequest, obj_name: str) -> None:
        """
        Logging for delete views
        """
        return logger.info(f'{date()} '
                           f'{request.user.username} '
                           f'{self.log_info} '
                           f'{str(obj_name)}')


class Result:
    """
    Class for check result objects
    """

    def __init__(self, success: bool, message: str) -> None:
        self.success = success
        self.message = message

    def __repr__(self) -> str:
        return (f'{self.__class__.__name__}('
                f'{self.success!r}, {self.message!r})')


class ChecksMixin(AbstractMixin):
    """
    Checks mixin for adding, updating and deleting instances
    """
    permission_alert: str = 'Permission alert, changes are prohibited'
    units_exist_message: str = 'There are no such units in this rack'
    units_busy_message: str = 'These units are busy'

    def _check_user(self,
                    request: HttpRequest,
                    pk: int
                    ) -> Result:
        """
        Check user permission
        Checking if there is a group named department
        in the list of user groups that matches
        the model object belonging to the area
        of responsibility of the department (by primary keys)
        Does not allow you to change the data assigned to another department
        """
        user_groups = list(request.user.groups.values_list('name', flat=True))
        if not UserCheckService.check_for_groups(user_groups, pk, self.model):
            check_result = Result(False, self.permission_alert)
            return check_result
        check_result = Result(True, 'Success')
        return check_result

    def _check_unique(self,
                      pk: int,
                      fk: Optional[int],
                      model: ModelBase,
                      fk_model: ModelBase,
                      instance_name: Optional[str],
                      form_instance_name: Optional[str]
                      ) -> Result:
        """
        Check for unique names (only for Site|Building|Room)
        """
        # For rack properties changes (name staing the same)
        if instance_name != form_instance_name:
            if fk is None:
                names_list = UniqueCheckService \
                    .get_unique_object_names_list(pk, model)
            names_list = UniqueCheckService \
                .get_unique_object_names_list(fk, fk_model)
            if form_instance_name in names_list:
                check_result = Result(False, self.error_message)
                return check_result
            check_result = Result(True, 'Success')
            return check_result
        check_result = Result(True, 'Success')
        return check_result

    def _check_device_for_add(self,
                              pk: int,
                              form: Form
                              ) -> Result:
        """
        Is it possible to add a new device?
        """
        units = DeviceCheckService \
            .get_new_units(form.instance.first_unit,
                           form.instance.last_unit)
        units.update(DeviceCheckService.get_all_units(pk))
        # Check units exists
        if DeviceCheckService.check_unit_exist(units):
            check_result = Result(False, self.units_exist_message)
            return check_result
        # Check units busy
        if DeviceCheckService \
            .check_unit_busy(form.instance.frontside_location,
                             units,
                             pk,
                             update=False):
            check_result = Result(False, self.units_busy_message)
            return check_result
        check_result = Result(True, 'Success')
        return check_result

    def _check_device_for_update(self,
                                 pk: int,
                                 form: Form
                                 ) -> Result:
        """
        Is it possible to replace an existing device?
        """
        units = DeviceCheckService.get_old_units(pk)
        rack_id = Device.objects.get_device(pk).rack_id_id
        units.update(DeviceCheckService.get_new_units(form.instance.first_unit,
                                                      form.instance.last_unit))
        units.update(DeviceCheckService.get_all_units(rack_id))
        # Check units exists
        if DeviceCheckService.check_unit_exist(units):
            check_result = Result(False, self.units_exist_message)
            return check_result
        # Check units busy
        if DeviceCheckService \
            .check_unit_busy(form.instance.frontside_location,
                             units,
                             rack_id,
                             update=True):
            check_result = Result(False, self.units_busy_message)
            return check_result
        check_result = Result(True, 'Success')
        return check_result

    def get_checks(self,
                   request: HttpRequest,
                   pk: int,
                   fk: Optional[int] = None,
                   model: Optional[ModelBase] = None,
                   fk_model: Optional[ModelBase] = None,
                   form: Optional[Form] = None,
                   instance_name: Optional[str] = None,
                   form_instance_name: Optional[str] = None
                   ) -> List[Result]:
        """
        Get a list of check results
        """
        check_results_list = []
        for check in self.checks_list:
            if check == 'check_user':
                check_results_list \
                    .append(self._check_user(request, pk))
            elif check == 'check_unique':
                check_results_list \
                    .append(self._check_unique(pk,
                                               fk,
                                               model,
                                               fk_model,
                                               instance_name,
                                               form_instance_name))
            elif check == 'check_device_for_add':
                check_results_list \
                    .append(self._check_device_for_add(pk, form))
            elif check == 'check_device_for_update':
                check_results_list \
                    .append(self._check_device_for_update(pk, form))
            else:
                raise ValueError('check: str must be'
                                 'check_user|check_unique|'
                                 'check_device_for_add|'
                                 'check_device_for_update')
        return check_results_list

    def get_checks_result(self,
                          results_list: List[Result]
                          ) -> Result:
        """
        Get the final result of the checks
        """
        for result in results_list:
            if not result.success:
                return result
        check_result = Result(True, 'Success')
        return check_result


class BaseAddMixin(AbstractViewMixin,
                   FormMixin,
                   ChecksMixin,
                   RenderMixin,
                   InstanceMixin,
                   LoggingMixin):
    """
    Base add mixin
    """

    def get(self,
            request: HttpRequest,
            pk: int,
            ) -> HttpResponse:
        form_update = self.get_form_update_for_add(request, pk)
        return self.get_add_render(request, form_update, None)

    def post(self,
             request: HttpRequest,
             pk: int,
             ) -> HttpResponse:
        form = self.get_form_update_for_add(request, pk)
        if form.is_valid():
            form_instance_name = self.get_form_instance_name(form)
            # Check for add possibility
            checks = self.get_checks(request,
                                     pk,
                                     model=self.model,
                                     form=form,
                                     form_instance_name=form_instance_name)
            result = self.get_checks_result(checks)
            if not result.success:
                return self.get_add_render(request, form, result.message)
            else:
                form.save()
                # Log this
                self.get_create_log(request, form)
                return self.get_add_render(request,
                                           form,
                                           self.success_message)
        else:
            return self.get_add_render(request, form, None)


class BaseUpdateMixin(AbstractViewMixin,
                      FormMixin,
                      ChecksMixin,
                      InstanceMixin,
                      RenderMixin,
                      LoggingMixin):
    """
    Base update mixin
    """

    def get(self,
            request: HttpResponse,
            pk: int,
            ) -> HttpResponse:
        instance = self.get_model_instance(pk)
        old_form = self.get_old_form(instance)
        return self.get_update_render(request, old_form, None)

    def post(self,
             request: HttpResponse,
             pk: int,
             ) -> HttpResponse:
        instance = self.get_model_instance(pk)
        # Old form for comparing in log
        old_form = self.form_class(instance=instance)
        form = self.form_class(request.POST or None, instance=instance)
        if form.is_valid():
            fk = self.get_fk(pk)
            instance_name = self.get_instance_name(pk)
            form_instance_name = self.get_form_instance_name(form)
            # Check for update possibility
            checks = self.get_checks(request,
                                     pk,
                                     fk,
                                     model=self.model,
                                     fk_model=self.fk_model,
                                     form=form,
                                     instance_name=instance_name,
                                     form_instance_name=form_instance_name)
            result = self.get_checks_result(checks)
            if not result.success:
                return self.get_update_render(request, form, result.message)
            else:
                new_form = self.get_form_update_for_update(request, form)
                new_form.save()
                # Log this
                self.get_update_log(request, old_form, form)
                return self.get_update_render(request,
                                              form,
                                              self.success_message)
        else:
            return self.get_update_render(request, form, None)


class BaseDeleteMixin(AbstractViewMixin,
                      ChecksMixin,
                      InstanceMixin,
                      RenderMixin,
                      LoggingMixin):
    """
    Base delete mixin
    """

    def get(self,
            request: HttpRequest,
            pk: int,
            ) -> HttpResponse:
        instance = self.get_model_instance(pk)
        return self.get_delete_render(request, instance)

    def post(self,
             request: HttpRequest,
             pk: int,
             ) -> HttpResponse:
        instance = self.get_model_instance(pk)
        # Check for update possibility
        checks = self.get_checks(request, pk, model=self.model)
        result = self.get_checks_result(checks)
        if not result.success:
            return self.get_info_render(request, result.message)
        else:
            instance.delete()
            # Log this
            self.get_delete_log(request, instance)
            return self.get_info_render(request, self.success_message)


class TreeDataMixin:
    """
    Add context for racks map
    """
    template_name: str

    def get(self, request: HttpRequest) -> HttpResponse:
        regions = Region.objects.get_all_regions()
        departments = Department.objects.get_all_departments()
        sites = Site.objects.get_all_sites()
        buildings = Building.objects.get_all_buildings()
        rooms = Room.objects.get_all_rooms()
        racks = Rack.objects.get_all_racks()
        context = {
            'regions': regions,
            'departments': departments,
            'sites': sites,
            'buildings': buildings,
            'rooms': rooms,
            'racks': racks,
        }
        return render(request, self.template_name, context=context)


class UnitsDataMixin:
    """
    Add context to single rack rendering
    """
    template_name: str

    def get(self, request: HttpRequest, pk: int) -> HttpResponse:
        direction = Rack.objects.get_rack(pk).numbering_from_bottom_to_top
        rack = Rack.objects.get_rack(pk)
        header = Rack.objects.get_fk_sequence(pk)
        start_list = RackLayoutService.get_start_list(pk, direction)
        devices_front = Device.objects.get_devices_for_side(pk, True)
        devices_back = Device.objects.get_devices_for_side(pk, False)
        first_units_front = RackLayoutService \
            .get_first_units(pk, direction, True)
        first_units_back = RackLayoutService \
            .get_first_units(pk, direction, False)
        spans_front = RackLayoutService.get_rowspans(pk, True)
        spans_back = RackLayoutService.get_rowspans(pk, False)
        context = {
            'rack': rack,
            'header': header,
            'start_list': start_list,
            'devices_front': devices_front,
            'devices_back': devices_back,
            'first_units_front': first_units_front,
            'first_units_back': first_units_back,
            'spans_front': spans_front,
            'spans_back': spans_back,
        }
        return render(request, self.template_name, context=context)


class BaseQrMixin(RenderMixin, AbstractViewMixin):
    """
    QR mixin (rack|device)
    """

    def get(self,
            request: HttpRequest,
            pk: int,
            ) -> HttpResponse:
        if self.model_name == 'device':
            queryset = Device.objects.get_device(pk)
            is_device = True
        elif self.model_name == 'rack':
            queryset = Rack.objects.get_rack(pk)
            is_device = False
        else:
            raise ValueError("instance_name: str must be device|rack")
        data = QrService.get_qr_data(pk, is_device, settings.START_PAGE_URL)
        image = QrService.show_qr(data, pk, is_device)
        return self.get_qr_render(request, queryset, data, image)

    def post(self):
        pass


class QrListMixin(AbstractViewMixin):
    """
    QRs for rack and all devices (for this rack)
    """

    def get(self,
            request: HttpRequest,
            pk: int,
            ) -> HttpResponse:
        devices_list = Device.objects.get_devices_id_list(pk)
        rack_qr_data = QrService.get_qr_data(pk,
                                             False,
                                             settings.START_PAGE_URL)
        rack = Rack.objects.get_rack(pk)
        all_devices = Device.objects.get_devices_for_rack(pk)
        device_images: List = []
        for device in devices_list:
            qr_data = QrService.get_qr_data(device,
                                            True,
                                            settings.START_PAGE_URL)
            device_images.append(QrService.show_qr(qr_data, device, True))
        rack_image = QrService.show_qr(rack_qr_data, pk, False)
        context = {
            'date': date(),
            'rack': rack,
            'devices_all': all_devices,
            'devices_id_list': devices_list,
            'device_images': device_images,
            'rack_image': rack_image,
        }
        return render(request, self.template_name, context=context)

    def post(self):
        pass


class UnitsPrintMixin(AbstractViewMixin):
    """
    Add context to rack rendering draft (one side)
    """

    def get(self,
            request: HttpRequest,
            pk: int,
            ) -> HttpResponse:
        rack = Rack.objects.get_rack(pk)
        direction = Rack.objects.get_rack(pk).numbering_from_bottom_to_top
        side_name = DraftService.get_side_name(self.front_side)
        start_list = RackLayoutService.get_start_list(pk, direction)
        devices = Device.objects.get_devices_for_side(pk, self.front_side)
        firts_units = RackLayoutService.get_first_units(pk,
                                                        direction,
                                                        self.front_side)
        rowspans = RackLayoutService.get_rowspans(pk, self.front_side)
        font_size = DraftService.get_font_size(rack.rack_amount)
        context = {
            'side_name': side_name,
            'rack': rack,
            'start_list': start_list,
            'devices': devices,
            'first_units': firts_units,
            'spans': rowspans,
            'font_size': font_size,
        }
        return render(request, self.template_name, context=context)

    def post(self):
        pass


class BaseReportMixin:
    """
    Csv report for all devices|racks
    """
    model_name: str

    def get(self, request: HttpRequest) -> HttpResponse:
        if self.model_name == 'device':
            header_list = ReportService.get_header_list(self.model_name)
            report_data = ReportService \
                .get_devices_data(f'{self.model_name}_detail/')
            responce = ReportService.get_responce(header_list,
                                                  report_data,
                                                  f'{self.model_name}.csv')
            return responce
        elif self.model_name == 'rack':
            header_list = ReportService.get_header_list(self.model_name)
            report_data = ReportService \
                .get_racks_data(f'{self.model_name}_detail/')
            responce = ReportService.get_responce(header_list,
                                                  report_data,
                                                  f'{self.model_name}.csv')
            return responce
        else:
            raise ValueError("instance_name: str must be device|rack")

    def post(self):
        pass


class GotoMixin:
    """
    Go to mixin
    """

    def get(self, request: HttpRequest) -> HttpResponse:
        form = GotoForm(request.POST)
        return render(request, 'goto.html', {
            'form': form,
        })

    def post(self, request: HttpRequest) -> HttpResponse:
        form = GotoForm(request.POST)
        if form.is_valid():
            if request.POST.get('object_type') == "Device":
                value = form.cleaned_data
                pk = value['object_id']
                try:
                    Device.objects.get_device(pk)
                    return redirect(f'{settings.START_PAGE_URL}'
                                    f'device_detail/{str(pk)}')
                except Device.DoesNotExist:
                    raise Http404()
            elif request.POST.get('object_type') == "Rack":
                value = form.cleaned_data
                pk = value['object_id']
                try:
                    Rack.objects.get_rack(pk)
                    return redirect(f'{settings.START_PAGE_URL}'
                                    f'units/{str(pk)}')
                except Rack.DoesNotExist:
                    raise Http404()
            else:
                raise ValueError("object_type: str must be Device|Rack")


class RackDetailApiViewMixin:
    """
    Rack detail API mixin
    """

    def get(self, request: HttpRequest, pk: int) -> HttpResponse:
        try:
            rack = Rack.objects.get_rack(pk)
            serializer = RackSerializer(rack)
            return Response(serializer.data, status=status.HTTP_200_OK)
        except Rack.DoesNotExist:
            return Response(
                {"res": "Rack with this ID does not exist"},
                status=status.HTTP_400_BAD_REQUEST
            )


class DeviceDetailApiViewMixin:
    """
    Device detail API mixin
    """

    def get(self, request: HttpRequest, pk: int) -> HttpResponse:
        try:
            device = Device.objects.get_device(pk)
            serializer = DeviceSerializer(device)
            return Response(serializer.data, status=status.HTTP_200_OK)
        except Device.DoesNotExist:
            return Response(
                {"res": "Device with this ID does not exist"},
                status=status.HTTP_400_BAD_REQUEST
            )


class RackListApiViewMixin:
    """
    Racks list API mixin
    """
    queryset: QuerySet = Rack.objects.get_all_racks()


class DeviceListApiViewMixin:
    """
    Devices list API mixin
    """
    queryset: QuerySet = Device.objects.get_all_devices()


class AuthMixin(LoginRequiredMixin):
    """
    Auth mixin
    """
    login_url: str = '/login/'
