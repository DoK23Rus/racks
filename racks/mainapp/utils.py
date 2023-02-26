"""
Utils and dataclasses
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
    Dataclass for check result objects
    """
    success: bool
    message: str


@dataclass
class BaseCheckProps:
    """
    Dataclass for checks props
    """
    user_groups: list
    pk: int
    data: dict
    model: ModelBase


@dataclass
class AddCheckProps(BaseCheckProps):
    """
    Dataclass for props (checks for add)
    """
    fk_model: ModelBase
    key_name: str


@dataclass
class UpdateCheckProps(BaseCheckProps):
    """
    Dataclass for props (checks for update)
    """
    fk: int
    fk_model: ModelBase
    key_name: str
    instance_name: str


@dataclass
class DeleteCheckProps(BaseCheckProps):
    """
    Dataclass for props (checks for delete)
    """
    pass


class AbstractProp(ABC):
    """
    Abstract prop class
    """

    @abstractmethod
    def _set_prop(self, *args, **kwargs) -> Any:
        raise NotImplementedError


class AbstractCheck(ABC):
    """
    Abstract check class
    """

    @abstractmethod
    def _set_result(self, *args, **kwargs) -> Result:
        """
        Set result
        """
        raise NotImplementedError

    @abstractmethod
    def _set_props(self, *args, **kwargs) -> None:
        """
        Set props
        """
        raise NotImplementedError


class AbstractChecker(ABC):
    """
    Abstract checker classs
    """

    @abstractmethod
    def _set_result(self, *args, **kwargs) -> Result:
        """
        Set result
        """
        raise NotImplementedError


class BaseCheck:
    """
    Base check
    """

    def __init__(self,
                 props: Union[AddCheckProps,
                              UpdateCheckProps,
                              DeleteCheckProps]
                 ) -> None:
        """
        Args:
            props (Union[AddCheckProps,
                         UpdateCheckProps,
                         DeleteCheckProps]): Props for check
        """
        self.props = props


class NamesList:
    """
    List of unique object names
    """

    def __init__(self, pk: int, model: ModelBase) -> None:
        """
        Args:
            pk (int): primary key
            model (Model): Model
        """
        self.pk = pk
        self.model = model
        self.names_list = self._set_prop(RepositoryHelper)

    def _set_prop(self, helper: Type[RepositoryHelper]) -> List[str]:
        """
        Set names_list

        Args:
            helper (RepositoryHelper): RepositoryHelper class

        Returns:
            names_list (list): list of unique object names
        """
        repository = helper.get_model_repository(self.model)
        return repository.get_unique_object_names_list(self.pk)


class DepartmentName:
    """
    Department name for object
    """

    def __init__(self,
                 pk: int,
                 model: ModelBase,
                 ) -> None:
        """
        Args:
            pk (int): primary key
            model (Model): Model
        """
        self.pk = pk
        self.model = model
        self.department_name = self._set_prop(RepositoryHelper)

    def _set_prop(self, helper: Type[RepositoryHelper]) -> str:
        """
        Set department_name

        Args:
            helper (RepositoryHelper): RepositoryHelper class

        Returns:
            department_name (str): department name
        """
        repository = helper.get_model_repository(self.model)
        return repository.get_department_name(self.pk)


class OldUnits:
    """
    Old units
    """

    def __init__(self, pk: int) -> None:
        """
        Args:
            pk (int): device id
        """
        self.pk = pk
        self.old_units = self._set_prop(DeviceRepository,
                                        DeviceCheckService,
                                        UnitsTuple)

    def _set_prop(self,
                  repository: Type[DeviceRepository],
                  service: Type[DeviceCheckService],
                  units: Type[UnitsTuple]
                  ) -> UnitsTuple:
        """
        Set old_units

        Args:
            repository (DeviceRepository): DeviceRepository class
            service (DeviceCheckService): DeviceCheckService class
            units (UnitsTuple): UnitsTuple class

        Returns:
            old_units (UnitsTuple): named tuple of old units
        """
        old_first_unit = repository.get_first_unit(self.pk)
        old_last_unit = repository.get_last_unit(self.pk)
        return service.get_units(old_first_unit, old_last_unit, units)


