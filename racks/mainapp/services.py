import datetime
from django.db import models
from .models import (
    Region, 
    Department, 
    Site, 
    Building, 
    Room, 
    Rack, 
    Device,
)


def _regions():
    """
    All regions
    """
    return Region.objects.all()


def _departments():
    """
    All departments
    """
    return Department.objects.all()


def _sites():
    """
    All sites
    """
    return Site.objects.all()


def _buildings():
    """
    All buildings
    """
    return Building.objects.all()


def _rooms():
    """
    All rooms
    """
    return Room.objects.all()


def _racks():
    """
    All racks
    """
    return Rack.objects.all()


def _device(pk):
    """
    One device
    """
    return Device.objects.get(id=pk)


def _rack(pk):
    """
    One rack
    """
    return Rack.objects.get(id=pk)


def _direction(pk):
    """
    Rack numbering direction
    """
    return Rack.objects.get(id=pk).numbering_from_bottom_to_top


def _devices(pk, side):
    """
    Devices in a rack for a specified side
    """
    return Device.objects.filter(rack_id_id=pk) \
                                 .filter(frontside_location=side)


def _rack_id(pk):
    """
    Rack ID
    """
    return Device.objects.get(id=pk).rack_id_id


def _rack_name(pk):
    """
    Rack name
    """
    return Rack.objects.get(id=pk).rack_name       


def _start_list(pk, direction):
    """
    Units list
    """
    if direction == False:
        return list(range(1, (int(Rack.objects.get(id=pk) \
                .rack_amount) + 1)))
    else:
        return list(range(1, (int(Rack.objects.get(id=pk) \
                .rack_amount) + 1)))[::-1]


def _first_units(pk, direction, side):
    """
    First units for each device
    """
    first_units = {}
    queryset_spans = Device.objects.filter(rack_id_id=pk) \
                                   .filter(frontside_location=side)
    for span in queryset_spans:
        last_unit = span.last_unit
        first_unit = span.first_unit
        if direction == True:
            if last_unit > first_unit:
                first_unit = span.last_unit
            first_units[span.id] = first_unit
        else:
            if last_unit < first_unit:
                first_unit = span.last_unit
            first_units[span.id] = first_unit
    return first_units


def _spans(pk, side):
    """
    Rowspans for each device
    """
    spans = {}
    queryset_spans = Device.objects.filter(rack_id_id=pk) \
                                   .filter(frontside_location=side)
    for span in queryset_spans:
        last_unit = span.last_unit
        first_unit = span.first_unit
        if last_unit < first_unit:
            first_unit = span.last_unit
            last_unit = span.first_unit
        spans[span.id] = last_unit - first_unit + 1
    return spans


def _group_check(user_groups, pk, model):
    """
    Checking if there is a group named department 
    in the list of user groups that matches 
    the model object belonging to the area 
    of responsibility of the department (by primary keys)
                                                             __
                                                 ======      \/
    _____________  _____________  _____________  | [] |=========
    \  crutches  / \  crutches  / \  crutches  / |              )
     ===========    ===========    ===========   ================
     O-O     O-O    O-O     O-O    O-O     O-O   O-O-O   O-O-O \\

    Does not allow you to change the data assigned to another department
    """
    if model == Department:
        department_raw_query = Department.objects.raw("""select department.id as id,
                                                      department.department_name 
                                                      from department 
                                                      where 
                                                      department.id = %s ;""",  
                                                      [str(pk)])
    elif model == Site:
        department_raw_query = Department.objects.raw("""select department.id as id, 
                                                      department.department_name 
                                                      from site 
                                                      join department on 
                                                      department.id = 
                                                      site.department_id_id 
                                                      where 
                                                      site.id = %s ;""",  
                                                      [str(pk)])
    elif model == Building:
        department_raw_query = Department.objects.raw("""select department.id as id, 
                                                      department.department_name 
                                                      from building 
                                                      join site on 
                                                      site.id = building.site_id_id 
                                                      join department on 
                                                      department.id = 
                                                      site.department_id_id 
                                                      where 
                                                      building.id = %s ;""",  
                                                      [str(pk)])
    elif model == Room:
        department_raw_query = Department.objects.raw("""select department.id as id, 
                                                      department.department_name 
                                                      from room
                                                      join building on 
                                                      building.id = 
                                                      room.building_id_id  
                                                      join site on 
                                                      site.id = 
                                                      building.site_id_id
                                                      join department on 
                                                      department.id = 
                                                      site.department_id_id 
                                                      where 
                                                      room.id = %s ;""",  
                                                      [str(pk)])
    elif model == Rack:
        department_raw_query = Department.objects.raw("""select department.id as id, 
                                                      department.department_name 
                                                      from rack
                                                      join room on 
                                                      room.id = 
                                                      rack.room_id_id 
                                                      join building on 
                                                      building.id = 
                                                      room.building_id_id  
                                                      join site on 
                                                      site.id = 
                                                      building.site_id_id
                                                      join department on 
                                                      department.id = 
                                                      site.department_id_id 
                                                      where 
                                                      rack.id = %s ;""",  
                                                      [str(pk)])
    elif model == Device:
        department_raw_query = Department.objects.raw("""select department.id as id, 
                                                      department.department_name 
                                                      from device
                                                      join rack on 
                                                      rack.id = 
                                                      device.rack_id_id
                                                      join room on 
                                                      room.id = 
                                                      rack.room_id_id 
                                                      join building on 
                                                      building.id = 
                                                      room.building_id_id  
                                                      join site on 
                                                      site.id = 
                                                      building.site_id_id
                                                      join department on 
                                                      department.id = 
                                                      site.department_id_id 
                                                      where 
                                                      device.id = %s ;""",  
                                                      [str(pk)])
    department_name = str([department_name for department_name in department_raw_query][0])
    if department_name in user_groups:
        return True
    else:
        return False


