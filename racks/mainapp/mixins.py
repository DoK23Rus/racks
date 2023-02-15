"""
Mixins for business logic calls
"""
import logging
import os
from abc import ABC, abstractmethod
from datetime import datetime
from typing import List, Optional

from django.db.models.base import ModelBase
from django.db.models.query import QuerySet
from django.http import HttpRequest, HttpResponse, HttpResponseNotFound
from celery.result import AsyncResult
from rest_framework.response import Response
from rest_framework.serializers import SerializerMetaclass

from mainapp.data import ReportHeaders
from mainapp.repository import (RepositoryHelper,
                                DeviceRepository,
                                RackRepository,
                                RoomRepository,
                                SiteRepository,
                                BuildingRepository,
                                DepartmentRepository,
                                RegionRepository)
from mainapp.serializers import DeviceSerializer
from mainapp.services import (date,
                              DataProcessingService,
                              DeviceCheckService,
                              # RepoService,
                              # UniqueCheckService,
                              # UserCheckService,
                              ReportService,)
from mainapp.utils import Result
from mainapp.tasks import delete_report_task, generate_report_task

logger = logging.getLogger(__name__)


class AbstractMixin(ABC):
    """
    Abstract mixin
    """

    @property
    def model(self) -> ModelBase:
        """
        Model
        """
        raise NotImplementedError

    @property
    def serializer_class(self) -> SerializerMetaclass:
        """
        Serializer class
        """
        raise NotImplementedError

    @property
    def fk_model(self) -> ModelBase:
        """
        Foreign key model
        """
        raise NotImplementedError

    @property
    def fk_name(self) -> str:
        """
        Foreign key model
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


class AbstractViewMixin(AbstractMixin):
    """
    Abstract view mixin
    """

    @abstractmethod
    def get(self,
            request: HttpRequest,
            *args,
            **kwargs
            ) -> HttpResponse:
        """
        Abstract GET method

        Args:
            request (HttpRequest): Request
            *args: Args
            **kwargs: Kwargs

        Returns:
            Response (HttpResponse): HttpResponse
        """
        raise NotImplementedError

    @abstractmethod
    def post(self,
             request: HttpRequest,
             *args,
             **kwargs
             ) -> HttpResponse:
        """
        Abstract POST method

        Args:
            request (HttpRequest): Request
            *args: Args
            **kwargs: Kwargs

        Returns:
            Response (HttpResponse): HttpResponse
        """
        raise NotImplementedError

    @abstractmethod
    def put(self,
            request: HttpRequest,
            *args,
            **kwargs
            ) -> HttpResponse:
        """
        Abstract PUT method

        Args:
            request (HttpRequest): Request
            *args: Args
            **kwargs: Kwargs

        Returns:
            Response (HttpResponse): HttpResponse
        """
        raise NotImplementedError

    @abstractmethod
    def delete(self,
               request: HttpRequest,
               *args,
               **kwargs
               ) -> HttpResponse:
        """
        Abstract DELETE method

        Args:
            request (HttpRequest): Request
            *args: Args
            **kwargs: Kwargs

        Returns:
            Response (HttpResponse): HttpResponse
        """
        raise NotImplementedError


class LoggingMixin(AbstractMixin):
    """
    Logging mixin
    """

    def create_log(self,
                   request: HttpRequest,
                   data: dict,
                   pk: Optional[str]
                   ) -> None:
        """
        Logging for add views

        Args:
            request (HttpRequest): Request
            data (dict): Log data (add payload)
            pk (str): Primary key (foreign key for that model)
        """
        logger.info({
            'time': datetime.now(),
            'user': request.user.username,
            'action': 'add',
            'model_name': self.model_name,
            'new_data': data,
            'fk': pk,
        })

    def update_log(self,
                   request: HttpRequest,
                   old_data: dict,
                   data: dict,
                   pk: Optional[int],
                   ) -> None:
        """
        Logging for update views

        Args:
            request (HttpRequest): Request
            old_data (dict): Old data (for checking difference)
            data (dict): Log data (update payload)
            pk (int): Primary key
        """
        logger.info({
            'time': datetime.now(),
            'user': request.user.username,
            'action': 'update',
            'model_name': self.model_name,
            'new_data': data,
            'old_data': old_data,
            'pk': str(pk),
        })

    def delete_log(self,
                   request: HttpRequest,
                   obj_name: str,
                   pk: Optional[int]
                   ) -> None:
        """
        Logging for delete views

        Args:
            request (HttpRequest): Request
            obj_name (str): Deleting object name
            pk (int): Primary key
        """
        logger.info({
            'time': datetime.now(),
            'user': request.user.username,
            'action': 'delete',
            'model_name': self.model_name,
            'object_name': obj_name,
            'pk': str(pk),
        })


class ChecksMixin(AbstractMixin):
    """
    Checks mixin for adding, updating and deleting instances
    """
    permission_alert: str = 'Permission alert, changes are prohibited'
    units_exist_message: str = 'There are no such units in this rack'
    units_busy_message: str = 'These units are busy'

    def _check_user(self, request: HttpRequest, pk: Optional[int]) -> Result:
        """
        Checks user permission
        Checking if there is a group named department
        in the list of user groups that matches
        the model object belonging to the area
        of responsibility of the department (by primary keys)
        Does not allow you to change the data assigned to another department

        Args:
            request (HttpRequest): Request
            pk (int): Primary key

        Returns:
            Result.sucsess == False (Result): Action prohibited
                (read Result.message)
            Result.sucsess == True (Result): Action allowed
        """
        user_groups = list(request.user.groups.values_list('name', flat=True))
        if not RepositoryHelper \
            .get_repository(self.model) \
            .get_department_name(pk) \
                in user_groups:
            return Result(False, self.permission_alert)
        return Result(True, 'Success')

        # user_groups = list(request.user.groups.values_list('name', flat=True))
        # if not UserCheckService.check_for_groups(user_groups, pk, self.model):
        #     return Result(False, self.permission_alert)
        # return Result(True, 'Success')

    def _check_unique(self,
                      pk: Optional[int],
                      fk: Optional[int],
                      model: ModelBase,
                      fk_model: ModelBase,
                      instance_name: Optional[str],
                      key_name: Optional[str]
                      ) -> Result:
        """
        Checks for unique names (only for Site|Building|Room)

        Args:
            pk (int): Primary key
            fk (int): Foreign key (optional for update)
            model (ModelBase): Model
            fk_model (ModelBase): Foreign key model
            instance_name (str): Instance name (optional for update and delete)
            key_name (str): Key name (optional for add and update)

        Returns:
            Result.sucsess == False (Result): Action prohibited
                (read Result.message)
            Result.sucsess == True (Result): Action allowed
        """
        # For rack properties changes (name staing the same)
        if instance_name != key_name:
            if fk is None:
                repository = RepositoryHelper.get_child_model_repository(model)
                names_list = repository.get_unique_object_names_list(pk)
            else:
                repository = RepositoryHelper \
                    .get_child_model_repository(fk_model)
                names_list = repository.get_unique_object_names_list(fk)
            if key_name in names_list:
                return Result(False,
                              f"A {self.model_name} "
                              f"with the same name already exists")
            return Result(True, 'Success')
        return Result(True, 'Success')

        # if instance_name != key_name:
        #     if fk is None:
        #         names_list = UniqueCheckService \
        #             .get_unique_object_names_list(pk, model)
        #     else:
        #         names_list = UniqueCheckService \
        #             .get_unique_object_names_list(fk, fk_model)
        #     if key_name in names_list:
        #         return Result(False,
        #                       f"A {self.model_name} "
        #                       f"with the same name already exists")
        #     return Result(True, 'Success')
        # return Result(True, 'Success')

    def _check_device_for_add(self, pk: Optional[int], data: dict) -> Result:
        """
        Checks is it possible to add a new device

        Args:
            pk (int): Primary key
            data (dict): Add payload data

        Returns:
            Result.sucsess == False (Result): Action prohibited
                (read Result.message)
            Result.sucsess == True (Result): Action allowed
        """
        if (first_unit := data.get('first_unit')) is None:
            return Result(False, "Missing required data - first_unit")
        if (last_unit := data.get('last_unit')) is None:
            return Result(False, "Missing required data - last_unit")
        if (frontside_location := data.get('frontside_location')) is None:
            return Result(False, "Missing required data - frontside_location")
        new_units = DeviceCheckService \
            .get_new_units(first_unit, last_unit)
        # Check units exists
        rack_amount = RackRepository.get_rack_amount(pk)
        if DeviceCheckService.check_unit_exist(new_units, rack_amount):
            return Result(False, self.units_exist_message)
        # Check units busy
        devices_for_side = DeviceRepository \
            .get_devices_for_side(pk, frontside_location)
        if DeviceCheckService \
                .check_unit_busy(devices_for_side, new_units, old_units=None):
            return Result(False, self.units_busy_message)
        return Result(True, 'Success')

    def _check_device_for_update(self,
                                 pk: Optional[int],
                                 data: dict
                                 ) -> Result:
        """
        Checks is it possible to replace an existing device

        Args:
            pk (int): Primary key
            data (dict): Add payload data

        Returns:
            Result.sucsess == False (Result): Action prohibited
                (read Result.message)
            Result.sucsess == True (Result): Action allowed
        """
        if (first_unit := data.get('first_unit')) is None:
            return Result(False, "Missing required data - first_unit")
        if (last_unit := data.get('last_unit')) is None:
            return Result(False, "Missing required data - last_unit")
        if (frontside_location := data.get('frontside_location')) is None:
            return Result(False, "Missing required data - frontside_location")
        rack_id = DeviceRepository.get_device_rack_id(pk)
        old_first_unit = DeviceRepository.get_first_unit(pk)
        old_last_unit = DeviceRepository.get_last_unit(pk)
        old_units = DeviceCheckService \
            .get_old_units(old_first_unit, old_last_unit)
        new_units = DeviceCheckService.get_new_units(first_unit, last_unit)
        # Check units exists
        rack_amount = RackRepository.get_rack_amount(rack_id)
        # breakpoint()
        if DeviceCheckService.check_unit_exist(new_units, rack_amount):
            return Result(False, self.units_exist_message)
        # Check units busy
        devices_for_side = DeviceRepository \
            .get_devices_for_side(rack_id, frontside_location)
        if DeviceCheckService \
                .check_unit_busy(devices_for_side, new_units, old_units):
            return Result(False, self.units_busy_message)
        return Result(True, 'Success')

    def get_checks(self,
                   request: HttpRequest,
                   pk: Optional[int],
                   data: dict,
                   fk: Optional[int] = None,
                   model: Optional[ModelBase] = None,
                   fk_model: Optional[ModelBase] = None,
                   instance_name: Optional[str] = None,
                   key_name: Optional[str] = None,
                   ) -> List[Result]:
        """
        Get a list of check results

        Args:
            request (HttpRequest): Request
            pk (int): Primary key
            data (dict): Add payload data
            fk (int): Foreign key (optional for update)
            model (ModelBase): Model
            fk_model (ModelBase): Foreign key model
            instance_name (str): Instance name (optional for update and delete)
            key_name (str): Key name (optional for add and update)

        Raises:
            ValueError ('check: str must be'
                        'check_user|check_unique|'
                        'check_device_for_add|'
                        'check_device_for_update,'
                        'other checks dont implemented'):
                Check value is not in a list of implemented check names
        Returns:
            check_results_list (list): List of Result objects
        """
        check_results_list: List[Result] = []
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
                                               key_name))
            elif check == 'check_device_for_add':
                check_results_list \
                    .append(self._check_device_for_add(pk, data))
            elif check == 'check_device_for_update':
                check_results_list \
                    .append(self._check_device_for_update(pk, data))
            else:
                raise ValueError('check: str must be'
                                 'check_user|check_unique|'
                                 'check_device_for_add|'
                                 'check_device_for_update,'
                                 'other checks dont implemented')
        return check_results_list

    def get_checks_result(self, results_list: List[Result]) -> Result:
        """
        Get the final result of the checks

        Args:
            results_list (list): List of Result objects

        Returns:
            Result.sucsess == False (Result): Action prohibited (final)
                (read Result.message)
            Result.sucsess == True (Result): Action allowed (final)
        """
        for result in results_list:
            if not result.success:
                return result
        return Result(True, 'Success')


class BaseApiMixin(AbstractViewMixin):

    def get(self, request: HttpRequest, *args, **kwargs) -> HttpResponse:
        """
        Get method plug

        Args:
            request (HttpRequest): Request
            *args: Args
            **kwargs: Kwargs

        Returns:
            Response (HttpResponse): This method not provided
        """
        return Response({"invalid": "GET not allowed"}, status=405)

    def put(self, request: HttpRequest, *args, **kwargs) -> HttpResponse:
        """
        Put method plug

        Args:
            request (HttpRequest): Request
            *args: Args
            **kwargs: Kwargs

        Returns:
            Response (HttpResponse): This method not provided
        """
        return Response({"invalid": "PUT not allowed"}, status=405)

    def post(self, request: HttpRequest, *args, **kwargs) -> HttpResponse:
        """
        Post method plug

        Args:
            request (HttpRequest): Request
            *args: Args
            **kwargs: Kwargs

        Returns:
            Response (HttpResponse): This method not provided
        """
        return Response({"invalid": "POST not allowed"}, status=405)

    def delete(self, request: HttpRequest, *args, **kwargs) -> HttpResponse:
        """
        Delete method plug

        Args:
            request (HttpRequest): Request
            *args: Args
            **kwargs: Kwargs

        Returns:
            Response (HttpResponse): This method not provided
        """
        return Response({"invalid": "DELETE not allowed"}, status=405)


class BaseApiGetMixin(BaseApiMixin):
    """
    Base api get mixin
    """

    def get(self, request: HttpRequest, *args, **kwargs) -> HttpResponse:
        """
        Base get method

        Args:
            request (HttpRequest): Request
            *args: Args
            **kwargs: Kwargs

        Returns:
            Response (HttpResponse): Response with data
            Response (HttpResponse): Object with this ID
                does not exist (exception)
        """
        try:
            repository = RepositoryHelper.get_repository(self.model)
            instance = repository.get_instance(kwargs.get('pk'))
            serializer = self.serializer_class(instance)
            return Response(serializer.data)
        except self.model.DoesNotExist:
            message = f"{self.model.__name__} with this ID does not exist"
            return Response({"invalid": message}, status=400)


class BaseApiAddMixin(BaseApiMixin,
                      ChecksMixin,
                      LoggingMixin):
    """
    Base api add mixin
    """

    def post(self, request: HttpRequest, *args, **kwargs) -> HttpResponse:
        """
        Base post method

        Args:
            request (HttpRequest): Request
            *args: Args
            **kwargs: Kwargs

        Returns:
            Response (HttpResponse): Need fk for post method (exception)
            Response (HttpResponse): Object with this ID
                does not exist (exception)
            Response (HttpResponse): Add not allowed (read result.message)
            Response (HttpResponse): Sucsessfully added
            Response (HttpResponse): Not good data (validation error)
        """
        data = request.data
        try:
            pk = data[self.pk_name]
        except KeyError:
            return Response({"invalid": "Need fk for post method"})
        try:
            repository = RepositoryHelper.get_repository(self.model)
            repository.get_instance(pk)
        except self.model.DoesNotExist:
            message = f"{self.model.__name__} with this ID does not exist"
            return Response({"invalid": message}, status=400)
        # Add username to data
        data['updated_by'] = request.user.username
        key_name = DataProcessingService.get_key_name(data, self.model_name)
        serializer = self.serializer_class(data=data)
        if serializer.is_valid(raise_exception=True):
            # Check for add possibility
            checks = self \
                .get_checks(request,
                            pk=pk,
                            model=self.model,
                            data=data,
                            key_name=key_name)
            result = self.get_checks_result(checks)
            if not result.success:
                return Response({"invalid": result.message}, status=400)
            serializer.save()
            # Log this
            self.create_log(request, data, pk)
            return Response({"sucsess": f"{key_name} sucsessfully added"})
        return Response({"invalid": "Not good data"}, status=400)


class BaseApiUpdateMixin(BaseApiMixin,
                         ChecksMixin,
                         LoggingMixin):
    """
    Base update mixin
    """

    def put(self, request: HttpResponse, *args, **kwargs) -> HttpResponse:
        """
        Base put method

        Args:
            request (HttpRequest): Request
            *args: Args
            **kwargs: Kwargs

        Returns:
            Response (HttpResponse): Object with this ID
                does not exist (exception)
            Response (HttpResponse): Update not allowed (read result.message)
            Response (HttpResponse): Sucsessfully updated
            Response (HttpResponse): Not good data (validation error)
        """
        data = request.data
        pk = kwargs.get('pk')
        try:
            repository = RepositoryHelper.get_repository(self.model)
            instance = repository.get_instance(pk)
        except self.model.DoesNotExist:
            message = f"{self.model.__name__} with this ID does not exist"
            return Response({"invalid": message}, status=400)
        # Add fk and username to data
        repository = RepositoryHelper.get_repository(self.model)
        fk = getattr(repository.get_instance(pk),
                     f"{self.fk_name}_id")
        data[self.fk_name] = fk
        data['updated_by'] = request.user.username
        # For some reason get method become lazy
        # when you call it from service layer
        old_data = self.model.objects.get(id=pk).__dict__
        # Prevent rack amount updating
        if data.get('rack_amount'):
            data['rack_amount'] = RackRepository.get_rack_amount(pk)
        # data = DataProcessingService.update_rack_amount(data, pk)
        key_name = DataProcessingService.get_key_name(data, self.model_name)
        instance_name = DataProcessingService \
            .get_instance_name(instance, self.model, self.model_name)
        serializer = self.serializer_class(data=data)
        if serializer.is_valid(raise_exception=True):
            # Check for update possibility
            checks = self \
                .get_checks(request,
                            pk=pk,
                            fk=fk,
                            model=self.model,
                            fk_model=self.fk_model,
                            data=data,
                            instance_name=instance_name,
                            key_name=key_name)
            result = self.get_checks_result(checks)
            if not result.success:
                return Response({"invalid": result.message}, status=400)
            # PrimaryKeyRelatedField doesent work for some unnown reason
            id = data.get(self.fk_name)
            repository = RepositoryHelper.get_repository(self.fk_model)
            data[self.fk_name] = repository.get_instance(id)
            # Update data
            for key, value in data.items():
                setattr(instance, key, value)
            instance.save()
            # Log this
            self.update_log(request, old_data, data, pk)
            return Response({"sucsess": f"{key_name} sucsessfully updated"})
        return Response({"invalid": "Not good data"}, status=400)


class BaseApiDeleteMixin(BaseApiMixin,
                         ChecksMixin,
                         LoggingMixin):
    """
    Base delete mixin
    """

    def delete(self, request: HttpRequest, *args, **kwargs) -> HttpResponse:
        """
        Base delete method

        Args:
            request (HttpRequest): Request
            *args: Args
            **kwargs: Kwargs

        Returns:
            Response (HttpResponse): Object with this ID
                does not exist (exception)
            Response (HttpResponse): Delete not allowed (read result.message)
            Response (HttpResponse): Sucsessfully dleted
            Response (HttpResponse): Not good data (validation error)
        """
        data = request.data
        pk = kwargs.get('pk')
        try:
            repository = RepositoryHelper.get_repository(self.model)
            instance = repository.get_instance(pk)
        except self.model.DoesNotExist:
            message = f"{self.model.__name__} with this ID does not exist"
            return Response({"invalid": message}, status=400)
        instance_name = DataProcessingService \
            .get_instance_name(instance, self.model, self.model_name)
        # Check for delete possibility
        checks = self.get_checks(request, pk, data, model=self.model)
        result = self.get_checks_result(checks)
        if not result.success:
            return Response({"invalid": result.message}, status=400)
        instance.delete()
        # Log this
        self.delete_log(request, instance_name, pk)
        return Response({"sucsess": f"{instance_name} sucsessfully deleted"})


class RackDevicesApiMixin(BaseApiMixin):
    """
    Devices for rack mixin
    """

    def get(self, request: HttpRequest, *args, **kwargs) -> HttpResponse:
        """
        Get devices for a single rack

        Args:
            request (HttpRequest): Request
            *args: Args
            **kwargs: Kwargs

        Returns:
            Response (HttpResponse): Response with devices for a single rack
        """
        devices = DeviceRepository.get_devices_for_rack(kwargs.get('pk'))
        serializaed_data = DeviceSerializer(devices, many=True).data
        return Response(serializaed_data)


class DeviceVendorsApiMixin(BaseApiMixin):
    """
    Device vendors mixin
    """

    def get(self, request: HttpRequest, *args, **kwargs) -> HttpResponse:
        """
        Get device vendors list

        Args:
            request (HttpRequest): Request
            *args: Args
            **kwargs: Kwargs

        Returns:
            Response (HttpResponse): Response with list of device vendors
        """
        device_vendors = DeviceRepository.get_device_vendors()
        return Response({"device_vendors": device_vendors})


class DeviceModelsApiMixin(BaseApiMixin):
    """
    Device models mixin
    """

    def get(self, request: HttpRequest, *args, **kwargs) -> HttpResponse:
        """
        Get device models list

        Args:
            request (HttpRequest): Request
            *args: Args
            **kwargs: Kwargs

        Returns:
            Response (HttpResponse): Response with list of device models
        """
        device_models = DeviceRepository.get_device_models()
        return Response({"device_models": device_models})


class RackVendorsApiMixin(BaseApiMixin):
    """
    Rack vendors mixin
    """

    def get(self, request: HttpRequest, *args, **kwargs) -> HttpResponse:
        """
        Get rack vendors list

        Args:
            request (HttpRequest): Request
            *args: Args
            **kwargs: Kwargs

        Returns:
            Response (HttpResponse): Response with list of device vendors
        """
        rack_vendors = RackRepository.get_rack_vendors()
        return Response({"rack_vendors": rack_vendors})


class RackModelsApiMixin(BaseApiMixin):
    """
    Rack models mixin
    """

    def get(self, request: HttpRequest, *args, **kwargs) -> HttpResponse:
        """
        Get rack models list

        Args:
            request (HttpRequest): Request
            *args: Args
            **kwargs: Kwargs

        Returns:
            Response (HttpResponse): Response with list of rack models
        """
        rack_models = RackRepository.get_rack_models()
        return Response({"rack_models": rack_models})


class RegionListApiMixin:
    """
    Regions list mixin
    """
    queryset: QuerySet = RegionRepository.get_all_regions()


class DepartmentListApiMixin:
    """
    Departments list mixin
    """
    queryset: QuerySet = DepartmentRepository.get_all_departments()


class SiteListApiMixin:
    """
    Sites list mixin
    """
    queryset: QuerySet = SiteRepository.get_all_sites()


class BuildingListApiMixin:
    """
    Buildings list mixin
    """
    queryset: QuerySet = BuildingRepository.get_all_buildings()


class RoomListApiMixin:
    """
    Rooms list mixin
    """
    queryset: QuerySet = RoomRepository.get_all_rooms()


class RackListApiViewMixin:
    """
    Racks list API mixin
    """
    queryset: QuerySet = RackRepository.get_all_racks()


class RackPartialListApiViewMixin:
    """
    Racks partial list API mixin
    """
    queryset: QuerySet = RackRepository.get_all_racks_partial()


class UserApiMixin(BaseApiMixin):
    """
    User mixin
    """

    def get(self, request: HttpRequest, *args, **kwargs) -> HttpResponse:
        """
        Get username

        Args:
            request (HttpRequest): Request
            *args: Args
            **kwargs: Kwargs

        Returns:
            Response (HttpResponse): Response with username
        """
        return Response({"user": request.user.username})


class DeviceLocationMixin(BaseApiMixin):
    """
    Device location mixin
    """

    def get(self, request: HttpRequest, *args, **kwargs) -> HttpResponse:
        """
        Get device location data

        Args:
            request (HttpRequest): Request
            *args: Args
            **kwargs: Kwargs

        Returns:
            Response (HttpResponse): Response with device location data
        """
        pk = kwargs.get('pk')
        rack_name = DeviceRepository.get_device_rack_name(pk)
        room_name = DeviceRepository.get_device_room_name(pk)
        site_name = DeviceRepository.get_device_site_name(pk)
        building_name = DeviceRepository.get_device_building_name(pk)
        department_name = DeviceRepository.get_device_department_name(pk)
        region_name = DeviceRepository.get_device_region_name(pk)
        return Response({
            "rack_name": rack_name,
            "room_name": room_name,
            "site_name": site_name,
            "building_name": building_name,
            "department_name": department_name,
            "region_name": region_name,
        })


class RackLocationMixin(BaseApiMixin):
    """
    Rack location mixin
    """

    def get(self, request: HttpRequest, *args, **kwargs) -> HttpResponse:
        """
        Get rack location data

        Args:
            request (HttpRequest): Request
            *args: Args
            **kwargs: Kwargs

        Returns:
            Response (HttpResponse): Response with rack location data
        """
        pk = kwargs.get('pk')
        room_name = RackRepository.get_rack_room_name(pk)
        site_name = RackRepository.get_rack_site_name(pk)
        building_name = RackRepository.get_rack_building_name(pk)
        department_name = RackRepository.get_rack_department_name(pk)
        region_name = RackRepository.get_rack_region_name(pk)
        return Response({
            "room_name": room_name,
            "site_name": site_name,
            "building_name": building_name,
            "department_name": department_name,
            "region_name": region_name,
        })


class RacksReportMixin(BaseApiMixin):
    """
    Racks report API mixin
    """

    def get(self, request: HttpRequest, *args, **kwargs) -> HttpResponse:
        """
        Get racks report

        Args:
            request (HttpRequest): Request
            *args: Args
            **kwargs: Kwargs

        Returns:
            Response (HttpResponse): Response with racks report data
        """
        file_path = f"{os.environ.get('STATIC_DIR')}/racks_report_{date()}.csv"
        headers = ReportHeaders.racks_header_list
        racks_report_qs = RackRepository.get_report_data()
        data = ReportService.get_racks_data(racks_report_qs)
        task = generate_report_task.delay(file_path, headers, data)
        result = AsyncResult(task.id)
        file_path = result.get()
        response = HttpResponseNotFound()
        with open(file_path, 'rb') as file:
            response = HttpResponse(file.read(),
                                    content_type="multipart/form-data")
            response['Content-Disposition'] = 'inline; filename=report.csv'
        delete_report_task.delay(file_path)
        return response


class DevicesReportMixin(BaseApiMixin):
    """
    Devices report API mixin
    """

    def get(self, request: HttpRequest, *args, **kwargs) -> HttpResponse:
        """
        Get devices report

        Args:
            request (HttpRequest): Request
            *args: Args
            **kwargs: Kwargs

        Returns:
            Response (HttpResponse): Response with devices report data
        """
        file_path = f"{os.environ.get('STATIC_DIR')}/devices_report_"
        f"{date()}.csv"
        headers = ReportHeaders.devices_header_list
        devices_report_qs = DeviceRepository.get_report_data()
        data = ReportService.get_devices_data(devices_report_qs)
        task = generate_report_task.delay(file_path, headers, data)
        result = AsyncResult(task.id)
        file_path = result.get()
        response = HttpResponseNotFound()
        with open(file_path, 'rb') as file:
            response = HttpResponse(file.read(),
                                    content_type="multipart/form-data")
            response['Content-Disposition'] = 'inline; filename=report.csv'
        delete_report_task.delay(file_path)
        return response
