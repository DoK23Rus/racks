from django.test import TestCase
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
    _export_devices,
    _export_racks,
    _header,
    _side_name,
    _font_size,
    _rack_name,
)


class ServicesTestCase(TestCase):
    def setUp(self):
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
                            .get(building_name='Test_building1'))
        Rack.objects.create(rack_name='Test_rack1',
                            rack_amount=40, 
                            room_id=Room.objects \
                            .get(room_name='Test_room1'))
        Rack.objects.create(rack_name='Test_rack2',
                            rack_amount=40, 
                            numbering_from_bottom_to_top=False,
                            room_id=Room.objects \
                            .get(room_name='Test_room2'))
        Device.objects.create(first_unit=20,
                              last_unit=21,
                              device_vendor='Test_vendor',
                              rack_id=Rack.objects \
                              .get(rack_name='Test_rack1'))

    def test_regions(self):
        self.assertEqual(list(_regions() \
                         .values_list('region_name', flat=True)), 
                         ['Test_region1', 'Test_region2'])

    def test_departments(self):
        self.assertEqual(list(_departments() \
                         .values_list('department_name', flat=True)), 
                         ['Test_department1', 'Test_department2'])

    def test_sites(self):
        self.assertEqual(list(_sites() \
                         .values_list('site_name', flat=True)), 
                         ['Test_site1', 'Test_site2'])

    def test_buildings(self):
        self.assertEqual(list(_buildings() \
                         .values_list('building_name', flat=True)), 
                         ['Test_building1', 'Test_building2'])

    def test_rooms(self):
        self.assertEqual(list(_rooms() \
                         .values_list('room_name', flat=True)), 
                         ['Test_room1', 'Test_room2'])

    def test_racks(self):
        self.assertEqual(list(_racks() \
                         .values_list('rack_name', flat=True)), 
                         ['Test_rack1', 'Test_rack2'])

    def test_device(self):
        self.assertEqual(_device(Device.objects \
            .get(device_vendor='Test_vendor').id).first_unit, 20)

    def test_rack(self):
        self.assertEqual(_rack(Rack.objects \
            .get(rack_name='Test_rack1').id).rack_name, 'Test_rack1')
