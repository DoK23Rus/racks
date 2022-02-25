import unittest
import datetime
from django.test import TestCase
from django.db import connection
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
    _regions,
    _departments,
    _sites,
    _buildings,
    _rooms,
    _racks,
    _devices,
    _device,
    _rack,
    _direction,
    _rack_id,
    _start_list,
    _first_units,
    _spans,
    _old_units,
    _new_units,
    _all_units,
    _group_check,
    _unit_exist_check,
    _unit_busy_check,
    _unique_list,
    _header,
    _side_name,
    _font_size,
    _rack_name,
    _device_stack,
    _frontside_location,
    _numbering,
    _external_ups,
    _cooler,
    _date,
    _devices_list,
    _devices_all,
    _device_vendors,
    _device_models,
    _rack_vendors,
    _rack_models,
)


class ServicesTestCase(TestCase):

    @classmethod
    def setUpClass(self):
        Region.objects.create(region_name='Test_region1')
        Region.objects.create(region_name='Test_region2')
        Department.objects.create(department_name='Test_department1',
                                  region_id=Region.objects \
                                  .get(region_name='Test_region1'))
        Department.objects.create(department_name='Test_department2',
                                  region_id=Region.objects \
                                  .get(region_name='Test_region2'))
        Site.objects.create(site_name='Test_site1',
                            department_id=Department.objects \
                            .get(department_name='Test_department1'))
        Site.objects.create(site_name='Test_site2',
                            department_id=Department.objects \
                            .get(department_name='Test_department2'))
        Building.objects.create(building_name='Test_building1',
                                site_id=Site.objects \
                                .get(site_name='Test_site1'))
        Building.objects.create(building_name='Test_building2',
                                site_id=Site.objects \
                                .get(site_name='Test_site2'))
        Room.objects.create(room_name='Test_room1',
                            building_id=Building.objects \
                            .get(building_name='Test_building1'))
        Room.objects.create(room_name='Test_room2',
                            building_id=Building.objects \
                            .get(building_name='Test_building2'))
        Rack.objects.create(rack_name='Test_rack1',
                            rack_amount=40, 
                            room_id=Room.objects \
                            .get(room_name='Test_room1'))
        Rack.objects.create(rack_name='Test_rack2',
                            rack_amount=40, 
                            numbering_from_bottom_to_top=False,
                            room_id=Room.objects \
                            .get(room_name='Test_room2'))
        Device.objects.create(first_unit=2,
                              last_unit=1,
                              device_vendor='Test_vendor1',
                              rack_id=Rack.objects \
                              .get(rack_name='Test_rack1'))
        Device.objects.create(first_unit=5,
                              last_unit=5,
                              device_vendor='Test_vendor2',
                              rack_id=Rack.objects \
                              .get(rack_name='Test_rack1'))
        Device.objects.create(first_unit=4,
                              last_unit=3,
                              frontside_location=False,
                              device_vendor='Test_vendor3',
                              rack_id=Rack.objects \
                              .get(rack_name='Test_rack1'))
        Device.objects.create(first_unit=7,
                              last_unit=7,
                              frontside_location=False,
                              device_vendor='Test_vendor4',
                              rack_id=Rack.objects \
                              .get(rack_name='Test_rack1'))
        Device.objects.create(first_unit=11,
                              last_unit=12,
                              device_vendor='Test_vendor5',
                              rack_id=Rack.objects \
                              .get(rack_name='Test_rack2'))
        Device.objects.create(first_unit=15,
                              last_unit=15,
                              device_vendor='Test_vendor6',
                              rack_id=Rack.objects \
                              .get(rack_name='Test_rack2'))
        Device.objects.create(first_unit=14,
                              last_unit=13,
                              frontside_location=False,
                              device_vendor='Test_vendor7',
                              rack_id=Rack.objects \
                              .get(rack_name='Test_rack2'))
        Device.objects.create(first_unit=18,
                              last_unit=18,
                              frontside_location=False,
                              device_vendor='Test_vendor8',
                              rack_id=Rack.objects \
                              .get(rack_name='Test_rack2'))
    
    @classmethod
    def tearDownClass(self):
        pass
    
    def test_regions(self):
        self.assertEqual(set(_regions() \
                         .values_list('region_name', flat=True)), 
                         {'Test_region1', 'Test_region2'})

    def test_departments(self):
        self.assertEqual(set(_departments() \
                         .values_list('department_name', flat=True)), 
                         {'Test_department1', 'Test_department2'})

    def test_sites(self):
        self.assertEqual(set(_sites() \
                         .values_list('site_name', flat=True)), 
                         {'Test_site1', 'Test_site2'})

    def test_buildings(self):
        self.assertEqual(set(_buildings() \
                         .values_list('building_name', flat=True)), 
                         {'Test_building1', 'Test_building2'})

    def test_rooms(self):
        self.assertEqual(set(_rooms() \
                         .values_list('room_name', flat=True)), 
                         {'Test_room1', 'Test_room2'})

    def test_racks(self):
        self.assertEqual(set(_racks() \
                         .values_list('rack_name', flat=True)), 
                         {'Test_rack1', 'Test_rack2'})

    def test_device(self):
        self.assertEqual(_device(Device.objects \
            .get(device_vendor='Test_vendor1').id).first_unit, 2)

    def test_rack(self):
        self.assertEqual(_rack(Rack.objects \
            .get(rack_name='Test_rack1').id).rack_name, 'Test_rack1')

    def test_direction(self):
        self.assertFalse(_direction(Rack.objects \
            .get(rack_name='Test_rack2').id))

    def test_devices(self):
        self.assertEqual(set(_devices(Rack.objects
                         .get(rack_name='Test_rack1'), True) \
                         .values_list('device_vendor', flat=True)), 
                         {'Test_vendor1', 'Test_vendor2'})
        self.assertEqual(set(_devices(Rack.objects
                         .get(rack_name='Test_rack1'), False) \
                         .values_list('device_vendor', flat=True)), 
                         {'Test_vendor3', 'Test_vendor4'})

    def test_rack_id(self):
        self.assertEqual(_rack_id(Device.objects \
            .get(device_vendor='Test_vendor1').id), 
            Rack.objects.get(rack_name='Test_rack1').id)

    def test_rack_name(self):
        self.assertEqual(_rack_name(Rack.objects
                         .get(rack_name='Test_rack1').id), 'Test_rack1')

    def test_start_list(self):
        pk = Rack.objects.get(rack_name='Test_rack1').id
        direction = Rack.objects.get(id=pk).numbering_from_bottom_to_top
        self.assertEqual(_start_list(pk, direction), list(range(1,41))[::-1])
        pk = Rack.objects.get(rack_name='Test_rack2').id
        direction = Rack.objects.get(id=pk).numbering_from_bottom_to_top
        self.assertEqual(_start_list(pk, direction), list(range(1,41)))

    def test_first_units(self):
        pk = Rack.objects.get(rack_name='Test_rack1').id
        direction = Rack.objects.get(id=pk).numbering_from_bottom_to_top
        device1_id = Device.objects.get(device_vendor='Test_vendor1').id
        device2_id = Device.objects.get(device_vendor='Test_vendor2').id 
        self.assertEqual(_first_units(pk, direction, True), 
                         {device2_id: 5, device1_id: 2})
        pk = Rack.objects.get(rack_name='Test_rack1').id
        direction = Rack.objects.get(id=pk).numbering_from_bottom_to_top
        device1_id = Device.objects.get(device_vendor='Test_vendor3').id
        device2_id = Device.objects.get(device_vendor='Test_vendor4').id
        self.assertEqual(_first_units(pk, direction, False), 
                         {device2_id: 7, device1_id: 4})
        pk = Rack.objects.get(rack_name='Test_rack2').id
        direction = Rack.objects.get(id=pk).numbering_from_bottom_to_top
        device1_id = Device.objects.get(device_vendor='Test_vendor5').id
        device2_id = Device.objects.get(device_vendor='Test_vendor6').id
        self.assertEqual(_first_units(pk, direction, True), 
                         {device1_id: 11, device2_id: 15})
        pk = Rack.objects.get(rack_name='Test_rack2').id
        direction = Rack.objects.get(id=pk).numbering_from_bottom_to_top
        device1_id = Device.objects.get(device_vendor='Test_vendor7').id
        device2_id = Device.objects.get(device_vendor='Test_vendor8').id
        self.assertEqual(_first_units(pk, direction, False), 
                         {device1_id: 13, device2_id: 18})

    def test_spans(self):
        pk = Rack.objects.get(rack_name='Test_rack1').id
        device1_id = Device.objects.get(device_vendor='Test_vendor1').id
        device2_id = Device.objects.get(device_vendor='Test_vendor2').id
        self.assertEqual(_spans(pk, True), {device2_id: 1, device1_id: 2})
        pk = Rack.objects.get(rack_name='Test_rack1').id
        device1_id = Device.objects.get(device_vendor='Test_vendor3').id
        device2_id = Device.objects.get(device_vendor='Test_vendor4').id
        self.assertEqual(_spans(pk, False), {device2_id: 1, device1_id: 2})

    def test_group_check(self):
        self.assertTrue(_group_check(['Test_department1'], Department.objects \
            .get(department_name='Test_department1').id, Department))
        self.assertTrue(_group_check(['Test_department1'], Site.objects \
            .get(site_name='Test_site1').id, Site))
        self.assertTrue(_group_check(['Test_department1'], Building.objects \
            .get(building_name='Test_building1').id, Building))
        self.assertTrue(_group_check(['Test_department1'], Room.objects \
            .get(room_name='Test_room1').id, Room))
        self.assertTrue(_group_check(['Test_department1'], Rack.objects \
            .get(rack_name='Test_rack1').id, Rack))
        self.assertTrue(_group_check(['Test_department1'], Device.objects \
            .get(device_vendor='Test_vendor1').id, Device))
        self.assertFalse(_group_check(['Test_department2'], Department.objects \
            .get(department_name='Test_department1').id, Department))
        self.assertFalse(_group_check(['Test_department2'], Site.objects \
            .get(site_name='Test_site1').id, Site))
        self.assertFalse(_group_check(['Test_department2'], Building.objects \
            .get(building_name='Test_building1').id, Building))
        self.assertFalse(_group_check(['Test_department2'], Room.objects \
            .get(room_name='Test_room1').id, Room))
        self.assertFalse(_group_check(['Test_department2'], Rack.objects \
            .get(rack_name='Test_rack1').id, Rack))
        self.assertFalse(_group_check(['Test_department2'], Device.objects \
            .get(device_vendor='Test_vendor1').id, Device))

    def test_old_units(self):
        self.assertEqual(_old_units(Device.objects \
                         .get(device_vendor='Test_vendor1').id), 
                         {'old_first_unit': 1, 'old_last_unit': 2})

    def test_new_units(self):
        self.assertEqual(_new_units(7, 5), 
                         {'new_first_unit': 5, 'new_last_unit': 7})

    def test_all_units(self):
        self.assertEqual(_all_units(Rack.objects \
            .get(rack_name='Test_rack1').id), {'all_units': 40})

    def test_unit_exist_check(self):
        self.assertTrue(_unit_exist_check({
            'new_first_unit': 39, 
            'new_last_unit': 42, 
            'all_units': 40,
        }))
        self.assertFalse(_unit_exist_check({
            'new_first_unit': 21, 
            'new_last_unit': 22, 
            'all_units': 40,
        }))

    def test_unit_busy_check(self):
        pk = Rack.objects.get(rack_name='Test_rack1').id
        units = {'new_first_unit': 5, 'new_last_unit': 6}
        self.assertTrue(_unit_busy_check(True, units, pk, False))
        units = {'new_first_unit': 7, 'new_last_unit': 9}
        self.assertFalse(_unit_busy_check(True, units, pk, False))
        units = {'new_first_unit': 2, 'new_last_unit': 3}
        self.assertTrue(_unit_busy_check(False, units, pk, False))
        units = {'new_first_unit': 10, 'new_last_unit': 12}
        self.assertFalse(_unit_busy_check(False, units, pk, False))
        units = {
            'new_first_unit': 4, 
            'new_last_unit': 5,
            'old_first_unit': 1,
            'old_last_unit': 2,
        }
        self.assertTrue(_unit_busy_check(True, units, pk, True))
        units = {
            'new_first_unit': 2, 
            'new_last_unit': 3,
            'old_first_unit': 1,
            'old_last_unit': 2,
        }
        self.assertFalse(_unit_busy_check(True, units, pk, True))
        units = {
            'new_first_unit': 7, 
            'new_last_unit': 8,
            'old_first_unit': 3,
            'old_last_unit': 4,
        }
        self.assertTrue(_unit_busy_check(False, units, pk, True))
        units = {
            'new_first_unit': 10, 
            'new_last_unit': 11,
            'old_first_unit': 3,
            'old_last_unit': 4,
        }
        self.assertFalse(_unit_busy_check(False, units, pk, True))

    def test_unique_list(self):
        self.assertEqual(_unique_list(Site.objects \
            .get(site_name='Test_site1').id, Site), ['Test_building1'])
        self.assertEqual(_unique_list(Building.objects \
            .get(building_name='Test_building1').id, Building), ['Test_room1'])
        self.assertEqual(_unique_list(Room.objects \
            .get(room_name='Test_room1').id, Room), ['Test_rack1'])

    def test_device_stack(self):
        device_link = 'http://127.0.0.1:80001/device_detail/'
        self.assertEqual(_device_stack(device_link, 3457), 
                         'http://127.0.0.1:80001/device_detail/3457')
        self.assertEqual(_device_stack(device_link, None), None)

    def test_frontside_location(self):
        self.assertEqual(_frontside_location(True), 'Да')
        self.assertEqual(_frontside_location(False), 'Нет')

    def test_numbering(self):
        self.assertEqual(_numbering(True), 'Да')
        self.assertEqual(_numbering(False), 'Нет')

    def test_external_ups(self):
        self.assertEqual(_external_ups(True), 'Да')
        self.assertEqual(_external_ups(False), 'Нет')

    def test_cooler(self):
        self.assertEqual(_cooler(True), 'Да')
        self.assertEqual(_cooler(False), 'Нет')

    def test_header(self):
        pk = Rack.objects.get(rack_name='Test_rack1').id
        with connection.cursor() as cursor:
            cursor.execute(_header(pk).query.__str__())
            row = cursor.fetchone()
            self.assertEqual(row, (
                Rack.objects.get(rack_name='Test_rack1').id, 
                'Test_rack1', 
                'Test_room1', 
                'Test_building1', 
                'Test_site1', 
                'Test_department1', 
                'Test_region1'
            ))

    def test_side_name(self):
        self.assertEqual(_side_name('True'), 'Фронтальная сторона стойки')
        self.assertEqual(_side_name('False'), 'Тыльная сторона стойки')

    def test_font_size(self):
        self.assertEqual(_font_size(20), '100')
        self.assertEqual(_font_size(40), '75')
        self.assertEqual(_font_size(60), '50')

    def test_date(self):
        self.assertEqual(_date(), 
            datetime.datetime.today().strftime("%Y-%m-%d"))

    def test_devices_list(self):
        pk = Rack.objects.get(rack_name='Test_rack1').id 
        self.assertEqual(set(_devices_list(pk)), set(Device.objects. \
            filter(rack_id_id=pk).values_list('id', flat=True)))

    def test_devices_all(self):
        pk = Rack.objects.get(rack_name='Test_rack1').id 
        self.assertEqual(set(_devices_all(pk).values_list('id', flat=True)), 
            set(Device.objects. \
            filter(rack_id_id=pk).values_list('id', flat=True)))

    def test_device_vendors(self):
        vendors = list(Device.objects. \
            values_list('device_vendor', flat=True).distinct())
        vendors.sort()
        self.assertEqual(_device_vendors(), vendors)

    def test_device_models(self):
        models = list(Device.objects. \
            values_list('device_model', flat=True).distinct())
        models.sort()
        self.assertEqual(_device_models(), models)

    def test_rack_vendors(self):
        vendors = list(Rack.objects. \
            values_list('rack_vendor', flat=True).distinct())
        vendors.sort()
        self.assertEqual(_rack_vendors(), vendors)

    def test_rack_models(self):
        models = list(Rack.objects. \
            values_list('rack_model', flat=True).distinct())
        models.sort()
        self.assertEqual(_rack_models(), models)