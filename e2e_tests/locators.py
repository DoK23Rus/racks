"""
Locators, and IDs
"""


class Locators():
    # locators
    first_device_loc = "//*[contains(text(), 'Cisco 2960')]"
    unit_outside_loc = ("//*[contains(text(), 'No such units')]")
    unit_busy_loc = "//*[contains(text(), 'These units are busy')]"
    violation_loc = ("//*[contains(text(), 'Action not allowed for this department')]")
    building_name_busy_loc = ("//*[contains(text(), 'Building with this name already exists in this site')]")
    room_name_busy_loc = ("//*[contains(text(), 'Room with this name already exists in this building')]")
    rack_name_busy_loc = ("//*[contains(text(), 'Rack with this name already exists in this room')]")

    # IDs
    region_name_id = "e2e_Test_region"
    department_name_id = "e2e_Test_department"
    site_name_id = "e2e_Test_site"
    building_name_id = "e2e_Test_building"
    room_name_id = "e2e_Test_room"
    rack_name_id = "e2e_Test_rack_№1"
    first_unit_textbox_id = 'e2e_first_unit'
    last_unit_textbox_id = 'e2e_last_unit'
    site_name_textbox_id = 'e2e_site_name'
    building_name_textbox_id = 'e2e_building_name'
    room_name_textbox_id = 'e2e_room_name'
    rack_name_textbox_id = 'e2e_rack_name'
    rack_amount_textbox_id = 'e2e_rack_amount'
    username_textbox_id = 'e2e_username'
    password_textbox_id = 'e2e_password'
    login_button_id = 'e2e_login'
    racks_map_id = 'e2e_racks_map'
    device_edit_id = 'e2e_device_edit'
    submit_button_id = 'e2e_submit_button'
    add_site_button_id = 'e2e_Some_other_department_add_button'
    add_device_button_id = 'e2e_add_device'
    add_building_button_id = 'e2e_Test_site_add_button'
    add_room_button_id = 'e2e_Test_building_add_button'
    add_rack_button_id = 'e2e_Test_room_add_button'
