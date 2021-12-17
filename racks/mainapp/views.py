from django.shortcuts import render
from django.http import HttpResponse
from django.contrib.auth.decorators import login_required
from .models import Region, Department, Site, Building, Room, Rack, Device
from django.forms.models import model_to_dict
from .forms import *
from django.db import models
import csv
import logging
from .services import (
	_queryset_devices, 
	_direction, 
	_start_list, 
	_first_units, 
	_spans, 
	_check_group, 
	_check_old_units, 
	_check_rack_id, 
	_check_new_units, 
	_check_all_units, 
	_unit_check_exist, 
	_unit_check_busy, 
	_unique_check,
)

logger = logging.getLogger(__name__)


@login_required(login_url='login/')
def tree_view(request):
	"""
	Карта стоек
	"""
	return render(request, 'tree.html', {
		'regions' : Region.objects.all(), 
		'departments' : Department.objects.all(), 
		'sites': Site.objects.all(), 
		'buildings': Building.objects.all(), 
		'rooms': Room.objects.all(), 
		'racks': Rack.objects.all(), 
		'devices': Device.objects.all(), 
	})


@login_required(login_url='login/') 
def device_view(request, pk):
	"""
	Карточка устройства
	"""
	device_queryset = Device.objects.get(id=pk)
	return render(request, 'device_detail.html', {
		'device': device_queryset
	})


