"""
Smoke test
"""
import datetime
import os
import time
import unittest

from selenium import webdriver
from selenium.webdriver.common.keys import Keys

from params import Params
from poms.device_page import DevicePage
from poms.form_page import FormPage
from poms.home_page import HomePage
from poms.login_page import LoginPage
from poms.racks_page import RacksPage
from poms.units_page import UnitsPage
from selenium.webdriver.common.desired_capabilities import DesiredCapabilities


class E2ETestCase(unittest.TestCase):
    """
    Selenium tests
    """

    def setUp(self):
        """
        Setup and login
        """
        options = webdriver.ChromeOptions()
        options.add_argument('--ignore-ssl-errors=yes')
        options.add_argument('--ignore-certificate-errors')
        self.driver = webdriver.Remote(
            command_executor=os.environ.get('COMMAND_EXECUTOR'),
            options=options,
            desired_capabilities=DesiredCapabilities.CHROME,
        )
        self.driver.implicitly_wait(10)
        self.driver.delete_all_cookies()
        self.driver.get(os.environ.get('LOGIN_ADDRESS'))
        login = LoginPage(self.driver)
        login.enter_username(os.environ.get('SELENIUM_USER'))
        login.enter_password(os.environ.get('SELENIUM_PASS'))
        login.click_login()

    def tearDown(self):
        # Take screenshot when test fails
        for method, error in self._outcome.errors:
            if error:
                date = datetime.datetime.today().strftime('%Y-%m-%d_%H-%M-%S')
                screenshot_name = f"{os.environ.get('BASE_TEST_DIR')}" \
                    f"{os.environ.get('SCREENSHOTS_PATH')}Screen_" \
                    f"{date}_{self._testMethodName}.png"
                self.driver.save_screenshot(screenshot_name)
        self.driver.close()
        self.driver.quit()


class MoveDeviceCase(E2ETestCase):
    """
    Move device cases
    """

    def test_1_move_device_outside(self):
        """
        Trying to move the device off the rack
        """
        home_page = HomePage(self.driver)
        home_page.go_to_racks_map()
        racks = RacksPage(self.driver)
        racks.open_rack()
        time.sleep(1)
        self.driver.switch_to.window(self.driver.window_handles[1])
        units = UnitsPage(self.driver)
        units.open_first_device()
        time.sleep(1)
        self.driver.switch_to.window(self.driver.window_handles[2])
        device = DevicePage(self.driver)
        device.edit_device()
        time.sleep(1)
        self.driver.switch_to.window(self.driver.window_handles[3])
        device_form = FormPage(self.driver)
        first_unit = device_form.use_first_unit_textbox()
        first_unit.send_keys(Keys.CONTROL + "a")
        first_unit.send_keys(Keys.DELETE)
        first_unit.send_keys(Params.first_device_first_unit_outside)
        last_unit = device_form.use_last_unit_textbox()
        last_unit.send_keys(Keys.CONTROL + "a")
        last_unit.send_keys(Keys.DELETE)
        last_unit.send_keys(Params.first_device_last_unit_outside)
        device_form.click_submit()
        self.assertTrue(device_form.get_unit_outside_loc())

    def test_2_move_device_to_busy_place(self):
        """
        Trying to move the device to a busy place
        """
        home_page = HomePage(self.driver)
        home_page.go_to_racks_map()
        racks = RacksPage(self.driver)
        racks.open_rack()
        time.sleep(1)
        self.driver.switch_to.window(self.driver.window_handles[1])
        units = UnitsPage(self.driver)
        units.open_first_device()
        time.sleep(1)
        self.driver.switch_to.window(self.driver.window_handles[2])
        device = DevicePage(self.driver)
        device.edit_device()
        time.sleep(1)
        self.driver.switch_to.window(self.driver.window_handles[3])
        device_form = FormPage(self.driver)
        first_unit = device_form.use_first_unit_textbox()
        first_unit.send_keys(Keys.CONTROL + "a")
        first_unit.send_keys(Keys.DELETE)
        first_unit.send_keys(Params.first_device_first_unit_busy)
        last_unit = device_form.use_last_unit_textbox()
        last_unit.send_keys(Keys.CONTROL + "a")
        last_unit.send_keys(Keys.DELETE)
        last_unit.send_keys(Params.first_device_last_unit_busy)
        device_form.click_submit()
        self.assertTrue(device_form.get_unit_busy_loc())


