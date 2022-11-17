from locators import Locators


class UnitsPage():
    """
    POM for rack layout page
    """

    def __init__(self, driver):
        self.driver = driver
        self.first_device_loc = Locators.first_device_loc
        self.add_device_button_id = Locators.add_device_button_id

    def open_first_device(self):
        """
        Open first device
        """
        self.driver.find_element_by_xpath(self.first_device_loc).click()

    def add_new_device(self):
        """
        Add new device
        """
        self.driver.find_element_by_id(self.add_device_button_id).click()
