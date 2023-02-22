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


class TestCheckProps(TestCase):

    @classmethod
    def setUpClass(cls):
        Setup.base_setup()

    def test_NamesList(self):
        pk = Room.objects.get(room_name='Test_room1').id
        result = NamesList(pk, Rack).names_list
        self.assertEqual(result, {'Test_rack1', 'Test_rack3'})

    @classmethod
    def tearDownClass(cls):
        pass
