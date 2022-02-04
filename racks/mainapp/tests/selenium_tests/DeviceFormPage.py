from locators import Locators


class DeviceFormPage():

    def __init__(self, driver):
        self.driver = driver
        self.device_first_unit_xpath = Locators.device_first_unit_xpath
        self.device_last_unit_xpath = Locators.device_last_unit_xpath
        self.value_attr = Locators.value_attr
        self.first_unit_textbox_id = Locators.first_unit_textbox_id
        self.last_unit_textbox_id = Locators.last_unit_textbox_id
        self.accept_button_xpath = Locators.accept_button_xpath

    def get_device_first_unit(self):
        return self.driver. \
            find_element_by_xpath(self.device_first_unit_xpath). \
            get_attribute(self.value_attr)

    def get_device_last_unit(self):
        return self.driver. \
            find_element_by_xpath(self.device_last_unit_xpath). \
            get_attribute(self.value_attr)

    def use_first_unit_textbox(self):
        return self.driver.find_element_by_id(self.first_unit_textbox_id)

    def use_last_unit_textbox(self):
        return self.driver.find_element_by_id(self.last_unit_textbox_id)

    def click_change(self):
        self.driver.find_element_by_xpath(self.accept_button_xpath).click()
