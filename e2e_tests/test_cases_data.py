"""
Simple abstraction for multithreading task
Case - class containing an instance of a unittest test case
and a list of test names
"""
from e2e_tests import (MoveDeviceCase,
                       PermissionsCase,
                       AddDeviceCase,
                       NameDuplicationCase)


class MoveDevice:
    test_case_class = MoveDeviceCase
    test_list = [
        'test_1_move_device_outside',
        'test_2_move_device_to_busy_place',
    ]


class Permissions:
    test_case_class = PermissionsCase
    test_list = [
        'test_3_check_permissions',
    ]


class AddDevice:
    test_case_class = AddDeviceCase
    test_list = [
        'test_4_add_device_outside',
        'test_5_add_device_to_busy_place',
    ]


class NameDuplication:
    test_case_class = NameDuplicationCase
    test_list = [
        'test_6_add_same_name_building',
        'test_7_add_same_name_room',
        'test_8_add_same_name_rack',
    ]
