from django.db import models
# Create your models here.


class Region(models.Model):
	region_name = models.CharField(max_length=128, unique=True, verbose_name='Регион')

	class Meta: 
		db_table = 'region'
		verbose_name = 'Регион'
		verbose_name_plural = 'Регионы'

	def __str__(self):
		return self.region_name


class Department(models.Model):
	department_name = models.CharField(max_length=128, unique=True, verbose_name='Отдел')
	region_id = models.ForeignKey(Region, on_delete=models.CASCADE, verbose_name='Регион')

	class Meta: 
		db_table = 'department'
		verbose_name = 'Отдел'
		verbose_name_plural = 'Отделы'

	def __str__(self):
		return self.department_name


class Site(models.Model):
	site_name = models.CharField(max_length=128, unique=True, verbose_name='Объект')
	updated_by = models.CharField(max_length=128, verbose_name='Обновлено сотрудник')
	updated_at = models.DateTimeField(auto_now=True, verbose_name='Обновлено дата')
	department_id = models.ForeignKey(Department, on_delete=models.CASCADE, verbose_name='Отдел')

	class Meta: 
		db_table = 'site'
		verbose_name = 'Объект'
		verbose_name_plural = 'Объекты'

	def __str__(self):
		return self.site_name


class Building(models.Model):
	building_name = models.CharField(max_length=128, verbose_name='Здание')
	updated_by = models.CharField(max_length=128, verbose_name='Обновлено сотрудник')
	updated_at = models.DateTimeField(auto_now=True, verbose_name='Обновлено дата')
	site_id = models.ForeignKey(Site, on_delete=models.CASCADE, verbose_name='Объект')

	class Meta: 
		db_table = 'building'
		verbose_name = 'Здание'
		verbose_name_plural = 'Здания'

	def __str__(self):
		return self.building_name


class Room(models.Model):
	room_name = models.CharField(max_length=128, verbose_name='Помещение')
	updated_by = models.CharField(max_length=128, verbose_name='Обновлено сотрудник')
	updated_at = models.DateTimeField(auto_now=True, verbose_name='Обновлено дата')
	building_id = models.ForeignKey(Building, on_delete=models.CASCADE, verbose_name='Здание')

	class Meta: 
		db_table = 'room'
		verbose_name = 'Помещение'
		verbose_name_plural = 'Помещения'

	def __str__(self):
		return self.room_name

 
class Rack(models.Model):
	rack_name = models.CharField(max_length=128, verbose_name='Стойка')	
	rack_amount = models.IntegerField(verbose_name='Вместимость стойки (юниты)')
	rack_vendor = models.CharField(max_length=128, blank=True, verbose_name='Фирма производитель')
	rack_model = models.CharField(max_length=128, blank=True, verbose_name='Модель стойки')
	rack_description = models.TextField(blank=True, verbose_name='Описание стойки')
	numbering_from_bottom_to_top = models.BooleanField(default=True, verbose_name='Нумерация снизу вверх')
	responsible = models.CharField(max_length=128, blank=True, verbose_name='Ответственный')
	rack_financially_responsible_person = models.CharField(max_length=128, blank=True, verbose_name='МОЛ')
	rack_inventory_number = models.CharField(max_length=128, blank=True, verbose_name='Инвентарный номер')
	row = models.CharField(max_length=128, blank=True, verbose_name='Ряд')
	place = models.CharField(max_length=128, blank=True, verbose_name='Место')
	rack_height = models.IntegerField(blank=True, null=True, verbose_name='Высота стойки (мм)')
	rack_width = models.IntegerField(blank=True, null=True, verbose_name='Ширина стойки (мм)')
	rack_depth = models.IntegerField(blank=True, null=True, verbose_name='Глубина стойки (мм)')
	rack_unit_width = models.IntegerField(blank=True, null=True, default=19, verbose_name='Полезная ширина стойки (дюймы)')
	rack_unit_depth = models.IntegerField(blank=True, null=True, verbose_name='Полезная глубина стойки (мм)')
	rack_type_choices = [
		('Стойка', 'Стойка'),
		('Шкаф', 'Шкаф'),
	]
	rack_type = models.CharField(max_length=32, choices=rack_type_choices, default='Стойка', verbose_name='Вариант исполнения')
	rack_palce_type_choices = [
		('Напольный', 'Напольный'),
		('Настенный', 'Настенный'),
	]
	rack_palce_type = models.CharField(max_length=32, choices=rack_palce_type_choices, default='Напольный', verbose_name='Тип расположения')
	max_load = models.IntegerField(blank=True, null=True, verbose_name='Максимальная нагрузка (кг)')
	power_sockets = models.IntegerField(blank=True, null=True, verbose_name='Свободных электророзеток')
	power_sockets_ups = models.IntegerField(blank=True, null=True, verbose_name='Свободных электророзеток UPS')
	external_ups = models.BooleanField(default=True, verbose_name='Внешняя система резервного электроснабжения')
	cooler = models.BooleanField(default=False, verbose_name='Активная вентиляция')
	updated_by = models.CharField(max_length=128, verbose_name='Обновлено сотрудник')
	updated_at = models.DateTimeField(auto_now=True, verbose_name='Обновлено дата')
	room_id = models.ForeignKey(Room, on_delete=models.CASCADE, verbose_name='Помещение')	

	class Meta: 
		db_table = 'rack'
		verbose_name = 'Стойка'
		verbose_name_plural = 'Стойки'

	def __str__(self):
		return self.rack_name


