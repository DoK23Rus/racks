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
from mainapp.views import (RackDevicesApiView,
                           DepartmentListApiView,
                           RegionListApiView,
                           SiteListApiView,
                           BuildingListApiView,
                           RoomListApiView,
                           SiteDetailApiView,
                           BuildingDetailApiView,
                           RoomDetailApiView,
                           SiteAddApiView,
                           SiteUpdateApiView,
                           SiteDeleteApiView,
                           BuildingAddApiView,
                           BuildingUpdateApiView,
                           BuildingDeleteApiView,
                           RoomAddApiView,
                           RoomUpdateApiView,
                           RoomDeleteApiView,
                           RackDetailApiView,
                           RackAddApiView,
                           RackUpdateApiView,
                           RackDeleteApiView,
                           DeviceAddApiView,
                           DeviceUpdateApiView,
                           DeviceDeleteApiView,
                           DeviceDetailApiView,
                           DeviceListApiView,
                           RackListApiView,
                           UserApiView,
                           DeviceVendorsApiView,
                           DeviceModelsApiView,
                           RackVendorsApiView,
                           RackModelsApiView,
                           )
from django.contrib.staticfiles.urls import staticfiles_urlpatterns
from django.urls import path, include
from .yasg import urlpatterns as doc_urls


urlpatterns = [
     path('admin/', admin.site.urls),
     path('api/v1/', include('djoser.urls')),
     path('api/v1/', include('djoser.urls.authtoken')),
     path('api-auth/', include('rest_framework.urls')),
     path('api/v1/user/', UserApiView.as_view()),
     path('api/v1/regions', RegionListApiView.as_view()),
     path('api/v1/departments', DepartmentListApiView.as_view()),
     path('api/v1/sites', SiteListApiView.as_view()),
     path('api/v1/site/<int:pk>', SiteDetailApiView.as_view()),
     path('api/v1/site_add', SiteAddApiView.as_view()),
     path('api/v1/site_upd', SiteUpdateApiView.as_view()),
     path('api/v1/site_del', SiteDeleteApiView.as_view()),
     path('api/v1/buildings', BuildingListApiView.as_view()),
     path('api/v1/building/<int:pk>', BuildingDetailApiView.as_view()),
     path('api/v1/building_add', BuildingAddApiView.as_view()),
     path('api/v1/building_upd', BuildingUpdateApiView.as_view()),
     path('api/v1/building_del', BuildingDeleteApiView.as_view()),
     path('api/v1/rooms', RoomListApiView.as_view()),
     path('api/v1/room/<int:pk>', RoomDetailApiView.as_view()),
     path('api/v1/room_add', RoomAddApiView.as_view()),
     path('api/v1/room_upd', RoomUpdateApiView.as_view()),
     path('api/v1/room_del', RoomDeleteApiView.as_view()),
     path('api/v1/racks/', RackListApiView.as_view()),
     path('api/v1/rack/<int:pk>/', RackDetailApiView.as_view()),
     path('api/v1/rack_add', RackAddApiView.as_view()),
     path('api/v1/rack_upd', RackUpdateApiView.as_view()),
     path('api/v1/rack_del', RackDeleteApiView.as_view()),
     path('api/v1/rack_devices/<int:pk>', RackDevicesApiView.as_view()),
     path('api/v1/rack_vendors', RackVendorsApiView.as_view()),
     path('api/v1/rack_models', RackModelsApiView.as_view()),
     path('api/v1/devices/', DeviceListApiView.as_view()),
     path('api/v1/device/<int:pk>/', DeviceDetailApiView.as_view()),
     path('api/v1/device_add', DeviceAddApiView.as_view()),
     path('api/v1/device_upd', DeviceUpdateApiView.as_view()),
     path('api/v1/device_del', DeviceDeleteApiView.as_view()),
     path('api/v1/device_vendors', DeviceVendorsApiView.as_view()),
     path('api/v1/device_models', DeviceModelsApiView.as_view()),
]
urlpatterns += doc_urls
urlpatterns += staticfiles_urlpatterns()
