"""
Some utils
"""
from dataclasses import dataclass
from mainapp.repository import (RepositoryHelper,
                                DeviceRepository,
                                RackRepository)
from mainapp.services import DeviceCheckService


@dataclass
class Result:
    """
    Class for check result objects
    """
    success: bool
    message: str


class Check:

    def __init__(self,
                 request,
                 pk,
                 data,
                 update,
                 fk,
                 model,
                 fk_model,
                 key_name,
                 instance_name):
        self.request = request
        self.pk = pk
        self.data = data
        self.update = update
        self.fk = fk
        self.model = model
        self.fk_model = fk_model
        self.instance_name = instance_name
        self.key_name = key_name


class NamesListProp:

    def __init__(self, pk, model, update):
        self.pk = pk
        self.model = model
        self.update = update
        self.names_list = self._set_prop()

    def _set_prop(self):
        if not self.update:
            repository = RepositoryHelper \
                .get_model_repository(self.model)
            return repository.get_unique_object_names_list(self.pk)
        repository = RepositoryHelper \
            .get_child_model_repository(self.fk_model)
        return repository.get_unique_object_names_list(self.fk)


class DepartmentNameProp:

    def __init__(self, pk, model, fk, fk_model, update):
        self.pk = pk
        self.model = model
        self.fk = fk
        self.fk_model = fk_model
        self.update = update
        self.department_name = self._set_prop()

    def _set_prop(self) -> str:
        if not self.update:
            self.model = self.fk_model
        repository = RepositoryHelper.get_model_repository(self.model)
        return repository.get_department_name(self.pk)


class UserGroupsProp:

    def __init__(self, request):
        self.request = request
        self.user_groups = self._set_prop()

    def _set_prop(self):
        return list(self.request.user.groups.values_list('name', flat=True))


class OldUnitsProp:

    def __init__(self, pk, update):
        self.pk = pk
        self.update = update
        self.old_units = None
        self._set_prop()

    def _set_prop(self):
        if self.update:
            old_first_unit = DeviceRepository.get_first_unit(self.pk)
            old_last_unit = DeviceRepository.get_last_unit(self.pk)
            self.old_units = DeviceCheckService \
                .get_old_units(old_first_unit, old_last_unit)


class FirstUnitProp:

    def __init__(self, data):
        self.data = data
        self.first_unit = self._set_prop()

    def _set_prop(self):
        return self.data.get('first_unit')


class LastUnitProp:

    def __init__(self, data):
        self.data = data
        self.last_unit = self._set_prop()

    def _set_prop(self):
        return self.data.get('last_unit')


class FrontsideLocationProp:

    def __init__(self, data):
        self.data = data
        self.frontside_location = self._set_prop()

    def _set_prop(self):
        return self.data.get('frontside_location')


class RackAmountProp:

    def __init__(self, pk):
        self.pk = pk
        self.rack_amount = self._set_prop()

    def _set_prop(self):
        return RackRepository.get_rack_amount(self.pk)


class NewUnitsProp:

    def __init__(self, first_unit, last_unit):
        self.first_unit = first_unit
        self.last_unit = last_unit
        self.new_units = self._set_prop()

    def _set_prop(self):
        return DeviceCheckService \
            .get_new_units(self.first_unit, self.last_unit)


class UnitsExistProp:

    def __init__(self, new_units, rack_amount):
        self.new_units = new_units
        self.rack_amount = rack_amount
        self.units_exist = self._set_prop()

    def _set_prop(self):
        return DeviceCheckService \
            .check_unit_exist(self.new_units, self.rack_amount)


class DevicesForSideProp:

    def __init__(self, pk, rack_id, update, frontside_location):
        self.pk = pk
        self.rack_id = rack_id
        self.update = update
        self.frontside_location = frontside_location
        self.devices_for_side = self._set_prop()

    def _set_prop(self):
        if self.update:
            self.pk = self.rack_id
        return DeviceRepository \
            .get_devices_for_side(self.pk, self.frontside_location)


class UnitsBusyProp:

    def __init__(self, devices_for_side, new_units, old_units):
        self.devices_for_side = devices_for_side
        self.new_units = new_units
        self.old_units = old_units
        self.unit_busy = self._set_prop()

    def _set_prop(self):
        return DeviceCheckService \
            .check_unit_busy(self.devices_for_side,
                             self.new_units,
                             self.old_units)


class RackIdProp:

    def __init__(self, pk, update):
        self.pk = pk
        self.update = update
        self.rack_id = self._set_prop()

    def _set_prop(self):
        if self.update:
            return DeviceRepository.get_device_rack_id(self.pk)
        return self.pk


class CheckUser(Check):

    def __init__(self, *args, **kwargs):
        super().__init__(*args, **kwargs)
        self.user_groups = UserGroupsProp(self.request).user_groups
        self.department_name = DepartmentNameProp(self.pk,
                                                  self.model,
                                                  self.fk,
                                                  self.fk_model,
                                                  self.update) \
            .department_name
        self.result = self._set_result()

    def _set_result(self) -> Result:
        if self.department_name not in self.user_groups:
            return Result(False, 'Permission alert, changes are prohibited')
        return Result(True, 'Success')


class CheckUnique(Check):

    def __init__(self, *args, **kwargs):
        super().__init__(*args, **kwargs)
        self.names_list = NamesListProp(self.pk,
                                        self.model,
                                        self.update).names_list
        self.result = self._set_result()

    def _set_result(self) -> Result:
        # For rack properties changes (name staing the same)
        if self.instance_name == self.key_name:
            return Result(True, 'Success')
        if self.key_name in self.names_list:
            return Result(False,
                          f"A {self.model._meta.db_table} "
                          f"with the same name already exists")
        return Result(True, 'Success')


class CheckDeviceForAddOrUpdate(Check):

    def __init__(self, *args, **kwargs):
        super().__init__(*args, **kwargs)
        self.old_units = OldUnitsProp(self.pk, self.update).old_units
        self.first_unit = FirstUnitProp(self.data).first_unit
        self.last_unit = LastUnitProp(self.data).last_unit
        self.frontside_location = FrontsideLocationProp(self.data) \
            .frontside_location
        self.rack_id = RackIdProp(self.pk, self.update).rack_id
        self.rack_amount = RackAmountProp(self.rack_id).rack_amount
        self.new_units = NewUnitsProp(self.first_unit, self.last_unit) \
            .new_units
        self.units_exist = UnitsExistProp(self.new_units, self.rack_amount) \
            .units_exist
        self.devices_for_side = DevicesForSideProp(self.pk,
                                                   self.rack_id,
                                                   self.update,
                                                   self.frontside_location) \
            .devices_for_side
        self.units_busy = UnitsBusyProp(self.devices_for_side,
                                        self.new_units,
                                        self.old_units).unit_busy
        self.result = self._set_result()

    def _set_result(self) -> Result:
        if None in [
            self.first_unit,
            self.last_unit,
            self.frontside_location,
        ]:
            return Result(False, "Missing required data")
        # Check units exists
        if not self.units_exist:
            return Result(False, 'There are no such units in this rack')
        # Check units busy
        if self.units_busy:
            return Result(False, 'These units are busy')
        return Result(True, 'Success')
