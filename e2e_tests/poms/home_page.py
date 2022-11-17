from locators import Locators


class HomePage():
    """
    POM for home page
    """

    def __init__(self, driver):
        self.driver = driver
        self.racks_map_id = Locators.racks_map_id

    def go_to_racks_map(self):
        """
        Go to racks map
        """
        self.driver.find_element_by_id(self.racks_map_id).click()
