from django.db import models


class Region(models.Model):
    region_name = models.CharField(max_length=128, 
                                   unique=True, 
                                   verbose_name='Region')

    class Meta: 
        db_table = 'region'
        verbose_name = 'Region'
        verbose_name_plural = 'Regions'

    def __str__(self):
        return self.region_name


class Department(models.Model):
    department_name = models.CharField(max_length=128, 
                                       unique=True, 
                                       verbose_name='Department')
    region_id = models.ForeignKey(Region, 
                                  on_delete=models.CASCADE, 
                                  verbose_name='Region')

    class Meta: 
        db_table = 'department'
        verbose_name = 'Department'
        verbose_name_plural = 'Departments'

    def __str__(self):
        return self.department_name


class Site(models.Model):
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

    class Meta: 
        db_table = 'site'
        verbose_name = 'Site'
        verbose_name_plural = 'Sites'

    def __str__(self):
        return self.site_name


class Building(models.Model):
    building_name = models.CharField(max_length=128, 
                                     verbose_name='Building')
    updated_by = models.CharField(max_length=128, 
                                  verbose_name='Updated by')
    updated_at = models.DateTimeField(auto_now=True, 
                                      verbose_name='Updated at')
    site_id = models.ForeignKey(Site, 
                                on_delete=models.CASCADE, 
                                verbose_name='Site')

    class Meta: 
        db_table = 'building'
        verbose_name = 'Building'
        verbose_name_plural = 'Buildings'

    def __str__(self):
        return self.building_name


class Room(models.Model):
    room_name = models.CharField(max_length=128, 
                                 verbose_name='Room')
    updated_by = models.CharField(max_length=128, 
                                  verbose_name='Updated by')
    updated_at = models.DateTimeField(auto_now=True, 
                                      verbose_name='Updated at')
    building_id = models.ForeignKey(Building, 
                                    on_delete=models.CASCADE, 
                                    verbose_name='Building')

    class Meta: 
        db_table = 'room'
        verbose_name = 'Room'
        verbose_name_plural = 'Rooms'

    def __str__(self):
        return self.room_name

 
class Rack(models.Model):
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
    numbering_from_bottom_to_top = models.BooleanField(default=True, 
                                                       verbose_name='Numbering from bottom to top')
    responsible = models.CharField(max_length=128, 
                                   blank=True, 
                                   verbose_name='Responsible')
    rack_financially_responsible_person = models.CharField(max_length=128, 
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
    rack_unit_width = models.IntegerField(blank=True, 
                                          null=True, 
                                          default=19, 
                                          verbose_name='Useful rack width (inches)')
    rack_unit_depth = models.IntegerField(blank=True, 
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
    power_sockets_ups = models.IntegerField(blank=True, 
                                            null=True, 
                                            verbose_name='Free UPS power sockets')
    external_ups = models.BooleanField(default=True, 
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

    class Meta: 
        db_table = 'rack'
        verbose_name = 'Rack'
        verbose_name_plural = 'Racks'

    def __str__(self):
        return self.rack_name


class Device(models.Model):
    first_unit = models.IntegerField(verbose_name='First unit')    
    last_unit = models.IntegerField(verbose_name='Last unit')
    frontside_location = models.BooleanField(default=True, 
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
    device_stack = models.IntegerField(blank=True, 
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
    financially_responsible_person = models.CharField(max_length=128, 
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

    class Meta: 
        db_table = 'device'
        verbose_name = 'Device'
        verbose_name_plural = 'Devices'

    def __str__(self):
        return str(self.device_vendor) + ' ' + str(self.device_model)
