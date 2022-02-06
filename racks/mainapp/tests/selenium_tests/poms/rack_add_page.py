from locators import Locators


class RackAddPage():

    def __init__(self, driver):
        self.driver = driver
        self.rack_name = Locators.rack_name
        self.rack_name_textbox_id = Locators.rack_name_textbox_id
        self.rack_amount_textbox_id = Locators.rack_amount_textbox_id
        self.accept_button_xpath = Locators.accept_button_xpath

    def enter_rack_name(self, rack_name):
        self.driver.find_element_by_id(self.rack_name_textbox_id). \
            send_keys(rack_name)

    def enter_rack_amount(self, rack_amount):
        self.driver.find_element_by_id(self.rack_amount_textbox_id). \
            send_keys(rack_amount)

    def click_accept(self):
        self.driver.find_element_by_xpath(self.accept_button_xpath).click()