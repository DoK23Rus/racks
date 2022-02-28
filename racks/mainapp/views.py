from django.shortcuts import render
from django.contrib.auth.decorators import login_required
from .forms import *
from django.db import models
import logging
import os
from .models import (
    Region, 
    Department, 
    Site, 
    Building, 
    Room, 
    Rack, 
    Device,
)
from .qr_services import (
    _remove_qr,
    _qr_data, 
    _show_qr, 
)
from .report_services import (
    _export_devices, 
    _export_racks,
)
from .services import ( 
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
    _date,
    _devices_list,
    _devices_all,
    _device_vendors,
    _device_models,
    _rack_vendors,
    _rack_models,
)


logger = logging.getLogger(__name__)


@login_required(login_url='login/')
def tree_view(request):
    """
    Racks map
    """
    return render(request, 'tree.html', {
        'regions': _regions(), 
        'departments': _departments(), 
        'sites': _sites(), 
        'buildings': _buildings(), 
        'rooms': _rooms(), 
        'racks': _racks(),  
    })


@login_required(login_url='login/') 
def device_view(request, pk):
    """
    Device info
    """
    return render(request, 'device_detail.html', {
        'device': _device(pk),
    })


@login_required(login_url='login/') 
def rack_view(request, pk):
    """
    Rack info
    """
    return render(request, 'rack_detail.html', {
        'rack': _rack(pk),
    })


@login_required(login_url='login/') 
def answer_view(request, args):
    """
    Plug-view
    """
    return render(request, 'answer.html', {
        'answer': args 
    })


@login_required(login_url='login/')
def units_view(request, pk):
    """
    Display rack layout with filled units
                                                             __
                                                 ======      \/
    _____________  _____________  _____________  | [] |=========
    \  crutches  / \  crutches  / \  crutches  / |              )
     ===========    ===========    ===========   ================
     O-O     O-O    O-O     O-O    O-O     O-O   O-O-O   O-O-O \\

    Each rack has two sides
    Each side has its own data set
    """
    direction = _direction(pk)
    return render(request, 'units.html', {
        'rack': _rack(pk), 
        'header': _header(pk), 
        'start_list': _start_list(pk, direction), 
        'devices_front': _devices(pk, True),
        'devices_back': _devices(pk, False),
        'first_units_front': _first_units(pk, direction, True), 
        'first_units_back': _first_units(pk, direction, False), 
        'spans_front': _spans(pk, True), 
        'spans_back': _spans(pk, False),
    })


@login_required(login_url='login/')
def device_qr_view(request, pk):
    """
    QR-code for device
    """
    return render(request, 'device_qr.html', {
        'date': _date(),
        'device': _device(pk),
        'image': _show_qr(_qr_data(pk, True), pk, True)
    })


@login_required(login_url='login/')
def rack_qr_view(request, pk):
    """
    QR-code for rack
    """
    return render(request, 'rack_qr.html', {
        'date': _date(),
        'rack': _rack(pk),
        'image': _show_qr(_qr_data(pk, False), pk, False)
    })


@login_required(login_url='login/')
def qr_list_view(request, pk):
    """
    QR-codes for rack and all devices
    """
    devices_list = _devices_list(pk)
    return render(request, 'qr_list.html', {
        'date': _date(),
        'rack': _rack(pk),
        'devices_all': _devices_all(pk),
        'devices_list': devices_list,
        'images': [_show_qr(_qr_data(device, True), device, True) for 
                   device in devices_list],
        'rack_image': _show_qr(_qr_data(pk, False), pk, False)
    })


@login_required(login_url='login/')
def units_print_view(request, pk, side):
    """
    Draft for one part of the rack
    """
    rack = _rack(pk)
    direction = _direction(pk)
    return render(request, 'print.html', {
            'side_name': _side_name(side),
            'rack': rack,  
            'start_list': _start_list(pk, direction), 
            'devices': _devices(pk, side),
            'first_units': _first_units(pk, direction, side),  
            'spans': _spans(pk, side),  
            'font_size': _font_size(rack.rack_amount),
        })


@login_required(login_url='login/')
def export_devices_view(request):
    """
    Devices report
    """
    return _export_devices()


@login_required(login_url='login/')
def export_racks_view(request):
    """
    Racks report
    """
    return _export_racks()


@login_required(login_url='login/')
def search(request):
    """
    Search for device or rack by ID
    """
    form = SearchForm(request.POST)
    if request.method == 'POST':
        if form.is_valid():
            if request.POST.get('object_type') == "Device":
                value = form.cleaned_data
                pk = value['object_id']
                try:
                    _device(pk)
                    return device_view(request, pk)
                except:
                    return render(request, 'answer.html', {
                        'answer': 'There is no device with this ID'
                    })
            elif request.POST.get('object_type') == "Rack":
                value = form.cleaned_data
                pk = value['object_id']
                try: 
                    _rack(pk)
                    return units_view(request, pk)
                except:
                    return render(request, 'answer.html', {
                        'answer': 'There is no rack with this ID'
                    })
    return render(request, 'search.html', {
        'form': form
    })


