from locators import Locators


class AnswerPage():

    def __init__(self, driver):
        self.driver = driver
        self.unit_outside_loc = Locators.unit_outside_loc
        self.unit_busy_loc = Locators.unit_busy_loc
        self.violation_loc = Locators.violation_loc
        self.building_name_busy_loc = Locators.building_name_busy_loc
        self.room_name_busy_loc = Locators.room_name_busy_loc
        self.rack_name_busy_loc = Locators.rack_name_busy_loc

    def get_unit_outside_loc(self):
        return self.driver.find_element_by_xpath(self.unit_outside_loc)

    def get_unit_busy_loc(self):
        return self.driver.find_element_by_xpath(self.unit_busy_loc)

    def get_violation_loc(self):
        return self.driver.find_element_by_xpath(self.violation_loc)

    def get_building_name_busy_loc(self):
        return self.driver.find_element_by_xpath(self.building_name_busy_loc)

    def get_room_name_busy_loc(self):
        return self.driver.find_element_by_xpath(self.room_name_busy_loc)

    def get_rack_name_busy_loc(self):
        return self.driver.find_element_by_xpath(self.rack_name_busy_loc)