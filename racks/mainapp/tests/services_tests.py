"""
Testing business logic
"""
import datetime

from django.test import TestCase
from mainapp.models import (Region,
                            Department,
                            Site,
                            Building,
                            Room,
                            Rack,
                            Device)
from mainapp.services import (DeviceCheckService,
                              DataProcessingService,
                              UnitsTuple,
                              ReportService,
                              date)
from mainapp.utils import *
from mainapp.repository import *
from mainapp.tests.mock_data import ReportMocks
from mainapp.tests.setup import Setup


class TestDate(TestCase):
    """
    Testing date service
    """

    def test_date(self):
        # Date without h-m-s
        result = datetime.datetime.today().strftime("%Y-%m-%d_%H-%M-%S")[:-9]
        self.assertEqual(result, date()[:-9])


class TestDeviceCheckService(TestCase):

    @classmethod
    def setUpClass(cls):
        Setup.base_setup()

    def test_get_units(self):
        result = DeviceCheckService.get_units(1, 2, UnitsTuple)
        self.assertEqual(result, UnitsTuple(1, 2))

        result = DeviceCheckService.get_units(5, 2, UnitsTuple)
        self.assertEqual(result, UnitsTuple(2, 5))

    def test_check_unit_exist(self):
        rack1_amount = Rack.objects.get(rack_name='Test_rack1').rack_amount
        result = DeviceCheckService \
            .check_unit_exist(UnitsTuple(39, 40), rack1_amount)
        self.assertTrue(result)

        rack2_amount = Rack.objects.get(rack_name='Test_rack2').rack_amount
        result = DeviceCheckService \
            .check_unit_exist(UnitsTuple(21, 22), rack2_amount)
        self.assertFalse(result)

    def test_get_filled_list(self):
        rack_id = Rack.objects.get(rack_name='Test_rack1').id
        devices_for_side_qs = Device.objects.filter(rack_id_id=rack_id)
        result = DeviceCheckService.get_filled_list(devices_for_side_qs)
        self.assertEqual(result, [1, 2, 5, 3, 4, 7])

    def test_check_unit_busy_for_update(self):
        result = DeviceCheckService \
            .check_unit_busy_for_update([1, 2, 3, 4, 6, 7],
                                        UnitsTuple(3, 6),
                                        UnitsTuple(2, 3))
        self.assertTrue(result)

        result = DeviceCheckService \
            .check_unit_busy_for_update([1, 2, 3, 4, 6, 7],
                                        UnitsTuple(8, 8),
                                        UnitsTuple(6, 7))
        self.assertFalse(result)

        result = DeviceCheckService \
            .check_unit_busy_for_update([1, 2, 3, 4, 6, 7],
                                        UnitsTuple(7, 8),
                                        UnitsTuple(6, 7))
        self.assertFalse(result)

    def test_check_unit_busy_for_add(self):
        result = DeviceCheckService \
            .check_unit_busy_for_add([1, 2, 3, 4, 6, 7],
                                     UnitsTuple(3, 6))
        self.assertTrue(result)

        result = DeviceCheckService \
            .check_unit_busy_for_add([1, 2, 3, 4, 6, 7],
                                     UnitsTuple(8, 8))
        self.assertFalse(result)

    @classmethod
    def tearDownClass(cls):
        pass


class TestDataProcessingService(TestCase):

    @classmethod
    def setUpClass(cls):
        Setup.base_setup()

    def test_get_devices_power_w_sum(self):
        result = DataProcessingService \
            .get_devices_power_w_sum([3, 5, 17])
        self.assertEqual(result, 25)

        result = DataProcessingService \
            .get_devices_power_w_sum([100, 200, None])
        self.assertEqual(result, 300)

    def test_get_key_name(self):
        # Get key name (if model != Device)
        data = {'rack_name': 'Test_rack1'}
        result = DataProcessingService.get_key_name(data, 'rack')
        self.assertEqual(result, 'Test_rack1')

        # Get key name (if model == Device)
        data = {
            'device_vendor': 'Test_vendor1',
            'device_model': 'Test_model1',
        }
        result = DataProcessingService.get_key_name(data, 'device')
        self.assertEqual(result, 'device Test_vendor1, Test_model1')

        # For Device model, if vendor and model not specified
        data = {}
        result = DataProcessingService.get_key_name(data, 'device')
        self.assertEqual(result,
                         'device unspecified vendor, unspecified model')

        data = {'device_vendor': 'Test_vendor1'}
        result = DataProcessingService.get_key_name(data, 'device')
        self.assertEqual(result,
                         'device Test_vendor1, unspecified model')

        data = {'device_model': 'Test_model1'}
        result = DataProcessingService.get_key_name(data, 'device')
        self.assertEqual(result,
                         'device unspecified vendor, Test_model1')

    def test_get_instance_name(self):
        # Model Rack
        rack1 = Rack.objects.get(rack_name='Test_rack1')
        result = DataProcessingService \
            .get_instance_name(rack1, Rack, Device)
        self.assertEqual(result, 'Test_rack1')

        # Model Device
        device1 = Device.objects.get(device_vendor='Test_vendor1')
        result = DataProcessingService \
            .get_instance_name(device1, Device, Device)
        self.assertEqual(result, 'device Test_vendor1, Test_model1')

        # Model Device, unspecified model
        device2 = Device.objects.get(device_vendor='Test_vendor9')
        result = DataProcessingService \
            .get_instance_name(device2, Device, Device)
        self.assertEqual(result,
                         'device Test_vendor9, unspecified model')

        # Model Device, unspecified vendor
        device3 = Device.objects.get(device_model='Test_model10')
        result = DataProcessingService \
            .get_instance_name(device3, Device, Device)
        self.assertEqual(result,
                         'device unspecified vendor, Test_model10')

        # Model Device, unspecified vendor and model
        device4 = Device.objects.get(first_unit=20)
        result = DataProcessingService \
            .get_instance_name(device4, Device, Device)
        self.assertEqual(result,
                         'device unspecified vendor, unspecified model')

    @classmethod
    def tearDownClass(cls):
        pass


