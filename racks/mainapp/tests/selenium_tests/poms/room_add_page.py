from locators import Locators


class RoomAddPage():

    def __init__(self, driver):
        self.driver = driver
        self.buildind_name = Locators.room_name
        self.room_name_textbox_id = Locators.room_name_textbox_id
        self.accept_button_xpath = Locators.accept_button_xpath

    def enter_room_name(self, room_name):
        self.driver.find_element_by_id(self.room_name_textbox_id). \
            send_keys(room_name)

    def click_accept(self):
        self.driver.find_element_by_xpath(self.accept_button_xpath).click()