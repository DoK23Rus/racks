from locators import Locators


class SiteAddPage():

    def __init__(self, driver):
        self.driver = driver
        self.site_name = Locators.site_name
        self.site_name_textbox_id = Locators.site_name_textbox_id
        self.accept_button_xpath = Locators.accept_button_xpath

    def enter_site_name(self, site_name):
        self.driver.find_element_by_id(self.site_name_textbox_id). \
            send_keys(site_name)

    def click_accept(self):
        self.driver.find_element_by_xpath(self.accept_button_xpath).click()