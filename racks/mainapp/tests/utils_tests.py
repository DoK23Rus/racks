"""
Tests for utils
"""
from django.test import TestCase
from mainapp.models import (Region,
                            Department,
                            Site,
                            Building,
                            Room,
                            Rack,
                            Device)
from mainapp.services import UnitsTuple
from mainapp.tests.setup import Setup
from mainapp.utils import (Result,
                           AddCheckProps,
                           UpdateCheckProps,
                           DeleteCheckProps,
                           NamesList,
                           DepartmentName,
                           OldUnits,
                           FirstUnit,
                           LastUnit,
                           FrontsideLocation,
                           RackAmount,
                           NewUnits,
                           UnitsExist,
                           DevicesForSide,
                           FilledList,
                           UnitsBusyUpdate,
                           UnitsBusyAdd,
                           RackId,
                           SameName,
                           NameInNamesList,
                           CheckUser,
                           CheckUnique,
                           CheckDeviceForAddOrUpdate,
                           Checker)


class TestCheckProps(TestCase):
    """
    Test CheckProps
    """

    @classmethod
    def setUpClass(cls):
        Setup.base_setup()

    def test_NamesList(self):
        # Names list for racks
        pk = Room.objects.get(name='Test_room1').id
        result = NamesList(pk, Rack).names_list
        self.assertEqual(result, {'Test_rack1', 'Test_rack3'})

        # Names list for rooms
        pk = Building.objects.get(name='Test_building1').id
        result = NamesList(pk, Room).names_list
        self.assertEqual(result, {'Test_room1'})

        # Names list for buildings
        pk = Site.objects.get(name='Test_site1').id
        result = NamesList(pk, Building).names_list
        self.assertEqual(result, {'Test_building1'})

    def test_DepartmentName(self):
        # Department name for department
        pk = Region.objects.get(name='Test_region1').id
        result = DepartmentName(pk, Department).department_name
        self.assertEqual(result, 'Test_department1')

        # Department name for site
        pk = Department.objects.get(name='Test_department1').id
        result = DepartmentName(pk, Site).department_name
        self.assertEqual(result, 'Test_department1')

        # Department name for building
        pk = Site.objects.get(name='Test_site1').id
        result = DepartmentName(pk, Building).department_name
        self.assertEqual(result, 'Test_department1')

        # Department name for room
        pk = Building.objects.get(name='Test_building1').id
        result = DepartmentName(pk, Room).department_name
        self.assertEqual(result, 'Test_department1')

        # Department name for rack
        pk = Room.objects.get(name='Test_room1').id
        result = DepartmentName(pk, Rack).department_name
        self.assertEqual(result, 'Test_department1')

        # Department name for device
        pk = Rack.objects.get(name='Test_rack1').id
        result = DepartmentName(pk, Device).department_name
        self.assertEqual(result, 'Test_department1')

    def test_OldUnits(self):
        pk = Device.objects.get(vendor='Test_vendor1').id
        result = OldUnits(pk).old_units
        self.assertEqual(result, UnitsTuple(1, 2))

    def test_FirstUnit(self):
        data = {'first_unit': 1}
        result = FirstUnit(data).first_unit
        self.assertEqual(result, 1)

        # No first_unit in data
        data = {}
        with self.assertRaises(KeyError):
            FirstUnit(data).first_unit

    def test_LastUnit(self):
        data = {'last_unit': 2}
        result = LastUnit(data).last_unit
        self.assertEqual(result, 2)

        # No last unit in data
        data = {}
        with self.assertRaises(KeyError):
            LastUnit(data).last_unit

    def test_FrontsideLocation(self):
        data = {'frontside_location': True}
        result = FrontsideLocation(data).frontside_location
        self.assertTrue(result)

        data = {'frontside_location': False}
        result = FrontsideLocation(data).frontside_location
        self.assertFalse(result)

        # No frontside_location in data
        data = {}
        with self.assertRaises(KeyError):
            FrontsideLocation(data).frontside_location

    def test_RackAmount(self):
        pk = Rack.objects.get(name='Test_rack1').id
        result = RackAmount(pk).rack_amount
        self.assertEqual(result, 40)

    def test_NewUnits(self):
        result = NewUnits(1, 2).new_units
        self.assertEqual(result, UnitsTuple(1, 2))

        result = NewUnits(2, 1).new_units
        self.assertEqual(result, UnitsTuple(1, 2))

    def test_UnitsExist(self):
        # Inside
        result = UnitsExist(UnitsTuple(4, 5), 40).units_exist
        self.assertTrue(result)

        # Partial
        result = UnitsExist(UnitsTuple(39, 45), 40).units_exist
        self.assertFalse(result)

        # Outside
        result = UnitsExist(UnitsTuple(44, 45), 40).units_exist
        self.assertFalse(result)

    def test_DevicesForSide(self):
        # Frontside
        pk = Rack.objects.get(name='Test_rack1').id
        result = DevicesForSide(pk, True).devices_for_side
        self.assertQuerysetEqual(result,
                                 Device.objects.filter(rack_id_id=pk)
                                 .filter(frontside_location=True),
                                 ordered=False)

        # Back
        result = DevicesForSide(pk, False).devices_for_side
        self.assertQuerysetEqual(result,
                                 Device.objects.filter(rack_id_id=pk)
                                 .filter(frontside_location=False),
                                 ordered=False)

    def test_FilledList(self):
        pk = Rack.objects.get(name='Test_rack1').id
        devices_for_side = Device.objects.filter(rack_id_id=pk) \
            .filter(frontside_location=True)
        result = FilledList(devices_for_side).filled_list
        self.assertEqual(result, [1, 2, 5])

    def test_UnitsBusyUpdate(self):
        # Partial move
        result = UnitsBusyUpdate([1, 2, 4, 5],
                                 UnitsTuple(2, 3),
                                 UnitsTuple(1, 2)).unit_busy
        self.assertFalse(result)

        # Free
        result = UnitsBusyUpdate([1, 2, 4, 5],
                                 UnitsTuple(3, 3),
                                 UnitsTuple(1, 2)).unit_busy
        self.assertFalse(result)

        # Busy
        result = UnitsBusyUpdate([1, 2, 4, 5],
                                 UnitsTuple(4, 4),
                                 UnitsTuple(1, 2)).unit_busy
        self.assertTrue(result)

    def test_UnitsBusyAdd(self):
        # Free
        result = UnitsBusyAdd([1, 2, 4, 5],
                              UnitsTuple(6, 7)).unit_busy
        self.assertFalse(result)

        # Busy
        result = UnitsBusyAdd([1, 2, 4, 5],
                              UnitsTuple(2, 3)).unit_busy
        self.assertTrue(result)

    def test_RackId(self):
        pk = Device.objects.get(vendor='Test_vendor1').id
        rack_id = Rack.objects.get(name='Test_rack1').id
        result = RackId(pk).rack_id
        self.assertEqual(result, rack_id)

    def test_SameName(self):
        result = SameName('instance_name', 'key_name').same_name
        self.assertFalse(result)

        result = SameName('same_name', 'same_name').same_name
        self.assertTrue(result)

    def test_NameInNamesList(self):
        result = NameInNamesList('key_name', [
            'some_name',
            'some_other_name',
        ]).name_in_names_list
        self.assertFalse(result)

        result = NameInNamesList('key_name', [
            'some_name',
            'key_name',
        ]).name_in_names_list
        self.assertTrue(result)

    @classmethod
    def tearDownClass(cls):
        pass


