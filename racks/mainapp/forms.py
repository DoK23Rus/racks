from django import forms
from mainapp.models import (
    Site,
    Building,
    Room,
    Rack,
    Device,
)


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


class UpdRackForm(forms.ModelForm):

    class Meta:
        model = Rack
        fields = '__all__'


class DeviceForm(forms.ModelForm):

    class Meta:
        model = Device
        fields = '__all__'


class GotoForm(forms.Form):

    choices = (
        ('Device', 'Device'),
        ('Rack', 'Rack'),
    )
    object_type = forms.ChoiceField(choices=choices,
                                    label='',
                                    error_messages={'required': ''})
    object_id = forms.IntegerField(label='', error_messages={'required': ''})