@login_required(login_url='login/') 
def rack_view(request, pk):
	"""
	Карточка стойки
	"""
	rack_queryset = Rack.objects.get(id=pk)
	return render(request, 'rack_detail.html', {
		'rack': rack_queryset
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
	queryset_header = Rack.objects.raw("""select rack.id as id, 
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
									   rack.id='""" + 
									   str(pk) + 
									   """';""") 
	# Наборы данных для отрисовки роуспанов для устройств шириной больше одного юнита
	queryset_rack = Rack.objects.get(id=pk)
	queryset_devices_front = _queryset_devices(pk, True)
	queryset_devices_back = _queryset_devices(pk, False)
	direction = _direction(pk)
	start_list = _start_list(pk, direction)
	first_units_front = _first_units(pk, direction, True)
	first_units_back = _first_units(pk, direction, False)
	spans_front = _spans(pk, True)
	spans_back = _spans(pk, False)

	return render(request, 'units.html', {
		'rack': queryset_rack, 
		'header': queryset_header, 
		'start_list': start_list, 
		'devices_front': queryset_devices_front, 
		'devices_back': queryset_devices_back, 
		'first_units_front': first_units_front, 
		'first_units_back': first_units_back, 
		'spans_front': spans_front, 
		'spans_back': spans_back,
	})


@login_required(login_url='login/')
def units_front_print_view(request, pk):
	"""
	Черновики для фронтальной части стойки
	"""
	# Наборы данных для отрисовки роуспанов для устройств шириной больше одного юнита
	queryset_rack = Rack.objects.get(id=pk)
	queryset_devices_front = _queryset_devices(pk, True)
	direction = _direction(pk)
	first_units_front = _first_units(pk, direction, True)
	spans_front = _spans(pk, True)
	start_list = _start_list(pk, direction)
	if len(start_list) <= 32:
		return render(request, 'print_front.html', {
			'rack': queryset_rack,  
			'start_list': start_list, 
			'devices_front': queryset_devices_front, 
			'first_units_front': first_units_front,  
			'spans_front': spans_front, 
			'font_size': '100',
		})
	elif len(start_list) > 32 and len(start_list) <= 42:
		return render(request, 'print_front.html', {
			'rack': queryset_rack,  
			'start_list': start_list, 
			'devices_front': queryset_devices_front, 
			'first_units_front': first_units_front,  
			'spans_front': spans_front, 
			'font_size': '75',
		})
	else:
		return render(request, 'print_front.html', {
			'rack': queryset_rack,  
			'start_list': start_list, 
			'devices_front': queryset_devices_front, 
			'first_units_front': first_units_front,  
			'spans_front': spans_front, 
			'font_size': '50',
		})


@login_required(login_url='login/')
def units_back_print_view(request, pk):
	"""
	Черновики для тыльной части стойки
	"""
	# Наборы данных для отрисовки роуспанов для устройств шириной больше одного юнита
	queryset_rack = Rack.objects.get(id=pk)
	queryset_devices_back = _queryset_devices(pk, False)
	direction = _direction(pk)
	first_units_back = _first_units(pk, direction, False)
	spans_back = _spans(pk, False)
	start_list = _start_list(pk, direction)
	if len(start_list) <= 32:
		return render(request, 'print_back.html', {
			'rack': queryset_rack,  
			'start_list': start_list,  
			'devices_back': queryset_devices_back,  
			'first_units_back': first_units_back, 
			'spans_back': spans_back,
			'font_size': '100',
		})
	elif len(start_list) > 32 and len(start_list) <= 42:
		return render(request, 'print_back.html', {
			'rack': queryset_rack,  
			'start_list': start_list,  
			'devices_back': queryset_devices_back,  
			'first_units_back': first_units_back, 
			'spans_back': spans_back,
			'font_size': '73',
		})
	else:
		return render(request, 'print_back.html', {
			'rack': queryset_rack,  
			'start_list': start_list, 
			'devices_back': queryset_devices_back,  
			'first_units_back': first_units_back, 
			'spans_back': spans_back,
			'font_size': '50',
		})


@login_required(login_url='login/')
def export_devices_view(request):
	"""
	Отчет по устройствам
	"""
	device_link = 'http://127.0.0.1:80001/device_detail/'
	response = HttpResponse(content_type='text/csv')
	response.write(u'\ufeff'.encode('utf8'))
	writer = csv.writer(response, delimiter=';', dialect='excel')
	writer.writerow([
		'Номер устройства', 
		'Статус',
		'Вендор', 
		'Модель', 
		'Серийный номер', 
		'Описание', 
		'Проект', 
		'Зона ответственности', 
		'МОЛ', 
		'Инвентарный номер', 
		'Первый юнит', 
		'Последний юнит', 
		'Расположено на фронтальной части', 
		'Тип оборудования',
		'Hostname',
		'Stack/Резерв',
		'Подключение к электросети',
		'Потребляемая мощность (Вт)',
		'Рабочее напряжение (В)',
		'Полярность тока',
		'Обновлено сотрудник', 
		'Обновлено дата', 
		'Стойка', 
		'Помещение', 
		'Здание', 
		'Узел', 
		'Отдел', 
		'Регион',
		'Ссылка на устройство',
	])
	raw_report =  Device.objects.raw("""select device.id as id,
									 device.status, 
									 device.device_vendor, 
									 device.device_model,
									 device.device_serial_number, 
									 device.device_description, 
									 device.project,  
									 device.ownership, 
									 device.financially_responsible_person, 
									 device.device_inventory_number, 
									 device.first_unit, 
									 device.last_unit, 
									 device.frontside_location, 
									 device.device_type, 
									 device.device_hostname, 
									 device.device_stack, 
									 device.power_type,
									 device.power_w, 
									 device.power_v, 
									 device.power_ac_dc,
									 device.updated_by, 
									 device.updated_at,
									 rack.rack_name, 
									 room.room_name, 
									 building.building_name, 
									 site.site_name, 
									 department.department_name, 
									 region.region_name 
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
									 join region on 
									 region.id = 
									 department.region_id_id;""")
	for device in raw_report:
		if device.device_stack != None:
			device_stack = device_link + str(device.device_stack)
		else:
			device_stack = None
		if device.frontside_location == True:
			frontside_location = 'Да'
		else:
			frontside_location = 'Нет'
		writer.writerow([
			device.id,
			device.status,
			device.device_vendor, 
			device.device_model, 
			device.device_serial_number,
			device.device_description,
			device.project,
			device.ownership,
			device.financially_responsible_person,
			device.device_inventory_number,
			device.first_unit,
			device.last_unit,
			frontside_location, 
			device.device_type, 
			device.device_hostname, 
			device_stack,
			device.power_type,
			device.power_w, 
			device.power_v, 
			device.power_ac_dc,
			device.updated_by,
			device.updated_at,
			device.rack_name,
			device.room_name,
			device.building_name,
			device.site_name,
			device.department_name,
			device.region_name,
			device_link + str(device.id),
		])
	response['Content-Disposition'] = 'attachment; filename="devices.csv"'
	return response


@login_required(login_url='login/')
def export_racks_view(request):
	"""
	Отчет по стойкам
	"""
	rack_link = 'http://127.0.0.1:80001/rack_detail/'
	response = HttpResponse(content_type='text/csv')
	response.write(u'\ufeff'.encode('utf8'))
	writer = csv.writer(response, delimiter=';', dialect='excel')
	writer.writerow([
		'Номер стойки',
		'Наименование', 
		'Вместимость стойки', 
		'Фирма производитель', 
		'Модель', 
		'Описание', 
		'Нумерация снизу вверх', 
		'Ответственный', 
		'МОЛ', 
		'Инвентарный номер', 
		'Ряд', 
		'Место', 
		'Высота стойки (мм)',
		'Ширина стойки (мм)',
		'Глубина стойки (мм)',
		'Полезная ширина стойки (дюймы)',
		'Полезная глубина стойки (мм)',
		'Вариант исполнения',
		'Тип расположения',
		'Максимальная нагрузка (кг)',
		'Свободных электророзеток',
		'Свободных электророзеток UPS',
		'Внешняя система резервного электроснабжения',
		'Активная вентиляция',
		'Обновлено сотрудник', 
		'Обновлено дата', 
		'Помещение', 
		'Здание', 
		'Узел', 
		'Отдел', 
		'Регион',
		'Ссылка на стойку',
	])
	raw_report =  Rack.objects.raw("""select rack.id as id, 
									 rack.rack_name, 
									 rack.rack_amount,
									 rack.rack_vendor, 
									 rack.rack_model, 
									 rack.rack_description,  
									 rack.numbering_from_bottom_to_top, 
									 rack.responsible, 
									 rack.rack_financially_responsible_person, 
									 rack.rack_inventory_number, 
									 rack.row, 
									 rack.place,
									 rack.rack_height,
									 rack.rack_width,
									 rack.rack_depth, 
									 rack.rack_unit_width,
									 rack.rack_unit_depth,
									 rack.rack_type,
									 rack.rack_palce_type,
									 rack.max_load,
									 rack.power_sockets,
									 rack.power_sockets_ups,
									 rack.external_ups,
									 rack.cooler,
									 rack.updated_by, 
									 rack.updated_at, 
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
									 department.region_id_id;""")
	for rack in raw_report:
		if rack.numbering_from_bottom_to_top == True:
			numbering_from_bottom_to_top = 'Да'
		else:
			numbering_from_bottom_to_top = 'Нет'
		if rack.external_ups == True:
			external_ups = 'Да'
		else:
			external_ups = 'Нет'
		if rack.cooler == True:
			cooler = 'Да'
		else:
			cooler = 'Нет'
		writer.writerow([
			rack.id,
			rack.rack_name, 
			rack.rack_amount,
			rack.rack_vendor, 
			rack.rack_model, 
			rack.rack_description,  
			numbering_from_bottom_to_top, 
			rack.responsible, 
			rack.rack_financially_responsible_person, 
			rack.rack_inventory_number, 
			rack.row, 
			rack.place, 
			rack.rack_height,
			rack.rack_width,
			rack.rack_depth, 
			rack.rack_unit_width,
			rack.rack_unit_depth,
			rack.rack_type,
			rack.rack_palce_type,
			rack.max_load,
			rack.power_sockets,
			rack.power_sockets_ups,
			external_ups,
			cooler,
			rack.updated_by, 
			rack.updated_at, 
			rack.room_name,
			rack.building_name,
			rack.site_name,
			rack.department_name,
			rack.region_name,
			rack_link + str(rack.id),
		])
	response['Content-Disposition'] = 'attachment; filename="racks.csv"'
	return response


#############################################
#Вьюшки для объектов
#############################################
@login_required(login_url='login/')
def site_add_view(request, pk):
	template_name = 'add.html'
	form_class = SiteForm
	form = form_class(request.POST or None, initial = {
		"updated_by": request.user.get_full_name(), 
		"department_id": pk
	})

	if request.method == 'POST':
		if form.is_valid():
			if _check_group(request, pk, model=Department):
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
	return render(request, template_name, {
		'form': form
	})


@login_required(login_url='login/')
def site_upd_view(request, pk):
	template_name = 'update.html'
	form_class = SiteForm
	site = Site.objects.get(id=pk)
	old_form = form_class(instance=site)

	if request.method == 'POST':
		form = form_class(request.POST, instance=site)
		if form.is_valid():
			if _check_group(request, pk, model=Site):
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
	return render(request, template_name, {
		'form': old_form
	})


@login_required(login_url='login/')
def site_del_view(request, pk):
	site = Site.objects.get(id=pk)

	if request.method == 'POST':
		if _check_group(request, pk, model=Site):
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
	template_name = 'add.html'
	form_class = BuildingForm
	form = form_class(request.POST or None, initial = {
		"updated_by": request.user.get_full_name(), 
		"site_id": pk
	})

	if request.method == 'POST':
		if form.is_valid():
			if _check_group(request, pk, model=Site):
				if form.instance.building_name in _unique_check(pk, 
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
	return render(request, template_name, {
		'form': form
	})


@login_required(login_url='login/')
def building_upd_view(request, pk):
	template_name = 'update.html'
	form_class = BuildingForm
	building = Building.objects.get(id=pk)
	old_form = form_class(instance=building)

	if request.method == 'POST':
		form = form_class(request.POST, instance=building)
		if form.is_valid():
			if _check_group(request, pk, model=Building):
				if form.instance.building_name in _unique_check(pk, 
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
	return render(request, template_name, {
		'form': old_form
	})


@login_required(login_url='login/')
def building_del_view(request, pk):
	building = Building.objects.get(id=pk)

	if request.method == 'POST':
		if _check_group(request, pk, model=Building):
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
	template_name = 'add.html'
	form_class = RoomForm
	form = form_class(request.POST or None, initial = {
		"updated_by": request.user.get_full_name(), 
		"building_id": pk
	})

	if request.method == 'POST':
		if form.is_valid():
			if _check_group(request, pk, model=Building):
				if form.instance.room_name in _unique_check(pk, 
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
	return render(request, template_name, {
		'form': form
	})


@login_required(login_url='login/')
def room_upd_view(request, pk):
	template_name = 'update.html'
	form_class = RoomForm
	room = Room.objects.get(id=pk)
	old_form = form_class(instance=room)

	if request.method == 'POST':
		form = form_class(request.POST, instance=room)
		if form.is_valid():
			if _check_group(request, pk, model=Room):
				if form.instance.room_name in _unique_check(pk, 
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
	return render(request, template_name, {
		'form': old_form
	})


@login_required(login_url='login/')
def room_del_view(request, pk):
	room = Room.objects.get(id=pk)

	if request.method == 'POST':
		if _check_group(request, pk, model=Room):
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
	template_name = 'add.html'
	form_class = RackForm
	form = form_class(request.POST or None, initial = {
		"updated_by": request.user.get_full_name(), "room_id": pk
	})

	if request.method == 'POST':
		if form.is_valid():
			if _check_group(request, pk, model=Room):
				if form.instance.rack_name in _unique_check(pk, model=Room):
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
	return render(request, template_name, {
		'form': form
	})


@login_required(login_url='login/')
def rack_upd_view(request, pk):
	template_name = 'update.html'
	form_class = UpdRackForm
	rack = Rack.objects.get(id=pk)
	old_form = form_class(instance=rack)

	if request.method == 'POST':
		form = form_class(request.POST, instance=rack)
		if form.is_valid():
			if _check_group(request, pk, model=Rack):
				if old_form.instance.rack_name != form.instance.rack_name:
					if form.instance.rack_name in _unique_check(pk, model=Room):
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
	return render(request, template_name, {
		'form': old_form
	})


@login_required(login_url='login/')
def rack_del_view(request, pk):
	rack = Rack.objects.get(id=pk)

	if request.method == 'POST':
		if _check_group(request, pk, model=Rack):
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
	template_name = 'add.html'
	form_class = DeviceForm
	form = form_class(request.POST or None, initial = {
		"updated_by": request.user.get_full_name(), 
		"rack_id": pk
	})

	if request.method == 'POST':
		if form.is_valid():
			if _check_group(request, pk, model=Rack):
				units = _check_new_units(form)
				units.update(_check_all_units(pk))
				if _unit_check_exist(units, form, pk): 
					return render(request, 'answer.html', {
						'answer': 'Указанных юнитов нет в стойке'
					})
				if _unit_check_busy(units, form, pk, update=False):
					return render(request, 'answer.html', {
						'answer': 'Указанные юниты заняты'
					})
				form.instance.device_vendor.capitalize()
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
	return render(request, template_name, {
		'form': form
	})


@login_required(login_url='login/')
def device_upd_view(request, pk):
	template_name = 'update.html'
	form_class = DeviceForm
	device = Device.objects.get(id=pk)
	old_form = form_class(instance=device)

	if request.method == 'POST':
		form = form_class(request.POST, instance=device)
		if form.is_valid():
			if _check_group(request, pk, model=Device):
				units = _check_old_units(pk)
				pk = _check_rack_id(pk)
				units.update(_check_new_units(form))
				units.update(_check_all_units(pk))
				if _unit_check_exist(units, form, pk): 
					return render(request, 'answer.html', {
						'answer': 'Указанных юнитов нет в стойке'
					})
				if _unit_check_busy(units, form, pk, update=True):
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
	return render(request, template_name, {
		'form': old_form
	})


@login_required(login_url='login/')
def device_del_view(request, pk):
	device = Device.objects.get(id=pk)

	if request.method == 'POST':
		if _check_group(request, pk, model=Device):
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








