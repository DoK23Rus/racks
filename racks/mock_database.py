"""
Mock database setup for E2E testing
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
Region.objects.create(name='Test region')
Region.objects.get_or_create(name='Another test region')
region1_id = Region.objects.get(name='Test region')
Department.objects.get_or_create(name='Test department',
                                 region_id=region1_id)
Department.objects.get_or_create(name='Some other department',
                                 region_id=region1_id)
department1_id = Department.objects.get(name='Test department')
Site.objects.get_or_create(name='Test site',
                           updated_by='tester',
                           department_id=department1_id)
site1_id = Site.objects.get(name='Test site')
Building.objects.get_or_create(name='Test building',
                               updated_by='tester',
                               site_id=site1_id)
building1_id = Building.objects.get(name='Test building')
Room.objects.get_or_create(name='Test room',
                           updated_by='tester',
                           building_id=building1_id)
room1_id = Room.objects.get(name='Test room')
Rack.objects.get_or_create(name='Test rack №1',
                           amount=42,
                           vendor='ITK',
                           model='ZPAS',
                           description='Telecom rack',
                           responsible='Иванов И. И.',
                           financially_responsible_person='Иванов И. И.',
                           inventory_number='12341234787',
                           row='1',
                           place='3',
                           height=2000,
                           width=600,
                           depth=1360,
                           unit_width=19,
                           unit_depth=580,
                           max_load=1360,
                           power_sockets=3,
                           power_sockets_ups=2,
                           cooler=True,
                           updated_by='tester',
                           room_id=room1_id)
Rack.objects.get_or_create(name='Test rack №2',
                           amount=22,
                           row='2',
                           place='2',
                           updated_by='tester',
                           room_id=room1_id)
rack1_id = Rack.objects.get(name='Test rack №1')
rack2_id = Rack.objects.get(name='Test rack №2')
Device.objects.get_or_create(first_unit=41,
                             last_unit=41,
                             type='RJ45 patch panel',
                             updated_by='tester',
                             rack_id=rack1_id)
Device.objects.get_or_create(first_unit=35,
                             last_unit=36,
                             type='Switch',
                             vendor='Cisco',
                             model='2911',
                             power_w=200,
                             updated_by='tester',
                             rack_id=rack1_id)
Device.objects.get_or_create(first_unit=5,
                             last_unit=6,
                             frontside_location=False,
                             type='UPC',
                             vendor='APC',
                             model='back-UPS',
                             inventory_number='123456789023',
                             updated_by='tester',
                             rack_id=rack1_id)
Device.objects.get_or_create(first_unit=38,
                             last_unit=38,
                             status='Device failed',
                             type='Switch',
                             vendor='Defective',
                             model='switch',
                             updated_by='tester',
                             rack_id=rack1_id)
Device.objects.get_or_create(first_unit=42,
                             last_unit=42,
                             type='Switch',
                             vendor='Provider',
                             model='switch',
                             ownership='Оборудование оператора',
                             responsible='Петров',
                             updated_by='tester',
                             rack_id=rack1_id)
Device.objects.get_or_create(first_unit=39,
                             last_unit=39,
                             type='Switch',
                             vendor='Cisco',
                             model='2960',
                             hostname='Switch_SW1f_1',
                             ip='192.168.15.74',
                             ports_amout=24,
                             version='12.2',
                             power_w=450,
                             power_v=220,
                             serial_number='JAF1710BBPJ',
                             description='First floor access switch',
                             project='Tech-refresh (2019)',
                             responsible='Some engineer',
                             financially_responsible_person=('Some other '
                                                             'engineer'),
                             inventory_number='1234567890',
                             fixed_asset='Cisco Catalyst 2960',
                             link='F:\\Accerts\\devices.doc',
                             updated_by='tester',
                             rack_id=rack1_id)
Device.objects.get_or_create(first_unit=2,
                             last_unit=4,
                             type='UPS',
                             updated_by='tester',
                             rack_id=rack2_id)
