from mainapp.models import (Building,
                            Department,
                            Device,
                            Rack,
                            Region,
                            Room,
                            Site)


class RegionRepository:
    
    @staticmethod
    def get_instance(pk):
        return Region.objects.get(id=pk)


class DepartmentRepository:

    @staticmethod
    def get_instance(pk):
        return Department.objects.get(id=pk)

    @staticmethod
    def get_department_name(pk):
        return Department.objects.get(id=pk) \
            .department_name


class SiteRepository:

    @staticmethod
    def get_instance(pk):
        return Site.objects.get(id=pk)

    @staticmethod
    def get_department_name(pk):
        return Site.objects.get_site_department(pk) \
            .department_id \
            .department_name


class BuildingRepository:

    @staticmethod
    def get_instance(pk):
        return Building.objects.get(id=pk)

    @staticmethod
    def get_department_name(pk):
        return Building.objects.get_building_department(pk) \
            .site_id \
            .department_id \
            .department_name

    @staticmethod
    def get_unique_object_names_list(key):
        return {building.building_name for building
                in Building.objects.get_buildings_for_site(key)}


class RoomRepository:

    @staticmethod
    def get_instance(pk):
        return Room.objects.get(id=pk)

    @staticmethod
    def get_department_name(pk):
        return Room.objects.get_room_department(pk) \
            .building_id \
            .site_id \
            .department_id \
            .department_name

    @staticmethod
    def get_unique_object_names_list(key):
        return {room.room_name for room
                in Room.objects.get_rooms_for_building(key)}


class RackRepository:

    @staticmethod
    def get_instance(pk):
        return Rack.objects.get(id=pk)

    @staticmethod
    def get_department_name(pk):
        return Rack.objects.get_rack_department(pk) \
            .room_id \
            .building_id \
            .site_id \
            .department_id \
            .department_name

    @staticmethod
    def get_rack_amount(rack_id):
        return int(Rack.objects.get_rack(rack_id).rack_amount)

    @staticmethod
    def get_unique_object_names_list(key):
        return {rack.rack_name for rack
                in Rack.objects.get_racks_for_room(key)}

    @staticmethod
    def get_report_data():
        return Rack.objects.get_racks_report()


class DeviceRepository:

    @staticmethod
    def get_instance(pk):
        return Device.objects.get(id=pk)

    @staticmethod
    def get_devices_for_side(pk, side):
        return Device.objects.get_devices_for_side(pk, side)

    @staticmethod
    def get_first_unit(pk):
        return Device.objects.get_device(pk).first_unit

    @staticmethod
    def get_last_unit(pk):
        return Device.objects.get_device(pk).last_unit

    @staticmethod
    def get_department_name(pk):
        return Device.objects.get_device_department(pk) \
            .rack_id \
            .room_id \
            .building_id \
            .site_id \
            .department_id \
            .department_name

    @staticmethod
    def get_devices_power_list(pk):
        return list(Device
                    .objects
                    .filter(rack_id_id=pk)
                    .values_list('power_w', flat=True))

    @staticmethod
    def get_report_data():
        return Device.objects.get_devices_report()


class RepositoryHelper:

    @staticmethod
    def get_repository(model):
        repository = {
            Region: RegionRepository,
            Department: DepartmentRepository,
            Site: SiteRepository,
            Building: BuildingRepository,
            Room: RoomRepository,
            Rack: RackRepository,
            Device: DeviceRepository,
        }.get(model)()
        if not repository:
            raise ValueError("model: ModelBase must be Site|Building|Room")
        return repository

    @staticmethod
    def get_child_model_repository(model):
        child_repository = {
            Region: DepartmentRepository,
            Department: SiteRepository,
            Site: BuildingRepository,
            Building: RoomRepository,
            Room: RackRepository,
            Rack: DeviceRepository,
        }.get(model)()
        if not child_repository:
            raise ValueError("model: ModelBase must be Site|Building|Room")
        return child_repository
