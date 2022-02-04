import unittest
from selenium import webdriver
from selenium.webdriver.firefox.options import Options
from selenium.webdriver.common.keys import Keys
import time
from LoginPage import LoginPage
from RacksPage import RacksPage
from UnitsPage import UnitsPage
from DevicePage import DevicePage
from DeviceFormPage import DeviceFormPage
from AnswerPage import AnswerPage
from SiteAddPage import SiteAddPage
from BuildingAddPage import BuildingAddPage
from RoomAddPage import RoomAddPage
from RackAddPage import RackAddPage
from locators import Locators


class ServicesTestCase(unittest.TestCase):

    def setUp(self):
        options = Options()
        options.headless = True
        #options.headless = False
        self.driver = webdriver.Firefox(options=options, 
            executable_path='/home/slunk/selenium/geckodriver')
        self.driver.implicitly_wait(10)
        self.driver.delete_all_cookies()
        self.driver.get('http://127.0.0.1:8001/login/')
        login = LoginPage(self.driver)
        login.enter_username('selenium')
        login.enter_password('sel_testing')
        login.click_login()

    def tearDown(self):
        self.driver.close()
        self.driver.quit()
    
    def test_1_1_user_check(self):
        racks = RacksPage(self.driver)
        self.assertTrue(racks.get_auth_loc(),
                        Locators.auth_loc)
        print('\ntest_1_1')

    def test_1_2_department_exists(self):
        racks = RacksPage(self.driver)
        self.assertTrue(racks.get_department_name_loc(),
                        Locators.department_name_loc)
        print('\ntest_1_2')

    def test_1_3_rack_exists(self):
        racks = RacksPage(self.driver)
        self.assertTrue(racks.get_rack_name_loc(),
                        Locators.rack_name_loc)
        print('\ntest_1_3')
    def test_1_4_first_device_exists(self):
        racks = RacksPage(self.driver)
        racks.open_rack()
        time.sleep(1)
        self.driver.switch_to.window(self.driver.window_handles[1])
        time.sleep(1)
        units = UnitsPage(self.driver)
        self.assertTrue(units.get_first_device_loc(),
                        Locators.first_device_loc)
        print('\ntest_1_4')

    def test_1_5_second_device_exists(self):
        racks = RacksPage(self.driver)
        racks.open_rack()
        time.sleep(1)
        self.driver.switch_to.window(self.driver.window_handles[1])
        time.sleep(1)
        units = UnitsPage(self.driver)
        self.assertTrue(units.get_second_device_loc(),
                        Locators.second_device_loc)
        print('\ntest_1_5')

    def test_1_6_first_device_in_their_place(self):
        racks = RacksPage(self.driver)
        racks.open_rack()
        time.sleep(1)
        self.driver.switch_to.window(self.driver.window_handles[1])
        units = UnitsPage(self.driver)
        units.open_first_device()
        time.sleep(1)
        self.driver.switch_to.window(self.driver.window_handles[2])
        device = DevicePage(self.driver)
        device.change_first_device()
        time.sleep(1)
        device_form = DeviceFormPage(self.driver)
        self.assertEqual(device_form.get_device_first_unit(), 
                         Locators.first_device_first_unit_ok)
        self.assertEqual(device_form.get_device_last_unit(), 
                         Locators.first_device_last_unit_ok) 
        print('\ntest_1_6')
    
    def test_1_7_second_device_in_their_place(self):
        racks = RacksPage(self.driver)
        racks.open_rack()
        time.sleep(1)
        self.driver.switch_to.window(self.driver.window_handles[1])
        units = UnitsPage(self.driver)
        units.open_second_device()
        time.sleep(1)
        self.driver.switch_to.window(self.driver.window_handles[2]) 
        device = DevicePage(self.driver)
        device.change_second_device()
        time.sleep(1)
        device_form = DeviceFormPage(self.driver)
        self.assertEqual(device_form.get_device_first_unit(), 
                         Locators.second_device_first_unit_ok)
        self.assertEqual(device_form.get_device_last_unit(), 
                         Locators.second_device_last_unit_ok)
        print('\ntest_1_7')

    def test_2_move_device_outside(self):
        racks = RacksPage(self.driver)
        racks.open_rack()
        time.sleep(1)
        self.driver.switch_to.window(self.driver.window_handles[1])
        units = UnitsPage(self.driver)
        units.open_first_device()
        time.sleep(1)
        self.driver.switch_to.window(self.driver.window_handles[2])
        device = DevicePage(self.driver)
        device.change_first_device()
        time.sleep(1)
        device_form = DeviceFormPage(self.driver)
        first_unit = device_form.use_first_unit_textbox()
        first_unit.send_keys(Keys.CONTROL + "a")
        first_unit.send_keys(Keys.DELETE)
        first_unit.send_keys(Locators.first_device_first_unit_outside)
        last_unit = device_form.use_last_unit_textbox()
        last_unit.send_keys(Keys.CONTROL + "a")
        last_unit.send_keys(Keys.DELETE)
        last_unit.send_keys(Locators.first_device_last_unit_outside)
        device_form.click_change()
        answer_page = AnswerPage(self.driver)
        self.assertTrue(answer_page.get_unit_outside_loc())
        print('\ntest_2')
    
    def test_3_move_device_to_busy_place(self):
        racks = RacksPage(self.driver)
        racks.open_rack()
        time.sleep(1)
        self.driver.switch_to.window(self.driver.window_handles[1])
        units = UnitsPage(self.driver)
        units.open_first_device()
        time.sleep(1)
        self.driver.switch_to.window(self.driver.window_handles[2])
        device = DevicePage(self.driver)
        device.change_first_device()
        time.sleep(1)
        device_form = DeviceFormPage(self.driver)
        first_unit = device_form.use_first_unit_textbox()
        first_unit.send_keys(Keys.CONTROL + "a")
        first_unit.send_keys(Keys.DELETE)
        first_unit.send_keys(Locators.first_device_first_unit_busy)
        last_unit = device_form.use_last_unit_textbox()
        last_unit.send_keys(Keys.CONTROL + "a")
        last_unit.send_keys(Keys.DELETE)
        last_unit.send_keys(Locators.first_device_last_unit_busy)
        device_form.click_change()
        answer_page = AnswerPage(self.driver)
        self.assertTrue(answer_page.get_unit_busy_loc())
        print('\ntest_3')
    
    def test_4_permitions(self):
        racks = RacksPage(self.driver)
        racks.expand_region()
        racks.add_site()
        time.sleep(1)
        site = SiteAddPage(self.driver)
        site.enter_site_name(Locators.site_name)
        site.click_accept()
        answer_page = AnswerPage(self.driver)
        self.assertTrue(answer_page.get_violation_loc())
        print('\ntest_4')
    
    def test_5_add_device_outside(self):
        racks = RacksPage(self.driver)
        racks.open_rack()
        time.sleep(1)
        self.driver.switch_to.window(self.driver.window_handles[1])
        units = UnitsPage(self.driver)
        units.add_new_device()
        time.sleep(1)
        self.driver.switch_to.window(self.driver.window_handles[2])
        device_form = DeviceFormPage(self.driver)
        first_unit = device_form.use_first_unit_textbox()
        first_unit.send_keys(Keys.CONTROL + "a")
        first_unit.send_keys(Keys.DELETE)
        first_unit.send_keys(Locators.first_device_first_unit_outside)
        last_unit = device_form.use_last_unit_textbox()
        last_unit.send_keys(Keys.CONTROL + "a")
        last_unit.send_keys(Keys.DELETE)
        last_unit.send_keys(Locators.first_device_last_unit_outside)
        device_form.click_change()
        answer_page = AnswerPage(self.driver)
        self.assertTrue(answer_page.get_unit_outside_loc())
        print('\ntest_5')

    def test_6_add_device_outside(self):
        racks = RacksPage(self.driver)
        racks.open_rack()
        time.sleep(1)
        self.driver.switch_to.window(self.driver.window_handles[1])
        units = UnitsPage(self.driver)
        units.add_new_device()
        time.sleep(1)
        self.driver.switch_to.window(self.driver.window_handles[2])
        device_form = DeviceFormPage(self.driver)
        first_unit = device_form.use_first_unit_textbox()
        first_unit.send_keys(Keys.CONTROL + "a")
        first_unit.send_keys(Keys.DELETE)
        first_unit.send_keys(Locators.first_device_first_unit_outside)
        last_unit = device_form.use_last_unit_textbox()
        last_unit.send_keys(Keys.CONTROL + "a")
        last_unit.send_keys(Keys.DELETE)
        last_unit.send_keys(Locators.first_device_last_unit_outside)
        device_form.click_change()
        answer_page = AnswerPage(self.driver)
        self.assertTrue(answer_page.get_unit_outside_loc())
        print('\ntest_6')

    def test_7_add_same_name_building(self):
        racks = RacksPage(self.driver)
        racks.add_new_building()
        time.sleep(1)
        building = BuildingAddPage(self.driver)
        building.enter_building_name(Locators.building_name)
        building.click_accept()
        time.sleep(1)
        answer_page = AnswerPage(self.driver)
        self.assertTrue(answer_page.get_building_name_busy_loc())
        print('\ntest_7')

    def test_8_add_same_name_room(self):
        racks = RacksPage(self.driver)
        racks.add_new_room()
        time.sleep(1)
        room = RoomAddPage(self.driver)
        room.enter_room_name(Locators.room_name)
        room.click_accept()
        time.sleep(1)
        answer_page = AnswerPage(self.driver)
        self.assertTrue(answer_page.get_room_name_busy_loc())
        print('\ntest_8')
    
    def test_9_add_same_name_rack(self):
        racks = RacksPage(self.driver)
        racks.add_new_rack()
        time.sleep(1)
        rack = RackAddPage(self.driver)
        rack.enter_rack_name(Locators.rack_name)
        rack.enter_rack_amount(Locators.rack_amount)
        rack.click_accept()
        time.sleep(1)
        answer_page = AnswerPage(self.driver)
        self.assertTrue(answer_page.get_rack_name_busy_loc())
        print('\ntest_9')


if __name__ == "__main__":
    unittest.main()
