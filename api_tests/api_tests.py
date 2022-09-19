import requests
import unittest
from requests.auth import HTTPBasicAuth
import HtmlTestRunner
from mock_data import MockData
from specs import Specs


class RacksApiTestCase(unittest.TestCase):
    """
    Testing endpoint for getting all racks
    """
    url = Specs.base_url + Specs.all_racks_url
    headers = Specs.headers
    auth = HTTPBasicAuth(Specs.username, Specs.password)

    def test_get_all_racks(self):
        response = requests.get(self.url, headers=self.headers, auth=self.auth)
        data = response.json()
        # Delete some dynamic data
        for dict_ in data:
            del dict_['id']
            del dict_['updated_at']
            del dict_['updated_by']
            del dict_['room_id']
        self.assertEqual(data, MockData.racks)


class DevicesApiTestCase(unittest.TestCase):
    """
    Testing endpoint for getting all devices
    """
    url = Specs.base_url + Specs.all_devices_url
    headers = Specs.headers
    auth = HTTPBasicAuth(Specs.username, Specs.password)

    def test_get_all_devices(self):
        response = requests.get(self.url, headers=self.headers, auth=self.auth)
        data = response.json()
        # Delete some dynamic data
        for dict_ in data:
            del dict_['id']
            del dict_['updated_at']
            del dict_['updated_by']
            del dict_['device_stack']
            del dict_['rack_id']
        self.assertEqual(data, MockData.devices)


if __name__ == "__main__":
    unittest.main(testRunner=HtmlTestRunner
                  .HTMLTestRunner(output=Specs.test_results_path))