class TestReportService(TestCase):
    """
    Testing report services
    """

    @classmethod
    def setUpClass(cls):
        Setup.base_setup()

    def test_get_devices_data(self):
        # Devices report data
        devices_report_qs = Device.objects.get_devices_report()
        data = ReportService.get_devices_data(devices_report_qs)
        # Replace datestamp
        for line in data:
            line[27] = ''
        self.assertEqual(data, ReportMocks.devices_mock_data)

    def test_get_racks_data(self):
        # Racks report data
        racks_report_qs = Rack.objects.get_racks_report()
        data = ReportService.get_racks_data(racks_report_qs)
        # Replace datestamp
        for line in data:
            line[28] = ''
        self.assertEqual(data, ReportMocks.racks_mock_data)

    @classmethod
    def tearDownClass(cls):
        pass


#class TestCheckProps(TestCase):
#
#    @classmethod
#    def setUpClass(cls):
#        Setup.base_setup()
#
#    def test_NamesList(self):
#        pk = Building.objects.get(building_name='Test_building1').id
#        result = NamesList(pk, Building).names_list
#        self.assertEqual(result, {'Test_building1'})
#
#    @classmethod
#    def tearDownClass(cls):
#        pass
'''
    def test_check_unit_busy(self):
        # Rack - Test_rack1
        # Side - Front (True)
        # add
        rack_id = Rack.objects.get(rack_name='Test_rack1').id
        queryset_devices = Device.objects.filter(rack_id_id=rack_id) \
            .filter(frontside_location=True)
        new_units = NewUnits(5, 6)
        result = DeviceCheckService \
            .check_unit_busy(queryset_devices, new_units, old_units=None)
        self.assertTrue(result)

        new_units = NewUnits(7, 9)
        result = DeviceCheckService \
            .check_unit_busy(queryset_devices, new_units, old_units=None)
        self.assertFalse(result)

        # Rack - Test_rack1
        # Side - Back (False)
        # add
        queryset_devices = Device.objects.filter(rack_id_id=rack_id) \
            .filter(frontside_location=False)
        new_units = NewUnits(2, 3)
        result = DeviceCheckService \
            .check_unit_busy(queryset_devices, new_units, old_units=None)
        self.assertTrue(result)

        new_units = NewUnits(10, 12)
        result = DeviceCheckService \
            .check_unit_busy(queryset_devices, new_units, old_units=None)
        self.assertFalse(result)

        # Rack - Test_rack1
        # Side - Front (True)
        # update
        queryset_devices = Device.objects.filter(rack_id_id=rack_id) \
            .filter(frontside_location=True)
        new_units = NewUnits(4, 5)
        old_units = OldUnits(1, 2)
        result = DeviceCheckService \
            .check_unit_busy(queryset_devices, new_units, old_units)
        self.assertTrue(result)

        new_units = NewUnits(2, 3)
        old_units = OldUnits(1, 2)
        result = DeviceCheckService \
            .check_unit_busy(queryset_devices, new_units, old_units)
        self.assertFalse(result)

        # Rack - Test_rack1
        # Side - Back (False)
        # update
        queryset_devices = Device.objects.filter(rack_id_id=rack_id) \
            .filter(frontside_location=False)
        new_units = NewUnits(7, 8)
        old_units = OldUnits(3, 4)
        result = DeviceCheckService \
            .check_unit_busy(queryset_devices, new_units, old_units)
        self.assertTrue(result)

        new_units = NewUnits(10, 11)
        old_units = OldUnits(3, 4)
        result = DeviceCheckService \
            .check_unit_busy(queryset_devices, new_units, old_units)
        self.assertFalse(result) 

    @classmethod
    def tearDownClass(cls):
        pass
'''

