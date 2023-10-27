"""
Business logic classes
"""
import datetime
import os
from typing import List, NamedTuple, Type

from django.db.models.base import ModelBase
from django.db.models.query import QuerySet, RawQuerySet

from mainapp.models import Device


def date() -> str:
    """
    Current date

    Returns:
        date (str): Date in y-m-d format
    """
    return datetime.datetime.today().strftime("%Y-%m-%d_%H-%M-%S")


class UnitsTuple(NamedTuple):
    """
    Named tuple for old units pair (for data update)
    """
    first_unit: int
    last_unit: int


class DeviceCheckService:
    """
    Services for checking capabilities to add or update devices
    """

    @staticmethod
    def get_units(first_unit: int,
                  last_unit: int,
                  units_dc: Type[UnitsTuple]
                  ) -> UnitsTuple:
        """
        Get tuple with already filled units

        Args:
            pk (int): Primary key

        Raises:
            ValueError ("pk cannot be None")

        Returns:
            OldUnits (tuple): First and last unit in named tuple (ordered)
        """
        if first_unit > last_unit:
            return units_dc(last_unit, first_unit)
        return units_dc(first_unit, last_unit)

    @staticmethod
    def check_unit_exist(units: UnitsTuple,
                         rack_amount: int
                         ) -> bool:
        """
        Units exist check
        Are there any such units?

        Args:
            units (tuple): Pair of units in tuple
            rack_id (int): Rack id

        Raises:
            ValueError ("rack_id cannot be None")

        Returns:
            True (bool): units pair are in range of all rack units
            False (bool): units pair are outside of the rack
        """
        new_device_range = range(units.first_unit, units.last_unit + 1)
        all_units_ramge = range(1, rack_amount + 1)
        if set(new_device_range).issubset(all_units_ramge):
            return True
        else:
            return False

    @staticmethod
    def get_filled_list(queryset_devices: QuerySet):
        filled_list: list[int] = []
        if len(list(queryset_devices)) > 0:
            for device in queryset_devices:
                first_unit = device.first_unit
                last_unit = device.last_unit
                if first_unit > last_unit:
                    first_unit = device.last_unit
                    last_unit = device.first_unit
                one_device_list = list(range(first_unit, last_unit + 1))
                filled_list.extend(one_device_list)
        return filled_list

    @staticmethod
    def check_unit_busy_for_update(filled_list: List[int],
                                   new_units: UnitsTuple,
                                   old_units: UnitsTuple
                                   ) -> bool:
        """
        Units busy check
        Are units busy? (adding, updating)

        Args:
            side (bool): Rack side (True - front, False - back)
            pk (int): Primary key
            new_units (tuple): Pair of new units
            old_units (tuple): Pair of old units (update only)

        Raises:
            ValueError ("pk cannot be None")

        Returns:
            True (bool): Units are busy
            False (bool): Units not busy
        """
        device_old_range = range(old_units.first_unit,
                                 old_units.last_unit + 1)
        filled_list = list(set(filled_list) - set(device_old_range))
        device_new_range = range(new_units.first_unit,
                                 new_units.last_unit + 1)
        if any(unit in set(device_new_range) for unit in filled_list):
            return True
        else:
            return False

    @staticmethod
    def check_unit_busy_for_add(filled_list: List[int],
                                new_units: UnitsTuple,
                                ) -> bool:
        """
        Units busy check
        Are units busy? (adding, updating)

        Args:
            side (bool): Rack side (True - front, False - back)
            pk (int): Primary key
            new_units (tuple): Pair of new units
            old_units (tuple): Pair of old units (update only)

        Raises:
            ValueError ("pk cannot be None")

        Returns:
            True (bool): Units are busy
            False (bool): Units not busy
        """
        device_new_range = range(new_units.first_unit,
                                 new_units.last_unit + 1)
        if any(unit in set(device_new_range) for unit in filled_list):
            return True
        else:
            return False


