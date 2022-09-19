from locators import Locators


class DevicePage():

    def __init__(self, driver):
        self.driver = driver
        self.device_edit_button_xpath = Locators. \
            device_edit_button_xpath

    def edit_device(self):
        self.driver.find_element_by_xpath(self. \
            device_edit_button_xpath).click()