class TestChecks(TestCase):
    """
    Test Checks
    """

    @classmethod
    def setUpClass(cls):
        Setup.base_setup()

    def test_CheckUser_add(self):
        # device
        user_groups = ['some_group', 'Test_department1']
        pk = Device.objects.get(vendor='Test_vendor1').id
        data = {
            'first_unit': 29,
            'last_unit': 30,
            'frontside_location': True,
        }
        model = Device
        fk_model = Rack
        key_name = 'device some_vendor, some_model'
        result = CheckUser(AddCheckProps(user_groups,
                                         pk,
                                         data,
                                         model,
                                         fk_model,
                                         key_name)).result
        self.assertEqual(result, Result(True, 'Success'))

        user_groups = ['some_group', 'some_other_group']
        result = CheckUser(AddCheckProps(user_groups,
                                         pk,
                                         data,
                                         model,
                                         fk_model,
                                         key_name)).result
        self.assertEqual(result,
                         Result(False,
                                'Permission alert, changes are prohibited'))

        # rack
        user_groups = ['some_group', 'Test_department1']
        pk = Rack.objects.get(name='Test_rack1').id
        data = {
            'amount': 40,
        }
        model = Rack
        fk_model = Room
        key_name = 'some_rack'
        result = CheckUser(AddCheckProps(user_groups,
                                         pk,
                                         data,
                                         model,
                                         fk_model,
                                         key_name)).result
        self.assertEqual(result, Result(True, 'Success'))

        user_groups = ['some_group', 'some_other_group']
        result = CheckUser(AddCheckProps(user_groups,
                                         pk,
                                         data,
                                         model,
                                         fk_model,
                                         key_name)).result
        self.assertEqual(result,
                         Result(False,
                                'Permission alert, changes are prohibited'))

        # room
        user_groups = ['some_group', 'Test_department1']
        pk = Room.objects.get(name='Test_room1').id
        data = {}
        model = Room
        fk_model = Building
        key_name = 'some_room'
        result = CheckUser(AddCheckProps(user_groups,
                                         pk,
                                         data,
                                         model,
                                         fk_model,
                                         key_name)).result
        self.assertEqual(result, Result(True, 'Success'))

        user_groups = ['some_group', 'some_other_group']
        result = CheckUser(AddCheckProps(user_groups,
                                         pk,
                                         data,
                                         model,
                                         fk_model,
                                         key_name)).result
        self.assertEqual(result,
                         Result(False,
                                'Permission alert, changes are prohibited'))

        # building
        user_groups = ['some_group', 'Test_department1']
        pk = Building.objects.get(name='Test_building1').id
        data = {}
        model = Building
        fk_model = Site
        key_name = 'some_building'
        result = CheckUser(AddCheckProps(user_groups,
                                         pk,
                                         data,
                                         model,
                                         fk_model,
                                         key_name)).result
        self.assertEqual(result, Result(True, 'Success'))

        user_groups = ['some_group', 'some_other_group']
        result = CheckUser(AddCheckProps(user_groups,
                                         pk,
                                         data,
                                         model,
                                         fk_model,
                                         key_name)).result
        self.assertEqual(result,
                         Result(False,
                                'Permission alert, changes are prohibited'))

        # site
        user_groups = ['some_group', 'Test_department1']
        pk = Site.objects.get(name='Test_site1').id
        data = {}
        model = Site
        fk_model = Department
        key_name = 'some_site'
        result = CheckUser(AddCheckProps(user_groups,
                                         pk,
                                         data,
                                         model,
                                         fk_model,
                                         key_name)).result
        self.assertEqual(result, Result(True, 'Success'))

        user_groups = ['some_group', 'some_other_group']
        result = CheckUser(AddCheckProps(user_groups,
                                         pk,
                                         data,
                                         model,
                                         fk_model,
                                         key_name)).result
        self.assertEqual(result,
                         Result(False,
                                'Permission alert, changes are prohibited'))

    def test_CheckUser_update(self):
        # device
        user_groups = ['Test_department1']
        pk = Device.objects.get(vendor='Test_vendor1').id
        data = {
            'first_unit': 1,
            'last_unit': 2,
            'frontside_location': True,
        }
        fk = Rack.objects.get(name='Test_rack1').id
        model = Device
        fk_model = Rack
        key_name = 'device some_vendor, some_model'
        instance_name = 'device some_vendor, some_model'
        result = CheckUser(UpdateCheckProps(user_groups,
                                            pk,
                                            data,
                                            model,
                                            fk,
                                            fk_model,
                                            key_name,
                                            instance_name)).result
        self.assertEqual(result, Result(True, 'Success'))

        user_groups = ['some_group', 'some_other_group']
        result = CheckUser(UpdateCheckProps(user_groups,
                                            pk,
                                            data,
                                            model,
                                            fk,
                                            fk_model,
                                            key_name,
                                            instance_name)).result
        self.assertEqual(result,
                         Result(False,
                                'Permission alert, changes are prohibited'))

        # rack
        user_groups = ['some_group', 'Test_department1']
        pk = Rack.objects.get(name='Test_rack1').id
        data = {
            'amount': 40,
        }
        fk = Room.objects.get(name='Test_room1').id
        model = Rack
        fk_model = Room
        key_name = 'some_rack'
        instance_name = 'some_rack'
        result = CheckUser(UpdateCheckProps(user_groups,
                                            pk,
                                            data,
                                            model,
                                            fk,
                                            fk_model,
                                            key_name,
                                            instance_name)).result
        self.assertEqual(result, Result(True, 'Success'))

        user_groups = ['some_group', 'some_other_group']
        result = CheckUser(UpdateCheckProps(user_groups,
                                            pk,
                                            data,
                                            model,
                                            fk,
                                            fk_model,
                                            key_name,
                                            instance_name)).result
        self.assertEqual(result,
                         Result(False,
                                'Permission alert, changes are prohibited'))

        # room
        user_groups = ['some_group', 'Test_department1']
        pk = Room.objects.get(name='Test_room1').id
        data = {}
        fk = Building.objects.get(name='Test_building1').id
        model = Room
        fk_model = Building
        key_name = 'some_room'
        instance_name = 'some_room'
        result = CheckUser(UpdateCheckProps(user_groups,
                                            pk,
                                            data,
                                            model,
                                            fk,
                                            fk_model,
                                            key_name,
                                            instance_name)).result
        self.assertEqual(result, Result(True, 'Success'))

        user_groups = ['some_group', 'some_other_group']
        result = CheckUser(UpdateCheckProps(user_groups,
                                            pk,
                                            data,
                                            model,
                                            fk,
                                            fk_model,
                                            key_name,
                                            instance_name)).result
        self.assertEqual(result,
                         Result(False,
                                'Permission alert, changes are prohibited'))

        # building
        user_groups = ['some_group', 'Test_department1']
        pk = Building.objects.get(name='Test_building1').id
        data = {}
        fk = Site.objects.get(name='Test_site1').id
        model = Building
        fk_model = Site
        key_name = 'some_building'
        instance_name = 'some_building'
        result = CheckUser(UpdateCheckProps(user_groups,
                                            pk,
                                            data,
                                            model,
                                            fk,
                                            fk_model,
                                            key_name,
                                            instance_name)).result
        self.assertEqual(result, Result(True, 'Success'))

        user_groups = ['some_group', 'some_other_group']
        result = CheckUser(UpdateCheckProps(user_groups,
                                            pk,
                                            data,
                                            model,
                                            fk,
                                            fk_model,
                                            key_name,
                                            instance_name)).result
        self.assertEqual(result,
                         Result(False,
                                'Permission alert, changes are prohibited'))

        # site
        user_groups = ['some_group', 'Test_department1']
        pk = Site.objects.get(name='Test_site1').id
        data = {}
        fk = Department.objects.get(name='Test_department1').id
        model = Site
        fk_model = Department
        key_name = 'some_site'
        instance_name = 'some_site'
        result = CheckUser(UpdateCheckProps(user_groups,
                                            pk,
                                            data,
                                            model,
                                            fk,
                                            fk_model,
                                            key_name,
                                            instance_name)).result
        self.assertEqual(result, Result(True, 'Success'))

        user_groups = ['some_group', 'some_other_group']
        result = CheckUser(UpdateCheckProps(user_groups,
                                            pk,
                                            data,
                                            model,
                                            fk,
                                            fk_model,
                                            key_name,
                                            instance_name)).result
        self.assertEqual(result,
                         Result(False,
                                'Permission alert, changes are prohibited'))

    def test_CheckUser_delete(self):
        # device
        user_groups = ['Test_department1']
        pk = Device.objects.get(vendor='Test_vendor1').id
        data = {
            'first_unit': 1,
            'last_unit': 2,
            'frontside_location': True,
        }
        model = Device
        result = CheckUser(DeleteCheckProps(user_groups,
                                            pk,
                                            data,
                                            model)).result
        self.assertEqual(result, Result(True, 'Success'))

        user_groups = ['some_group', 'some_other_group']
        result = CheckUser(DeleteCheckProps(user_groups,
                                            pk,
                                            data,
                                            model)).result
        self.assertEqual(result,
                         Result(False,
                                'Permission alert, changes are prohibited'))

        # rack
        user_groups = ['some_group', 'Test_department1']
        pk = Rack.objects.get(name='Test_rack1').id
        data = {
            'rack_amount': 40,
        }
        model = Rack
        result = CheckUser(DeleteCheckProps(user_groups,
                                            pk,
                                            data,
                                            model)).result
        self.assertEqual(result, Result(True, 'Success'))

        user_groups = ['some_group', 'some_other_group']
        result = CheckUser(DeleteCheckProps(user_groups,
                                            pk,
                                            data,
                                            model)).result
        self.assertEqual(result,
                         Result(False,
                                'Permission alert, changes are prohibited'))

        # room
        user_groups = ['some_group', 'Test_department1']
        pk = Room.objects.get(name='Test_room1').id
        data = {}
        model = Room
        result = CheckUser(DeleteCheckProps(user_groups,
                                            pk,
                                            data,
                                            model)).result
        self.assertEqual(result, Result(True, 'Success'))

        user_groups = ['some_group', 'some_other_group']
        result = CheckUser(DeleteCheckProps(user_groups,
                                            pk,
                                            data,
                                            model)).result
        self.assertEqual(result,
                         Result(False,
                                'Permission alert, changes are prohibited'))

        # building
        user_groups = ['some_group', 'Test_department1']
        pk = Building.objects.get(name='Test_building1').id
        data = {}
        model = Building
        result = CheckUser(DeleteCheckProps(user_groups,
                                            pk,
                                            data,
                                            model)).result
        self.assertEqual(result, Result(True, 'Success'))

        user_groups = ['some_group', 'some_other_group']
        result = CheckUser(DeleteCheckProps(user_groups,
                                            pk,
                                            data,
                                            model)).result
        self.assertEqual(result,
                         Result(False,
                                'Permission alert, changes are prohibited'))

        # site
        user_groups = ['some_group', 'Test_department1']
        pk = Site.objects.get(name='Test_site1').id
        data = {}
        model = Site
        result = CheckUser(DeleteCheckProps(user_groups,
                                            pk,
                                            data,
                                            model)).result
        self.assertEqual(result, Result(True, 'Success'))

        user_groups = ['some_group', 'some_other_group']
        result = CheckUser(DeleteCheckProps(user_groups,
                                            pk,
                                            data,
                                            model)).result
        self.assertEqual(result,
                         Result(False,
                                'Permission alert, changes are prohibited'))

    def test_CheckUnique_add(self):
        # rack
        user_groups = ['Test_department1']
        pk = Rack.objects.get(name='Test_rack1').id
        data = {
            'rack_amount': 40,
        }
        model = Rack
        fk_model = Room
        key_name = 'some_rack'
        result = CheckUnique(AddCheckProps(user_groups,
                                           pk,
                                           data,
                                           model,
                                           fk_model,
                                           key_name)).result
        self.assertEqual(result, Result(True, 'Success'))

        key_name = 'Test_rack1'
        result = CheckUnique(AddCheckProps(user_groups,
                                           pk,
                                           data,
                                           model,
                                           fk_model,
                                           key_name)).result
        self.assertEqual(result,
                         Result(False,
                                'A rack with the same name already exists'))

        # room
        user_groups = ['Test_department1']
        pk = Room.objects.get(name='Test_room1').id
        data = {}
        model = Room
        fk_model = Building
        key_name = 'some_room'
        result = CheckUnique(AddCheckProps(user_groups,
                                           pk,
                                           data,
                                           model,
                                           fk_model,
                                           key_name)).result
        self.assertEqual(result, Result(True, 'Success'))

        key_name = 'Test_room1'
        result = CheckUnique(AddCheckProps(user_groups,
                                           pk,
                                           data,
                                           model,
                                           fk_model,
                                           key_name)).result
        self.assertEqual(result,
                         Result(False,
                                'A room with the same name already exists'))

        # building
        user_groups = ['Test_department1']
        pk = Building.objects.get(name='Test_building1').id
        data = {}
        model = Building
        fk_model = Site
        key_name = 'some_building'
        result = CheckUnique(AddCheckProps(user_groups,
                                           pk,
                                           data,
                                           model,
                                           fk_model,
                                           key_name)).result
        self.assertEqual(result, Result(True, 'Success'))

        key_name = 'Test_building1'
        result = CheckUnique(AddCheckProps(user_groups,
                                           pk,
                                           data,
                                           model,
                                           fk_model,
                                           key_name)).result
        self.assertEqual(result,
                         Result(False,
                                'A building '
                                'with the same name already exists'))

    def test_CheckUnique_update(self):
        # rack
        user_groups = ['Test_department1']
        pk = Rack.objects.get(name='Test_rack1').id
        data = {
            'amount': 40,
        }
        fk = Room.objects.get(name='Test_room1').id
        model = Rack
        fk_model = Room
        key_name = 'some_rack'
        instance_name = 'some_rack'
        result = CheckUnique(UpdateCheckProps(user_groups,
                                              pk,
                                              data,
                                              model,
                                              fk,
                                              fk_model,
                                              key_name,
                                              instance_name)).result
        self.assertEqual(result, Result(True, 'Success'))

        key_name = 'Test_rack1'
        instance_name = 'Test_rack1'
        result = CheckUnique(UpdateCheckProps(user_groups,
                                              pk,
                                              data,
                                              model,
                                              fk,
                                              fk_model,
                                              key_name,
                                              instance_name)).result
        self.assertEqual(result, Result(True, 'Success'))

        key_name = 'Test_rack1'
        instance_name = 'some_rack'
        result = CheckUnique(UpdateCheckProps(user_groups,
                                              pk,
                                              data,
                                              model,
                                              fk,
                                              fk_model,
                                              key_name,
                                              instance_name)).result
        self.assertEqual(result,
                         Result(False,
                                'A rack with the same name already exists'))

        # room
        user_groups = ['Test_department1']
        pk = Room.objects.get(name='Test_room1').id
        data = {}
        model = Room
        fk = Building.objects.get(name='Test_building1').id
        model = Room
        fk_model = Building
        key_name = 'some_room'
        instance_name = 'some_room'
        result = CheckUnique(UpdateCheckProps(user_groups,
                                              pk,
                                              data,
                                              model,
                                              fk,
                                              fk_model,
                                              key_name,
                                              instance_name)).result
        self.assertEqual(result, Result(True, 'Success'))

        key_name = 'Test_room1'
        instance_name = 'Test_room1'
        result = CheckUnique(UpdateCheckProps(user_groups,
                                              pk,
                                              data,
                                              model,
                                              fk,
                                              fk_model,
                                              key_name,
                                              instance_name)).result
        self.assertEqual(result, Result(True, 'Success'))

        key_name = 'Test_room1'
        instance_name = 'some_room'
        result = CheckUnique(UpdateCheckProps(user_groups,
                                              pk,
                                              data,
                                              model,
                                              fk,
                                              fk_model,
                                              key_name,
                                              instance_name)).result
        self.assertEqual(result,
                         Result(False,
                                'A room with the same name already exists'))

        # building
        user_groups = ['Test_department1']
        pk = Building.objects.get(name='Test_building1').id
        data = {}
        model = Building
        fk = Site.objects.get(name='Test_site1').id
        model = Building
        fk_model = Site
        key_name = 'some_building'
        instance_name = 'some_building'
        result = CheckUnique(UpdateCheckProps(user_groups,
                                              pk,
                                              data,
                                              model,
                                              fk,
                                              fk_model,
                                              key_name,
                                              instance_name)).result
        self.assertEqual(result, Result(True, 'Success'))

        key_name = 'Test_building1'
        instance_name = 'Test_building1'
        result = CheckUnique(UpdateCheckProps(user_groups,
                                              pk,
                                              data,
                                              model,
                                              fk,
                                              fk_model,
                                              key_name,
                                              instance_name)).result
        self.assertEqual(result, Result(True, 'Success'))

        key_name = 'Test_building1'
        instance_name = 'some_building'
        result = CheckUnique(UpdateCheckProps(user_groups,
                                              pk,
                                              data,
                                              model,
                                              fk,
                                              fk_model,
                                              key_name,
                                              instance_name)).result
        self.assertEqual(result,
                         Result(False,
                                'A building '
                                'with the same name already exists'))

    def test_CheckUnique_delete(self):
        user_groups = ['Test_department1']
        pk = Device.objects.get(vendor='Test_vendor1').id
        data = {
            'first_unit': 1,
            'last_unit': 2,
            'frontside_location': True,
        }
        model = Device
        with self.assertRaises(ValueError):
            CheckUnique(DeleteCheckProps(user_groups,
                                         pk,
                                         data,
                                         model)).result

    def test_CheckDeviceForAddOrUpdate_add(self):
        # Ok
        user_groups = ['Test_department1']
        pk = Rack.objects.get(name='Test_rack1').id
        data = {
            'first_unit': 29,
            'last_unit': 30,
            'frontside_location': True,
        }
        model = Device
        fk_model = Rack
        key_name = 'some_device'
        result = CheckDeviceForAddOrUpdate(AddCheckProps(user_groups,
                                                         pk,
                                                         data,
                                                         model,
                                                         fk_model,
                                                         key_name)).result
        self.assertEqual(result, Result(True, 'Success'))

        # Units busy
        data = {
            'first_unit': 1,
            'last_unit': 2,
            'frontside_location': True,
        }
        result = CheckDeviceForAddOrUpdate(AddCheckProps(user_groups,
                                                         pk,
                                                         data,
                                                         model,
                                                         fk_model,
                                                         key_name)).result
        self.assertEqual(result,
                         Result(False, 'These units are busy'))

        # Units busy (partial)
        data = {
            'first_unit': 2,
            'last_unit': 3,
            'frontside_location': True,
        }
        result = CheckDeviceForAddOrUpdate(AddCheckProps(user_groups,
                                                         pk,
                                                         data,
                                                         model,
                                                         fk_model,
                                                         key_name)).result
        self.assertEqual(result,
                         Result(False, 'These units are busy'))

        # Data miss first_unit
        data = {
            'last_unit': 3,
            'frontside_location': True,
        }
        with self.assertRaises(KeyError):
            CheckDeviceForAddOrUpdate(AddCheckProps(user_groups,
                                                    pk,
                                                    data,
                                                    model,
                                                    fk_model,
                                                    key_name)).result

        # Data miss last_unit
        data = {
            'first_unit': 2,
            'frontside_location': True,
        }
        with self.assertRaises(KeyError):
            CheckDeviceForAddOrUpdate(AddCheckProps(user_groups,
                                                    pk,
                                                    data,
                                                    model,
                                                    fk_model,
                                                    key_name)).result

        # Data miss frontside_location
        data = {
            'first_unit': 2,
            'last_unit': 3,
        }
        with self.assertRaises(KeyError):
            CheckDeviceForAddOrUpdate(AddCheckProps(user_groups,
                                                    pk,
                                                    data,
                                                    model,
                                                    fk_model,
                                                    key_name)).result

        # No such units (partial)
        data = {
            'first_unit': 39,
            'last_unit': 42,
            'frontside_location': True,
        }
        result = CheckDeviceForAddOrUpdate(AddCheckProps(user_groups,
                                                         pk,
                                                         data,
                                                         model,
                                                         fk_model,
                                                         key_name)).result
        self.assertEqual(result,
                         Result(False, 'There are no such units in this rack'))

        # No such units
        data = {
            'first_unit': 51,
            'last_unit': 53,
            'frontside_location': True,
        }
        result = CheckDeviceForAddOrUpdate(AddCheckProps(user_groups,
                                                         pk,
                                                         data,
                                                         model,
                                                         fk_model,
                                                         key_name)).result
        self.assertEqual(result,
                         Result(False, 'There are no such units in this rack'))

    def test_CheckDeviceForAddOrUpdate_update(self):
        # Ok
        user_groups = ['Test_department1']
        pk = Device.objects.get(vendor='Test_vendor1').id
        data = {
            'first_unit': 3,
            'last_unit': 4,
            'frontside_location': True,
        }
        model = Device
        fk = Rack.objects.get(name='Test_rack1').id
        fk_model = Rack
        key_name = 'some_device'
        instance_name = 'some_device'
        result = CheckDeviceForAddOrUpdate(UpdateCheckProps(user_groups,
                                                            pk,
                                                            data,
                                                            model,
                                                            fk,
                                                            fk_model,
                                                            key_name,
                                                            instance_name)) \
            .result
        self.assertEqual(result, Result(True, 'Success'))

        # Partial move
        data = {
            'first_unit': 2,
            'last_unit': 3,
            'frontside_location': True,
        }
        result = CheckDeviceForAddOrUpdate(UpdateCheckProps(user_groups,
                                                            pk,
                                                            data,
                                                            model,
                                                            fk,
                                                            fk_model,
                                                            key_name,
                                                            instance_name)) \
            .result
        self.assertEqual(result, Result(True, 'Success'))

        # Units busy (partial)
        data = {
            'first_unit': 1,
            'last_unit': 5,
            'frontside_location': True,
        }
        result = CheckDeviceForAddOrUpdate(UpdateCheckProps(user_groups,
                                                            pk,
                                                            data,
                                                            model,
                                                            fk,
                                                            fk_model,
                                                            key_name,
                                                            instance_name)) \
            .result
        self.assertEqual(result,
                         Result(False, 'These units are busy'))

        # Units busy
        data = {
            'first_unit': 5,
            'last_unit': 5,
            'frontside_location': True,
        }
        result = CheckDeviceForAddOrUpdate(UpdateCheckProps(user_groups,
                                                            pk,
                                                            data,
                                                            model,
                                                            fk,
                                                            fk_model,
                                                            key_name,
                                                            instance_name)) \
            .result
        self.assertEqual(result,
                         Result(False, 'These units are busy'))

        # Data miss first_unit
        data = {
            'last_unit': 3,
            'frontside_location': True,
        }
        with self.assertRaises(KeyError):
            CheckDeviceForAddOrUpdate(UpdateCheckProps(user_groups,
                                                       pk,
                                                       data,
                                                       model,
                                                       fk,
                                                       fk_model,
                                                       key_name,
                                                       instance_name)).result

        # Data miss last_unit
        data = {
            'first_unit': 2,
            'frontside_location': True,
        }
        with self.assertRaises(KeyError):
            CheckDeviceForAddOrUpdate(UpdateCheckProps(user_groups,
                                                       pk,
                                                       data,
                                                       model,
                                                       fk,
                                                       fk_model,
                                                       key_name,
                                                       instance_name)).result

        # Data miss frontside_location
        data = {
            'first_unit': 2,
            'last_unit': 3,
        }
        with self.assertRaises(KeyError):
            CheckDeviceForAddOrUpdate(UpdateCheckProps(user_groups,
                                                       pk,
                                                       data,
                                                       model,
                                                       fk,
                                                       fk_model,
                                                       key_name,
                                                       instance_name)).result

        # No such units (partial)
        data = {
            'first_unit': 39,
            'last_unit': 42,
            'frontside_location': True,
        }
        result = CheckDeviceForAddOrUpdate(UpdateCheckProps(user_groups,
                                                            pk,
                                                            data,
                                                            model,
                                                            fk,
                                                            fk_model,
                                                            key_name,
                                                            instance_name)) \
            .result
        self.assertEqual(result,
                         Result(False, 'There are no such units in this rack'))

        # No such units
        data = {
            'first_unit': 51,
            'last_unit': 53,
            'frontside_location': True,
        }
        result = CheckDeviceForAddOrUpdate(UpdateCheckProps(user_groups,
                                                            pk,
                                                            data,
                                                            model,
                                                            fk,
                                                            fk_model,
                                                            key_name,
                                                            instance_name)) \
            .result
        self.assertEqual(result,
                         Result(False, 'There are no such units in this rack'))

    def test_CheckDeviceForAddOrUpdate_delete(self):
        user_groups = ['Test_department1']
        pk = Device.objects.get(vendor='Test_vendor1').id
        data = {
            'first_unit': 1,
            'last_unit': 2,
            'frontside_location': True,
        }
        model = Device
        with self.assertRaises(ValueError):
            CheckDeviceForAddOrUpdate(DeleteCheckProps(user_groups,
                                                       pk,
                                                       data,
                                                       model)).result

    @classmethod
    def tearDownClass(cls):
        pass


