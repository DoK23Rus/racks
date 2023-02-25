"""
Some utils
"""
from abc import ABC, abstractmethod
from dataclasses import dataclass
from typing import List, Union, Type, Any

from django.db.models.base import ModelBase
from django.db.models.query import QuerySet

from mainapp.repository import (RepositoryHelper,
                                DeviceRepository,
                                RackRepository)
from mainapp.services import DeviceCheckService, UnitsTuple


@dataclass
class Result:
    """
    Class for check result objects
    """
    success: bool
    message: str


@dataclass
class BaseCheckProps:

    user_groups: list
    pk: int
    data: dict
    model: ModelBase


@dataclass
class AddCheckProps(BaseCheckProps):

    fk_model: ModelBase
    key_name: str


@dataclass
class UpdateCheckProps(BaseCheckProps):

    fk: int
    fk_model: ModelBase
    key_name: str
    instance_name: str


@dataclass
class DeleteCheckProps(BaseCheckProps):
    pass


class AbstractProp(ABC):

    @abstractmethod
    def _set_prop(self, *args, **kwargs) -> Any:
        raise NotImplementedError


class AbstractCheck(ABC):

    @abstractmethod
    def _set_result(self, *args, **kwargs) -> Result:
        raise NotImplementedError

    @abstractmethod
    def _set_props(self, *args, **kwargs) -> None:
        raise NotImplementedError


class AbstractChecker(ABC):

    @abstractmethod
    def _set_result(self, *args, **kwargs) -> Result:
        raise NotImplementedError


class BaseCheck:

    def __init__(self,
                 props: Union[AddCheckProps,
                              UpdateCheckProps,
                              DeleteCheckProps]
                 ) -> None:
        self.props = props


class NamesList:

    def __init__(self, pk: int, model: ModelBase) -> None:
        self.pk = pk
        self.model = model
        self.names_list = self._set_prop(RepositoryHelper)

    def _set_prop(self, helper: Type[RepositoryHelper]) -> List[str]:
        repository = helper.get_model_repository(self.model)
        return repository.get_unique_object_names_list(self.pk)


class DepartmentName:

    def __init__(self,
                 pk: int,
                 model: ModelBase,
                 ) -> None:
        self.pk = pk
        self.model = model
        self.department_name = self._set_prop(RepositoryHelper)

    def _set_prop(self, helper: Type[RepositoryHelper]) -> str:
        repository = helper.get_model_repository(self.model)
        return repository.get_department_name(self.pk)


class OldUnits:

    def __init__(self, pk: int) -> None:
        self.pk = pk
        self.old_units = self._set_prop(DeviceRepository,
                                        DeviceCheckService,
                                        UnitsTuple)

    def _set_prop(self,
                  repository: Type[DeviceRepository],
                  service: Type[DeviceCheckService],
                  units: Type[UnitsTuple]
                  ) -> UnitsTuple:
        old_first_unit = repository.get_first_unit(self.pk)
        old_last_unit = repository.get_last_unit(self.pk)
        return service.get_units(old_first_unit, old_last_unit, units)


class FirstUnit:

    def __init__(self, data: dict) -> None:
        self.data = data
        self.first_unit = self._set_prop()

    def _set_prop(self) -> int:
        try:
            first_unit = self.data['first_unit']
            return first_unit
        except KeyError:
            raise KeyError("There is no first_unit in data") from None


class LastUnit:

    def __init__(self, data: dict) -> None:
        self.data = data
        self.last_unit = self._set_prop()

    def _set_prop(self) -> int:
        try:
            first_unit = self.data['last_unit']
            return first_unit
        except KeyError:
            raise KeyError("There is no last_unit in data") from None


class FrontsideLocation:

    def __init__(self, data: dict) -> None:
        self.data = data
        self.frontside_location = self._set_prop()

    def _set_prop(self) -> bool:
        try:
            first_unit = self.data['frontside_location']
            return first_unit
        except KeyError:
            raise KeyError("There is no frontside_location in data") from None


class RackAmount:

    def __init__(self, pk: int) -> None:
        self.pk = pk
        self.rack_amount = self._set_prop(RackRepository)

    def _set_prop(self, repository: Type[RackRepository]) -> int:
        return repository.get_rack_amount(self.pk)


class NewUnits:

    def __init__(self, first_unit: int, last_unit: int) -> None:
        self.first_unit = first_unit
        self.last_unit = last_unit
        self.new_units = self._set_prop(DeviceCheckService, UnitsTuple)

    def _set_prop(self,
                  service: Type[DeviceCheckService],
                  units: Type[UnitsTuple]
                  ) -> UnitsTuple:
        return service.get_units(self.first_unit, self.last_unit, units)


class UnitsExist:

    def __init__(self, new_units: UnitsTuple, rack_amount: int) -> None:
        self.new_units = new_units
        self.rack_amount = rack_amount
        self.units_exist = self._set_prop(DeviceCheckService)

    def _set_prop(self, service: Type[DeviceCheckService]) -> bool:
        return service.check_unit_exist(self.new_units, self.rack_amount)


