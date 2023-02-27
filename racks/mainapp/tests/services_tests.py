"""
Tests for services
"""
import datetime

from django.test import TestCase

from mainapp.models import Rack, Device
from mainapp.services import (DeviceCheckService,
                              DataProcessingService,
                              UnitsTuple,
                              ReportService,
                              date)
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
    """
    Test DeviceCheckService
    """

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
    """
    Test DataProcessingService
    """

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
