"""
Testing business logic
"""
from django.test import TestCase
from mainapp.data import ReportHeaders
from mainapp.models import (
    Region,
    Department,
    Site,
    Building,
    Room,
    Rack,
    Device,
)
from mainapp.services import (
    RackLayoutService,
    UserCheckService,
    UniqueCheckService,
    DeviceCheckService,
    QrService,
    DraftService,
    ReportService
)


def base_setup():
    """
    DB setup
    """
    Region.objects.get_or_create(region_name='Test_region1')
    Region.objects.get_or_create(region_name='Test_region2')
    region1_id = Region.objects.get(region_name='Test_region1')
    Department.objects.get_or_create(department_name='Test_department1',
                                     region_id=region1_id)
    region2_id = Region.objects.get(region_name='Test_region2')
    Department.objects.get_or_create(department_name='Test_department2',
                                     region_id=region2_id)
    department1_id = Department.objects.get(department_name='Test_department1')
    Site.objects.get_or_create(site_name='Test_site1',
                               department_id=department1_id)
    department2_id = Department.objects.get(department_name='Test_department2')
    Site.objects.get_or_create(site_name='Test_site2',
                               department_id=department2_id)
    site1_id = Site.objects.get(site_name='Test_site1')
    Building.objects.get_or_create(building_name='Test_building1',
                                   site_id=site1_id)
    site2_id = Site.objects.get(site_name='Test_site2')
    Building.objects.get_or_create(building_name='Test_building2',
                                   site_id=site2_id)
    building1_id = Building.objects.get(building_name='Test_building1')
    Room.objects.get_or_create(room_name='Test_room1',
                               building_id=building1_id)
    building2_id = Building.objects.get(building_name='Test_building2')
    Room.objects.get_or_create(room_name='Test_room2',
                               building_id=building2_id)
    room1_id = Room.objects.get(room_name='Test_room1')
    Rack.objects.get_or_create(rack_name='Test_rack1',
                               rack_amount=40,
                               rack_model='Test_model1',
                               rack_vendor='Test_vendor1',
                               room_id=room1_id)
    room2_id = Room.objects.get(room_name='Test_room2')
    Rack.objects.get_or_create(rack_name='Test_rack2',
                               rack_amount=20,
                               rack_model='Test_model2',
                               rack_vendor='Test_vendor2',
                               numbering_from_bottom_to_top=False,
                               room_id=room2_id)
    rack1_id = Rack.objects.get(rack_name='Test_rack1')
    Device.objects.get_or_create(first_unit=2,
                                 last_unit=1,
                                 device_vendor='Test_vendor1',
                                 device_model='Test_model1',
                                 rack_id=rack1_id)
    Device.objects.get_or_create(first_unit=5,
                                 last_unit=5,
                                 device_vendor='Test_vendor2',
                                 device_model='Test_model2',
                                 rack_id=rack1_id)
    Device.objects.get_or_create(first_unit=4,
                                 last_unit=3,
                                 frontside_location=False,
                                 device_vendor='Test_vendor3',
                                 device_model='Test_model3',
                                 rack_id=rack1_id)
    Device.objects.get_or_create(first_unit=7,
                                 last_unit=7,
                                 frontside_location=False,
                                 device_vendor='Test_vendor4',
                                 device_model='Test_model4',
                                 rack_id=rack1_id)
    rack2_id = Rack.objects.get(rack_name='Test_rack2')
    Device.objects.get_or_create(first_unit=11,
                                 last_unit=12,
                                 device_vendor='Test_vendor5',
                                 device_model='Test_model5',
                                 rack_id=rack2_id)
    Device.objects.get_or_create(first_unit=15,
                                 last_unit=15,
                                 device_vendor='Test_vendor6',
                                 device_model='Test_model6',
                                 rack_id=rack2_id)
    Device.objects.get_or_create(first_unit=14,
                                 last_unit=13,
                                 frontside_location=False,
                                 device_vendor='Test_vendor7',
                                 device_model='Test_model7',
                                 rack_id=rack2_id)
    Device.objects.get_or_create(first_unit=18,
                                 last_unit=18,
                                 frontside_location=False,
                                 device_vendor='Test_vendor8',
                                 device_model='Test_model8',
                                 rack_id=rack2_id)


