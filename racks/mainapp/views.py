from django.shortcuts import render
from django.contrib.auth.decorators import login_required
from .models import Region, Department, Site, Building, Room, Rack, Device
from django.forms.models import model_to_dict
from .forms import *
from django.db import models
import logging
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
    _export_devices,
    _export_racks,
    _header,
    _side_name,
    _font_size,
    _rack_name,
)

logger = logging.getLogger(__name__)


@login_required(login_url='login/')
def tree_view(request):
    """
    Карта стоек
    """
    return render(request, 'tree.html', {
        'regions' : _regions(), 
        'departments' : _departments(), 
        'sites': _sites(), 
        'buildings': _buildings(), 
        'rooms': _rooms(), 
        'racks': _racks(),  
    })


@login_required(login_url='login/') 
def device_view(request, pk):
    """
    Карточка устройства
    """
    return render(request, 'device_detail.html', {
        'device': _device(pk),
    })


@login_required(login_url='login/') 
def rack_view(request, pk):
    """
    Карточка стойки
    """
    return render(request, 'rack_detail.html', {
        'rack': _rack(pk),
    })


@login_required(login_url='login/') 
def answer_view(request, args):
    """
    Вьюшка-заглушка
    """
    return render(request, 'answer.html', {
        'answer': args 
    })