##############
# Site Views #
##############
@login_required(login_url='login/')
def site_add_view(request, pk):
    form_class = SiteForm
    form = form_class(request.POST or None, initial = {
        "updated_by": request.user.get_full_name(), 
        "department_id": pk
    })
    if request.method == 'POST':
        if form.is_valid():
            if _group_check(list(request.user.groups \
                .values_list('name', flat=True)), pk, model=Department):
                form.save()
                logger.info(request.user.username + 
                            ' ADD SITE: ' + 
                            str(form))
                return render(request, 'answer.html', {
                    'answer': 'Site added'
                })
            else:
                return render(request, 'answer.html', {
                    'answer': 'Permission alert, changes are prohibited'
                })
    return render(request, 'add.html', {
        'form': form
    })


@login_required(login_url='login/')
def site_upd_view(request, pk):
    site = Site.objects.get(id=pk)
    form_class = SiteForm
    old_form = form_class(instance=site)
    if request.method == 'POST':
        form = form_class(request.POST or None, instance=site)
        if form.is_valid():
            if _group_check(list(request.user.groups \
                .values_list('name', flat=True)), pk, model=Site):
                form.instance.updated_by = request.user.get_full_name()
                form.save()
                logger.info(request.user.username + 
                            ' UPDATE SITE OLD_FORM: ' + 
                            str(old_form) + 
                            ', NEW_FORM: ' + str(form))
                return render(request, 'answer.html', {
                    'answer': 'Site information changed'
                })
            else:
                return render(request, 'answer.html', {
                    'answer': 'Permission alert, changes are prohibited'
                })
    return render(request, 'update.html', {
        'form': old_form
    })


@login_required(login_url='login/')
def site_del_view(request, pk):
    site = Site.objects.get(id=pk)
    if request.method == 'POST':
        if _group_check(list(request.user.groups \
            .values_list('name', flat=True)), pk, model=Site):
            site.delete()
            logger.info(request.user.username + 
                        ' DELETE SITE: ' + 
                        str(site))
            return render(request, 'answer.html', {
                'answer': 'Site deleted'
            })
        else:
            return render(request, 'answer.html', {
                'answer': 'Permission alert, changes are prohibited'
            })
    return render(request, 'delete.html', {
        'site': site,
        'object': 'site',
    })


##################
# Building Views #
##################
@login_required(login_url='login/')
def building_add_view(request, pk):
    form_class = BuildingForm
    form = form_class(request.POST or None, initial = {
        "updated_by": request.user.get_full_name(), 
        "site_id": pk
    })
    if request.method == 'POST':
        if form.is_valid():
            if _group_check(list(request.user.groups \
                .values_list('name', flat=True)), pk, model=Site):
                if form.instance.building_name in _unique_list(pk, 
                                                               model=Site):
                    return render(request, 'answer.html', {
                        'answer': 'A building with the same name already exists'
                    })
                form.save()
                logger.info(request.user.username + 
                            ' ADD BUILDING: ' + 
                            str(form))
                return render(request, 'answer.html', {
                    'answer': 'Building added'
                })
            else:
                return render(request, 'answer.html', {
                    'answer': 'Permission alert, changes are prohibited'
                })
    return render(request, 'add.html', {
        'form': form
    })


@login_required(login_url='login/')
def building_upd_view(request, pk, site_id):
    building = Building.objects.get(id=pk)
    form_class = BuildingForm
    old_form = form_class(instance=building)
    if request.method == 'POST':
        form = form_class(request.POST or None, instance=building)
        if form.is_valid():
            if _group_check(list(request.user.groups \
                .values_list('name', flat=True)), pk, model=Building):
                if form.instance.building_name in _unique_list(site_id, 
                                                               model=Site):
                    return render(request, 'answer.html', {
                        'answer': 'A building with the same name already exists'
                    })
                form.instance.updated_by = request.user.get_full_name()
                form.save()
                logger.info(request.user.username + 
                            ' UPDATE BUILDING OLD_FORM: ' + 
                            str(old_form) + 
                            ', NEW_FORM: ' + 
                            str(form))
                return render(request, 'answer.html', {
                    'answer': 'Building information changed'
                })
            else:
                return render(request, 'answer.html', {
                    'answer': 'Permission alert, changes are prohibited'
                })
    return render(request, 'update.html', {
        'form': old_form
    })


