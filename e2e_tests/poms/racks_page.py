from locators import Locators
from selenium.webdriver.common.action_chains import ActionChains
from selenium.webdriver.common.by import By
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.ui import WebDriverWait


class RacksPage():
    """
    POM for racks map page
    """

    def __init__(self, driver):
        self.driver = driver
        self.wait = WebDriverWait(self.driver, 1)
        self.region_name_id = Locators.region_name_id
        self.department_name_id = Locators.department_name_id
        self.site_name_id = Locators.site_name_id
        self.building_name_id = Locators.building_name_id
        self.room_name_id = Locators.room_name_id
        self.rack_name_id = Locators.rack_name_id
        self.add_site_button_id = Locators.add_site_button_id
        self.add_building_button_id = Locators.add_building_button_id
        self.add_room_button_id = Locators.add_room_button_id
        self.add_rack_button_id = Locators.add_rack_button_id

    def open_rack(self):
        """
        Open rack layout pager
        """
        # reset_actions() dont work for some reason...
        self.driver.find_element_by_id(self.region_name_id).click()
        department = self.wait.until(EC.element_to_be_clickable(
                       (By.ID, self.department_name_id)))
        action = ActionChains(self.driver)
        action.move_to_element_with_offset(department, 5, 5).click().perform()
        site = self.wait.until(EC.element_to_be_clickable(
                       (By.ID, self.site_name_id)))
        action = ActionChains(self.driver)
        action.move_to_element_with_offset(site, 5, 5).click().perform()
        building = self.wait.until(EC.element_to_be_clickable(
                       (By.ID, self.building_name_id)))
        action = ActionChains(self.driver)
        action.move_to_element_with_offset(building, 5, 5).click().perform()
        room = self.wait.until(EC.element_to_be_clickable(
                       (By.ID, self.room_name_id)))
        action = ActionChains(self.driver)
        action.move_to_element_with_offset(room, 5, 5).click().perform()
        self.wait.until(EC.element_to_be_clickable(
                       (By.ID, self.rack_name_id))).click()

    def expand_region(self):
        """
        Expand region
        """
        self.driver.find_element_by_id(self.region_name_id).click()

    def add_site(self):
        """
        Add new site
        """
        self.wait.until(EC.element_to_be_clickable(
                       (By.ID, self.add_site_button_id))).click()

    def add_new_building(self):
        """
        Add new building
        """
        self.driver.find_element_by_id(self.region_name_id).click()
        department = self.wait.until(EC.element_to_be_clickable(
                       (By.ID, self.department_name_id)))
        action = ActionChains(self.driver)
        action.move_to_element_with_offset(department, 5, 5).click().perform()
        self.wait.until(EC.element_to_be_clickable(
                       (By.ID, self.add_building_button_id))).click()

    def add_new_room(self):
        """
        Add new room
        """
        self.driver.find_element_by_id(self.region_name_id).click()
        department = self.wait.until(EC.element_to_be_clickable(
                       (By.ID, self.department_name_id)))
        action = ActionChains(self.driver)
        action.move_to_element_with_offset(department, 5, 5).click().perform()
        site = self.wait.until(EC.element_to_be_clickable(
                       (By.ID, self.site_name_id)))
        action = ActionChains(self.driver)
        action.move_to_element_with_offset(site, 5, 5).click().perform()
        self.wait.until(EC.element_to_be_clickable(
                       (By.ID, self.add_room_button_id))).click()


    def add_new_rack(self):
        """
        Add new rack
        """
        self.driver.find_element_by_id(self.region_name_id).click()
        department = self.wait.until(EC.element_to_be_clickable(
                       (By.ID, self.department_name_id)))
        action = ActionChains(self.driver)
        action.move_to_element_with_offset(department, 5, 5).click().perform()
        site = self.wait.until(EC.element_to_be_clickable(
                       (By.ID, self.site_name_id)))
        action = ActionChains(self.driver)
        action.move_to_element_with_offset(site, 5, 5).click().perform()
        building = self.wait.until(EC.element_to_be_clickable(
                       (By.ID, self.building_name_id)))
        action = ActionChains(self.driver)
        action.move_to_element_with_offset(building, 5, 5).click().perform()
        self.wait.until(EC.element_to_be_clickable(
                       (By.ID, self.add_rack_button_id))).click()
