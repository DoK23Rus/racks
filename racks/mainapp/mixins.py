"""
Mixins for business logic calls
"""
import logging
import os
from abc import ABC, abstractmethod
from datetime import datetime

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
                                RegionRepository,
                                Repository_Type)
from mainapp.serializers import (DeviceSerializer,
                                 DepartmentSerializer,
                                 TreeRegionSerializer
                                 )
from mainapp.services import (date,
                              DataProcessingService,
                              ReportService,)
from mainapp.utils import (AddCheckProps,
                           DeleteCheckProps,
                           UpdateCheckProps,
                           Checker,
                           Checks_List_Type)
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
    def checks_list(self) -> Checks_List_Type:
        """
        List of check names
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

        Raises:
            NotImplementedError

        Returns:
            (HttpResponse): HttpResponse
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

        Raises:
            NotImplementedError

        Returns:
            (HttpResponse): HttpResponse
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

        Raises:
            NotImplementedError

        Returns:
            (HttpResponse): HttpResponse
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

        Raises:
            NotImplementedError

        Returns:
            (HttpResponse): HttpResponse
        """
        raise NotImplementedError


class LoggingMixin(AbstractMixin):
    """
    Logging mixin
    """

    def create_log(self,
                   request: HttpRequest,
                   data: dict,
                   pk: int
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
            'model_name': self.model._meta.db_table,
            'new_data': data,
            'fk': pk,
        })

    def update_log(self,
                   request: HttpRequest,
                   old_data: dict,
                   data: dict,
                   pk: int,
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
            'model_name': self.model._meta.db_table,
            'new_data': data,
            'old_data': old_data,
            'pk': str(pk),
        })

    def delete_log(self,
                   request: HttpRequest,
                   obj_name: str,
                   pk: int
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
            'model_name': self.model._meta.db_table,
            'object_name': obj_name,
            'pk': str(pk),
        })


class HelperMixin(AbstractMixin):
    """
    Some helpers
    """

    def get_pk(self, data: dict, key: str) -> int:
        """
        Get pk from data

        Args:
            data (dict): data dict
            key (str): key name

        Raises:
            ValueError ("No pk in data")

        Returns:
            pk (int): primary key
        """
        try:
            pk = data[key]
            return pk
        except KeyError:
            raise ValueError("No pk in data")

    def get_static_dir(self) -> str:
        """
        Get static_dir from .env

        Raises:
            ValueError ("No STATIC_DIR in .env file")

        Returns:
            static_dir (str): primary key
        """
        if not (static_dir := os.environ.get('STATIC_DIR')):
            raise ValueError("No STATIC_DIR in .env file")
        return static_dir

    def check_for_instance(self, pk: int, repository: Repository_Type) -> bool:
        """
        Check for instance

        Args:
            pk (int): primary key
            repository (Repository_Type): Repository

        Returns:
            (bool): True - instance exists
                    False - instance dont exist
        """
        try:
            repository.get_instance(pk)
            return True
        except self.model.DoesNotExist:
            return False


class BaseApiMixin(AbstractViewMixin):
    """
    Base API Mixin
    """

    def get(self, request: HttpRequest, *args, **kwargs) -> HttpResponse:
        """
        Get method plug

        Args:
            request (HttpRequest): Request
            *args: Args
            **kwargs: Kwargs

        Returns:
            (HttpResponse): This method not provided
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
            (HttpResponse): This method not provided
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
            (HttpResponse): This method not provided
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
            (HttpResponse): This method not provided
        """
        return Response({"invalid": "DELETE not allowed"}, status=405)