class DevicesForSide:

    def __init__(self,
                 pk: int,
                 frontside_location: bool
                 ) -> None:
        self.pk = pk
        self.frontside_location = frontside_location
        self.devices_for_side = self._set_prop(DeviceRepository)

    def _set_prop(self, repository: Type[DeviceRepository]) -> QuerySet:
        return repository \
            .get_devices_for_side(self.pk, self.frontside_location)


class FilledList:

    def __init__(self, devices_for_side: QuerySet) -> None:
        self.devices_for_side = devices_for_side
        self.filled_list = self._set_prop(DeviceCheckService)

    def _set_prop(self, service: Type[DeviceCheckService]) -> List[int]:
        return service.get_filled_list(self.devices_for_side)


class UnitsBusyUpdate:

    def __init__(self,
                 filled_list: List[int],
                 new_units: UnitsTuple,
                 old_units: UnitsTuple
                 ) -> None:
        self.filled_list = filled_list
        self.new_units = new_units
        self.old_units = old_units
        self.unit_busy = self._set_prop(DeviceCheckService)

    def _set_prop(self, service: Type[DeviceCheckService]) -> bool:
        return service \
            .check_unit_busy_for_update(self.filled_list,
                                        self.new_units,
                                        self.old_units)


class UnitsBusyAdd:

    def __init__(self,
                 filled_list: List[int],
                 new_units: UnitsTuple,
                 ) -> None:
        self.filled_list = filled_list
        self.new_units = new_units
        self.unit_busy = self._set_prop(DeviceCheckService)

    def _set_prop(self, service: Type[DeviceCheckService]) -> bool:
        return service \
            .check_unit_busy_for_add(self.filled_list,
                                     self.new_units)


class RackId:

    def __init__(self, pk: int) -> None:
        self.pk = pk
        self.rack_id = self._set_prop(DeviceRepository)

    def _set_prop(self, repository: Type[DeviceRepository]) -> int:
        return repository.get_device_rack_id(self.pk)


class SameName:

    def __init__(self, instance_name: str, key_name: str) -> None:
        self.instance_name = instance_name
        self.key_name = key_name
        self.same_name = self._set_prop()

    def _set_prop(self) -> bool:
        if self.instance_name == self.key_name:
            return True
        return False


class NameInNamesList:

    def __init__(self,
                 key_name: str,
                 names_list: List[str]
                 ) -> None:
        self.key_name = key_name
        self.names_list = names_list
        self.name_in_names_list = self._set_prop()

    def _set_prop(self) -> bool:
        if self.key_name in self.names_list:
            return True
        return False


class CheckUser(BaseCheck):

    def __init__(self, *args, **kwargs) -> None:
        super().__init__(*args, **kwargs)
        self._set_props(DepartmentName,
                        AddCheckProps,
                        UpdateCheckProps,
                        DeleteCheckProps)
        self.result = self._set_result(Result)

    def _set_props(self,
                   department_name_prop: Type[DepartmentName],
                   add_check_props_dc: Type[AddCheckProps],
                   update_check_props_dc: Type[UpdateCheckProps],
                   delete_check_props_dc: Type[DeleteCheckProps]
                   ) -> None:
        if isinstance(self.props, add_check_props_dc):
            self.department_name = department_name_prop(self.props.pk,
                                                        self.props.fk_model) \
                .department_name
        if isinstance(self.props, update_check_props_dc):
            self.department_name = department_name_prop(self.props.pk,
                                                        self.props.model) \
                .department_name
        if isinstance(self.props, delete_check_props_dc):
            self.department_name = department_name_prop(self.props.pk,
                                                        self.props.model) \
                .department_name

    def _set_result(self, result: Type[Result]) -> Result:
        if self.department_name not in self.props.user_groups:
            return result(False, 'Permission alert, changes are prohibited')
        return result(True, 'Success')


class CheckUnique(BaseCheck):

    def __init__(self, *args, **kwargs) -> None:
        super().__init__(*args, **kwargs)
        self._set_props(NamesList,
                        NameInNamesList,
                        SameName,
                        AddCheckProps,
                        UpdateCheckProps,
                        DeleteCheckProps)
        self.result = self._set_result(Result)

    def _set_props(self,
                   names_list_prop: Type[NamesList],
                   name_in_names_prop: Type[NameInNamesList],
                   same_name_prop: Type[SameName],
                   add_check_props_dc: Type[AddCheckProps],
                   update_check_props_dc: Type[UpdateCheckProps],
                   delete_check_props_dc: Type[DeleteCheckProps],
                   ) -> None:
        if isinstance(self.props, add_check_props_dc):
            self.names_list = names_list_prop(self.props.pk,
                                              self.props.model).names_list
            self.same_name = False
            self.name_in_names_list = name_in_names_prop(self.props.key_name,
                                                         self.names_list) \
                .name_in_names_list
        if isinstance(self.props, update_check_props_dc):
            self.pk = self.props.fk
            self.names_list = names_list_prop(self.pk,
                                              self.props.model).names_list
            self.same_name = same_name_prop(self.props.instance_name,
                                            self.props.key_name).same_name
            self.name_in_names_list = name_in_names_prop(self.props.key_name,
                                                         self.names_list) \
                .name_in_names_list
        if isinstance(self.props, delete_check_props_dc):
            pass

    def _set_result(self, result: Type[Result]) -> Result:
        # For rack properties changes (name staing the same)
        if self.same_name:
            return result(True, 'Success')
        if self.name_in_names_list:
            return result(False,
                          f"A {self.props.model._meta.db_table} "
                          f"with the same name already exists")
        return result(True, 'Success')


