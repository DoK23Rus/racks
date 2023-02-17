"""
Some utils
"""
from dataclasses import dataclass
from django.db.models.base import ModelBase
from django.db.models.query import QuerySet
from django.http import HttpRequest
from typing import List, Union

from mainapp.repository import (RepositoryHelper,
                                DeviceRepository,
                                RackRepository)
from mainapp.services import DeviceCheckService, NewUnitsTuple, OldUnitsTuple


@dataclass
class Result:
    """
    Class for check result objects
    """
    success: bool
    message: str


@dataclass
class AddCheckProps:

    request: HttpRequest
    pk: int
    data: dict
    update: bool
    model: ModelBase
    fk_model: ModelBase
    key_name: str


@dataclass
class UpdateCheckProps:

    request: HttpRequest
    pk: int
    data: dict
    update: bool
    fk: int
    model: ModelBase
    fk_model: ModelBase
    key_name: str
    instance_name: str


@dataclass
class DeleteCheckProps:

    request: HttpRequest
    pk: int
    data: dict
    model: ModelBase


class Check:

    def __init__(self,
                 props: Union[
                    AddCheckProps,
                    UpdateCheckProps,
                    DeleteCheckProps]
                 ) -> None:
        self.props = props


class NamesList:

    def __init__(self, pk: int, model: ModelBase, update: bool) -> None:
        self.pk = pk
        self.model = model
        self.update = update
        self.names_list = self._set_prop(RepositoryHelper)

    def _set_prop(self, helper) -> List[str]:
        repository = helper.get_model_repository(self.model)
        return repository.get_unique_object_names_list(self.pk)


class DepartmentName:

    def __init__(self,
                 pk: int,
                 model: ModelBase,
                 fk_model: ModelBase,
                 update: bool
                 ) -> None:
        self.pk = pk
        self.model = model
        self.fk_model = fk_model
        self.update = update
        self.department_name = self._set_prop(RepositoryHelper)

    def _set_prop(self, helper) -> str:
        if self.update is False:
            self.model = self.fk_model
        repository = helper.get_model_repository(self.model)
        return repository.get_department_name(self.pk)


class UserGroups:

    def __init__(self, request: HttpRequest) -> None:
        self.request = request
        self.user_groups = self._set_prop()

    def _set_prop(self) -> List[str]:
        return list(self.request.user.groups.values_list('name', flat=True))


class OldUnits:

    def __init__(self, pk: int) -> None:
        self.pk = pk
        self.old_units = self._set_prop(DeviceRepository,
                                        DeviceCheckService,
                                        OldUnitsTuple)

    def _set_prop(self, repository, service, units) -> None:
        old_first_unit = repository.get_first_unit(self.pk)
        old_last_unit = repository.get_last_unit(self.pk)
        return service.get_units(old_first_unit, old_last_unit, units)


class FirstUnit:

    def __init__(self, data: dict) -> None:
        self.data = data
        self.first_unit = self._set_prop()

    def _set_prop(self) -> int:
        return self.data.get('first_unit')


class LastUnit:

    def __init__(self, data: dict) -> None:
        self.data = data
        self.last_unit = self._set_prop()

    def _set_prop(self) -> int:
        return self.data.get('last_unit')


class FrontsideLocation:

    def __init__(self, data: dict) -> bool:
        self.data = data
        self.frontside_location = self._set_prop()

    def _set_prop(self) -> bool:
        return self.data.get('frontside_location')


class RackAmount:

    def __init__(self, pk: int) -> None:
        self.pk = pk
        self.rack_amount = self._set_prop(RackRepository)

    def _set_prop(self, repository) -> int:
        return repository.get_rack_amount(self.pk)


class NewUnits:

    def __init__(self, first_unit: int, last_unit: int) -> None:
        self.first_unit = first_unit
        self.last_unit = last_unit
        self.new_units = self._set_prop(DeviceCheckService, NewUnitsTuple)

    def _set_prop(self, service, units) -> NewUnitsTuple:
        return service.get_units(self.first_unit, self.last_unit, units)


class UnitsExist:

    def __init__(self, new_units: NewUnitsTuple, rack_amount: int) -> None:
        self.new_units = new_units
        self.rack_amount = rack_amount
        self.units_exist = self._set_prop(DeviceCheckService)

    def _set_prop(self, service) -> bool:
        return service.check_unit_exist(self.new_units, self.rack_amount)


class DevicesForSide:

    def __init__(self,
                 pk: int,
                 rack_id: int,
                 update: bool,
                 frontside_location: bool
                 ) -> None:
        self.pk = pk
        self.rack_id = rack_id
        self.update = update
        self.frontside_location = frontside_location
        self.devices_for_side = self._set_prop(DeviceRepository)

    def _set_prop(self, repository) -> QuerySet:
        if self.update is True:
            self.pk = self.rack_id
        return repository \
            .get_devices_for_side(self.pk, self.frontside_location)


class FilledList:

    def __init__(self, devices_for_side):
        self.devices_for_side = devices_for_side
        self.filled_list = self._set_prop(DeviceCheckService)

    def _set_prop(self, service):
        return service.get_filled_list(self.devices_for_side)