'''
class TestDataProcessingService:

    @classmethod
    def setUpClass(cls):
        Setup.base_setup()

    def test_get_devices_power_w_sum(self):
        # Rack - Test_rack1
        rack1_id = Rack.objects.get(rack_name='Test_rack1').id
        power_w_list = list(Device
                            .objects
                            .filter(rack_id_id=rack1_id)
                            .values_list('power_w', flat=True))
        result = DataProcessingService.get_devices_power_w_sum(power_w_list)
        self.assertEqual(result, 350)

        # Rack - Test_rack2
        rack2_id = Rack.objects.get(rack_name='Test_rack2').id
        power_w_list = list(Device
                            .objects
                            .filter(rack_id_id=rack2_id)
                            .values_list('power_w', flat=True))
        result = DataProcessingService.get_devices_power_w_sum(power_w_list)
        self.assertEqual(result, 0)

    def test_get_key_name(self):
        # Get key name (if model != Device)
        data = {'rack_name': 'Test_rack1'}
        result = DataProcessingService.get_key_name(data, 'rack')
        self.assertEqual(result, 'Test_rack1')

        # Get key name (if model == Device)
        data = {
            'device_vendor': 'Test_vendor1',
            'device_model': 'Test_model1',
        }
        result = DataProcessingService.get_key_name(data, 'device')
        self.assertEqual(result, 'device Test_vendor1, Test_model1')

        # For Device model, if vendor and model not specified
        data = {}
        result = DataProcessingService.get_key_name(data, 'device')
        self.assertEqual(result,
                         'device unspecified vendor, unspecified model')

    def test_get_instance_name(self):
        # Model Rack
        rack1 = Rack.objects.get(rack_name='Test_rack1')
        result = DataProcessingService \
            .get_instance_name(rack1, Rack)
        self.assertEqual(result, 'Test_rack1')

        # Model Device
        device1 = Device.objects.get(device_vendor='Test_vendor1')
        result = DataProcessingService \
            .get_instance_name(device1, Device)
        self.assertEqual(result, 'device Test_vendor1, Test_model1')

        # Model Device, unspecified model
        device2 = Device.objects.get(device_vendor='Test_vendor9')
        result = DataProcessingService \
            .get_instance_name(device2, Device)
        self.assertEqual(result,
                         'device Test_vendor9, unspecified model')

        # Model Device, unspecified vendor
        device3 = Device.objects.get(device_model='Test_model10')
        result = DataProcessingService \
            .get_instance_name(device3, Device)
        self.assertEqual(result,
                         'device unspecified vendor, Test_model10')

        # Model Device, unspecified vendor and model
        device4 = Device.objects.get(first_unit=20)
        result = DataProcessingService \
            .get_instance_name(device4, Device)
        self.assertEqual(result,
                         'device unspecified vendor, unspecified model')

    @classmethod
    def tearDownClass(cls):
        pass


class TestReportService(TestCase):
    """
    Testing report services
    """

    @classmethod
    def setUpClass(cls):
        Setup.base_setup()

    def test_get_devices_data(self):
        # Devices report data
        devices_report_qs = Device.objects.get_devices_report()
        data = ReportService.get_devices_data(devices_report_qs)
        # Replace datestamp
        for line in data:
            line[27] = ''
        self.assertEqual(data, devices_mock_data)

    def test_get_racks_data(self):
        # Racks report data
        racks_report_qs = Rack.objects.get_racks_report()
        data = ReportService.get_racks_data(racks_report_qs)
        # Replace datestamp
        for line in data:
            line[28] = ''
        self.assertEqual(data, racks_mock_data)

    @classmethod
    def tearDownClass(cls):
        pass


# class TestChecksProps:
# 
#     @classmethod
#     def setUpClass(cls):
#         Setup.base_setup()
# 
#     def test_TestNamesListProp(self):
#         pk = Room.objects.get(room_name='Test_room1').id
#         fk = Building.objects.get(room_name='Test_building1').id
#         model = Room
#         fk_model = Building
#         result = NamesListProp(pk, fk, model, fk_model).names_list
#         self.assertEqual(['Test_room1'], result)
# 
#     def test_DepartmentNameProp(self):
#         pk = Room.objects.get(room_name='Test_room1').id
#         model = Room
#         result = DepartmentNameProp(pk, model).department_name
#         self.assertEqual('Test_department1', result)
# 
#     @classmethod
#     def tearDownClass(cls):
#         pass
'''