def _old_units(pk):
    """
    Already filled units
    """
    units = {}
    first_unit = Device.objects.get(id=pk).first_unit
    last_unit = Device.objects.get(id=pk).last_unit
    units['old_first_unit'] = first_unit
    units['old_last_unit'] = last_unit
    if units['old_first_unit'] > units['old_last_unit']:
        units['old_last_unit'] = first_unit
        units['old_first_unit'] = last_unit
    return units


def _new_units(first_unit, last_unit):
    """
    Units for newly added device
    """
    units= {}
    units['new_first_unit'] = first_unit
    units['new_last_unit'] = last_unit
    if units['new_first_unit'] > units['new_last_unit']:
        units['new_last_unit'] = first_unit
        units['new_first_unit'] = last_unit  
    return units


def _all_units(pk):
    """
    Total units per rack
    """
    units = {}
    units['all_units'] = Rack.objects.get(id=pk).rack_amount
    return units
    

def _unit_exist_check(units):
    """
    Are there any such units?
    """
    if not set(range(units['new_first_unit'], units['new_last_unit'] + 1)) \
        .issubset(range(1, units['all_units'] + 1)):
        return True
    else:
        return False

        
def _unit_busy_check(location, units, pk, update):
    """
    Are units busy? (adding, updating)
    """
    filled_list = []
    queryset_devices = Device.objects.filter(rack_id_id=pk) \
                .filter(frontside_location=location)
    if len(list(queryset_devices)) > 0:
        for device in queryset_devices:
            first_unit = device.first_unit
            last_unit = device.last_unit
            if first_unit > last_unit:
                first_unit = device.last_unit
                last_unit = device.first_unit
            one_device_list = list(range(first_unit, last_unit + 1))
            filled_list.extend(one_device_list)
    if update == True:
        filled_list = set(filled_list) - set(range(units['old_first_unit'], 
                                                   units['old_last_unit'] + 1))
    if any(unit in set(range(units['new_first_unit'], 
           units['new_last_unit'] + 1)) for unit in filled_list):
        return True
    else:
        return False


def _unique_list(pk, model):
    """
    Names of building, rooms and racks can be repeated 
    within the area of responsibility of one department
    """
    if model == Site:
        return [building.building_name for building 
                in Building.objects.filter(site_id_id=pk)]
    elif model == Building:
        return [room.room_name for room 
                in Room.objects.filter(building_id_id=pk)]
    elif model == Room:
        return [rack.rack_name for rack 
                in Rack.objects.filter(room_id_id=pk)]


def _device_stack(device_link, device_stack):
    """
    Link to backup device (for csv)
    """
    if device_stack != None:
        return device_link + str(device_stack)
    else:
        return None


def _frontside_location(frontside_location):
    """
    Location (for csv)
    """
    if frontside_location == True:
        return 'Yes'
    else:
        return 'No'


def _numbering(numbering):
    """
    Numbering (for csv)
    """
    if numbering == True:
        return 'Yes'
    else:
        return 'No'


def _external_ups(external_ups):
    """
    UPS availability (for csv)
    """
    if external_ups == True:
        return 'Yes'
    else:
        return 'No'


def _cooler(cooler):
    """
    Venting availability (for csv)
    """
    if cooler == True:
        return 'Yes'
    else:
        return 'No'


def _header(pk):
    """
    Header data set (location)
    """
    return Rack.objects.raw("""select rack.id as id, 
                            rack.rack_name,
                            room.room_name, 
                            building.building_name, 
                            site.site_name, 
                            department.department_name, 
                            region.region_name 
                            from rack 
                            join room on 
                            room.id = 
                            rack.room_id_id 
                            join building on 
                            building.id = 
                            room.building_id_id 
                            join site on 
                            site.id = 
                            building.site_id_id 
                            join department on 
                            department.id = 
                            site.department_id_id 
                            join region on 
                            region.id = 
                            department.region_id_id 
                            where 
                            rack.id = %s ;""",  
                            [str(pk)])


def _side_name(side):
    """
    Rack side (for a draft)
    """
    if side == 'True':
        return 'Front side of the rack'
    else:
        return 'Back side of the rack'


def _font_size(rack_size):
    """
    Font size (for a draft)
    """
    if rack_size <= 32: 
        return '100'
    elif rack_size > 32 and rack_size <= 42:
        return '75'
    else:  
        return '50'


def _date():
    """
    Date
    """
    return datetime.datetime.today().strftime("%Y-%m-%d")


def _devices_list(pk):
    """
    List of device IDs for rack
    """
    return Device.objects.filter(rack_id_id=pk).values_list('id', flat=True)


def _devices_all(pk):
    """
    All devices in rack
    """
    return Device.objects.filter(rack_id_id=pk)


def _device_vendors():
    """
    Vendors list (for devices)
    """
    vendors = list(Device.objects. \
        values_list('device_vendor', flat=True).distinct())
    vendors.sort()
    return vendors


def _device_models():
    """
    Models list (for devices)
    """
    models = list(Device.objects. \
        values_list('device_model', flat=True).distinct())
    models.sort()
    return models


def _rack_vendors():
    """
    Vendors list (for racks)
    """
    vendors = list(Rack.objects. \
        values_list('rack_vendor', flat=True).distinct())
    vendors.sort()
    return vendors


def _rack_models():
    """
    Models list (for racks)
    """
    models = list(Rack.objects. \
        values_list('rack_model', flat=True).distinct())
    models.sort()
    return models