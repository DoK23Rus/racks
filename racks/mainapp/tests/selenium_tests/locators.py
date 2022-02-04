class Locators():

    username_textbox_id = 'id_username'
    password_textbox_id = 'id_password'
    login_button_id = 'button'
    value_attr = 'value'
    site_name = 'Test site'
    building_name = 'Центральный офис г. Анапа'
    room_name = 'Кабинет №17 Кроссовая 1 эт.'
    rack_name = 'Шкаф №1'

    first_device_first_unit_ok = '39'
    first_device_last_unit_ok = '39'
    second_device_first_unit_ok = '35'
    second_device_last_unit_ok = '36'
    first_device_first_unit_outside = '43'
    first_device_last_unit_outside = '44'
    first_device_first_unit_busy = '37'
    first_device_last_unit_busy = '36'
    rack_amount = '42'

    first_unit_textbox_id = 'id_first_unit'
    last_unit_textbox_id = 'id_last_unit'
    site_name_textbox_id = 'id_site_name'
    building_name_textbox_id = 'id_building_name'
    room_name_textbox_id = 'id_room_name'
    rack_name_textbox_id = 'id_rack_name'
    rack_amount_textbox_id = 'id_rack_amount'

    region_xpath = '/html/body/ul/li[1]/span/b/a'
    department_xpath = '/html/body/ul/li[1]/ul/li[1]/span/i/a'
    site_xpath = '/html/body/ul/li[1]/ul/li[1]/ul/li[1]/span/a'
    building_xpath = '/html/body/ul/li[1]/ul/li[1]/ul/li[1]/ul/li[1]/span/a'
    room_xpath = '/html/body/ul/li[1]/ul/li[1]/ul/li[1]/ul/li[1]/ul/li[1]/span/a'
    rack_xpath = '/html/body/ul/li[1]/ul/li[1]/ul/li[1]/ul/li[1]/ul/li[1]/ul/li[1]/a[1]'
    first_device_xpath = '/html/body/font/table/tbody/tr[6]/th[2]/a'
    second_device_xpath = '/html/body/font/table/tbody/tr[9]/th[2]/a'
    accept_button_xpath = '/html/body/form/input[2]'
    add_site_button_xpath = '/html/body/ul/li[1]/ul/li[2]/a'
    add_device_button_xpath = '/html/body/table/tbody/tr[5]/td/a'
    add_building_button_xpath = '/html/body/ul/li[1]/ul/li[1]/ul/li[1]/a[1]'
    add_room_button_xpath = '/html/body/ul/li[1]/ul/li[1]/ul/li[1]/ul/li[1]/a[1]'
    add_rack_button_xpath = '/html/body/ul/li[1]/ul/li[1]/ul/li[1]/ul/li[1]/ul/li[1]/a[1]'

    auth_loc = "//*[contains(text(), 'Вы авторизованы как: Selenium Testing')]"
    department_name_loc = "//*[contains(text(), 'Техподдержка Анапа')]"
    rack_name_loc = "//*[contains(text(), 'Шкаф №1')]"
    first_device_loc = "//*[contains(text(), 'Cisco 2960')]"
    second_device_loc = "//*[contains(text(), 'Cisco 2911')]"
    first_device_change_button_xpath = '/html/body/a[1]'
    second_device_change_button_xpath = '/html/body/a[2]'
    device_first_unit_xpath = '//*[@id="id_first_unit"]'
    device_last_unit_xpath = '//*[@id="id_last_unit"]'
    unit_outside_loc = "//*[contains(text(), 'Указанных юнитов нет в стойке')]"
    unit_busy_loc = "//*[contains(text(), 'Указанные юниты заняты')]"
    violation_loc = "//*[contains(text(), 'У вас нет прав на изменения')]"
    building_name_busy_loc = "//*[contains(text(), 'Здание с таким названием уже существует')]"
    room_name_busy_loc = "//*[contains(text(), 'Помещение с таким названием уже существует')]"
    rack_name_busy_loc = "//*[contains(text(), 'Стойка с таким названием уже существует')]"
