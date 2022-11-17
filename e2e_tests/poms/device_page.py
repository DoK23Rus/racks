from locators import Locators


class DevicePage():
    """
    POM for device page
    """

    def __init__(self, driver):
        self.driver = driver
        self.device_edit_id = Locators. \
            device_edit_id

    def edit_device(self):
        """
        Edit device
        """
        self.driver \
            .find_element_by_id(self.device_edit_id).click()