class DataProcessingService:
    """
    Services for operations with data
    """

    @staticmethod
    def get_devices_power_w_sum(power_w_list: list) -> int:
        """
        Get total power for single rack

        Args:
            pk (int): Primary key

        Returns:
            devices_power_w_sum (int): Summary power of all rack devices
        """
        return sum(power_w for power_w in power_w_list if power_w is not None)

    @staticmethod
    def get_key_name(data: dict) -> str:
        """
        Get key name for different models

        Args:
            data (dict): New data set

        Returns:
            key_name (str): Key name for an object
                (devices has no name, only vendor and model)
        """
        key_name = data.get("name")
        if key_name is not None:
            return key_name
        key_name = f"device " \
            f"{str(data.get('vendor') or 'unspecified vendor')}, " \
            f"{str(data.get('model') or 'unspecified model')}"
        return key_name

    @staticmethod
    def get_instance_name(instance: ModelBase,
                          model: ModelBase,
                          exception: ModelBase = Device,
                          ) -> str:
        if model != exception:
            return getattr(instance, "name")
        device_vendor = instance.vendor \
            if instance.vendor != '' else 'unspecified vendor'
        device_model = instance.model \
            if instance.model != '' else 'unspecified model'
        return f"device {device_vendor}, {device_model}"


class ReportService:
    """
    Service for generating reports
    """

    @staticmethod
    def get_devices_data(devices_report_qs: RawQuerySet) -> List[List[str]]:
        """
        Get data for devices report (all devices data)

        Returns:
            devices_data (list): List of lists with devices data
        """
        devices_data: List = []
        for device in devices_report_qs:
            devices_data.append([
                device.id,
                device.status,
                device.vendor,
                device.model,
                device.serial_number,
                device.description,
                device.project,
                device.ownership,
                device.financially_responsible_person,
                device.inventory_number,
                device.responsible,
                device.fixed_asset,
                device.link,
                device.first_unit,
                device.last_unit,
                'Yes' if device.frontside_location else 'No',
                device.type,
                device.hostname,
                device.ip,
                f"{os.environ.get('DEVICE_REPORT_LINK')}"
                f"{str(device.stack)}" if device.stack
                is not None else None,
                device.ports_amout,
                device.version,
                device.power_type,
                device.power_w,
                device.power_v,
                device.power_ac_dc,
                device.updated_by,
                device.updated_at,
                device.rack_name,
                device.room_name,
                device.building_name,
                device.site_name,
                device.department_name,
                device.region_name,
                f"{os.environ.get('DEVICE_REPORT_LINK')}{str(str(device.id))}",
            ])
        return devices_data

    @staticmethod
    def get_racks_data(racks_report_qs: RawQuerySet) -> List[List[str]]:
        """
        Get data for racks report (all racks data)

        Returns:
            racks_data (list): List of lists with racks data
        """
        racks_data: List = []
        for rack in racks_report_qs:
            racks_data.append([
                rack.id,
                rack.name,
                rack.amount,
                rack.vendor,
                rack.model,
                rack.description,
                'Yes' if rack.numbering_from_bottom_to_top else 'No',
                rack.responsible,
                rack.financially_responsible_person,
                rack.inventory_number,
                rack.fixed_asset,
                rack.link,
                rack.row,
                rack.place,
                rack.height,
                rack.width,
                rack.depth,
                rack.unit_width,
                rack.unit_depth,
                rack.type,
                rack.frame,
                rack.place_type,
                rack.max_load,
                rack.power_sockets,
                rack.power_sockets_ups,
                'Yes' if rack.external_ups else 'No',
                'Yes' if rack.cooler else 'No',
                rack.updated_by,
                rack.updated_at,
                rack.room_name,
                rack.building_name,
                rack.site_name,
                rack.department_name,
                rack.region_name,
                f"{os.environ.get('RACK_REPORT_LINK')}{str(str(rack.id))}",
            ])
        return racks_data