class TestRackLayoutService(TestCase):
    """
    Testing services for rack layout 
    """

    @classmethod
    def setUpClass(cls):
        base_setup()

    def test_get_start_list(self):
        # Test_rack1
        pk = Rack.objects.get(rack_name='Test_rack1').id
        direction = Rack.objects.get(id=pk).numbering_from_bottom_to_top
        result = RackLayoutService.get_start_list(pk, direction)
        self.assertEqual(result, list(range(1, 41))[::-1])

        # Test_rack2
        pk = Rack.objects.get(rack_name='Test_rack2').id
        direction = Rack.objects.get(id=pk).numbering_from_bottom_to_top
        result = RackLayoutService.get_start_list(pk, direction)
        self.assertEqual(result, list(range(1, 21)))

    def test_get_first_units(self):
        # Device with Test_vendor1 and Test_vendor2,
        # Test_rack1 front side location
        pk = Rack.objects.get(rack_name='Test_rack1').id
        direction = Rack.objects.get(id=pk).numbering_from_bottom_to_top
        device1_id = Device.objects.get(device_vendor='Test_vendor1').id
        device2_id = Device.objects.get(device_vendor='Test_vendor2').id
        result = RackLayoutService.get_first_units(pk, direction, True)
        self.assertEqual(result, {device2_id: 5, device1_id: 2})

        # Device with Test_vendor3 and Test_vendor4,
        # Test_rack1 back side location
        pk = Rack.objects.get(rack_name='Test_rack1').id
        direction = Rack.objects.get(id=pk).numbering_from_bottom_to_top
        device1_id = Device.objects.get(device_vendor='Test_vendor3').id
        device2_id = Device.objects.get(device_vendor='Test_vendor4').id
        result = RackLayoutService.get_first_units(pk, direction, False)
        self.assertEqual(result, {device2_id: 7, device1_id: 4})

        # Device with Test_vendor5 and Test_vendor6,
        # Test_rack2 front side location
        pk = Rack.objects.get(rack_name='Test_rack2').id
        direction = Rack.objects.get(id=pk).numbering_from_bottom_to_top
        device1_id = Device.objects.get(device_vendor='Test_vendor5').id
        device2_id = Device.objects.get(device_vendor='Test_vendor6').id
        result = RackLayoutService.get_first_units(pk, direction, True)
        self.assertEqual(result, {device1_id: 11, device2_id: 15})

        # Device with Test_vendor7 and Test_vendor8,
        # Test_rack2 back side location
        pk = Rack.objects.get(rack_name='Test_rack2').id
        direction = Rack.objects.get(id=pk).numbering_from_bottom_to_top
        device1_id = Device.objects.get(device_vendor='Test_vendor7').id
        device2_id = Device.objects.get(device_vendor='Test_vendor8').id
        result = RackLayoutService.get_first_units(pk, direction, False)
        self.assertEqual(result, {device1_id: 13, device2_id: 18})

    def test_get_rowspans(self):
        # Device with Test_vendor1 and Test_vendor2,
        # Test_rack1 front side location
        pk = Rack.objects.get(rack_name='Test_rack1').id
        device1_id = Device.objects.get(device_vendor='Test_vendor1').id
        device2_id = Device.objects.get(device_vendor='Test_vendor2').id
        result = RackLayoutService.get_rowspans(pk, True)
        self.assertEqual(result, {device2_id: 1, device1_id: 2})

        # Device with Test_vendor1 and Test_vendor2,
        # Test_rack1 front side location
        pk = Rack.objects.get(rack_name='Test_rack1').id
        device1_id = Device.objects.get(device_vendor='Test_vendor3').id
        device2_id = Device.objects.get(device_vendor='Test_vendor4').id
        result = RackLayoutService.get_rowspans(pk, False)
        self.assertEqual(result, {device2_id: 1, device1_id: 2})

    @classmethod
    def tearDownClass(cls):
        pass