class BaseApiGetMixin(BaseApiMixin, HelperMixin):
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
            (HttpResponse): Response with data
            (HttpResponse): Object with this ID does not exist (exception)
        """
        pk = self.get_pk(kwargs, 'pk')
        repository = RepositoryHelper.get_model_repository(self.model)
        if not self.check_for_instance(pk, repository):
            return Response({
                "invalid": f"{self.model.__name__} with this ID does not exist"
            }, status=400)
        instance = repository.get_instance(pk)
        serializer = self.serializer_class(instance)
        return Response(serializer.data)


class BaseApiAddMixin(BaseApiMixin,
                      LoggingMixin,
                      HelperMixin):
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
            (HttpResponse): Object with this ID does not exist (exception)
            (HttpResponse): Add not allowed (read result.message)
            (HttpResponse): Sucsessfully added
            (HttpResponse): Not good data (validation error)
        """
        data = request.data
        user_groups = list(request.user.groups.values_list('name', flat=True))
        pk = self.get_pk(data, f"{self.fk_model._meta.db_table}_id")
        repository = RepositoryHelper.get_model_repository(self.fk_model)
        if not self.check_for_instance(pk, repository):
            return Response({
                "invalid": f"{self.model.__name__} with this ID does not exist"
            }, status=400)
        # Add username to data
        data['updated_by'] = request.user.username
        key_name = DataProcessingService \
            .get_key_name(data, self.model._meta.db_table)
        serializer = self.serializer_class(data=data)
        if serializer.is_valid(raise_exception=True):
            # Check for add possibility
            check_props = AddCheckProps(user_groups,
                                        pk,
                                        data,
                                        self.model,
                                        self.fk_model,
                                        key_name)
            result = Checker(self.checks_list, check_props).result
            if not result.success:
                return Response({"invalid": result.message}, status=400)
            serializer.save()
            # Log this
            self.create_log(request, data, pk)
            return Response({"sucsess": f"{key_name} sucsessfully added"})
        return Response({"invalid": "Not good data"}, status=400)


class BaseApiUpdateMixin(BaseApiMixin,
                         LoggingMixin,
                         HelperMixin):
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
            (HttpResponse): Object with this ID does not exist (exception)
            (HttpResponse): Update not allowed (read result.message)
            (HttpResponse): Sucsessfully updated
            (HttpResponse): Not good data (validation error)
        """
        data = request.data
        user_groups = list(request.user.groups.values_list('name', flat=True))
        pk = self.get_pk(data, 'id')
        repository = RepositoryHelper.get_model_repository(self.model)
        if not self.check_for_instance(pk, repository):
            return Response({
                "invalid": f"{self.model.__name__} with this ID does not exist"
            }, status=400)
        instance = repository.get_instance(pk)
        # Add fk and username to data
        fk_model_name = self.fk_model._meta.db_table
        fk = getattr(repository.get_instance(pk), f"{fk_model_name}_id_id")
        data[f"{fk_model_name}_id"] = fk
        data['updated_by'] = request.user.username
        # For some reason get method become lazy
        # when you call it from service layer
        old_data = self.model.objects.get(id=pk).__dict__
        # Prevent rack amount updating
        if data.get('rack_amount'):
            data['rack_amount'] = RackRepository.get_rack_amount(pk)
        key_name = DataProcessingService \
            .get_key_name(data, self.model._meta.db_table)
        instance_name = DataProcessingService \
            .get_instance_name(instance, self.model)
        serializer = self.serializer_class(data=data)
        if serializer.is_valid(raise_exception=True):
            # Check for update possibility
            check_props = UpdateCheckProps(user_groups,
                                           pk,
                                           data,
                                           self.model,
                                           fk,
                                           self.fk_model,
                                           key_name,
                                           instance_name)
            result = Checker(self.checks_list, check_props).result
            if not result.success:
                return Response({"invalid": result.message}, status=400)
            id = data.get(f"{fk_model_name}_id")
            repository = RepositoryHelper.get_model_repository(self.fk_model)
            data[f"{fk_model_name}_id"] = repository.get_instance(id)
            # Update data
            for key, value in data.items():
                setattr(instance, key, value)
            instance.save()
            # Log this
            self.update_log(request, old_data, data, pk)
            return Response({"sucsess": f"{key_name} sucsessfully updated"})
        return Response({"invalid": "Not good data"}, status=400)


class BaseApiDeleteMixin(BaseApiMixin,
                         LoggingMixin,
                         HelperMixin):
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
            (HttpResponse): Object with this ID does not exist (exception)
            (HttpResponse): Delete not allowed (read result.message)
            (HttpResponse): Sucsessfully dleted
        """
        data = request.data
        user_groups = list(request.user.groups.values_list('name', flat=True))
        pk = self.get_pk(data, 'id')
        repository = RepositoryHelper.get_model_repository(self.model)
        if not self.check_for_instance(pk, repository):
            return Response({
                "invalid": f"{self.model.__name__} with this ID does not exist"
            }, status=400)
        instance = repository.get_instance(pk)
        instance_name = DataProcessingService \
            .get_instance_name(instance, self.model)
        # Check for delete possibility
        check_props = DeleteCheckProps(user_groups,
                                       pk,
                                       data,
                                       self.model)
        result = Checker(self.checks_list, check_props).result
        if not result.success:
            return Response({"invalid": result.message}, status=400)
        instance.delete()
        # Log this
        self.delete_log(request, instance_name, pk)
        return Response({"sucsess": f"{instance_name} sucsessfully deleted"})


