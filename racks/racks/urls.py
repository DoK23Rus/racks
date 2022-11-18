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
from django.contrib.auth import views as auth_views
from django.contrib.staticfiles.urls import staticfiles_urlpatterns
from django.urls import path, include
from .yasg import urlpatterns as doc_urls


urlpatterns = [
     path('admin/', admin.site.urls),
     path('admin/logout/login/', admin.site.urls),
     path('api/v1/', include('djoser.urls')),
     path('api/v1/', include('djoser.urls.authtoken')),
     path('login/',
          auth_views.LoginView.as_view(template_name="login.html"),
          name='authapp-login'),
     path('api/v1/rack_devices/<int:pk>',
          RackDevicesApiView.as_view(),
          name='rack_devices'),
     path('api/v1/regions', RegionListApiView.as_view(), name='regions'),
     path('api/v1/departments',
          DepartmentListApiView.as_view(),
          name='departments'),
     path('api/v1/sites', SiteListApiView.as_view(), name='sites'),
     path('api/v1/buildings', BuildingListApiView.as_view(), name='buildings'),
     path('api/v1/rooms', RoomListApiView.as_view(), name='rooms'),
     path('api/v1/site/<int:pk>',
          SiteDetailApiView.as_view(),
          name='site'),
     path('api/v1/building/<int:pk>',
          BuildingDetailApiView.as_view(),
          name='building'),
     path('api/v1/room/<int:pk>',
          RoomDetailApiView.as_view(),
          name='room'),
     path('api/v1/site_add',
          SiteAddApiView.as_view(),
          name='site_add'),
     path('api/v1/site_upd',
          SiteUpdateApiView.as_view(),
          name='site_upd'),
     path('api/v1/site_del',
          SiteDeleteApiView.as_view(),
          name='site_del'),
     path('api/v1/building_add',
          BuildingAddApiView.as_view(),
          name='building_add'),
     path('api/v1/building_upd',
          BuildingUpdateApiView.as_view(),
          name='building_upd'),
     path('api/v1/building_del',
          BuildingDeleteApiView.as_view(),
          name='building_del'),
     path('api/v1/room_add', RoomAddApiView.as_view(), name='room_add'),
     path('api/v1/room_upd', RoomUpdateApiView.as_view(), name='room_upd'),
     path('api/v1/room_del', RoomDeleteApiView.as_view(), name='room_del'),
     path('api/v1/rack/<int:pk>/', RackDetailApiView.as_view()),
     path('api/v1/rack_add', RackAddApiView.as_view(), name='rack_add'),
     path('api/v1/rack_upd', RackUpdateApiView.as_view(), name='rack_upd'),
     path('api/v1/rack_del', RackDeleteApiView.as_view(), name='rack_del'),
     path('api/v1/device_add', DeviceAddApiView.as_view(), name='device_add'),
     path('api/v1/device_upd',
          DeviceUpdateApiView.as_view(),
          name='device_upd'),
     path('api/v1/device_del',
          DeviceDeleteApiView.as_view(),
          name='device_del'),
     path('api-auth/', include('rest_framework.urls')),
     path('api/v1/rack_detail/<int:pk>/', RackDetailApiView.as_view()),
     path('api/v1/device/<int:pk>/', DeviceDetailApiView.as_view()),
     path('api/v1/devices/', DeviceListApiView.as_view()),
     path('api/v1/racks/', RackListApiView.as_view()),
     path('api/v1/user/', UserApiView.as_view()),
     path('api/v1/device_vendors', DeviceVendorsApiView.as_view()),
     path('api/v1/device_models', DeviceModelsApiView.as_view()),
     path('api/v1/rack_vendors', RackVendorsApiView.as_view()),
     path('api/v1/rack_models', RackModelsApiView.as_view()),
]
urlpatterns += doc_urls
urlpatterns += staticfiles_urlpatterns()
