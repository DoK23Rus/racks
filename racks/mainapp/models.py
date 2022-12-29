from django.db import models
from django.db.models.base import ModelBase
from django.db.models.query import QuerySet, RawQuerySet


class RegionManager(models.Manager):
    """
    Region manager
    """

    def get_all_regions(self) -> QuerySet:
        """
        Get all regions

        Returns:
            all_regions (QuerySet): All regions queryset
        """
        return Region.objects.all()


class DepartmentManager(models.Manager):
    """
    Department manager
    """

    def get_all_departments(self) -> QuerySet:
        """
        Get all departments

        Returns:
            all_departments (QuerySet): All departments queryset
        """
        return Department.objects.all()


class SiteManager(models.Manager):
    """
    Site manager
    """

    def get_all_sites(self) -> QuerySet:
        """
        Get all sites

        Returns:
            all_sites (QuerySet): All sites queryset
        """
        return Site.objects.all()

    def get_site_department(self, pk: int) -> ModelBase:
        """
        Get select related department for site

        Args:
            pk (int): Primary key

        Returns:
            site_department (ModelBase): Select related department for site
        """
        return Site.objects \
            .select_related('department_id') \
            .get(id=pk)


class BuildingManager(models.Manager):
    """
    Building manager
    """

    def get_all_buildings(self) -> QuerySet:
        """
        Get all buildings

        Returns:
            all_buildings (QuerySet): All buildings queryset
        """
        return Building.objects.all()

    def get_buildings_for_site(self, pk: int) -> QuerySet:
        """
        Get buildings for single site

        Args:
            pk (int): Primary key

        Returns:
            buildings_for_site (QuerySet): Buildings for single site queryset
        """
        return Building.objects.filter(site_id_id=pk)

    def get_building_department(self, pk: int) -> ModelBase:
        """
        Get select related department for building

        Args:
            pk (int): Primary key

        Returns:
            building_department (ModelBase): Select related department
                for building
        """
        return Building.objects \
            .select_related('site_id__'
                            'department_id') \
            .get(id=pk)


class RoomManager(models.Manager):
    """
    Room manager
    """

    def get_all_rooms(self) -> QuerySet:
        """
        Get all rooms

        Returns:
            all_rooms (QuerySet): All rooms queryset
        """
        return Room.objects.all()

    def get_rooms_for_building(self, pk: int) -> QuerySet:
        """
        Get rooms for single building

        Args:
            pk (int): Primary key

        Returns:
            rooms_for_building (QuerySet): Rooms for single building
        """
        return Room.objects.filter(building_id_id=pk)

    def get_room_department(self, pk: int) -> ModelBase:
        """
        Get select related department for room

        Args:
            pk (int): Primary key

        Returns:
            room_department (ModelBase): Select related department for room
        """
        return Room.objects \
            .select_related('building_id__'
                            'site_id__'
                            'department_id') \
            .get(id=pk)