class FirstUnit:
    """
    First unit
    """

    def __init__(self, data: dict) -> None:
        """
        Args:
            data (dict): data dict
        """
        self.data = data
        self.first_unit = self._set_prop()

    def _set_prop(self) -> int:
        """
        Set first_unit

        Returns:
            first_unit (int): first unit

        Raises:
            KeyError ('There is no first_unit in data')
        """
        try:
            first_unit = self.data['first_unit']
            return first_unit
        except KeyError:
            raise KeyError('There is no first_unit in data') from None


class LastUnit:
    """
    Last unit
    """

    def __init__(self, data: dict) -> None:
        """
        Args:
            data (dict): data dict
        """
        self.data = data
        self.last_unit = self._set_prop()

    def _set_prop(self) -> int:
        """
        Set last_unit

        Returns:
            last_unit (int): last unit

        Raises:
            KeyError ('There is no last_unit in data')
        """
        try:
            first_unit = self.data['last_unit']
            return first_unit
        except KeyError:
            raise KeyError('There is no last_unit in data') from None


class FrontsideLocation:
    """
    Frontsite location
    """

    def __init__(self, data: dict) -> None:
        """
        Args:
            data (dict): data dict
        """
        self.data = data
        self.frontside_location = self._set_prop()

    def _set_prop(self) -> bool:
        """
        Set frontside_location

        Returns:
            frontside_location (bool): frontside location

        Raises:
            KeyError ('There is no frontside_location in data')
        """
        try:
            first_unit = self.data['frontside_location']
            return first_unit
        except KeyError:
            raise KeyError('There is no frontside_location in data') from None


class RackAmount:
    """
    Rack amount
    """

    def __init__(self, pk: int) -> None:
        """
        Args:
            pk (int): rack id
        """
        self.pk = pk
        self.rack_amount = self._set_prop(RackRepository)

    def _set_prop(self, repository: Type[RackRepository]) -> int:
        """
        Set rack_amount

        Args:
            repository (RackRepositor): RackRepository class

        Returns:
            rack_amount (int): rack amount
        """
        return repository.get_rack_amount(self.pk)


class NewUnits:
    """
    New units
    """

    def __init__(self, first_unit: int, last_unit: int) -> None:
        """
        Args:
            first_unit (int): first unit
            last_unit (int): last unit
        """
        self.first_unit = first_unit
        self.last_unit = last_unit
        self.new_units = self._set_prop(DeviceCheckService, UnitsTuple)

    def _set_prop(self,
                  service: Type[DeviceCheckService],
                  units: Type[UnitsTuple]
                  ) -> UnitsTuple:
        """
        Set new_units

        Args:
            service (DeviceCheckService): DeviceCheckService class
            units (UnitsTuple): UnitsTuple class

        Returns:
            new_units (UnitsTuple): new units named tuple
        """
        return service.get_units(self.first_unit, self.last_unit, units)


class UnitsExist:
    """
    Units exist
    """

    def __init__(self, new_units: UnitsTuple, rack_amount: int) -> None:
        """
        Args:
            new_units (UnitsTuple): new units named tuple
            rack_amount (int): rack amount
        """
        self.new_units = new_units
        self.rack_amount = rack_amount
        self.units_exist = self._set_prop(DeviceCheckService)

    def _set_prop(self, service: Type[DeviceCheckService]) -> bool:
        """
        Set units_exist

        Args:
            service (DeviceCheckService): DeviceCheckService class

        Returns:
            units_exist (bool): True if exist, False in not
        """
        return service.check_unit_exist(self.new_units, self.rack_amount)


class DevicesForSide:
    """
    Devices for side
    """

    def __init__(self,
                 pk: int,
                 frontside_location: bool
                 ) -> None:
        """
        Args:
            pk (int): rack id
            frontside_location (bool): frontside location
        """
        self.pk = pk
        self.frontside_location = frontside_location
        self.devices_for_side = self._set_prop(DeviceRepository)

    def _set_prop(self, repository: Type[DeviceRepository]) -> QuerySet:
        """
        Set devices_for_side

        Args:
            repository (DeviceRepository): DeviceRepository class

        Returns:
            devices_for_side (QuerySet): QuerySet
                of devices for one side
        """
        return repository \
            .get_devices_for_side(self.pk, self.frontside_location)