@login_required(login_url='login/')
def building_del_view(request, pk):
    building = Building.objects.get(id=pk)
    if request.method == 'POST':
        if _group_check(list(request.user.groups \
            .values_list('name', flat=True)), pk, model=Building):
            building.delete()
            logger.info(request.user.username + 
                        ' DELETE BUILDING: ' + 
                        str(building))
            return render(request, 'answer.html', {
                'answer': 'Building deleted'
            })
        else:
            return render(request, 'answer.html', {
                'answer': 'Permission alert, changes are prohibited'
            })
    return render(request, 'delete.html', {
        'building': building,
        'object': 'building',
    })


##############
# Room Views #
##############
@login_required(login_url='login/')
def room_add_view(request, pk):
    form_class = RoomForm
    form = form_class(request.POST or None, initial = {
        "updated_by": request.user.get_full_name(), 
        "building_id": pk
    })
    if request.method == 'POST':
        if form.is_valid():
            if _group_check(list(request.user.groups \
                .values_list('name', flat=True)), pk, model=Building):
                if form.instance.room_name in _unique_list(pk, 
                                                           model=Building):
                    return render(request, 'answer.html', {
                        'answer': 'A room with the same name already exists'
                    })
                form.save()
                logger.info(request.user.username + 
                            ' ADD ROOM: ' + 
                            str(form))
                return render(request, 'answer.html', {
                    'answer': 'Room added'
                })
            else:
                return render(request, 'answer.html', {
                    'answer': 'Permission alert, changes are prohibited'
                })
    return render(request, 'add.html', {
        'form': form
    })


@login_required(login_url='login/')
def room_upd_view(request, pk, building_id):
    room = Room.objects.get(id=pk)
    form_class = RoomForm
    old_form = form_class(instance=room)
    if request.method == 'POST':
        form = form_class(request.POST or None, instance=room)
        if form.is_valid():
            if _group_check(list(request.user.groups \
                .values_list('name', flat=True)), pk, model=Room):
                if form.instance.room_name in _unique_list(building_id, 
                                                           model=Building):
                    return render(request, 'answer.html', {
                        'answer': 'A room with the same name already exists'
                    })
                form.instance.updated_by = request.user.get_full_name()
                form.save()
                logger.info(request.user.username + 
                            ' UPDATE ROOM OLD_FORM: ' + 
                            str(old_form) + 
                            ', NEW_FORM: ' + 
                            str(form))
                return render(request, 'answer.html', {
                    'answer': 'Room information changed'
                })
            else:
                return render(request, 'answer.html', {
                    'answer': 'Permission alert, changes are prohibited'
                })
    return render(request, 'update.html', {
        'form': old_form
    })


@login_required(login_url='login/')
def room_del_view(request, pk):
    room = Room.objects.get(id=pk)
    if request.method == 'POST':
        if _group_check(list(request.user.groups \
            .values_list('name', flat=True)), pk, model=Room):
            room.delete()
            logger.info(request.user.username + 
                        ' DELETE ROOM: ' + 
                        str(room))
            return render(request, 'answer.html', {
                'answer': 'Room deleted'
            })
        else:
            return render(request, 'answer.html', {
                'answer': 'Permission alert, changes are prohibited'
            })
    return render(request, 'delete.html', {
        'room': room,
        'object': 'room',
    })


###############
# Racks Views #
###############
@login_required(login_url='login/')
def rack_add_view(request, pk):
    form_class = RackForm
    form = form_class(request.POST or None, initial = {
        "updated_by": request.user.get_full_name(), "room_id": pk
    })
    if request.method == 'POST':
        if form.is_valid():
            if _group_check(list(request.user.groups \
                .values_list('name', flat=True)), pk, model=Room):
                if form.instance.rack_name in _unique_list(pk, model=Room):
                    return render(request, 'answer.html', {
                        'answer': 'A rack with the same name already exists'
                    })
                form.save()
                logger.info(request.user.username + 
                            ' ADD RACK: ' + 
                            str(form))
                return render(request, 'answer.html', {
                    'answer': 'Rack added'
                })
            else:
                return render(request, 'answer.html', {
                    'answer': 'Permission alert, changes are prohibited'
                })
    return render(request, 'add.html', {
        'form': form,
        'choices_vendor': _rack_vendors(),
        'choices_model': _rack_models(),
    })


@login_required(login_url='login/')
def rack_upd_view(request, pk, room_id):
    rack = Rack.objects.get(id=pk)
    form_class = UpdRackForm
    old_form = form_class(instance=rack)
    if request.method == 'POST':
        form = form_class(request.POST or None, instance=rack)
        if form.is_valid():
            if _group_check(list(request.user.groups \
                .values_list('name', flat=True)), pk, model=Rack):
                if _rack_name(pk) != form.instance.rack_name:
                    if form.instance.rack_name in _unique_list(room_id, 
                                                               model=Room):
                        return render(request, 'answer.html', {
                            'answer': 'A rack with the same name already exists'
                        })
                form.instance.updated_by = request.user.get_full_name()
                form.save()
                logger.info(request.user.username + 
                            ' UPDATE RACK OLD_FORM: ' + 
                            str(old_form) + ', NEW_FORM: ' + 
                            str(form))
                return render(request, 'answer.html', {
                    'answer': 'Rack information changed'
                })
            else:
                return render(request, 'answer.html', {
                    'answer': 'Permission alert, changes are prohibited'
                })
    return render(request, 'update.html', {
        'form': old_form,
        'choices_vendor': _rack_vendors(),
        'choices_model': _rack_models(),
    })


