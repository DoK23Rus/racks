from locators import Locators


class DevicePage():

    def __init__(self, driver):
        self.driver = driver
        self.device_change_button_xpath = Locators. \
            device_change_button_xpath

    def change_device(self):
        self.driver.find_element_by_xpath(self. \
            device_change_button_xpath).click()
