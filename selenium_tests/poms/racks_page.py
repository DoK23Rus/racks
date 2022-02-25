from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from locators import Locators


class RacksPage():

    def __init__(self, driver):
        self.driver = driver
        self.wait = WebDriverWait(self.driver, 0.5)
        self.region_xpath = Locators.region_xpath
        self.department_xpath = Locators.department_xpath
        self.site_xpath = Locators.site_xpath
        self.building_xpath = Locators.building_xpath
        self.room_xpath = Locators.room_xpath
        self.rack_xpath = Locators.rack_xpath
        self.auth_loc = Locators.auth_loc
        self.department_name_loc = Locators.department_name_loc
        self.rack_name_loc = Locators.rack_name_loc
        self.add_site_button_xpath = Locators.add_site_button_xpath
        self.add_building_button_xpath = Locators.add_building_button_xpath
        self.add_room_button_xpath = Locators.add_room_button_xpath
        self.add_rack_button_xpath = Locators.add_rack_button_xpath

    def open_rack(self):
        self.driver.find_element_by_xpath(self.region_xpath).click()
        self.wait.until(EC. \
            element_to_be_clickable((By.XPATH, self.department_xpath))).click()
        self.wait.until(EC. \
            element_to_be_clickable((By.XPATH, self.site_xpath))).click()
        self.wait.until(EC. \
            element_to_be_clickable((By.XPATH, self.building_xpath))).click()
        self.wait.until(EC. \
            element_to_be_clickable((By.XPATH, self.room_xpath))).click()
        self.wait.until(EC. \
            element_to_be_clickable((By.XPATH, self.rack_xpath))).click()

    def get_auth_loc(self):
        return self.driver.find_element_by_xpath(self.auth_loc)

    def get_department_name_loc(self):
        return self.driver.find_element_by_xpath(self.department_name_loc)

    def get_rack_name_loc(self):
        return self.driver.find_element_by_xpath(self.rack_name_loc)

    def expand_region(self):
        self.driver.find_element_by_xpath(self.region_xpath).click()

    def add_site(self):
        self.wait.until(EC. \
            element_to_be_clickable((By.XPATH, self.add_site_button_xpath))). \
            click()

    def add_new_building(self):
        self.driver.find_element_by_xpath(self.region_xpath).click()
        self.wait.until(EC. \
            element_to_be_clickable((By.XPATH, self.department_xpath))).click()
        self.wait.until(EC. \
            element_to_be_clickable((By. \
            XPATH, self.add_building_button_xpath))).click()

    def add_new_room(self):
        self.driver.find_element_by_xpath(self.region_xpath).click()
        self.wait.until(EC. \
            element_to_be_clickable((By.XPATH, self.department_xpath))).click()
        self.wait.until(EC. \
            element_to_be_clickable((By.XPATH, self.site_xpath))).click()
        self.wait.until(EC. \
            element_to_be_clickable((By. \
            XPATH, self.add_room_button_xpath))).click()

    def add_new_rack(self):
        self.driver.find_element_by_xpath(self.region_xpath).click()
        self.wait.until(EC. \
            element_to_be_clickable((By.XPATH, self.department_xpath))).click()
        self.wait.until(EC. \
            element_to_be_clickable((By.XPATH, self.site_xpath))).click()
        self.wait.until(EC. \
            element_to_be_clickable((By.XPATH, self.building_xpath))).click()
        self.wait.until(EC. \
            element_to_be_clickable((By. \
            XPATH, self.add_rack_button_xpath))).click()