class FilledList:
    """
    Filled list
    """

    def __init__(self, devices_for_side: QuerySet) -> None:
        """
        Args:
            devices_for_side (QuerySet): QuerySet
                of devices for one side
        """
        self.devices_for_side = devices_for_side
        self.filled_list = self._set_prop(DeviceCheckService)

    def _set_prop(self, service: Type[DeviceCheckService]) -> List[int]:
        """
        Set filled_list

        Args:
            service (DeviceCheckService): DeviceCheckService class

        Returns:
            filled_list (list): List of filled units
        """
        return service.get_filled_list(self.devices_for_side)


class UnitsBusyUpdate:
    """
    Units busy for update
    """

    def __init__(self,
                 filled_list: List[int],
                 new_units: UnitsTuple,
                 old_units: UnitsTuple
                 ) -> None:
        """
        Args:
            filled_list (list): list of units
            new_units (UnitsTuple): New units named tuple
            old_units (UnitsTuple): Old units named tuple
        """
        self.filled_list = filled_list
        self.new_units = new_units
        self.old_units = old_units
        self.unit_busy = self._set_prop(DeviceCheckService)

    def _set_prop(self, service: Type[DeviceCheckService]) -> bool:
        """
        Set unit_busy

        Args:
            service (DeviceCheckService): DeviceCheckService class

        Returns:
            unit_busy (bool): True if busy, False if not
        """
        return service \
            .check_unit_busy_for_update(self.filled_list,
                                        self.new_units,
                                        self.old_units)


class UnitsBusyAdd:
    """
    Units busy for add
    """

    def __init__(self,
                 filled_list: List[int],
                 new_units: UnitsTuple,
                 ) -> None:
        """
        Args:
            filled_list (list): list of units
            new_units (UnitsTuple): New units named tuple
        """
        self.filled_list = filled_list
        self.new_units = new_units
        self.unit_busy = self._set_prop(DeviceCheckService)

    def _set_prop(self, service: Type[DeviceCheckService]) -> bool:
        """
        Set unit_busy

        Args:
            service (DeviceCheckService): DeviceCheckService class

        Returns:
            unit_busy (bool): True if busy, False if not
        """
        return service \
            .check_unit_busy_for_add(self.filled_list,
                                     self.new_units)


class RackId:
    """
    Rack id
    """

    def __init__(self, pk: int) -> None:
        """
        Args:
            pk (int): Device id
        """
        self.pk = pk
        self.rack_id = self._set_prop(DeviceRepository)

    def _set_prop(self, repository: Type[DeviceRepository]) -> int:
        """
        Set rack_id

        Args:
            repository (DeviceRepository): DeviceRepository class

        Returns:
            rack_id (int): Rack id
        """
        return repository.get_device_rack_id(self.pk)


class SameName:
    """
    Names comparsion
    """

    def __init__(self, instance_name: str, key_name: str) -> None:
        """
        Args:
            instance_name (str): Instance name
            key_name (str): Key name
        """
        self.instance_name = instance_name
        self.key_name = key_name
        self.same_name = self._set_prop()

    def _set_prop(self) -> bool:
        """
        Set same_name

        Returns:
            same_name (bool): True if instance_name and key_name are the same
        """
        if self.instance_name == self.key_name:
            return True
        return False


class NameInNamesList:
    """
    Name in names list
    """

    def __init__(self,
                 key_name: str,
                 names_list: List[str]
                 ) -> None:
        """
        Args:
            key_name (str): Key name
            names_list (list): List of object names
        """
        self.key_name = key_name
        self.names_list = names_list
        self.name_in_names_list = self._set_prop()

    def _set_prop(self) -> bool:
        """
        Set name_in_names_list

        Returns:
            name_in_names_list (bool): True if key_name in names_list
        """
        if self.key_name in self.names_list:
            return True
        return False


class CheckUser(BaseCheck):
    """
    Check permissions
    """

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
        """
        Set all props for permission check

        Args:
            department_name_prop (DepartmentName): DepartmentName class
            add_check_props_dc (AddCheckProps): AddCheckProps class
            update_check_props_dc (UpdateCheckProps): UpdateCheckProps class
            delete_check_props_dc (DeleteCheckProps): DeleteCheckProps class

        Returns:
            name_in_names_list (bool): True if key_name in names_list
        """
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
        """
        Set all props permission check

        Args:
            result (Result): Result class

        Returns:
            result (Result): Result(succsess=False,
                                    message='Permission alert,'
                                    ' changes are prohibited') if fails
                             Result(succsess=True, message='Success') if pass
        """
        if self.department_name not in self.props.user_groups:
            return result(False, 'Permission alert, changes are prohibited')
        return result(True, 'Success')


