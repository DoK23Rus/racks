from django.contrib import admin
from mainapp.models import (Region,
                            Department,
                            Site,
                            Building,
                            Room,
                            Rack,
                            Device)
# Register your models here.


admin.site.register(Region)
admin.site.register(Department)
admin.site.register(Site)
admin.site.register(Building)
admin.site.register(Room)
admin.site.register(Rack)
admin.site.register(Device)