class Device(models.Model):
	first_unit = models.IntegerField(verbose_name='Первый юнит')	
	last_unit = models.IntegerField(verbose_name='Последний юнит')
	frontside_location = models.BooleanField(default=True, verbose_name='Установленно на фронтальной стороне')
	status_choices = [
		('Устройство в работе', 'Устройство в работе'),
		('Устройство неисправно', 'Устройство неисправно'),
		('Устройство выключено', 'Устройство выключено'),
		('Устройство не эксплуатируется', 'Устройство не эксплуатируется'),
		('Юниты зарезервированы', 'Юниты зарезервированы'),
		('Юниты недоступны', 'Юниты недоступны'),	
	]
	status = models.CharField(max_length=32, choices=status_choices, default='Устройство в работе', verbose_name='Статус')
	device_type_choices = [
		('Коммутатор', 'Коммутатор'),
		('Маршрутизатор', 'Маршрутизатор'),
		('Межсетевой экран', 'Межсетевой экран'),
		('Устройство шифрования', 'Устройство шифрования'),
		('Мультиплексор', 'Мультиплексор'),
		('Оборудование РРЛ', 'Оборудование РРЛ'),
		('АТС', 'АТС'),
		('Другое', 'Другое'),
		('Кросс медный', 'Кросс медный'),
		('Кросс оптический', 'Кросс оптический'),
		('Патч-панель', 'Патч-панель'),
		('Органайзер', 'Органайзер'),
		('Полка', 'Полка'),
		('ИБП', 'ИБП'),
		('АКБ', 'АКБ'),
		('Сервер', 'Сервер'),
		('KVM консоль', 'KVM консоль'),
	]
	device_type = models.CharField(max_length=32, choices=device_type_choices, default='Другое', verbose_name='Тип оборудования')
	device_vendor = models.CharField(max_length=128, blank=True, verbose_name='Фирма производитель')
	device_model = models.CharField(max_length=128, blank=True, verbose_name='Модель устройства')
	device_hostname = models.CharField(max_length=128, blank=True, verbose_name='Hostname')
	device_stack = models.IntegerField(blank=True, null=True, verbose_name='Stack/Резерв (ID резерва)')
	power_type_choices = [
		('Внешний БП', 'Внешний БП'),
		('Клеммы', 'Клеммы'),
		('Розетка IEC C14', 'Розетка IEC C14'),
		('Пассивное оборудование', 'Пассивное оборудование'),
		('Другое', 'Другое'),
	]
	power_type = models.CharField(max_length=32, choices=power_type_choices, default='Розетка IEC C14', verbose_name='Подключение к электросети')
	power_w = models.IntegerField(blank=True, null=True, verbose_name='Потребляемая мощность (Вт)')
	power_v = models.IntegerField(blank=True, null=True, default=220, verbose_name='Рабочее напряжение (В)')
	power_ac_dc_choices = [
		('AC', 'AC'),
		('DC', 'DC'),
	]
	power_ac_dc = models.CharField(max_length=2, choices=power_ac_dc_choices, default='AC', verbose_name='Полярность тока')
	device_serial_number = models.CharField(max_length=128, blank=True, verbose_name='Серийный номер устройства')
	device_description = models.TextField(blank=True, verbose_name='Описание устройства')
	project = models.CharField(max_length=128, blank=True, verbose_name='Проект')
	ownership = models.CharField(max_length=128, default='Оборудование подразделения', verbose_name='Зона ответственности')
	financially_responsible_person = models.CharField(max_length=128, blank=True, verbose_name='МОЛ')
	device_inventory_number = models.CharField(max_length=128, blank=True, verbose_name='Инвентарный номер устройства')
	updated_by = models.CharField(max_length=128, verbose_name='Обновлено сотрудник')
	updated_at = models.DateTimeField(auto_now=True, verbose_name='Обновлено дата')
	rack_id = models.ForeignKey(Rack, on_delete=models.CASCADE, verbose_name='Стойка')	

	class Meta: 
		db_table = 'device'
		verbose_name = 'Устройство'
		verbose_name_plural = 'Устройства'

	def __str__(self):
		return str(self.device_vendor) + ' ' + str(self.device_model)
