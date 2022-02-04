from locators import Locators


class DevicePage():

    def __init__(self, driver):
        self.driver = driver
        self.first_device_change_button_xpath = Locators. \
            first_device_change_button_xpath
        self.second_device_change_button_xpath = Locators. \
            second_device_change_button_xpath

    def change_first_device(self):
        self.driver.find_element_by_xpath(self. \
            first_device_change_button_xpath).click()

    def change_second_device(self):
        self.driver.find_element_by_xpath(self. \
            second_device_change_button_xpath).click() 