@login_required(login_url='login/')
def units_view(request, pk):
    """
    Отображение схемы стойки с заполненными юнитами
                                                          __
                                              ======      \/
    _____________ _____________ _____________ | [] |=========
    \  костыли  / \  костыли  / \  костыли  / |              )
     ===========   ===========   ===========  ================
     O-O     O-O   O-O     O-O   O-O     O-O  O-O-O   O-O-O \\

    Каждая стойка отображается с двух сторон
    Для каждой стороны свой набор данных
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
def units_print_view(request, pk, side):
    """
    Черновик для одной части стойки
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
    Вьюшка для отчета по устройствам
    """
    return _export_devices()


@login_required(login_url='login/')
def export_racks_view(request):
    """
    Вьюшка для отчета по стойкам
    """
    return _export_racks()


#############################################
#Вьюшки для объектов
#############################################
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
                    'answer': 'Объект добавлен'
                })
            else:
                return render(request, 'answer.html', {
                    'answer': 'У вас нет прав на изменения'
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
                    'answer': 'Информация об объекте изменена'
                })
            else:
                return render(request, 'answer.html', {
                    'answer': 'У вас нет прав на изменения'
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
                'answer': 'Объект удален'
            })
        else:
            return render(request, 'answer.html', {
                'answer': 'У вас нет прав на изменения'
            })
    return render(request, 'site_del.html', {
        'site': site
    })


#############################################
#Вьюшки для зданий
#############################################
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
                        'answer': 'Здание с таким названием уже существует'
                    })
                form.save()
                logger.info(request.user.username + 
                            ' ADD BUILDING: ' + 
                            str(form))
                return render(request, 'answer.html', {
                    'answer': 'Здание добавлено'
                })
            else:
                return render(request, 'answer.html', {
                    'answer': 'У вас нет прав на изменения'
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
                        'answer': 'Здание с таким названием уже существует'
                    })
                form.instance.updated_by = request.user.get_full_name()
                form.save()
                logger.info(request.user.username + 
                            ' UPDATE BUILDING OLD_FORM: ' + 
                            str(old_form) + 
                            ', NEW_FORM: ' + 
                            str(form))
                return render(request, 'answer.html', {
                    'answer': 'Информация о здании изменена'
                })
            else:
                return render(request, 'answer.html', {
                    'answer': 'У вас нет прав на изменения'
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
                'answer': 'Здание удалено'
            })
        else:
            return render(request, 'answer.html', {
                'answer': 'У вас нет прав на изменения'
            })
    return render(request, 'build_del.html', {
        'building': building
    })


#############################################
#Вьюшки для помещений
#############################################
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
                        'answer': 'Помещение с таким названием уже существует'
                    })
                form.save()
                logger.info(request.user.username + 
                            ' ADD ROOM: ' + 
                            str(form))
                return render(request, 'answer.html', {
                    'answer': 'Помещение добавлено'
                })
            else:
                return render(request, 'answer.html', {
                    'answer': 'У вас нет прав на изменения'
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
                        'answer': 'Помещение с таким названием уже существует'
                    })
                form.instance.updated_by = request.user.get_full_name()
                form.save()
                logger.info(request.user.username + 
                            ' UPDATE ROOM OLD_FORM: ' + 
                            str(old_form) + 
                            ', NEW_FORM: ' + 
                            str(form))
                return render(request, 'answer.html', {
                    'answer': 'Информация о помещении изменена'
                })
            else:
                return render(request, 'answer.html', {
                    'answer': 'У вас нет прав на изменения'
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
                'answer': 'Помещение удалено'
            })
        else:
            return render(request, 'answer.html', {
                'answer': 'У вас нет прав на изменения'
            })
    return render(request, 'room_del.html', {
        'room': room
    })


#############################################
#Вьюшки для стоек
#############################################
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
                        'answer': 'Стойка с таким названием уже существует'
                    })
                form.save()
                logger.info(request.user.username + 
                            ' ADD RACK: ' + 
                            str(form))
                return render(request, 'answer.html', {
                    'answer': 'Стойка добавлена'
                })
            else:
                return render(request, 'answer.html', {
                    'answer': 'У вас нет прав на изменения'
                })
    return render(request, 'add.html', {
        'form': form
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
                            'answer': 'Стойка с таким названием уже существует'
                        })
                form.instance.updated_by = request.user.get_full_name()
                form.save()
                logger.info(request.user.username + 
                            ' UPDATE RACK OLD_FORM: ' + 
                            str(old_form) + ', NEW_FORM: ' + 
                            str(form))
                return render(request, 'answer.html', {
                    'answer': 'Информация о стойке изменена'
                })
            else:
                return render(request, 'answer.html', {
                    'answer': 'У вас нет прав на изменения'
                })
    return render(request, 'update.html', {
        'form': old_form
    })


@login_required(login_url='login/')
def rack_del_view(request, pk):
    rack = Rack.objects.get(id=pk)
    if request.method == 'POST':
        if _group_check(list(request.user.groups \
            .values_list('name', flat=True)), pk, model=Rack):
            rack.delete()
            logger.info(request.user.username + 
                        ' DELETE RACK: ' + 
                        str(rack))
            return render(request, 'answer.html', {
                'answer': 'Стойка удалена'
            })
        else:
            return render(request, 'answer.html', {
                'answer': 'У вас нет прав на изменения'
            })
    return render(request, 'rack_del.html', {
        'rack': rack
    })


#############################################
#Вьюшки для устройств
#############################################
@login_required(login_url='login/')
def device_add_view(request, pk):
    form_class = DeviceForm
    form = form_class(request.POST or None, initial = {
        "updated_by": request.user.get_full_name(), 
        "rack_id": pk
    })
    if request.method == 'POST':
        if form.is_valid():
            if _group_check(list(request.user.groups \
                .values_list('name', flat=True)), pk, model=Rack):
                units = _new_units(form.instance.first_unit, 
                                   form.instance.last_unit)
                units.update(_all_units(pk))
                if _unit_exist_check(units, pk): 
                    return render(request, 'answer.html', {
                        'answer': 'Указанных юнитов нет в стойке'
                    })
                if _unit_busy_check(form.instance.frontside_location, 
                                    units, pk, update=False):
                    return render(request, 'answer.html', {
                        'answer': 'Указанные юниты заняты'
                    })
                form.save()
                logger.info(request.user.username + 
                            ' ADD DEVICE: ' + 
                            str(form))
                return render(request, 'answer.html', {
                    'answer': 'Устройство добавлено'
                })
            else:
                return render(request, 'answer.html', {
                    'answer': 'У вас нет прав на изменения'
                })
    return render(request, 'add.html', {
        'form': form
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
                if _unit_exist_check(units, rack_id): 
                    return render(request, 'answer.html', {
                        'answer': 'Указанных юнитов нет в стойке'
                    })
                if _unit_busy_check(form.instance.frontside_location, 
                                    units, rack_id, update=True):
                    return render(request, 'answer.html', {
                        'answer': 'Указанные юниты заняты'
                    })
                form.instance.updated_by = request.user.get_full_name()
                form.save()
                logger.info(request.user.username + 
                            ' UPDATE DEVICE OLD_FORM: ' + 
                            str(old_form) + 
                            ', NEW_FORM: ' + 
                            str(form))
                return render(request, 'answer.html', {
                    'answer': 'Информация об устройстве изменена'
                })
            else:
                return render(request, 'answer.html', {
                    'answer': 'У вас нет прав на изменения'
                })
    return render(request, 'update.html', {
        'form': old_form
    })


@login_required(login_url='login/')
def device_del_view(request, pk):
    device = Device.objects.get(id=pk)
    if request.method == 'POST':
        if _group_check(list(request.user.groups \
            .values_list('name', flat=True)), pk, model=Device):
            device.delete()
            logger.info(request.user.username + 
                        ' DELETE DEVICE: ' + 
                        str(device))
            return render(request, 'answer.html', {
                'answer': 'Устройство удалено'
            })
        else:
            return render(request, 'answer.html', {
                'answer': 'У вас нет прав на изменения'
            })
    return render(request, 'device_del.html', {
        'device': device
    })
