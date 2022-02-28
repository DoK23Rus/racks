class Locators():

    selenium_username = 'selenium'
    selenium_password = 'sel_testing'
    username_textbox_id = 'id_username'
    password_textbox_id = 'id_password'
    login_button_id = 'button'
    value_attr = 'value'
    building_name = 'Test site'
    room_name = 'Test room'
    rack_name = 'Test rack №1'
    site_name = 'Test_site_name'

    # Values
    first_device_first_unit_ok = '39'
    first_device_last_unit_ok = '39'
    second_device_first_unit_ok = '35'
    second_device_last_unit_ok = '36'
    first_device_first_unit_outside = '43'
    first_device_last_unit_outside = '44'
    first_device_first_unit_busy = '37'
    first_device_last_unit_busy = '36'
    rack_amount = '42'

    # IDs
    first_unit_textbox_id = 'id_first_unit'
    last_unit_textbox_id = 'id_last_unit'
    site_name_textbox_id = 'id_site_name'
    building_name_textbox_id = 'id_building_name'
    room_name_textbox_id = 'id_room_name'
    rack_name_textbox_id = 'id_rack_name'
    rack_amount_textbox_id = 'id_rack_amount'

    # XPATHs
    accept_device_button_xpath = '/html/body/form/input[22]'
    accept_rack_button_xpath = '/html/body/form/input[24]'
    accept_button_xpath = '/html/body/form/input[3]'
    add_site_button_xpath = '/html/body/ul/li[1]/ul/li[2]/a'
    add_device_button_xpath = '/html/body/table/tbody/tr[6]/td/a'
    add_building_button_xpath = '/html/body/ul/li[1]/ul/li[1]/ul/li[1]/a[1]'
    add_room_button_xpath = '/html/body/ul/li[1]/ul/li[1]/ul/li[1]/ul/li[1]/a[1]'
    add_rack_button_xpath = '/html/body/ul/li[1]/ul/li[1]/ul/li[1]/ul/li[1]/ul/li[1]/a[1]'
    device_change_button_xpath = '/html/body/a[2]'
    device_first_unit_xpath = '//*[@id="id_first_unit"]'
    device_last_unit_xpath = '//*[@id="id_last_unit"]'

    # locators
    region_name_loc = "//*[contains(text(), 'Test region')]"
    department_name_loc = "//*[contains(text(), 'Test department')]"
    site_name_loc = "//*[contains(text(), 'Test site')]"
    building_name_loc = "//*[contains(text(), 'Test building')]"
    room_name_loc = "//*[contains(text(), 'Test room')]"
    rack_name_loc = "//*[contains(text(), 'Test rack №1')]"
    auth_loc = "//*[contains(text(), 'You are logged in as: Selenium Testing')]"
    first_device_loc = "//*[contains(text(), 'Cisco 2960')]"
    second_device_loc = "//*[contains(text(), 'Cisco 2911')]"
    unit_outside_loc = "//*[contains(text(), 'There are no such units in this rack')]"
    unit_busy_loc = "//*[contains(text(), 'These units are busy')]"
    violation_loc = "//*[contains(text(), 'Permission alert, changes are prohibited')]"
    building_name_busy_loc = "//*[contains(text(), 'A building with the same name already exists')]"
    room_name_busy_loc = "//*[contains(text(), 'A room with the same name already exists')]"
    rack_name_busy_loc = "//*[contains(text(), 'A rack with the same name already exists')]"