class RackManager(models.Manager):
    """
    Rack manager
    """

    def get_all_racks(self) -> QuerySet:
        """
        Get all racks

        Returns:
            all_racks (QuerySet): All racks queryset
        """
        return Rack.objects.all()

    def get_rack(self, pk: int) -> ModelBase:
        """
        Get single rack

        Args:
            pk (int): Primary key

        Returns:
            rack (ModelBase): Single rack
        """
        return Rack.objects.get(id=pk)

    def get_racks_for_room(self, pk: int) -> QuerySet:
        """
        Get racks for single room

        Args:
            pk (int): Primary key

        Returns:
            racks_for_rooms (QuerySet): Racks for single room
        """
        return Rack.objects.filter(room_id_id=pk)

    def get_rack_vendors(self) -> QuerySet:
        """
        Get rack vendors

        Returns:
            rack_vendors (QuerySet): Rack vendors
        """
        return Rack.objects.values_list('rack_vendor', flat=True)

    def get_rack_models(self) -> QuerySet:
        """
        Get rack models

        Returns:
            rack_models (QuerySet): Rack models
        """
        return Rack.objects.values_list('rack_model', flat=True)

    def get_rack_room(self, pk: int) -> ModelBase:
        """
        Get select related room for rack

        Args:
            pk (int): Primary key

        Returns:
            rack_room (ModelBase): Select related room for rack
        """
        return Rack.objects \
            .select_related('room_id').get(id=pk)

    def get_rack_building(self, pk: int) -> ModelBase:
        """
        Get select related building for rack

        Args:
            pk (int): Primary key

        Returns:
            rack_building (ModelBase): Select related building for rack
        """
        return Rack.objects \
            .select_related('room_id__'
                            'building_id') \
            .get(id=pk)

    def get_rack_site(self, pk: int) -> ModelBase:
        """
        Get select related site for rack

        Args:
            pk (int): Primary key

        Returns:
            rack_building (ModelBase): Select related building for rack
        """
        return Rack.objects \
            .select_related('room_id__'
                            'building_id__'
                            'site_id') \
            .get(id=pk)

    def get_rack_department(self, pk: int) -> ModelBase:
        """
        Get select related department for rack

        Args:
            pk (int): Primary key

        Returns:
            rack_department (ModelBase): Select related department for rack
        """
        return Rack.objects \
            .select_related('room_id__'
                            'building_id__'
                            'site_id__'
                            'department_id') \
            .get(id=pk)

    def get_rack_region(self, pk: int) -> ModelBase:
        """
        Get select related region for rack

        Args:
            pk (int): Primary key

        Returns:
            rack_region (ModelBase): Select related region for rack
        """
        return Rack.objects \
            .select_related('room_id__'
                            'building_id__'
                            'site_id__'
                            'department_id__'
                            'region_id') \
            .get(id=pk)

    def get_racks_report(self) -> RawQuerySet:
        return Rack.objects.raw("""SELECT rack.id as id,
                                rack.*,
                                room.room_name,
                                building.building_name,
                                site.site_name,
                                department.department_name,
                                region.region_name
                                FROM rack
                                JOIN room ON
                                room.id =
                                rack.room_id_id
                                JOIN building ON
                                building.id =
                                room.building_id_id
                                JOIN site ON
                                site.id =
                                building.site_id_id
                                JOIN department ON
                                department.id =
                                site.department_id_id
                                JOIN region ON
                                region.id =
                                department.region_id_id;""")


class DeviceManager(models.Manager):
    """
    Device manager
    """

    def get_device(self, pk: int) -> ModelBase:
        """
        Get single device

        Args:
            pk (int): Primary key

        Returns:
            device (ModelBase): Single device
        """
        return Device.objects.get(id=pk)

    def get_devices_for_side(self, pk: int, side: bool) -> QuerySet:
        """
        Get devices for rack on one side

        Args:
            pk (int): Primary key
            side (bool): Side location (front - True, back - False)

        Returns:
            devices_for_side (QuerySet): Devices for rack on one side queryset
        """
        return Device.objects.filter(rack_id_id=pk) \
            .filter(frontside_location=side)

    def get_devices_for_rack(self, pk: int) -> QuerySet:
        """
        Get devices for rack

        Args:
            pk (int): Primary key

        Returns:
            devices_for_rack (QuerySet): Devices for rack queryset
        """
        return Device.objects.filter(rack_id_id=pk)

    def get_device_rack(self, pk: int) -> ModelBase:
        """
        Get select related rack for device

        Args:
            pk (int): Primary key

        Returns:
            device_rack (ModelBase): Select related rack for device
        """
        return Device.objects \
            .select_related('rack_id') \
            .get(id=pk)

    def get_device_room(self, pk: int) -> ModelBase:
        """
        Get select related room for device

        Args:
            pk (int): Primary key

        Returns:
            device_room (ModelBase): Select related room for device
        """
        return Device.objects \
            .select_related('rack_id__'
                            'room_id') \
            .get(id=pk)

    def get_device_building(self, pk: int) -> ModelBase:
        """
        Get select related building for device

        Args:
            pk (int): Primary key

        Returns:
            device_building (ModelBase): Select related building for device
        """
        return Device.objects \
            .select_related('rack_id__'
                            'room_id__'
                            'building_id') \
            .get(id=pk)

    def get_device_site(self, pk: int) -> ModelBase:
        """
        Get select related site for device

        Args:
            pk (int): Primary key

        Returns:
            device_site (ModelBase): Select related site for device
        """
        return Device.objects \
            .select_related('rack_id__'
                            'room_id__'
                            'building_id__'
                            'site_id') \
            .get(id=pk)

    def get_device_department(self, pk: int) -> ModelBase:
        """
        Get select related department for device

        Args:
            pk (int): Primary key

        Returns:
            device_department (ModelBase): Select related department for device
        """
        return Device.objects \
            .select_related('rack_id__'
                            'room_id__'
                            'building_id__'
                            'site_id__'
                            'department_id') \
            .get(id=pk)

    def get_device_region(self, pk: int) -> ModelBase:
        """
        Get select related region for device

        Args:
            pk (int): Primary key

        Returns:
            device_region (ModelBase): Select related region for device
        """
        return Device.objects \
            .select_related('rack_id__'
                            'room_id__'
                            'building_id__'
                            'site_id__'
                            'department_id__'
                            'region_id') \
            .get(id=pk)

    def get_device_vendors(self) -> QuerySet:
        """
        Get device vendors

        Returns:
            device_vendors (QuerySet): Device vendors queryset
        """
        return Device.objects.values_list('device_vendor', flat=True)

    def get_device_models(self) -> QuerySet:
        """
        Get device models

        Returns:
            device_models (QuerySet): Device models queryset
        """
        return Device.objects.values_list('device_model', flat=True)

    def get_devices_report(self) -> RawQuerySet:
        return Device.objects.raw("""SELECT device.id as id,
                                  device.*,
                                  rack.rack_name,
                                  room.room_name,
                                  building.building_name,
                                  site.site_name,
                                  department.department_name,
                                  region.region_name
                                  FROM device
                                  JOIN rack ON
                                  rack.id =
                                  device.rack_id_id
                                  JOIN room ON
                                  room.id =
                                  rack.room_id_id
                                  JOIN building ON
                                  building.id =
                                  room.building_id_id
                                  JOIN site ON
                                  site.id =
                                  building.site_id_id
                                  JOIN department ON
                                  department.id =
                                  site.department_id_id
                                  JOIN region ON
                                  region.id =
                                  department.region_id_id;""")


