from locators import Locators
from params import Params
from selenium.webdriver.support.ui import WebDriverWait


class FormPage:
    """
    POM for add|update form pages
    """

    def __init__(self, driver):
        self.driver = driver
        self.wait = WebDriverWait(self.driver, 10)
        self.unit_outside_loc = Locators.unit_outside_loc
        self.unit_busy_loc = Locators.unit_busy_loc
        self.violation_loc = Locators.violation_loc
        self.building_name_busy_loc = Locators.building_name_busy_loc
        self.room_name_busy_loc = Locators.room_name_busy_loc
        self.rack_name_busy_loc = Locators.rack_name_busy_loc
        self.site_name = Params.site_name
        self.site_name_textbox_id = Locators.site_name_textbox_id
        self.buildind_name = Params.room_name
        self.room_name_textbox_id = Locators.room_name_textbox_id
        self.rack_name = Params.rack_name
        self.rack_name_textbox_id = Locators.rack_name_textbox_id
        self.rack_amount_textbox_id = Locators.rack_amount_textbox_id
        self.value_attr = Params.value_attr
        self.first_unit_textbox_id = Locators.first_unit_textbox_id
        self.last_unit_textbox_id = Locators.last_unit_textbox_id
        self.submit_button_id = Locators.submit_button_id
        self.building_name_textbox_id = Locators.building_name_textbox_id
        self.buildind_name = Params.building_name
        self.room_floor_textbox_id = Locators.room_floor_textbox_id

    def get_unit_outside_loc(self):
        """
        Get unit outside locator
        """
        return self.driver.find_element_by_xpath(self.unit_outside_loc)

    def get_unit_busy_loc(self):
        """
        Get unit busy locator
        """
        return self.driver.find_element_by_xpath(self.unit_busy_loc)

    def get_violation_loc(self):
        """
        Get violation locator
        """
        return self.driver.find_element_by_xpath(self.violation_loc)

    def get_building_name_busy_loc(self):
        """
        Get building name busy locator
        """
        return self.driver.find_element_by_xpath(self.building_name_busy_loc)

    def enter_building_name(self, building_name):
        """
        Enter building name
        """
        self.driver.find_element_by_id(self.building_name_textbox_id) \
            .send_keys(building_name)

    def get_room_name_busy_loc(self):
        """
        Get room name busy locator
        """
        return self.driver.find_element_by_xpath(self.room_name_busy_loc)

    def get_rack_name_busy_loc(self):
        """
        Get rack name busy locator
        """
        return self.driver.find_element_by_xpath(self.rack_name_busy_loc)

    def enter_site_name(self, site_name):
        """
        Enter site name
        """
        self.driver \
            .find_element_by_id(self.site_name_textbox_id).send_keys(site_name)

    def enter_room_name(self, room_name):
        """
        Enter room name
        """
        self.driver \
            .find_element_by_id(self.room_name_textbox_id).send_keys(room_name)

    def enter_room_floor(self, room_floor):
        """
        Enter room floor
        """
        self.driver \
            .find_element_by_id(self.room_floor_textbox_id).send_keys(room_floor)

    def enter_rack_name(self, rack_name):
        """
        Enter rack name
        """
        self.driver \
            .find_element_by_id(self.rack_name_textbox_id).send_keys(rack_name)

    def enter_rack_amount(self, rack_amount):
        """
        Enter rack amount
        """
        self.driver \
            .find_element_by_id(self.rack_amount_textbox_id) \
            .send_keys(rack_amount)

    def use_first_unit_textbox(self):
        """
        Use first unit textbox
        """
        return self.driver.find_element_by_id(self.first_unit_textbox_id)

    def use_last_unit_textbox(self):
        """
        Use last unit textbox
        """
        return self.driver.find_element_by_id(self.last_unit_textbox_id)

    def click_submit(self):
        """
        Click submit
        """
        self.driver \
            .find_element_by_id(self.submit_button_id).click()