class CheckUnique(BaseCheck):
    """
    Check for unique name (for buildings, rooms and racks)
    """

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
        """
        Set all props for unique check

        Args:
            names_list_prop (NamesList): NamesList class
            name_in_names_prop (NameInNamesList): NameInNamesList class
            same_name_prop (SameName): SameName class
            add_check_props_dc (AddCheckProps): AddCheckProps class
            update_check_props_dc (UpdateCheckProps): UpdateCheckProps class
            delete_check_props_dc (DeleteCheckProps): DeleteCheckProps class

        Raises:
            ValueError ('DeleteCheckProps cannot be used with CheckUnique')
        """
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
            raise ValueError('DeleteCheckProps cannot be used '
                             'with CheckUnique')

    def _set_result(self, result: Type[Result]) -> Result:
        """
        Set result

        Args:
            result (Result): Result class

        Returns:
            result (Result): Result(succsess=False,
                                    message='A model_name with the same '
                                    'name already exists') if fails
                             Result(succsess=True, message='Success') if pass
        """
        # For rack properties changes (name staing the same)
        if self.same_name:
            return result(True, 'Success')
        if self.name_in_names_list:
            return result(False,
                          f"A {self.props.model._meta.db_table} "
                          f"with the same name already exists")
        return result(True, 'Success')


class CheckDeviceForAddOrUpdate(BaseCheck):
    """
    Check device for add or update
    """

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
        """
        Set all props for device add or update check

        Args:
            first_unit_prop (FirstUnit): FirstUnit class
            Last_unit_prop (LastUnit): LastUnit class
            frontside_location_prop (FrontsideLocation):
                FrontsideLocation class
            rack_amount_prop (RackAmount): RackAmount class
            new_units_prop (NewUnits): NewUnits class
            units_exist_prop (UnitsExist): UnitsExist class
            device_for_side_prop (DevicesForSide): DevicesForSide class
            filled_list_prop (FilledList): FilledList class
            rack_id_prop (RackId): RackId class
            old_units_prop (OldUnits): OldUnits class
            units_busy_update_prop (UnitsBusyUpdate): UnitsBusyUpdate class
            units_busy_add_prop (UnitsBusyAdd): UnitsBusyAdd class
            add_check_props_dc (AddCheckProps): AddCheckProps class
            update_check_props_dc (UpdateCheckProps): UpdateCheckProps class
            delete_check_props_dc (DeleteCheckProps): DeleteCheckProps class

        Raises:
            ValueError ('DeleteCheckProps cannot be used '
                        'with CheckDeviceForAddOrUpdate')
        """
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
            raise ValueError('DeleteCheckProps cannot be used '
                             'with CheckDeviceForAddOrUpdate')

    def _set_result(self, result: Type[Result]) -> Result:
        """
        Set result

        Args:
            result (Result): Result class

        Returns:
            result (Result): Result(succsess=False,
                                    message='There are no such '
                                    'units in this rack') if no such units
                             Result(succsess=False,
                                    message='These units '
                                    'are busy') if units busy
                             Result(succsess=True, message='Success') if pass
        """
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
    """
    Checker
    """

    def __init__(self,
                 checks_list: Checks_List_Type,
                 props: Union[AddCheckProps,
                              UpdateCheckProps,
                              DeleteCheckProps]
                 ) -> None:
        """
        Set all props for device add or update check

        Args:
            checks_list (list): list of checks classes
            props (Union[AddCheckProps,
                         UpdateCheckProps,
                         DeleteCheckProps]): Props for check
        """
        self.checks_list = checks_list
        self.props = props
        self.result = self._set_result(Result)

    def _set_result(self, result: Type[Result]) -> Result:
        """
        Set result

        Args:
            result (Result): Result class

        Returns:
            result (Result): Result(succsess=False, message='some message')
                                if single check fails
                             Result(succsess=True, message='Success') if pass
        """
        check_results_list: list[Result] = []
        for check in self.checks_list:
            check_results_list.append(check(self.props).result)
        for single_result in check_results_list:
            if not single_result.success:
                return single_result
        total_result = result(True, 'Success')
        return total_result