class Region(models.Model):
    """
    Region model
    """
    region_name = models.CharField(max_length=128,
                                   unique=True,
                                   verbose_name='Region')
    objects = RegionManager()

    class Meta:
        db_table = 'region'
        verbose_name = 'Region'
        verbose_name_plural = 'Regions'

    def __str__(self):
        return self.region_name


class Department(models.Model):
    """
    Department model
    """
    department_name = models.CharField(max_length=128,
                                       unique=True,
                                       verbose_name='Department')
    region_id = models.ForeignKey(Region,
                                  on_delete=models.CASCADE,
                                  verbose_name='Region')
    objects = DepartmentManager()

    class Meta:
        db_table = 'department'
        verbose_name = 'Department'
        verbose_name_plural = 'Departments'

    def __str__(self):
        return self.department_name


class Site(models.Model):
    """
    Site model
    """
    site_name = models.CharField(max_length=128,
                                 unique=True,
                                 verbose_name='Site')
    updated_by = models.CharField(max_length=128,
                                  verbose_name='Updated by')
    updated_at = models.DateTimeField(auto_now=True,
                                      verbose_name='Updated at')
    department_id = models.ForeignKey(Department,
                                      on_delete=models.CASCADE,
                                      verbose_name='Department')
    objects = SiteManager()

    class Meta:
        db_table = 'site'
        verbose_name = 'Site'
        verbose_name_plural = 'Sites'

    def __str__(self):
        return self.site_name


class Building(models.Model):
    """
    Building model
    """
    building_name = models.CharField(max_length=128,
                                     verbose_name='Building')
    updated_by = models.CharField(max_length=128,
                                  verbose_name='Updated by')
    updated_at = models.DateTimeField(auto_now=True,
                                      verbose_name='Updated at')
    site_id = models.ForeignKey(Site,
                                on_delete=models.CASCADE,
                                verbose_name='Site')
    objects = BuildingManager()

    class Meta:
        db_table = 'building'
        verbose_name = 'Building'
        verbose_name_plural = 'Buildings'

    def __str__(self):
        return self.building_name


class Room(models.Model):
    """
    Room model (technical rooms, server rooms, etc)
    """
    room_name = models.CharField(max_length=128,
                                 verbose_name='Room')
    updated_by = models.CharField(max_length=128,
                                  verbose_name='Updated by')
    updated_at = models.DateTimeField(auto_now=True,
                                      verbose_name='Updated at')
    building_id = models.ForeignKey(Building,
                                    on_delete=models.CASCADE,
                                    verbose_name='Building')
    objects = RoomManager()

    class Meta:
        db_table = 'room'
        verbose_name = 'Room'
        verbose_name_plural = 'Rooms'

    def __str__(self):
        return self.room_name