class UnitsBusyUpdate:

    def __init__(self,
                 filled_list: List[int],
                 new_units: NewUnitsTuple,
                 old_units: OldUnitsTuple
                 ) -> NotImplemented:
        self.filled_list = filled_list
        self.new_units = new_units
        self.old_units = old_units
        self.unit_busy = self._set_prop(DeviceCheckService)

    def _set_prop(self, service) -> bool:
        return service \
            .check_unit_busy_for_update(self.filled_list,
                                        self.new_units,
                                        self.old_units)


class UnitsBusyAdd:

    def __init__(self,
                 filled_list: List[int],
                 new_units: NewUnitsTuple,
                 ) -> NotImplemented:
        self.filled_list = filled_list
        self.new_units = new_units
        self.unit_busy = self._set_prop(DeviceCheckService)

    def _set_prop(self, service) -> bool:
        return service \
            .check_unit_busy_for_add(self.filled_list,
                                     self.new_units)


class RackId:

    def __init__(self, pk: int, update: bool) -> None:
        self.pk = pk
        self.update = update
        self.rack_id = self._set_prop(DeviceRepository)

    def _set_prop(self, repository) -> int:
        if self.update is True:
            return repository.get_device_rack_id(self.pk)
        return self.pk


class CheckUser(Check):

    def __init__(self, *args, **kwargs) -> None:
        super().__init__(*args, **kwargs)
        self.user_groups = UserGroups(self.props.request).user_groups
        self.department_name = DepartmentName(self.props.pk,
                                              self.props.model,
                                              self.props.fk_model,
                                              self.props.update) \
            .department_name
        self.result = self._set_result(Result)

    def _set_result(self, result) -> Result:
        if self.department_name not in self.user_groups:
            return result(False, 'Permission alert, changes are prohibited')
        return result(True, 'Success')


class CheckUnique(Check):

    def __init__(self, *args, **kwargs) -> None:
        super().__init__(*args, **kwargs)
        self._reset_props()
        self.pk = self.props.pk
        self.model = self.props.model
        self.names_list = NamesList(self.pk,
                                    self.model,
                                    self.props.update).names_list
        self.result = self._set_result(Result)

    def _reset_props(self) -> None:
        if self.props.update is True:
            self.pk = self.props.fk
            self.model = self.props.fk_model

    def _set_result(self, result) -> Result:
        # For rack properties changes (name staing the same)
        if self.props.update is True:
            if self.props.instance_name == self.props.key_name:
                return result(True, 'Success')
        if self.props.key_name in self.names_list:
            return result(False,
                          f"A {self.props.model._meta.db_table} "
                          f"with the same name already exists")
        return result(True, 'Success')


class CheckDeviceForAddOrUpdate(Check):

    def __init__(self, *args, **kwargs) -> None:
        super().__init__(*args, **kwargs)
        self._set_old_units(OldUnits)
        self.first_unit = FirstUnit(self.props.data).first_unit
        self.last_unit = LastUnit(self.props.data).last_unit
        self.frontside_location = FrontsideLocation(self.props.data) \
            .frontside_location
        self.rack_id = RackId(self.props.pk, self.props.update).rack_id
        self.rack_amount = RackAmount(self.rack_id).rack_amount
        self.new_units = NewUnits(self.first_unit, self.last_unit) \
            .new_units
        self.units_exist = UnitsExist(self.new_units, self.rack_amount) \
            .units_exist
        self.devices_for_side = DevicesForSide(self.props.pk,
                                               self.rack_id,
                                               self.props.update,
                                               self.frontside_location) \
            .devices_for_side
        self.filled_list = FilledList(self.devices_for_side).filled_list
        self._set_units_busy(UnitsBusyUpdate, UnitsBusyAdd)
        self.result = self._set_result(Result)

    def _set_old_units(self, old_units_prop):
        if self.props.update is True:
            self.old_units = old_units_prop(self.props.pk) \
                .old_units

    def _set_units_busy(self,
                        units_busy_update_prop,
                        units_busy_add_prop
                        ):
        if self.props.update is True:
            self.units_busy = units_busy_update_prop(self.filled_list,
                                                     self.new_units,
                                                     self.old_units).unit_busy
        self.units_busy = units_busy_add_prop(self.filled_list,
                                              self.new_units).unit_busy

    def _set_result(self, result) -> Result:
        if None in [
            self.first_unit,
            self.last_unit,
            self.frontside_location,
        ]:
            return result(False, "Missing required data")
        # Check units exists
        if not self.units_exist:
            return result(False, 'There are no such units in this rack')
        # Check units busy
        if self.units_busy:
            return result(False, 'These units are busy')
        return result(True, 'Success')


class Checker:

    def __init__(self,
                 checks_list: List[Check],
                 props: Union[AddCheckProps,
                              UpdateCheckProps,
                              DeleteCheckProps]
                 ) -> None:
        self.checks_list = checks_list
        self.props = props
        self.result = self._set_result(Result)

    def _set_result(self, result) -> Result:
        check_results_list: list[Result] = []
        for check in self.checks_list:
            check_results_list.append(check(self.props).result)
        for result in check_results_list:
            if not result.success:
                return result
        return result(True, 'Success')