class TestUserCheckService(TestCase):
    """
    Testing services for checking user permissions
    """

    @classmethod
    def setUpClass(cls):
        base_setup()

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

    @classmethod
    def tearDownClass(cls):
        pass


class TestUniqueCheckService(TestCase):
    """
    Testing services for checking unique names
    """

    @classmethod
    def setUpClass(cls):
        base_setup()
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

    def test_get_unique_device_vendors(self):
        # Device vendors
        result = UniqueCheckService.get_unique_device_vendors()
        self.assertEqual(result, [
            'Test_vendor1',
            'Test_vendor2',
            'Test_vendor3',
            'Test_vendor4',
            'Test_vendor5',
            'Test_vendor6',
            'Test_vendor7',
            'Test_vendor8',
        ])

    def test_get_unique_device_models(self):
        # Device models
        result = UniqueCheckService.get_unique_device_models()
        self.assertEqual(result, [
            'Test_model1',
            'Test_model2',
            'Test_model3',
            'Test_model4',
            'Test_model5',
            'Test_model6',
            'Test_model7',
            'Test_model8',
        ])

    def test_get_unique_rack_vendors(self):
        # Rack vendors
        result = UniqueCheckService.get_unique_rack_vendors()
        self.assertEqual(result, [
            'Test_vendor1',
            'Test_vendor2',
        ])

    def test_get_unique_rack_models(self):
        # Rack models
        result = UniqueCheckService.get_unique_rack_models()
        self.assertEqual(result, [
            'Test_model1',
            'Test_model2',
        ])

    @classmethod
    def tearDownClass(cls):
        pass


class TestDeviceCheckService(TestCase):
    """
    Testing services for device add|upadate capabilities
    """

    @classmethod
    def setUpClass(cls):
        base_setup()

    def test_get_old_units(self):
        # Device with Test_vendor1
        device1_id = Device.objects.get(device_vendor='Test_vendor1').id
        result = DeviceCheckService.get_old_units(device1_id)
        self.assertEqual(result, {'old_first_unit': 1, 'old_last_unit': 2})

    def test_get_new_units(self):
        result = DeviceCheckService.get_new_units(7, 5)
        self.assertEqual(result, {'new_first_unit': 5, 'new_last_unit': 7})

    def test_get_all_units(self):
        # Rack - Test_rack1
        rack1_id = Rack.objects.get(rack_name='Test_rack1').id
        result = DeviceCheckService.get_all_units(rack1_id)
        self.assertEqual(result, {'all_units': 40})

    def test_check_unit_exist(self):
        result = DeviceCheckService.check_unit_exist({
            'new_first_unit': 39,
            'new_last_unit': 42,
            'all_units': 40,
        })
        self.assertTrue(result)

        result = DeviceCheckService.check_unit_exist({
            'new_first_unit': 21,
            'new_last_unit': 22,
            'all_units': 40,
        })
        self.assertFalse(result)

    def test_check_unit_busy(self):
        # Rack - Test_rack1
        # Side - Front (True)
        # update = False
        pk = Rack.objects.get(rack_name='Test_rack1').id
        units = {'new_first_unit': 5, 'new_last_unit': 6}
        result = DeviceCheckService.check_unit_busy(True, units, pk, False)
        self.assertTrue(result)

        units = {'new_first_unit': 7, 'new_last_unit': 9}
        result = DeviceCheckService.check_unit_busy(True, units, pk, False)
        self.assertFalse(result)

        # Rack - Test_rack1
        # Side - Back (False)
        # update = False
        units = {'new_first_unit': 2, 'new_last_unit': 3}
        result = DeviceCheckService.check_unit_busy(False, units, pk, False)
        self.assertTrue(result)

        units = {'new_first_unit': 10, 'new_last_unit': 12}
        result = DeviceCheckService.check_unit_busy(False, units, pk, False)
        self.assertFalse(result)

        # Rack - Test_rack1
        # Side - Front (True)
        # update = True
        units = {
            'new_first_unit': 4,
            'new_last_unit': 5,
            'old_first_unit': 1,
            'old_last_unit': 2,
        }
        result = DeviceCheckService.check_unit_busy(True, units, pk, True)
        self.assertTrue(result)

        units = {
            'new_first_unit': 2,
            'new_last_unit': 3,
            'old_first_unit': 1,
            'old_last_unit': 2,
        }
        result = DeviceCheckService.check_unit_busy(True, units, pk, True)
        self.assertFalse(result)

        # Rack - Test_rack1
        # Side - Back (False)
        # update = True
        units = {
            'new_first_unit': 7,
            'new_last_unit': 8,
            'old_first_unit': 3,
            'old_last_unit': 4,
        }
        result = DeviceCheckService.check_unit_busy(False, units, pk, True)
        self.assertTrue(result)

        units = {
            'new_first_unit': 10,
            'new_last_unit': 11,
            'old_first_unit': 3,
            'old_last_unit': 4,
        }
        result = DeviceCheckService.check_unit_busy(False, units, pk, True)
        self.assertFalse(result)

    @classmethod
    def tearDownClass(cls):
        pass