class Rack(models.Model):
    """
    Rack model (racks, telecom-cabinets, etc)
    """
    rack_name = models.CharField(max_length=128,
                                 verbose_name='Rack name')
    rack_amount = models.IntegerField(verbose_name='Rack amount (units)')
    rack_vendor = models.CharField(max_length=128,
                                   blank=True,
                                   verbose_name='Rack vendor')
    rack_model = models.CharField(max_length=128,
                                  blank=True,
                                  verbose_name='Rack model')
    rack_description = models.TextField(blank=True,
                                        verbose_name='Description')
    numbering_from_bottom_to_top = models \
        .BooleanField(default=True,
                      verbose_name='Numbering from bottom to top')
    responsible = models.CharField(max_length=128,
                                   blank=True,
                                   verbose_name='Responsible')
    rack_financially_responsible_person = models \
        .CharField(max_length=128,
                   blank=True,
                   verbose_name='Financially responsible')
    rack_inventory_number = models.CharField(max_length=128,
                                             blank=True,
                                             verbose_name='Inventory number')
    fixed_asset = models.CharField(max_length=128,
                                   blank=True,
                                   verbose_name='Fixed asset')
    link = models.CharField(max_length=128,
                            blank=True,
                            verbose_name='Link to docs')
    row = models.CharField(max_length=128,
                           blank=True,
                           verbose_name='Row')
    place = models.CharField(max_length=128,
                             blank=True,
                             verbose_name='Place')
    rack_height = models.IntegerField(blank=True,
                                      null=True,
                                      verbose_name='Rack height (mm)')
    rack_width = models.IntegerField(blank=True,
                                     null=True,
                                     verbose_name='Rack width (mm)')
    rack_depth = models.IntegerField(blank=True,
                                     null=True,
                                     verbose_name='Rack depth (mm)')
    rack_unit_width = models \
        .IntegerField(blank=True,
                      null=True,
                      default=19,
                      verbose_name='Useful rack width (inches)')
    rack_unit_depth = models \
        .IntegerField(blank=True,
                      null=True,
                      verbose_name='Useful rack depth (mm)')
    rack_type_choices = [
        ('Rack', 'Rack'),
        ('Protective cabinet', 'Protective cabinet'),
    ]
    rack_type = models.CharField(max_length=32,
                                 choices=rack_type_choices,
                                 default='Rack',
                                 verbose_name='Execution variant')
    frame_choices = [
        ('Single frame', 'Single frame'),
        ('Double frame', 'Double frame'),
    ]
    rack_frame = models.CharField(max_length=32,
                                  choices=frame_choices,
                                  default='Double frame',
                                  verbose_name='Construction')
    rack_palce_type_choices = [
        ('Floor standing', 'Floor standing'),
        ('Wall mounted', 'Wall mounted'),
    ]
    rack_palce_type = models.CharField(max_length=32,
                                       choices=rack_palce_type_choices,
                                       default='Floor standing',
                                       verbose_name='Location type')
    max_load = models.IntegerField(blank=True,
                                   null=True,
                                   verbose_name='Max load (kilo)')
    power_sockets = models.IntegerField(blank=True,
                                        null=True,
                                        verbose_name='Free power sockets')
    power_sockets_ups = models \
        .IntegerField(blank=True,
                      null=True,
                      verbose_name='Free UPS power sockets')
    external_ups = models \
        .BooleanField(default=True,
                      verbose_name='External power backup supply system')
    cooler = models.BooleanField(default=False,
                                 verbose_name='Active ventilation')
    updated_by = models.CharField(max_length=128,
                                  verbose_name='Updated by')
    updated_at = models.DateTimeField(auto_now=True,
                                      verbose_name='Updated at')
    room_id = models.ForeignKey(Room,
                                on_delete=models.CASCADE,
                                verbose_name='Room')
    objects = RackManager()

    class Meta:
        db_table = 'rack'
        verbose_name = 'Rack'
        verbose_name_plural = 'Racks'

    def __str__(self):
        return self.rack_name


