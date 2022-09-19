"""
Mock data for API tests
"""
class MockData:
    racks = [
        {
            'rack_name': 'Test rack №1',
            'rack_amount': 42,
            'rack_vendor': 'ITK',
            'rack_model': 'ZPAS',
            'rack_description': 'Telecom rack',
            'numbering_from_bottom_to_top': True,
            'responsible': 'Иванов И. И.',
            'rack_financially_responsible_person': 'Иванов И. И.',
            'rack_inventory_number': '12341234787',
            'fixed_asset': '',
            'link': '',
            'row': '1',
            'place': '3',
            'rack_height': 2000,
            'rack_width': 600,
            'rack_depth': 1360,
            'rack_unit_width': 19,
            'rack_unit_depth': 580,
            'rack_type': 'Rack',
            'rack_frame': 'Double frame',
            'rack_palce_type': 'Floor standing',
            'max_load': 1360,
            'power_sockets': 3,
            'power_sockets_ups': 2,
            'external_ups': True,
            'cooler': True,
        },
        {
            'rack_name': 'Test rack №2',
            'rack_amount': 22,
            'rack_vendor': '',
            'rack_model': '',
            'rack_description': '',
            'numbering_from_bottom_to_top': True,
            'responsible': '',
            'rack_financially_responsible_person': '',
            'rack_inventory_number': '',
            'fixed_asset': '',
            'link': '',
            'row': '2',
            'place': '2',
            'rack_height': None,
            'rack_width': None,
            'rack_depth': None,
            'rack_unit_width': 19,
            'rack_unit_depth': None,
            'rack_type': 'Rack',
            'rack_frame': 'Double frame',
            'rack_palce_type': 'Floor standing',
            'max_load': None,
            'power_sockets': None,
            'power_sockets_ups': None,
            'external_ups': True,
            'cooler': False,
        }
    ]
    devices = [
        {
            'first_unit': 41,
            'last_unit': 41,
            'frontside_location': True,
            'status': 'Device active',
            'device_type': 'RJ45 patch panel',
            'device_vendor': '',
            'device_model': '',
            'device_hostname': '',
            'ip': None,
            'ports_amout': None,
            'version': '',
            'power_type': 'IEC C14 socket',
            'power_w': None,
            'power_v': 220,
            'power_ac_dc': 'AC',
            'device_serial_number': '',
            'device_description': '',
            'project': '',
            'ownership': 'Our department',
            'responsible': '',
            'financially_responsible_person': '',
            'device_inventory_number': '',
            'fixed_asset': '',
            'link': '',
        },
        {
            'first_unit': 35,
            'last_unit': 36,
            'frontside_location': True,
            'status': 'Device active',
            'device_type': 'Switch',
            'device_vendor': 'Cisco',
            'device_model': '2911',
            'device_hostname': '',
            'ip': None,
            'ports_amout': None,
            'version': '',
            'power_type': 'IEC C14 socket',
            'power_w': None,
            'power_v': 220,
            'power_ac_dc': 'AC',
            'device_serial_number': '',
            'device_description': '',
            'project': '',
            'ownership': 'Our department',
            'responsible': '',
            'financially_responsible_person': '',
            'device_inventory_number': '',
            'fixed_asset': '',
            'link': '',
        },
        {
            'first_unit': 5,
            'last_unit': 6,
            'frontside_location': False,
            'status': 'Device active',
            'device_type': 'UPC',
            'device_vendor': 'APC',
            'device_model': 'back-UPS',
            'device_hostname': '',
            'ip': None,
            'ports_amout': None,
            'version': '',
            'power_type': 'IEC C14 socket',
            'power_w': None,
            'power_v': 220,
            'power_ac_dc': 'AC',
            'device_serial_number': '',
            'device_description': '',
            'project': '',
            'ownership': 'Our department',
            'responsible': '',
            'financially_responsible_person': '',
            'device_inventory_number': '123456789023',
            'fixed_asset': '',
            'link': '',
        },
        {
            'first_unit': 38,
            'last_unit': 38,
            'frontside_location': True,
            'status': 'Device failed',
            'device_type': 'Switch',
            'device_vendor': 'Defective',
            'device_model': 'switch',
            'device_hostname': '',
            'ip': None,
            'ports_amout': None,
            'version': '',
            'power_type': 'IEC C14 socket',
            'power_w': None,
            'power_v': 220,
            'power_ac_dc': 'AC',
            'device_serial_number': '',
            'device_description': '',
            'project': '',
            'ownership': 'Our department',
            'responsible': '',
            'financially_responsible_person': '',
            'device_inventory_number': '',
            'fixed_asset': '',
            'link': '',
        },
        {
            'first_unit': 42,
            'last_unit': 42,
            'frontside_location': True,
            'status': 'Device active',
            'device_type': 'Switch',
            'device_vendor': 'Provider',
            'device_model': 'switch',
            'device_hostname': '',
            'ip': None,
            'ports_amout': None,
            'version': '',
            'power_type': 'IEC C14 socket',
            'power_w': None,
            'power_v': 220,
            'power_ac_dc': 'AC',
            'device_serial_number': '',
            'device_description': '',
            'project': '',
            'ownership': 'Оборудование оператора',
            'responsible': 'Петров',
            'financially_responsible_person': '',
            'device_inventory_number': '',
            'fixed_asset': '',
            'link': '',
        },
        {
            'first_unit': 39,
            'last_unit': 39,
            'frontside_location': True,
            'status': 'Device active',
            'device_type': 'Switch',
            'device_vendor': 'Cisco',
            'device_model': '2960',
            'device_hostname': 'Switch_SW1f_1',
            'ip': '192.168.15.74',
            'ports_amout': 24,
            'version': '12.2',
            'power_type': 'IEC C14 socket',
            'power_w': 450,
            'power_v': 220,
            'power_ac_dc': 'AC',
            'device_serial_number': 'JAF1710BBPJ',
            'device_description': 'First floor access switch',
            'project': 'Tech-refresh (2019)',
            'ownership': 'Our department',
            'responsible': 'Some engineer',
            'financially_responsible_person': 'Some other engineer',
            'device_inventory_number': '1234567890',
            'fixed_asset': 'Cisco Catalyst 2960',
            'link': 'F:\\Accerts\\devices.doc',
        },
        {
            'first_unit': 2,
            'last_unit': 4,
            'frontside_location': True,
            'status': 'Device active',
            'device_type': 'UPS',
            'device_vendor': '',
            'device_model': '',
            'device_hostname': '',
            'ip': None,
            'ports_amout': None,
            'version': '',
            'power_type': 'IEC C14 socket',
            'power_w': None,
            'power_v': 220,
            'power_ac_dc': 'AC',
            'device_serial_number': '',
            'device_description': '',
            'project': '',
            'ownership': 'Our department',
            'responsible': '',
            'financially_responsible_person': '',
            'device_inventory_number': '',
            'fixed_asset': '',
            'link': '',
        }
    ]
