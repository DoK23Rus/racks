from .models import Region, Department, Site, Building, Room, Rack, Device
from django.forms.models import model_to_dict
from .forms import *
from django.db import models
from urllib import request



def _queryset_devices(pk, side):
	"""
	Данные об устройствах в зависимости от стороны стойки
	Для отрисовки стоек
	"""
	return Device.objects.filter(rack_id_id=pk) \
						 .filter(frontside_location=side)


def _direction(pk):
	"""
	Напрвление нумерации стойки
	Для отрисовки стоек
	"""
	return model_to_dict(Rack.objects \
						 .get(id=pk))['numbering_from_bottom_to_top']


def _start_list(pk, direction):
	"""
	Список юнитов (всего)
	Для отрисовки стоек
	"""
	rack_query_dict = model_to_dict(Rack.objects.get(id=pk))
	if direction == False:
		return list(range(1, (int(rack_query_dict['rack_amount']) + 1)))
	else:
		return list(range(1, (int(rack_query_dict['rack_amount']) + 1)))[::-1]


def _first_units(pk, direction, side):
	"""
	Первые юниты по порядку для каждого устройства 
	в зависимости от напрвления нумерации
	Для отрисовки стоек
	"""
	first_units = {}
	queryset_spans = Device.objects.filter(rack_id_id=pk) \
								   .filter(frontside_location=side)
	for span in queryset_spans:
		queryset_spans_dict = model_to_dict(span)
		last = queryset_spans_dict["last_unit"]
		first = queryset_spans_dict["first_unit"]
		if direction == True:
			if last > first:
				first = queryset_spans_dict["last_unit"]
			first_units[queryset_spans_dict["id"]] = first
		else:
			if last < first:
				first = queryset_spans_dict["last_unit"]
			first_units[queryset_spans_dict["id"]] = first
	return first_units


def _spans(pk, side):
	"""
	Роуспаны для каждого устройства (устройства шириной более одного юнита)
	Для отрисовки стоек
	"""
	spans = {}
	queryset_spans = Device.objects.filter(rack_id_id=pk) \
								   .filter(frontside_location=side)
	for span in queryset_spans:
		queryset_spans_dict = model_to_dict(span)
		last = queryset_spans_dict["last_unit"]
		first = queryset_spans_dict["first_unit"]
		if last < first:
			first = queryset_spans_dict["last_unit"]
			last = queryset_spans_dict["first_unit"]
		spans[queryset_spans_dict["id"]] = last - first + 1
	return spans


def _check_group(request, pk, model):
	"""
	Проверка есть ли в списке групп пользователя группа 
	с наминованием отдела совпадающая с принадлежностью объекта модели к 
	зоне ответственности отдела по первичным ключам 
	                                                      __
	                                          ======      \/
	_____________ _____________ _____________ | [] |=========
	\  костыли  / \  костыли  / \  костыли  / |              )
	 ===========   ===========   ===========  ================
	 O-O     O-O   O-O     O-O   O-O     O-O  O-O-O   O-O-O \\

	Не дает изменять данные закрепленые за другим отделом
	"""
	if model == Department:
		department_raw_query = Department.objects.raw("""select department.id as id,
											  department.department_name 
											  from department 
	 										  where 
	 										  department.id='""" + 
	 										  str(pk) + 
	 										  """';""")
	elif model == Site:
		department_raw_query = Department.objects.raw("""select department.id as id, 
											  department.department_name 
											  from site 
											  join department on 
											  department.id = 
											  site.department_id_id 
											  where 
											  site.id='""" + 
											  str(pk) + 
											  """';""")
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
											  building.id='""" + 
											  str(pk) + 
											  """';""")
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
											  room.id='""" + 
											  str(pk) + 
											  """';""")
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
											  rack.id='""" + 
											  str(pk) + 
											  """';""")
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
											  device.id='""" + 
											  str(pk) + 
											  """';""")
	user_groups = list(request.user.groups.values_list('name', flat=True))
	department_name = str([department_name for department_name in department_raw_query][0])
	if department_name in user_groups:
		return True


def _check_old_units(pk):
	"""
	Уже заполненные юниты
	Для перемещения устройства в стойке
	"""
	units = {}
	units['old_first_unit'] = model_to_dict(Device.objects \
											.get(id=pk))['first_unit']
	units['old_last_unit'] = model_to_dict(Device.objects \
										   .get(id=pk))['last_unit']
	if units['old_first_unit'] > units['old_last_unit']:
		units['old_last_unit'] = model_to_dict(Device.objects \
											   .get(id=pk))['first_unit']
		units['old_first_unit'] = model_to_dict(Device.objects \
												.get(id=pk))['last_unit']
	return units


def _check_rack_id(pk):
	"""
	ID стойки
	"""
	return model_to_dict(Device.objects.get(id=pk))['rack_id']


def _check_new_units(form):
	"""
	Юниты для вновь добавляемого устройства
	"""
	units= {}
	new_first_unit = form.instance.first_unit
	new_last_unit = form.instance.last_unit
	if new_first_unit > new_last_unit:
		new_last_unit = form.instance.first_unit
		new_first_unit = form.instance.last_unit
	units['new_first_unit'] = new_first_unit
	units['new_last_unit'] = new_last_unit
	return units


def _check_all_units(pk):
	"""
	Всего юнитов в стойке
	"""
	units = {}
	units['all_units'] = model_to_dict(Rack.objects.get(id=pk))['rack_amount']
	return units
	

def _unit_check_exist(units, form, pk):
	"""
	Есть ли вообще такие юниты (болше или меньше указанного)?
	"""
	if not set(range(units['new_first_unit'], units['new_last_unit'] + 1)) \
		.issubset(range(1, units['all_units'] + 1)):
		return True
		

def _unit_check_busy(units, form, pk, update):
	"""
	Заняты ли юниты (добавление, перемещение устройства)?
	"""
	filled_list = []
	queryset_devices = Device.objects.filter(rack_id_id=pk) \
				.filter(frontside_location=form.instance.frontside_location)
	if len(list(queryset_devices)) > 0:
		for device in queryset_devices:
			devices_dict = model_to_dict(device)
			first_unit = devices_dict["first_unit"]
			last_unit = devices_dict["last_unit"]
			if first_unit > last_unit:
				first_unit = devices_dict["last_unit"]
				last_unit = devices_dict["first_unit"]
			one_device_list = list(range(first_unit, last_unit + 1))
			filled_list.extend(one_device_list)
	if update == True:
		filled_list = set(filled_list) - set(range(units['old_first_unit'], 
												   units['old_last_unit'] + 1)) 
	if any(unit in set(range(units['new_first_unit'], 
		   units['new_last_unit'] + 1)) for unit in filled_list):
		return True


def _unique_check(pk, model):
	"""
	Чтобы наименования зданий помещений и стоек могли повторяться 
	в рамках зоны ответственности одного отдела
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



