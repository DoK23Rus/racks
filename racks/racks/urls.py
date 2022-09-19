"""racks URL Configuration

The `urlpatterns` list routes URLs to views. For more information please see:
    https://docs.djangoproject.com/en/2.2/topics/http/urls/
Examples:
Function views
    1. Add an import:  from my_app import views
    2. Add a URL to urlpatterns:  path('', views.home, name='home')
Class-based views
    1. Add an import:  from other_app.views import Home
    2. Add a URL to urlpatterns:  path('', Home.as_view(), name='home')
Including another URLconf
    1. Import the include() function: from django.urls import include, path
    2. Add a URL to urlpatterns:  path('blog/', include('blog.urls'))
"""
from django.contrib import admin
from django.urls import path
from mainapp.views import *
from django.contrib.auth import views as auth_views
from django.contrib.staticfiles.urls import staticfiles_urlpatterns
from django.urls import path, include


urlpatterns = [
     path('admin/', admin.site.urls),
     path('admin/logout/login/', admin.site.urls),
     path('login/',
          auth_views.LoginView.as_view(template_name="login.html"),
          name='authapp-login'),
     path('logout/',
          auth_views.LogoutView.as_view(next_page="/login/"),
          name='authapp-logout'),
     path('', TreeView.as_view(), name='tree'),
     path('goto/', GotoView.as_view(), name='goto'),
     path('export_devices_view/',
          ExportDevicesView.as_view(),
          name='export_devices'),
     path('export_racks_view/',
          ExportRacksView.as_view(),
          name='export_racks'),
     path('units/<int:pk>', UnitsView.as_view(), name='units'),
     path('front_units_print/<int:pk>/',
          FrontUnitsPrintView.as_view(),
          name='front_units_print'),
     path('back_units_print/<int:pk>/',
          BackUnitsPrintView.as_view(),
          name='back_units_print'),
     path('site_add/<int:pk>',
          SiteAddView.as_view(),
          name='site_add'),
     path('site_upd/<int:pk>',
          SiteUpdateView.as_view(),
          name='site_upd'),
     path('site_del/<int:pk>/delete',
          SiteDeleteView.as_view(),
          name='site_del'),
     path('building_add/<int:pk>',
          BuildingAddView.as_view(),
          name='building_add'),
     path('building_upd/<int:pk>',
          BuildingUpdateView.as_view(),
          name='building_upd'),
     path('building_del/<int:pk>/delete',
          BuildingDeleteView.as_view(),
          name='building_del'),
     path('room_add/<int:pk>', RoomAddView.as_view(), name='room_add'),
     path('room_upd/<int:pk>', RoomUpdateView.as_view(), name='room_upd'),
     path('room_del/<int:pk>', RoomDeleteView.as_view(), name='room_del'),
     path('rack_add/<int:pk>', RackAddView.as_view(), name='rack_add'),
     path('rack_upd/<int:pk>', RackUpdateView.as_view(), name='rack_upd'),
     path('rack_del/<int:pk>', RackDeleteView.as_view(), name='rack_del'),
     path('rack_detail/<int:pk>', RackView.as_view(), name='rack_detail'),
     path('device_add/<int:pk>', DeviceAddView.as_view(), name='device_add'),
     path('device_upd/<int:pk>',
          DeviceUpdateView.as_view(),
          name='device_upd'),
     path('device_del/<int:pk>',
          DeviceDeleteView.as_view(),
          name='device_del'),
     path('device_detail/<int:pk>',
          DeviceView.as_view(),
          name='device_detail'),
     path('device_qr/<int:pk>', DeviceQrView.as_view(), name='device_qr'),
     path('rack_qr/<int:pk>', RackQrView.as_view(), name='rack_qr'),
     path('qr_list/<int:pk>', QrListView.as_view(), name='qr_list'),
     path('api-auth/', include('rest_framework.urls')),
     path('api/rack_detail/<int:pk>/', RackDetailApiView.as_view()),
     path('api/device_detail/<int:pk>/', DeviceDetailApiView.as_view()),
     path('api/devices/', DeviceListApiView.as_view()),
     path('api/racks/', RackListApiView.as_view()),
]
urlpatterns += staticfiles_urlpatterns()
