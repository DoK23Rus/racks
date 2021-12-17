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



urlpatterns = [
    path('admin/', admin.site.urls),
    path('', tree_view, name='tree'),
    path('export_devices_view/', export_devices_view, name='export_devices'),
    path('export_racks_view/', export_racks_view, name='export_racks'),
    path('units/<int:pk>', units_view, name='units'),
    path('units_front_print/<int:pk>', units_front_print_view, name='units_front_print'),
    path('units_back_print/<int:pk>', units_back_print_view, name='units_back_print'),
    path('site_add/<int:pk>', site_add_view, name='site_add'),
    path('site_upd/<int:pk>', site_upd_view, name='site_upd'),
    path('site_del/<int:pk>/delete', site_del_view, name='site_del'),
    path('building_add/<int:pk>', building_add_view, name='building_add'),
    path('building_upd/<int:pk>', building_upd_view, name='building_upd'),
    path('building_del/<int:pk>/delete', building_del_view, name='building_del'),
    path('room_add/<int:pk>', room_add_view, name='room_add'),
    path('room_upd/<int:pk>', room_upd_view, name='room_upd'),
    path('room_del/<int:pk>', room_del_view, name='room_del'),
    path('rack_add/<int:pk>', rack_add_view, name='rack_add'),
    path('rack_upd/<int:pk>', rack_upd_view, name='rack_upd'),
    path('rack_del/<int:pk>', rack_del_view, name='rack_del'),
    path('device_add/<int:pk>', device_add_view, name='device_add'),
    path('device_upd/<int:pk>', device_upd_view, name='device_upd'),
    path('device_del/<int:pk>', device_del_view, name='device_del'),
    path('device_detail/<int:pk>', device_view, name='device_detail'),
    path('rack_detail/<int:pk>', rack_view, name='rack_detail'),
    path('login/', auth_views.LoginView.as_view(template_name="login.html"), name='authapp-login'),
    path('logout/', auth_views.LogoutView.as_view(next_page="/login/"), name='authapp-logout'),
    path('answer/<str:args>', answer_view, name='answer'),
    path('admin/logout/login/', admin.site.urls), 
]
urlpatterns += staticfiles_urlpatterns()
