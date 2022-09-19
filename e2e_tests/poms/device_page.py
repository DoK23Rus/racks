from locators import Locators


class DevicePage():
    """
    POM for device page
    """

    def __init__(self, driver):
        self.driver = driver
        self.device_edit_button_xpath = Locators. \
            device_edit_button_xpath

    def edit_device(self):
        """
        Edit device
        """
        self.driver \
            .find_element_by_xpath(self.device_edit_button_xpath).click()