class Device(models.Model):
    """
    Device model (switches, routers, servers, etc)
    """
    first_unit = models.IntegerField(verbose_name='First unit')
    last_unit = models.IntegerField(verbose_name='Last unit')
    frontside_location = models \
        .BooleanField(default=True,
                      verbose_name='Installed on the front')
    status_choices = [
        ('Device active', 'Device active'),
        ('Device failed', 'Device failed'),
        ('Device turned off', 'Device turned off'),
        ('Device not in use', 'Device not in use'),
        ('Units reserved', 'Units reserved'),
        ('Units not available', 'Units not available'),
    ]
    status = models.CharField(max_length=32,
                              choices=status_choices,
                              default='Device active',
                              verbose_name='Status')
    device_type_choices = [
        ('Switch', 'Switch'),
        ('Router', 'Router'),
        ('Firewall', 'Firewall'),
        ('Security Gateway', 'Security Gateway'),
        ('Other', 'Other'),
        ('Fiber optic patch panel', 'Fiber optic patch panel'),
        ('RJ45 patch panel', 'RJ45 patch panel'),
        ('Organizer', 'Organizer'),
        ('Rack shelf', 'Rack shelf'),
        ('UPS', 'UPS'),
        ('Server', 'Server'),
        ('KVM console', 'KVM console'),
    ]
    device_type = models.CharField(max_length=32,
                                   choices=device_type_choices,
                                   default='Other',
                                   verbose_name='Device type')
    device_vendor = models.CharField(max_length=128,
                                     blank=True,
                                     verbose_name='Device vendor')
    device_model = models.CharField(max_length=128,
                                    blank=True,
                                    verbose_name='Device model')
    device_hostname = models.CharField(max_length=128,
                                       blank=True,
                                       verbose_name='Hostname')
    ip = models.GenericIPAddressField(blank=True,
                                      null=True,
                                      verbose_name='IP-address')
    device_stack = models \
        .IntegerField(blank=True,
                      null=True,
                      verbose_name='Stack/Reserve (reserve ID)')
    ports_amout = models.IntegerField(blank=True,
                                      null=True,
                                      verbose_name='Port capacity')
    version = models.CharField(max_length=128,
                               blank=True,
                               verbose_name='Software version')
    power_type_choices = [
        ('External power supply', 'External power supply'),
        ('Clamps', 'Clamps'),
        ('IEC C14 socket', 'IEC C14 socket'),
        ('Passive equipment', 'Passive equipment'),
        ('Other', 'Other'),
    ]
    power_type = models.CharField(max_length=32,
                                  choices=power_type_choices,
                                  default='IEC C14 socket',
                                  verbose_name='Socket type')
    power_w = models.IntegerField(blank=True,
                                  null=True,
                                  verbose_name='Power requirement (W)')
    power_v = models.IntegerField(blank=True,
                                  null=True,
                                  default=220,
                                  verbose_name='Voltage (V)')
    power_ac_dc_choices = [
        ('AC', 'AC'),
        ('DC', 'DC'),
    ]
    power_ac_dc = models.CharField(max_length=2,
                                   choices=power_ac_dc_choices,
                                   default='AC',
                                   verbose_name='AC/DC')
    device_serial_number = models.CharField(max_length=128,
                                            blank=True,
                                            verbose_name='Serial number')
    device_description = models.TextField(blank=True,
                                          verbose_name='Description')
    project = models.CharField(max_length=128,
                               blank=True,
                               verbose_name='Project')
    ownership = models.CharField(max_length=128,
                                 default='Our department',
                                 verbose_name='Ownership')
    responsible = models.CharField(max_length=128,
                                   blank=True,
                                   verbose_name='Responsible')
    financially_responsible_person = models \
        .CharField(max_length=128,
                   blank=True,
                   verbose_name='Financially responsible')
    device_inventory_number = models.CharField(max_length=128,
                                               blank=True,
                                               verbose_name='Inventory number')
    fixed_asset = models.CharField(max_length=128,
                                   blank=True,
                                   verbose_name='Fixed asset')
    link = models.CharField(max_length=128,
                            blank=True,
                            verbose_name='Link to docs')
    updated_by = models.CharField(max_length=128,
                                  verbose_name='Updated by')
    updated_at = models.DateTimeField(auto_now=True,
                                      verbose_name='Updated at')
    rack_id = models.ForeignKey(Rack,
                                on_delete=models.CASCADE,
                                verbose_name='Rack')
    rack_name = True
    objects = DeviceManager()

    class Meta:
        db_table = 'device'
        verbose_name = 'Device'
        verbose_name_plural = 'Devices'

    def __str__(self):
        return f'{str(self.device_vendor)} {str(self.device_model)}'
