from locators import Locators


class LoginPage():
    """
    POM for authorization page
    """

    def __init__(self, driver):
        self.driver = driver
        self.username_textbox_id = Locators.username_textbox_id
        self.password_textbox_id = Locators.password_textbox_id
        self.login_button_id = Locators.login_button_id

    def enter_username(self, username):
        """
        Enter username
        """
        self.driver.find_element_by_id(self.username_textbox_id).clear()
        self.driver.find_element_by_id(self.username_textbox_id) \
            .send_keys(username)

    def enter_password(self, password):
        """
        Enter password
        """
        self.driver.find_element_by_id(self.password_textbox_id).clear()
        self.driver.find_element_by_id(self.password_textbox_id) \
            .send_keys(password)

    def click_login(self):
        """
        Click login
        """
        self.driver.find_element_by_tag_name(self.login_button_id).click()