class TestChecker(TestCase):
    """
    Test Checker
    """

    @classmethod
    def setUpClass(cls):
        Setup.base_setup()

    def test_Checker(self):
        # All checks pass
        user_groups = ['Test_department1']
        pk = Device.objects.get(vendor='Test_vendor1').id
        data = {
            'first_unit': 29,
            'last_unit': 30,
            'frontside_location': True,
        }
        model = Device
        fk_model = Rack
        key_name = 'device some_vendor, some_model'
        props = AddCheckProps(user_groups, pk, data, model, fk_model, key_name)
        checks_list = [CheckUser, CheckDeviceForAddOrUpdate]
        result = Checker(checks_list, props).result
        self.assertEqual(result, Result(True, 'Success'))

        # One check fail
        user_groups = ['some_group']
        pk = Device.objects.get(vendor='Test_vendor1').id
        data = {
            'first_unit': 29,
            'last_unit': 30,
            'frontside_location': True,
        }
        model = Device
        fk_model = Rack
        key_name = 'device some_vendor, some_model'
        props = AddCheckProps(user_groups, pk, data, model, fk_model, key_name)
        result = Checker(checks_list, props).result
        self.assertEqual(result,
                         Result(False,
                                'Permission alert, changes are prohibited'))

    @classmethod
    def tearDownClass(cls):
        pass