class TestQrService(TestCase):
    """
    Testing services for QRs
    """

    @classmethod
    def setUpClass(cls):
        base_setup()

    def test_get_img_name(self):
        # Device with Test_vendor1
        device1_id = Device.objects.get(device_vendor='Test_vendor1').id
        result = QrService.get_img_name(device1_id, True)
        self.assertEqual(result, '/device_qr/d-' + str(device1_id) + '.png')

        # Rack with Test_vendor1
        rack1_id = Rack.objects.get(rack_vendor='Test_vendor1').id
        result = QrService.get_img_name(rack1_id, False)
        self.assertEqual(result, '/rack_qr/r-' + str(rack1_id) + '.png')

    def test_get_qr_data(self):
        url = 'http://127.0.0.1:8000/'
        # Device with Test_vendor1
        device1_id = Device.objects.get(device_vendor='Test_vendor1').id
        result = QrService.get_qr_data(device1_id, True, url)
        self.assertEqual(result, url + 'device_detail/' + str(device1_id))

        # Rack with Test_vendor1
        rack1_id = Rack.objects.get(rack_vendor='Test_vendor1').id
        result = QrService.get_qr_data(rack1_id, False, url)
        self.assertEqual(result, url + 'rack_detail/' + str(device1_id))

    @classmethod
    def tearDownClass(cls):
        pass


class TestDraftService(TestCase):
    """
    Testing services for printing drafts
    """

    def test_get_side_name(self):
        result = DraftService.get_side_name(True)
        self.assertEqual(result, 'FRONT SIDE')

        result = DraftService.get_side_name(False)
        self.assertEqual(result, 'BACK SIDE')

    def test_get_font_size(self):
        result = DraftService.get_font_size(20)
        self.assertEqual(result, '100')

        result = DraftService.get_font_size(40)
        self.assertEqual(result, '75')

        result = DraftService.get_font_size(60)
        self.assertEqual(result, '50')


class TestReportService(TestCase):
    """
    Testing report services
    """

    def test_get_header_list(self):
        # Racks
        result = ReportService.get_header_list('rack')
        self.assertEqual(result, ReportHeaders.racks_header_list)

        # Devices
        result = ReportService.get_header_list('device')
        self.assertEqual(result, ReportHeaders.devices_header_list)

        # Room
        with self.assertRaises(ValueError):
            ReportService.get_header_list('room')

    def test_get_devices_data(self):
        result = ReportService.get_devices_data('address')
        self.assertEqual(type(result), list)

    def test_get_racks_data(self):
        result = ReportService.get_racks_data('address')
        self.assertEqual(type(result), list)

    def test_get_device_stack(self):
        device_link = 'device_link'
        device_stack = 10
        result = ReportService.get_device_stack(device_link, device_stack)
        self.assertEqual(result, device_link + str(device_stack))

        device_stack = None
        result = ReportService.get_device_stack(device_link, device_stack)
        self.assertEqual(result, None)
