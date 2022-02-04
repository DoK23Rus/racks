from locators import Locators


class BuildingAddPage():

    def __init__(self, driver):
        self.driver = driver
        self.buildind_name = Locators.building_name
        self.building_name_textbox_id = Locators.building_name_textbox_id
        self.accept_button_xpath = Locators.accept_button_xpath

    def enter_building_name(self, building_name):
        self.driver.find_element_by_id(self.building_name_textbox_id). \
            send_keys(building_name)

    def click_accept(self):
        self.driver.find_element_by_xpath(self.accept_button_xpath).click()