class RackDevicesApiMixin(BaseApiMixin, HelperMixin):
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
            (HttpResponse): Response with devices for a single rack
        """
        pk = self.get_pk(kwargs, 'pk')
        devices = DeviceRepository.get_devices_for_rack(pk)
        serialized_data = DeviceSerializer(devices, many=True).data
        return Response(serialized_data)


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
            (HttpResponse): Response with list of device vendors
        """
        device_vendors = DeviceRepository.get_device_vendors()
        # return Response({"device_vendors": device_vendors})
        return Response({
            "item_type": "device_vendor",
            "items": device_vendors
        })


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
            (HttpResponse): Response with list of device models
        """
        device_models = DeviceRepository.get_device_models()
        # return Response({"device_models": device_models})
        return Response({
            "item_type": "device_model",
            "items": device_models
        })


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
            (HttpResponse): Response with list of device vendors
        """
        rack_vendors = RackRepository.get_rack_vendors()
        # return Response({"rack_vendors": rack_vendors})
        return Response({
            "item_type": "rack_vendor",
            "items": rack_vendors
        })


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
            (HttpResponse): Response with list of rack models
        """
        rack_models = RackRepository.get_rack_models()
        # return Response({"rack_models": rack_models})
        return Response({
            "item_type": "rack_model",
            "items": rack_models
        })


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


class RegionDepartmentsListApiMixin(BaseApiMixin, HelperMixin):
    """
    Departments list mixin
    """
    def get(self, request: HttpRequest, *args, **kwargs) -> HttpResponse:
        pk = self.get_pk(kwargs, 'pk')
        departments = DepartmentRepository.get_departments_for_region(pk)
        serializaed_data = DepartmentSerializer(departments, many=True).data
        return Response(serializaed_data)


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
            (HttpResponse): Response with username
        """
        return Response({"user": request.user.username})


class DeviceLocationMixin(BaseApiMixin, HelperMixin):
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
            (HttpResponse): Response with device location data
        """
        pk = self.get_pk(kwargs, 'pk')
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


class RackLocationMixin(BaseApiMixin, HelperMixin):
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
            (HttpResponse): Response with rack location data
        """
        pk = self.get_pk(kwargs, 'pk')
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


class RacksReportMixin(BaseApiMixin, HelperMixin):
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
            (HttpResponse): Response with racks report data
        """
        file_path = f"{self.get_static_dir()}/racks_report_{date()}.csv"
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


class DevicesReportMixin(BaseApiMixin, HelperMixin):
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
            response (HttpResponse): Response with devices report data
        """
        file_path = f"{self.get_static_dir()}/devices_report_{date()}.csv"
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


class TreeRegionApiMixin(BaseApiMixin):
    """
    Departments list mixin
    """
    def get(self, request: HttpRequest, *args, **kwargs) -> HttpResponse:
        regions = RegionRepository.get_all_regions()
        serialized_data = TreeRegionSerializer(regions, many=True).data
        return Response(serialized_data)