@login_required(login_url='login/')
def rack_del_view(request, pk):
    rack = Rack.objects.get(id=pk)
    if request.method == 'POST':
        if _group_check(list(request.user.groups \
            .values_list('name', flat=True)), pk, model=Rack):
            rack.delete()
            _remove_qr(pk, False)
            logger.info(request.user.username + 
                        ' DELETE RACK: ' + 
                        str(rack))
            return render(request, 'answer.html', {
                'answer': 'Rack deleted'
            })
        else:
            return render(request, 'answer.html', {
                'answer': 'Permission alert, changes are prohibited'
            })
    return render(request, 'delete.html', {
        'rack': rack,
        'object': 'rack',
    })


#################
# Devices Views #
#################
@login_required(login_url='login/')
def device_add_view(request, pk):
    form_class = DeviceForm
    form = form_class(request.POST or None, initial = {
        "updated_by": request.user.get_full_name(), 
        "rack_id": pk,
    })
    if request.method == 'POST':
        if form.is_valid():
            if _group_check(list(request.user.groups \
                .values_list('name', flat=True)), pk, model=Rack):
                units = _new_units(form.instance.first_unit, 
                                   form.instance.last_unit)
                units.update(_all_units(pk))
                if _unit_exist_check(units): 
                    return render(request, 'answer.html', {
                        'answer': 'There are no such units in this rack'
                    })
                if _unit_busy_check(form.instance.frontside_location, 
                                    units, pk, update=False):
                    return render(request, 'answer.html', {
                        'answer': 'These units are busy'
                    })
                form.save()
                logger.info(request.user.username + 
                            ' ADD DEVICE: ' + 
                            str(form))
                return render(request, 'answer.html', {
                    'answer': 'Device added'
                })
            else:
                return render(request, 'answer.html', {
                    'answer': 'Permission alert, changes are prohibited'
                })
    return render(request, 'add.html', {
        'form': form,
        'choices_vendor': _device_vendors(),
        'choices_model': _device_models(),
    })


@login_required(login_url='login/')
def device_upd_view(request, pk):
    device = Device.objects.get(id=pk)
    form_class = DeviceForm
    old_form = form_class(instance=device)
    if request.method == 'POST':
        form = form_class(request.POST or None, instance=device)
        if form.is_valid():
            if _group_check(list(request.user.groups \
                .values_list('name', flat=True)), pk, model=Device):
                units = _old_units(pk)
                rack_id = _rack_id(pk)

                units.update(_new_units(form.instance.first_unit, 
                                        form.instance.last_unit))
                units.update(_all_units(rack_id))
                if _unit_exist_check(units): 
                    return render(request, 'answer.html', {
                        'answer': 'There are no such units in this rack'
                    })
                if _unit_busy_check(form.instance.frontside_location, 
                                    units, rack_id, update=True):
                    return render(request, 'answer.html', {
                        'answer': 'These units are busy'
                    })
                form.instance.updated_by = request.user.get_full_name()
                form.save()
                logger.info(request.user.username + 
                            ' UPDATE DEVICE OLD_FORM: ' + 
                            str(old_form) + 
                            ', NEW_FORM: ' + 
                            str(form))
                return render(request, 'answer.html', {
                    'answer': 'Device information changed'
                })
            else:
                return render(request, 'answer.html', {
                    'answer': 'Permission alert, changes are prohibited'
                })
    return render(request, 'update.html', {
        'form': old_form,
        'choices_vendor': _device_vendors(),
        'choices_model': _device_models(),
    })


@login_required(login_url='login/')
def device_del_view(request, pk):
    device = Device.objects.get(id=pk)
    if request.method == 'POST':
        if _group_check(list(request.user.groups \
            .values_list('name', flat=True)), pk, model=Device):
            device.delete()
            _remove_qr(pk, True)
            logger.info(request.user.username + 
                        ' DELETE DEVICE: ' + 
                        str(device))
            return render(request, 'answer.html', {
                'answer': 'Device deleted'
            })
        else:
            return render(request, 'answer.html', {
                'answer': 'Permission alert, changes are prohibited'
            })
    return render(request, 'delete.html', {
        'device': device,
        'object': 'device',
    })