'''
class TestUserCheckService(TestCase):
    """
    Testing services for checking user permissions
    """

    @classmethod
    def setUpClass(cls):
        Setup.base_setup()

    def test_check_for_groups(self):
        # Department - Test_department1
        # user_group = ['Test_department1']
        department1_id = Department.objects \
            .get(department_name='Test_department1').id
        result = UserCheckService \
            .check_for_groups(['Test_department1'], department1_id, Department)
        self.assertTrue(result)

        # Department - Test_department1
        # Site - Test_site1
        # user_group = ['Test_department1']
        site1_id = Site.objects.get(site_name='Test_site1').id
        result = UserCheckService \
            .check_for_groups(['Test_department1'], site1_id, Site)
        self.assertTrue(result)

        # Department - Test_department1
        # Building - Test_building1
        # user_group = ['Test_department1']
        building1_id = Building.objects.get(building_name='Test_building1').id
        result = UserCheckService \
            .check_for_groups(['Test_department1'], building1_id, Building)
        self.assertTrue(result)

        # Department - Test_department1
        # Room - Test_room1
        # user_group = ['Test_department1']
        room1_id = Room.objects.get(room_name='Test_room1').id
        result = UserCheckService \
            .check_for_groups(['Test_department1'], room1_id, Room)
        self.assertTrue(result)

        # Department - Test_department1
        # Rack - Test_rack1
        # user_group = ['Test_department1']
        rack1_id = Rack.objects.get(rack_name='Test_rack1').id
        result = UserCheckService \
            .check_for_groups(['Test_department1'], rack1_id, Rack)
        self.assertTrue(result)

        # Department - Test_department1
        # Device - device with Test_vendor2
        # user_group = ['Test_department1']
        device2_id = Device.objects.get(device_vendor='Test_vendor2').id
        result = UserCheckService \
            .check_for_groups(['Test_department1'], device2_id, Device)
        self.assertTrue(result)

        # Department - Test_department1
        # user_group = ['Test_department2']
        result = UserCheckService \
            .check_for_groups(['Test_department2'], department1_id, Department)
        self.assertFalse(result)

        # Department - Test_department1
        # Site - Test_site1
        # user_group = ['Test_department2']
        result = UserCheckService \
            .check_for_groups(['Test_department2'], site1_id, Site)
        self.assertFalse(result)

        # Department - Test_department1
        # Building - Test_building1
        # user_group = ['Test_department2']
        result = UserCheckService \
            .check_for_groups(['Test_department2'], building1_id, Building)
        self.assertFalse(result)

        # Department - Test_department1
        # Room - Test_room1
        # user_group = ['Test_department2']
        result = UserCheckService \
            .check_for_groups(['Test_department2'], room1_id, Room)
        self.assertFalse(result)

        # Department - Test_department1
        # Rack - Test_rack1
        # user_group = ['Test_department2']
        result = UserCheckService \
            .check_for_groups(['Test_department2'], rack1_id, Rack)
        self.assertFalse(result)

        # Department - Test_department1
        # Device - device with Test_vendor2
        # user_group = ['Test_department2']
        result = UserCheckService \
            .check_for_groups(['Test_department2'], device2_id, Device)
        self.assertFalse(result)

        # Department - Test_department1
        # Rack - device with Test_rack1
        # user_group = ['Test_department2']
        # model = 'model'
        with self.assertRaises(ValueError):
            UserCheckService \
                .check_for_groups(['Test_department2'], rack1_id, 'model')

        # pk is None
        with self.assertRaises(ValueError):
            UserCheckService \
                .check_for_groups(['Test_department2'], None, Device)

    @classmethod
    def tearDownClass(cls):
        pass


class TestUniqueCheckService(TestCase):
    """
    Testing services for checking unique names
    """

    @classmethod
    def setUpClass(cls):
        Setup.base_setup()
        # Add some devices with already existing params
        room1_id = Room.objects.get(room_name='Test_room1')
        Rack.objects.get_or_create(rack_name='Test_rack1',
                                   rack_amount=40,
                                   rack_model='Test_model1',
                                   rack_vendor='Test_vendor1',
                                   room_id=room1_id)
        rack1_id = Rack.objects.get(rack_name='Test_rack1')
        Device.objects.get_or_create(first_unit=30,
                                     last_unit=31,
                                     device_vendor='Test_vendor1',
                                     device_model='Test_model1',
                                     rack_id=rack1_id)

    def test_get_unique_object_names_list(self):
        # Site - Test_site1
        site1_id = Site.objects.get(site_name='Test_site1').id
        result = UniqueCheckService \
            .get_unique_object_names_list(site1_id, Site)
        self.assertEqual(result, {'Test_building1'})

        # Building - Test_building1
        building1_id = Building.objects \
            .get(building_name='Test_building1').id
        result = UniqueCheckService \
            .get_unique_object_names_list(building1_id, Building)
        self.assertEqual(result, {'Test_room1'})

        # Room - Test_room1
        room1_id = Room.objects.get(room_name='Test_room1').id
        result = UniqueCheckService \
            .get_unique_object_names_list(room1_id, Room)
        self.assertEqual(result, {'Test_rack1'})

        # Key is None
        with self.assertRaises(ValueError):
            UniqueCheckService \
                .get_unique_object_names_list(None, Building)

        # Model = 'model'
        with self.assertRaises(ValueError):
            UniqueCheckService \
                .get_unique_object_names_list(building1_id, 'model')

    @classmethod
    def tearDownClass(cls):
        pass


class TestDeviceCheckService(TestCase):
    """
    Testing services for device add|upadate capabilities
    """

    @classmethod
    def setUpClass(cls):
        Setup.base_setup()

    # def test_get_old_units(self):
    #     # Device with Test_vendor1
    #     device1_id = Device.objects.get(device_vendor='Test_vendor1').id
    #     result = DeviceCheckService.get_old_units(device1_id)
    #     self.assertEqual(result, OldUnits(1, 2))
    #
    #     # Device with Test_vendor3
    #     device1_id = Device.objects.get(device_vendor='Test_vendor3').id
    #     result = DeviceCheckService.get_old_units(device1_id)
    #     self.assertEqual(result, OldUnits(3, 4))
    #
    #     # pk is None
    #     with self.assertRaises(ValueError):
    #         DeviceCheckService.get_old_units(None)

    def test_get_new_units(self):
        # First unit > last unit
        result = DeviceCheckService.get_new_units(7, 5)
        self.assertEqual(result, NewUnits(5, 7))

        # First unit < last unit
        result = DeviceCheckService.get_new_units(5, 7)
        self.assertEqual(result, NewUnits(5, 7))

    def test_check_unit_exist(self):
        # Rack - Test_rack1
        rack1_id = Rack.objects.get(rack_name='Test_rack1').id
        result = DeviceCheckService \
            .check_unit_exist(NewUnits(39, 42), rack1_id)
        self.assertTrue(result)

        result = DeviceCheckService \
            .check_unit_exist(NewUnits(21, 22), rack1_id)
        self.assertFalse(result)

        # rack_id is None
        with self.assertRaises(ValueError):
            DeviceCheckService.check_unit_exist(NewUnits(21, 22), None)

    def test_check_unit_busy(self):
        # Rack - Test_rack1
        # Side - Front (True)
        # add
        pk = Rack.objects.get(rack_name='Test_rack1').id
        new_units = NewUnits(5, 6)
        result = DeviceCheckService \
            .check_unit_busy(True, pk, new_units, old_units=None)
        self.assertTrue(result)

        new_units = NewUnits(7, 9)
        result = DeviceCheckService \
            .check_unit_busy(True, pk, new_units, old_units=None)
        self.assertFalse(result)

        # Rack - Test_rack1
        # Side - Back (False)
        # add
        new_units = NewUnits(2, 3)
        result = DeviceCheckService \
            .check_unit_busy(False, pk, new_units, old_units=None)
        self.assertTrue(result)

        new_units = NewUnits(10, 12)
        result = DeviceCheckService \
            .check_unit_busy(False, pk, new_units, old_units=None)
        self.assertFalse(result)

        # Rack - Test_rack1
        # Side - Front (True)
        # update
        new_units = NewUnits(4, 5)
        old_units = OldUnits(1, 2)
        result = DeviceCheckService \
            .check_unit_busy(True, pk, new_units, old_units)
        self.assertTrue(result)

        new_units = NewUnits(2, 3)
        old_units = OldUnits(1, 2)
        result = DeviceCheckService \
            .check_unit_busy(True, pk, new_units, old_units)
        self.assertFalse(result)

        # Rack - Test_rack1
        # Side - Back (False)
        # update
        new_units = NewUnits(7, 8)
        old_units = OldUnits(3, 4)
        result = DeviceCheckService \
            .check_unit_busy(False, pk, new_units, old_units)
        self.assertTrue(result)

        new_units = NewUnits(10, 11)
        old_units = OldUnits(3, 4)
        result = DeviceCheckService \
            .check_unit_busy(False, pk, new_units, old_units)
        self.assertFalse(result)

        # pk is None
        with self.assertRaises(ValueError):
            DeviceCheckService \
                .check_unit_busy(True, None, new_units, old_units=None)

    @classmethod
    def tearDownClass(cls):
        pass


class TestDataProcessingService(TestCase):
    """
    Testing data processing services
    """

    @classmethod
    def setUpClass(cls):
        Setup.base_setup()

    def test_get_devices_power_w_sum(self):
        # Rack - Test_rack1
        rack1_id = Rack.objects.get(rack_name='Test_rack1').id
        result = DataProcessingService.get_devices_power_w_sum(rack1_id)
        self.assertEqual(result, 350)

        # Rack - Test_rack2
        rack2_id = Rack.objects.get(rack_name='Test_rack2').id
        result = DataProcessingService.get_devices_power_w_sum(rack2_id)
        self.assertEqual(result, 0)

    def test_update_rack_amount(self):
        # No rack_amount in data
        rack1_id = Rack.objects.get(rack_name='Test_rack1').id
        rack_amount = Rack.objects.get_rack(rack1_id).rack_amount
        data = {'some_key': 'some_value'}
        result = DataProcessingService.update_rack_amount(data, rack1_id)
        self.assertEqual(result, data)

        # Replacing rack_amount in data
        data = {'rack_amount': 12}
        result = DataProcessingService.update_rack_amount(data, rack1_id)
        self.assertEqual(result, {'rack_amount': rack_amount})

        # pk is None
        with self.assertRaises(ValueError):
            DataProcessingService.update_rack_amount(data, None)

    def test_get_key_name(self):
        # Get key name (if model != Device)
        data = {'rack_name': 'Test_rack1'}
        result = DataProcessingService.get_key_name(data, 'rack')
        self.assertEqual(result, 'Test_rack1')

        # Get key name (if model == Device)
        data = {
            'device_vendor': 'Test_vendor1',
            'device_model': 'Test_model1',
        }
        result = DataProcessingService.get_key_name(data, 'device')
        self.assertEqual(result, 'device Test_vendor1, Test_model1')

        # For Device model, if vendor and model not specified
        data = {}
        result = DataProcessingService.get_key_name(data, 'device')
        self.assertEqual(result,
                         'device unspecified vendor, unspecified model')

    def test_get_instance_name(self):
        # Model Rack
        rack1_id = Rack.objects.get(rack_name='Test_rack1').id
        result = DataProcessingService \
            .get_instance_name(rack1_id, Rack, 'rack')
        self.assertEqual(result, 'Test_rack1')

        # Model Device
        device1_id = Device.objects.get(device_vendor='Test_vendor1').id
        result = DataProcessingService \
            .get_instance_name(device1_id, Device, 'device')
        self.assertEqual(result, 'device Test_vendor1, Test_model1')

        # Model Device, unspecified model
        device2_id = Device.objects.get(device_vendor='Test_vendor9').id
        result = DataProcessingService \
            .get_instance_name(device2_id, Device, 'device')
        self.assertEqual(result,
                         'device Test_vendor9, unspecified model')

        # Model Device, unspecified vendor
        device3_id = Device.objects.get(device_model='Test_model10').id
        result = DataProcessingService \
            .get_instance_name(device3_id, Device, 'device')
        self.assertEqual(result,
                         'device unspecified vendor, Test_model10')

        # Model Device, unspecified vendor and model
        device4_id = Device.objects.get(first_unit=20).id
        result = DataProcessingService \
            .get_instance_name(device4_id, Device, 'device')
        self.assertEqual(result,
                         'device unspecified vendor, unspecified model')

        # pk is None
        with self.assertRaises(ValueError):
            DataProcessingService \
                .get_instance_name(None, Device, 'device')

    @classmethod
    def tearDownClass(cls):
        pass


class TestRepoService(TestCase):
    """
    Testing Repository services
    """

    @classmethod
    def setUpClass(cls):
        Setup.base_setup()

    def test_get_instance(self):
        # Region - Test_region1
        region1_id = Region.objects.get(region_name='Test_region1').id
        instance = Region.objects.get(id=region1_id)
        result = RepoService.get_instance(Region, region1_id)
        self.assertEqual(result, instance)

        # Department - Test_department1
        department1_id = Department \
            .objects.get(department_name='Test_department1').id
        instance = Department.objects.get(id=department1_id)
        result = RepoService.get_instance(Department, department1_id)
        self.assertEqual(result, instance)

        # Site - Test_site1
        site1_id = Site.objects.get(site_name='Test_site1').id
        instance = Site.objects.get(id=site1_id)
        result = RepoService.get_instance(Site, site1_id)
        self.assertEqual(result, instance)

        # Building - Test_building1
        building1_id = Building.objects.get(building_name='Test_building1').id
        instance = Building.objects.get(id=building1_id)
        result = RepoService.get_instance(Building, building1_id)
        self.assertEqual(result, instance)

        # Room - Test_room1
        room1_id = Room.objects.get(room_name='Test_room1').id
        instance = Room.objects.get(id=room1_id)
        result = RepoService.get_instance(Room, room1_id)
        self.assertEqual(result, instance)

        # Rack - Test_rack1
        rack1_id = Rack.objects.get(rack_name='Test_rack1').id
        instance = Rack.objects.get(id=rack1_id)
        result = RepoService.get_instance(Rack, rack1_id)
        self.assertEqual(result, instance)

        # Device(vendor)- Test_vendor1
        device1_id = Device.objects.get(device_vendor='Test_vendor1').id
        instance = Device.objects.get(id=device1_id)
        result = RepoService.get_instance(Device, device1_id)
        self.assertEqual(result, instance)

        # pk is None
        with self.assertRaises(ValueError):
            RepoService.get_instance(Device, None)

    def test_get_devices_for_rack(self):
        # Rack - Test_rack1
        rack1_id = Rack.objects.get(rack_name='Test_rack1').id
        instance = Device.objects.filter(rack_id_id=rack1_id)
        result = RepoService.get_devices_for_rack(rack1_id)
        self.assertQuerysetEqual(result, instance, ordered=False)

        # pk is None
        with self.assertRaises(ValueError):
            RepoService.get_devices_for_rack(None)

    def test_get_all_racks(self):
        # All racks Queryset
        racks = Rack.objects.all()
        result = RepoService.get_all_racks()
        self.assertQuerysetEqual(result, racks, ordered=False)

    def test_get_all_racks_partial(self):
        # All racks partial Queryset
        racks = Rack.objects.all().only('id',
                                        'rack_name',
                                        'rack_amount',
                                        'numbering_from_bottom_to_top',
                                        'room_id')
        result = RepoService.get_all_racks_partial()
        self.assertQuerysetEqual(result, racks, ordered=False)

    def test_get_all_rooms(self):
        # All rooms Queryset
        rooms = Room.objects.all()
        result = RepoService.get_all_rooms()
        self.assertQuerysetEqual(result, rooms, ordered=False)

    def test_get_all_buildings(self):
        # All buildings Queryset
        buildings = Building.objects.all()
        result = RepoService.get_all_buildings()
        self.assertQuerysetEqual(result, buildings, ordered=False)

    def test_get_all_sites(self):
        # All sites Queryset
        sites = Site.objects.all()
        result = RepoService.get_all_sites()
        self.assertQuerysetEqual(result, sites, ordered=False)

    def test_get_all_departments(self):
        # All departments Queryset
        departments = Department.objects.all()
        result = RepoService.get_all_departments()
        self.assertQuerysetEqual(result, departments, ordered=False)

    def test_get_all_regions(self):
        # All regions Queryset
        regions = Region.objects.all()
        result = RepoService.get_all_regions()
        self.assertQuerysetEqual(result, regions, ordered=False)

    def test_get_rack_room_name(self):
        # Room - Test_room1
        room1_id = Room.objects.get(room_name='Test_room1').id
        room_name = Rack.objects \
            .select_related('room_id') \
            .get(id=room1_id) \
            .room_id \
            .room_name
        result = RepoService.get_rack_room_name(room1_id)
        self.assertEqual(result, room_name)

        # pk is None
        with self.assertRaises(ValueError):
            RepoService.get_rack_room_name(None)

    def test_get_rack_building_name(self):
        # Building - Test_building1
        building1_id = Building.objects.get(building_name='Test_building1').id
        building_name = Rack.objects \
            .select_related('room_id__'
                            'building_id') \
            .get(id=building1_id) \
            .room_id \
            .building_id \
            .building_name
        result = RepoService.get_rack_building_name(building1_id)
        self.assertEqual(result, building_name)

        # pk is None
        with self.assertRaises(ValueError):
            RepoService.get_rack_building_name(None)

    def test_get_rack_site_name(self):
        # Site - Test_site1
        site1_id = Site.objects.get(site_name='Test_site1').id
        site_name = Rack.objects \
            .select_related('room_id__'
                            'building_id__'
                            'site_id') \
            .get(id=site1_id) \
            .room_id \
            .building_id \
            .site_id \
            .site_name
        result = RepoService.get_rack_site_name(site1_id)
        self.assertEqual(result, site_name)

        # pk is None
        with self.assertRaises(ValueError):
            RepoService.get_rack_site_name(None)

    def test_get_rack_department_name(self):
        # Department - Test_department1
        department1_id = Department.objects \
            .get(department_name='Test_department1').id
        department_name = Rack.objects \
            .select_related('room_id__'
                            'building_id__'
                            'site_id__'
                            'department_id') \
            .get(id=department1_id) \
            .room_id \
            .building_id \
            .site_id \
            .department_id \
            .department_name
        result = RepoService.get_rack_department_name(department1_id)
        self.assertEqual(result, department_name)

        # pk is None
        with self.assertRaises(ValueError):
            RepoService.get_rack_department_name(None)

    def test_get_rack_region_name(self):
        # Region - Test_region1
        region1_id = Region.objects \
            .get(region_name='Test_region1').id
        region_name = Rack.objects \
            .select_related('room_id__'
                            'building_id__'
                            'site_id__'
                            'department_id__'
                            'region_id') \
            .get(id=region1_id) \
            .room_id \
            .building_id \
            .site_id \
            .department_id \
            .region_id \
            .region_name
        result = RepoService.get_rack_region_name(region1_id)
        self.assertEqual(result, region_name)

        # pk is None
        with self.assertRaises(ValueError):
            RepoService.get_rack_region_name(None)

    def test_get_device_rack_name(self):
        # Rack - Test_rack1
        rack1_id = Rack.objects.get(rack_name='Test_rack1').id
        rack_name = Device.objects \
            .select_related('rack_id') \
            .get(id=rack1_id) \
            .rack_id \
            .rack_name
        result = RepoService.get_device_rack_name(rack1_id)
        self.assertEqual(result, rack_name)

        # pk is None
        with self.assertRaises(ValueError):
            RepoService.get_device_rack_name(None)

    def test_get_device_room_name(self):
        # Room - Test_room1
        room1_id = Room.objects.get(room_name='Test_room1').id
        room_name = Device.objects \
            .select_related('rack_id__'
                            'room_id') \
            .get(id=room1_id) \
            .rack_id \
            .room_id \
            .room_name
        result = RepoService.get_device_room_name(room1_id)
        self.assertEqual(result, room_name)

        # pk is None
        with self.assertRaises(ValueError):
            RepoService.get_device_room_name(None)

    def test_get_device_building_name(self):
        # Building - Test_building1
        building1_id = Building.objects.get(building_name='Test_building1').id
        building_name = Device.objects \
            .select_related('rack_id__'
                            'room_id__'
                            'building_id') \
            .get(id=building1_id) \
            .rack_id \
            .room_id \
            .building_id \
            .building_name
        result = RepoService.get_device_building_name(building1_id)
        self.assertEqual(result, building_name)

        # pk is None
        with self.assertRaises(ValueError):
            RepoService.get_device_building_name(None)

    def test_get_device_site_name(self):
        # Site - Test_site1
        site1_id = Site.objects.get(site_name='Test_site1').id
        site_name = Device.objects \
            .select_related('rack_id__'
                            'room_id__'
                            'building_id__'
                            'site_id') \
            .get(id=site1_id) \
            .rack_id \
            .room_id \
            .building_id \
            .site_id \
            .site_name
        result = RepoService.get_device_site_name(site1_id)
        self.assertEqual(result, site_name)

        # pk is None
        with self.assertRaises(ValueError):
            RepoService.get_device_site_name(None)

    def test_get_device_department_name(self):
        # Department - Test_department1
        department1_id = Department.objects \
            .get(department_name='Test_department1').id
        department_name = Device.objects \
            .select_related('rack_id__'
                            'room_id__'
                            'building_id__'
                            'site_id__'
                            'department_id') \
            .get(id=department1_id) \
            .rack_id \
            .room_id \
            .building_id \
            .site_id \
            .department_id \
            .department_name
        result = RepoService.get_device_department_name(department1_id)
        self.assertEqual(result, department_name)

        # pk is None
        with self.assertRaises(ValueError):
            RepoService.get_device_department_name(None)

    def test_get_device_region_name(self):
        # Region - Test_region1
        region1_id = Region.objects \
            .get(region_name='Test_region1').id
        region_name = Device.objects \
            .select_related('rack_id__'
                            'room_id__'
                            'building_id__'
                            'site_id__'
                            'department_id__'
                            'region_id') \
            .get(id=region1_id) \
            .rack_id \
            .room_id \
            .building_id \
            .site_id \
            .department_id \
            .region_id \
            .region_name
        result = RepoService.get_device_region_name(region1_id)
        self.assertEqual(result, region_name)

        # pk is None
        with self.assertRaises(ValueError):
            RepoService.get_device_region_name(None)

    def test_get_device_rack_id(self):
        # Device(vendor) - Test_vendor1
        device1_id = Device.objects.get(device_vendor='Test_vendor1').id
        rack_id = Device.objects.get_device(device1_id).rack_id_id
        result = RepoService.get_device_rack_id(device1_id)
        self.assertEqual(result, rack_id)

        # pk is None
        with self.assertRaises(ValueError):
            RepoService.get_device_rack_id(None)

    def test_get_device_vendors(self):
        # Device vendors list
        vendors_list = list(Device
                            .objects
                            .values_list('device_vendor', flat=True)
                            .distinct())
        vendors_list.sort()
        result = RepoService.get_device_vendors()
        self.assertEqual(result, vendors_list)

    def test_get_device_models(self):
        # Device models list
        models_list = list(Device
                           .objects
                           .values_list('device_model', flat=True)
                           .distinct())
        models_list.sort()
        result = RepoService.get_device_models()
        self.assertEqual(result, models_list)

    def test_get_rack_vendors(self):
        # Rack vendors list
        vendors_list = list(Rack
                            .objects
                            .values_list('rack_vendor', flat=True)
                            .distinct())
        vendors_list.sort()
        result = RepoService.get_rack_vendors()
        self.assertEqual(result, vendors_list)

    def test_get_rack_models(self):
        # Rack models list
        models_list = list(Rack
                           .objects
                           .values_list('rack_model', flat=True)
                           .distinct())
        models_list.sort()
        result = RepoService.get_rack_models()
        self.assertEqual(result, models_list)

    @classmethod
    def tearDownClass(cls):
        pass


class TestReportService(TestCase):
    """
    Testing report services
    """

    @classmethod
    def setUpClass(cls):
        Setup.base_setup()

    def test_get_devices_data(self):
        # Devices report data
        data = ReportService.get_devices_data()
        # Replace datestamp
        for line in data:
            line[27] = ''
        self.assertEqual(data, devices_mock_data)

    def test_get_racks_data(self):
        # RAcks report data
        data = ReportService.get_racks_data()
        # Replace datestamp
        for line in data:
            line[28] = ''
        self.assertEqual(data, racks_mock_data)

    @classmethod
    def tearDownClass(cls):
        pass
'''
