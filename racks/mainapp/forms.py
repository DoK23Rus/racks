from django import forms
from .models import *


class SiteForm(forms.ModelForm):
    class Meta:
        model = Site
        fields = '__all__'
        widgets = {
                    'updated_by': forms.HiddenInput(),
                    'department_id': forms.HiddenInput(),
                  }


class BuildingForm(forms.ModelForm):
    class Meta:
        model = Building
        fields = '__all__'
        widgets = {
            'updated_by': forms.HiddenInput(),
            'site_id': forms.HiddenInput(),
          }


class RoomForm(forms.ModelForm):
    class Meta:
        model = Room
        fields = '__all__'
        widgets = {
            'updated_by': forms.HiddenInput(),
            'building_id': forms.HiddenInput(),
          }


class RackForm(forms.ModelForm):
    class Meta:
        model = Rack
        fields = '__all__'
        widgets = {
            #'rack_amount': forms.HiddenInput(),
            'updated_by': forms.HiddenInput(),
            'room_id': forms.HiddenInput(),
          }


class UpdRackForm(forms.ModelForm):
    class Meta:
        model = Rack
        fields = '__all__'
        widgets = {
            'rack_amount': forms.HiddenInput(),
            'updated_by': forms.HiddenInput(),
            'room_id': forms.HiddenInput(),
          }


class DeviceForm(forms.ModelForm):
    class Meta:
        model = Device
        fields = '__all__'
        widgets = {
            'updated_by': forms.HiddenInput(),
            'rack_id': forms.HiddenInput(),
          }
