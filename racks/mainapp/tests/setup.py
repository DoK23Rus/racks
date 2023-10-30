"""
Database setup
"""
from mainapp.models import (Region,
                            Department,
                            Site,
                            Building,
                            Room,
                            Rack,
                            Device)


class Setup:

    @staticmethod
    def base_setup():
        """
        DB setup
        """
        Region.objects.get_or_create(name='Test_region1')
        Region.objects.get_or_create(name='Test_region2')
        region1_id = Region.objects.get(name='Test_region1')
        Department.objects.get_or_create(name='Test_department1',
                                         region_id=region1_id)
        region2_id = Region.objects.get(name='Test_region2')
        Department.objects.get_or_create(name='Test_department2',
                                         region_id=region2_id)
        department1_id = Department.objects.get(name='Test_department1')
        Site.objects.get_or_create(name='Test_site1',
                                   department_id=department1_id)
        department2_id = Department.objects.get(name='Test_department2')
        Site.objects.get_or_create(name='Test_site2',
                                   department_id=department2_id)
        site1_id = Site.objects.get(name='Test_site1')
        Building.objects.get_or_create(name='Test_building1',
                                       site_id=site1_id)
        site2_id = Site.objects.get(name='Test_site2')
        Building.objects.get_or_create(name='Test_building2',
                                       site_id=site2_id)
        building1_id = Building.objects.get(name='Test_building1')
        Room.objects.get_or_create(name='Test_room1',
                                   building_id=building1_id)
        building2_id = Building.objects.get(name='Test_building2')
        Room.objects.get_or_create(name='Test_room2',
                                   building_id=building2_id)
        room1_id = Room.objects.get(name='Test_room1')
        Rack.objects.get_or_create(name='Test_rack1',
                                   amount=40,
                                   model='Test_model1',
                                   vendor='Test_vendor1',
                                   room_id=room1_id)
        Rack.objects.get_or_create(name='Test_rack3',
                                   amount=40,
                                   model='Test_model3',
                                   vendor='Test_vendor3',
                                   room_id=room1_id)
        room2_id = Room.objects.get(name='Test_room2')
        Rack.objects.get_or_create(name='Test_rack2',
                                   amount=20,
                                   model='Test_model2',
                                   vendor='Test_vendor2',
                                   has_numbering_from_bottom_to_top=False,
                                   room_id=room2_id)
        rack1_id = Rack.objects.get(name='Test_rack1')
        Device.objects.get_or_create(first_unit=2,
                                     last_unit=1,
                                     vendor='Test_vendor1',
                                     model='Test_model1',
                                     power_w=100,
                                     rack_id=rack1_id)
        Device.objects.get_or_create(first_unit=5,
                                     last_unit=5,
                                     vendor='Test_vendor2',
                                     model='Test_model2',
                                     power_w=200,
                                     rack_id=rack1_id)
        Device.objects.get_or_create(first_unit=3,
                                     last_unit=4,
                                     has_frontside_location=False,
                                     vendor='Test_vendor3',
                                     model='Test_model3',
                                     power_w=50,
                                     rack_id=rack1_id)
        Device.objects.get_or_create(first_unit=7,
                                     last_unit=7,
                                     has_frontside_location=False,
                                     vendor='Test_vendor4',
                                     model='Test_model4',
                                     rack_id=rack1_id)
        rack2_id = Rack.objects.get(name='Test_rack2')
        Device.objects.get_or_create(first_unit=11,
                                     last_unit=12,
                                     vendor='Test_vendor5',
                                     model='Test_model5',
                                     rack_id=rack2_id)
        Device.objects.get_or_create(first_unit=15,
                                     last_unit=15,
                                     vendor='Test_vendor6',
                                     model='Test_model6',
                                     rack_id=rack2_id)
        Device.objects.get_or_create(first_unit=14,
                                     last_unit=13,
                                     has_frontside_location=False,
                                     vendor='Test_vendor7',
                                     model='Test_model7',
                                     rack_id=rack2_id)
        Device.objects.get_or_create(first_unit=18,
                                     last_unit=18,
                                     has_frontside_location=False,
                                     vendor='Test_vendor8',
                                     model='Test_model8',
                                     rack_id=rack2_id)
        Device.objects.get_or_create(first_unit=17,
                                     last_unit=17,
                                     vendor='Test_vendor9',
                                     has_frontside_location=False,
                                     rack_id=rack2_id)
        Device.objects.get_or_create(first_unit=19,
                                     last_unit=19,
                                     model='Test_model10',
                                     has_frontside_location=False,
                                     rack_id=rack2_id)
        Device.objects.get_or_create(first_unit=20,
                                     last_unit=20,
                                     has_frontside_location=False,
                                     rack_id=rack2_id)