class CheckDeviceForAddOrUpdate(BaseCheck):

    def __init__(self, *args, **kwargs) -> None:
        super().__init__(*args, **kwargs)
        self._set_props(FirstUnit,
                        LastUnit,
                        FrontsideLocation,
                        RackAmount,
                        NewUnits,
                        UnitsExist,
                        DevicesForSide,
                        FilledList,
                        RackId,
                        OldUnits,
                        UnitsBusyUpdate,
                        UnitsBusyAdd,
                        AddCheckProps,
                        UpdateCheckProps,
                        DeleteCheckProps)
        self.result = self._set_result(Result)

    def _set_props(self,
                   first_unit_prop: Type[FirstUnit],
                   Last_unit_prop: Type[LastUnit],
                   frontside_location_prop: Type[FrontsideLocation],
                   rack_amount_prop: Type[RackAmount],
                   new_units_prop: Type[NewUnits],
                   units_exist_prop: Type[UnitsExist],
                   device_for_side_prop: Type[DevicesForSide],
                   filled_list_prop: Type[FilledList],
                   rack_id_prop: Type[RackId],
                   old_units_prop: Type[OldUnits],
                   units_busy_update_prop: Type[UnitsBusyUpdate],
                   units_busy_add_prop: Type[UnitsBusyAdd],
                   add_check_props_dc: Type[AddCheckProps],
                   update_check_props_dc: Type[UpdateCheckProps],
                   delete_check_props_dc: Type[DeleteCheckProps]
                   ) -> None:
        if isinstance(self.props, add_check_props_dc):
            self.first_unit = first_unit_prop(self.props.data).first_unit
            self.last_unit = Last_unit_prop(self.props.data).last_unit
            self.frontside_location = frontside_location_prop(self.props
                                                              .data) \
                .frontside_location
            self.rack_id = self.props.pk
            self.rack_amount = rack_amount_prop(self.rack_id).rack_amount
            self.new_units = new_units_prop(self.first_unit, self.last_unit) \
                .new_units
            self.units_exist = units_exist_prop(self.new_units,
                                                self.rack_amount) \
                .units_exist
            self.devices_for_side = device_for_side_prop(self.props.pk,
                                                         self
                                                         .frontside_location) \
                .devices_for_side
            self.filled_list = filled_list_prop(self.devices_for_side) \
                .filled_list
            self.units_busy = units_busy_add_prop(self.filled_list,
                                                  self.new_units).unit_busy

        if isinstance(self.props, update_check_props_dc):
            self.old_units = old_units_prop(self.props.pk).old_units
            self.first_unit = first_unit_prop(self.props.data).first_unit
            self.last_unit = Last_unit_prop(self.props.data).last_unit
            self.frontside_location = frontside_location_prop(self.props
                                                              .data) \
                .frontside_location
            self.rack_id = rack_id_prop(self.props.pk).rack_id
            self.rack_amount = rack_amount_prop(self.rack_id).rack_amount
            self.new_units = new_units_prop(self.first_unit, self.last_unit) \
                .new_units
            self.units_exist = units_exist_prop(self.new_units,
                                                self.rack_amount) \
                .units_exist
            self.devices_for_side = device_for_side_prop(self.rack_id,
                                                         self
                                                         .frontside_location) \
                .devices_for_side
            self.filled_list = filled_list_prop(self.devices_for_side) \
                .filled_list
            self.units_busy = units_busy_update_prop(self.filled_list,
                                                     self.new_units,
                                                     self.old_units).unit_busy
        if isinstance(self.props, delete_check_props_dc):
            pass

    def _set_result(self, result: Type[Result]) -> Result:
        #if None in [
        #    self.first_unit,
        #    self.last_unit,
        #    self.frontside_location,
        #]:
        #    return result(False, 'Missing required data')
        # Check units exists
        if not self.units_exist:
            return result(False, 'There are no such units in this rack')
        # Check units busy
        if self.units_busy:
            return result(False, 'These units are busy')
        return result(True, 'Success')


Checks_List_Type = List[Union[Type[CheckDeviceForAddOrUpdate],
                              Type[CheckUser],
                              Type[CheckUnique]]]


class Checker:

    def __init__(self,
                 checks_list: Checks_List_Type,
                 props: Union[AddCheckProps,
                              UpdateCheckProps,
                              DeleteCheckProps]
                 ) -> None:
        self.checks_list = checks_list
        self.props = props
        self.result = self._set_result(Result)

    def _set_result(self, result: Type[Result]) -> Result:
        check_results_list: list[Result] = []
        for check in self.checks_list:
            check_results_list.append(check(self.props).result)
        for single_result in check_results_list:
            if not single_result.success:
                return single_result
        total_result = result(True, 'Success')
        return total_result