class PermissionsCase(E2ETestCase):
    """
    Permissions cases
    """

    def test_3_check_permissions(self):
        """
        Trying to add a new object
        in the area of responsibility of another department
        """
        home_page = HomePage(self.driver)
        home_page.go_to_racks_map()
        racks = RacksPage(self.driver)
        racks.expand_region()
        racks.add_site()
        time.sleep(1)
        self.driver.switch_to.window(self.driver.window_handles[1])
        site_form = FormPage(self.driver)
        site_form.enter_site_name(Params.site_name)
        site_form.click_submit()
        self.assertTrue(site_form.get_violation_loc())


class AddDeviceCase(E2ETestCase):
    """
    Add device cases
    """

    def test_4_add_device_outside(self):
        """
        Trying to add a new device outside the rack
        """
        home_page = HomePage(self.driver)
        home_page.go_to_racks_map()
        racks = RacksPage(self.driver)
        racks.open_rack()
        time.sleep(1)
        self.driver.switch_to.window(self.driver.window_handles[1])
        units = UnitsPage(self.driver)
        units.add_new_device()
        time.sleep(1)
        self.driver.switch_to.window(self.driver.window_handles[2])
        device_form = FormPage(self.driver)
        first_unit = device_form.use_first_unit_textbox()
        first_unit.send_keys(Keys.CONTROL + "a")
        first_unit.send_keys(Keys.DELETE)
        first_unit.send_keys(Params.first_device_first_unit_outside)
        last_unit = device_form.use_last_unit_textbox()
        last_unit.send_keys(Keys.CONTROL + "a")
        last_unit.send_keys(Keys.DELETE)
        last_unit.send_keys(Params.first_device_last_unit_outside)
        device_form.click_submit()
        self.assertTrue(device_form.get_unit_outside_loc())

    def test_5_add_device_to_busy_place(self):
        """
        Trying to add a new device to the busy space
        """
        home_page = HomePage(self.driver)
        home_page.go_to_racks_map()
        racks = RacksPage(self.driver)
        racks.open_rack()
        time.sleep(1)
        self.driver.switch_to.window(self.driver.window_handles[1])
        units = UnitsPage(self.driver)
        units.add_new_device()
        time.sleep(1)
        self.driver.switch_to.window(self.driver.window_handles[2])
        device_form = FormPage(self.driver)
        first_unit = device_form.use_first_unit_textbox()
        first_unit.send_keys(Keys.CONTROL + "a")
        first_unit.send_keys(Keys.DELETE)
        first_unit.send_keys(Params.first_device_first_unit_busy)
        last_unit = device_form.use_last_unit_textbox()
        last_unit.send_keys(Keys.CONTROL + "a")
        last_unit.send_keys(Keys.DELETE)
        last_unit.send_keys(Params.first_device_last_unit_busy)
        device_form.click_submit()
        self.assertTrue(device_form.get_unit_busy_loc())


class NameDuplicationCase(E2ETestCase):
    """
    Name duplication cases
    for buildings, rooms and racks
    """

    def test_6_add_same_name_building(self):
        """
        Trying to add a building with a duplicate name
        """
        home_page = HomePage(self.driver)
        home_page.go_to_racks_map()
        racks = RacksPage(self.driver)
        racks.add_new_building()
        time.sleep(1)
        self.driver.switch_to.window(self.driver.window_handles[1])
        building_form = FormPage(self.driver)
        building_form.enter_building_name(Params.building_name)
        building_form.click_submit()
        time.sleep(1)
        self.assertTrue(building_form.get_building_name_busy_loc())

    def test_7_add_same_name_room(self):
        """
        Trying to add a room with a duplicate name
        """
        home_page = HomePage(self.driver)
        home_page.go_to_racks_map()
        racks = RacksPage(self.driver)
        racks.add_new_room()
        time.sleep(1)
        self.driver.switch_to.window(self.driver.window_handles[1])
        room_form = FormPage(self.driver)
        room_form.enter_room_name(Params.room_name)
        room_form.enter_room_floor(Params.room_floor)
        room_form.click_submit()
        time.sleep(1)
        self.assertTrue(room_form.get_room_name_busy_loc())

    def test_8_add_same_name_rack(self):
        """
        Trying to add a rack with a duplicate name
        """
        home_page = HomePage(self.driver)
        home_page.go_to_racks_map()
        racks = RacksPage(self.driver)
        racks.add_new_rack()
        time.sleep(1)
        self.driver.switch_to.window(self.driver.window_handles[1])
        rack_form = FormPage(self.driver)
        rack_form.enter_rack_name(Params.rack_name)
        rack_form.enter_rack_amount(Params.rack_amount)
        rack_form.click_submit()
        time.sleep(1)
        self.assertTrue(rack_form.get_rack_name_busy_loc())
