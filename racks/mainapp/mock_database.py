"""
Mock database setup for E2E and API testing
"""
from mainapp.models import (
    Region,
    Department,
    Site,
    Building,
    Room,
    Rack,
    Device,
)

Region.objects.all().delete()
Region.objects.create(region_name='Test region')
Region.objects.get_or_create(region_name='Another test region')
region1_id = Region.objects.get(region_name='Test region')
Department.objects.get_or_create(department_name='Test department',
                                 region_id=region1_id)
Department.objects.get_or_create(department_name='Some other department',
                                 region_id=region1_id)
department1_id = Department.objects.get(department_name='Test department')
Site.objects.get_or_create(site_name='Test site',
                           updated_by='tester',
                           department_id=department1_id)
site1_id = Site.objects.get(site_name='Test site')
Building.objects.get_or_create(building_name='Test building',
                               updated_by='tester',
                               site_id=site1_id)
building1_id = Building.objects.get(building_name='Test building')
Room.objects.get_or_create(room_name='Test room',
                           updated_by='tester',
                           building_id=building1_id)
room1_id = Room.objects.get(room_name='Test room')
Rack.objects.get_or_create(rack_name='Test rack №1',
                           rack_amount=42,
                           rack_vendor='ITK',
                           rack_model='ZPAS',
                           rack_description='Telecom rack',
                           responsible='Иванов И. И.',
                           rack_financially_responsible_person='Иванов И. И.',
                           rack_inventory_number='12341234787',
                           row='1',
                           place='3',
                           rack_height=2000,
                           rack_width=600,
                           rack_depth=1360,
                           rack_unit_width=19,
                           rack_unit_depth=580,
                           max_load=1360,
                           power_sockets=3,
                           power_sockets_ups=2,
                           cooler=True,
                           updated_by='tester',
                           room_id=room1_id)
Rack.objects.get_or_create(rack_name='Test rack №2',
                           rack_amount=22,
                           row='2',
                           place='2',
                           updated_by='tester',
                           room_id=room1_id)
rack1_id = Rack.objects.get(rack_name='Test rack №1')
rack2_id = Rack.objects.get(rack_name='Test rack №2')
Device.objects.get_or_create(first_unit=41,
                             last_unit=41,
                             device_type='RJ45 patch panel',
                             updated_by='tester',
                             rack_id=rack1_id)
Device.objects.get_or_create(first_unit=35,
                             last_unit=36,
                             device_type='Switch',
                             device_vendor='Cisco',
                             device_model='2911',
                             updated_by='tester',
                             rack_id=rack1_id)
Device.objects.get_or_create(first_unit=5,
                             last_unit=6,
                             frontside_location=False,
                             device_type='UPC',
                             device_vendor='APC',
                             device_model='back-UPS',
                             device_inventory_number='123456789023',
                             updated_by='tester',
                             rack_id=rack1_id)
Device.objects.get_or_create(first_unit=38,
                             last_unit=38,
                             status='Device failed',
                             device_type='Switch',
                             device_vendor='Defective',
                             device_model='switch',
                             updated_by='tester',
                             rack_id=rack1_id)
Device.objects.get_or_create(first_unit=42,
                             last_unit=42,
                             device_type='Switch',
                             device_vendor='Provider',
                             device_model='switch',
                             ownership='Оборудование оператора',
                             responsible='Петров',
                             updated_by='tester',
                             rack_id=rack1_id)
Device.objects.get_or_create(first_unit=39,
                             last_unit=39,
                             device_type='Switch',
                             device_vendor='Cisco',
                             device_model='2960',
                             device_hostname='Switch_SW1f_1',
                             ip='192.168.15.74',
                             ports_amout=24,
                             version='12.2',
                             power_w=450,
                             power_v=220,
                             device_serial_number='JAF1710BBPJ',
                             device_description='First floor access switch',
                             project='Tech-refresh (2019)',
                             responsible='Some engineer',
                             financially_responsible_person=('Some other '
                                                             'engineer'),
                             device_inventory_number='1234567890',
                             fixed_asset='Cisco Catalyst 2960',
                             link='F:\\Accerts\\devices.doc',
                             updated_by='tester',
                             rack_id=rack1_id)
Device.objects.get_or_create(first_unit=2,
                             last_unit=4,
                             device_type='UPS',
                             updated_by='tester',
                             rack_id=rack2_id)
