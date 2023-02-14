from mainapp.models import (Building,
                            Department,
                            Device,
                            Rack,
                            Region,
                            Room,
                            Site)


class RegionRepository:
    pass


class DepartmentRepository:
    pass


class SiteRepository:
    pass


class BuildingRepository:

    @staticmethod
    def get_unique_object_names_list(key):
        return {building.building_name for building
                in Building.objects.get_buildings_for_site(key)}


class RoomRepository:

    @staticmethod
    def get_unique_object_names_list(key):
        return {room.room_name for room
                in Room.objects.get_rooms_for_building(key)}


class RackRepository:

    @staticmethod
    def get_unique_object_names_list(key):
        return {rack.rack_name for rack
                in Rack.objects.get_racks_for_room(key)}


class DeviceRepository:
    pass


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
