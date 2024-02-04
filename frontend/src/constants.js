// Base path for API
export const BASE_PATH = '/api/auth';

// Status codes
export const RESPONSE_STATUS = Object.freeze({
  OK: 200, // GET
  CREATED: 201, // POST
  ACCEPTED: 202, // PUT
  NO_CONTENT: 204, //DELETE
  UNAUTHORIZED: 401,
  NOT_FOUND: 404,
  INTERNAL_SERVER_ERROR: 500
});

// List of device types with OS
export const DEVICES_WITH_OS = [
  'Switch',
  'Router',
  'Firewall',
  'Security Gateway',
  'Server'
];

// List of device types with many ports
export const DEVICES_WITH_PORTS = [
  'Switch',
  'Fiber optic patch panel',
  'RJ45 patch panel'
];

// Truncation length
export const TRUNCATION_LENGTH = Object.freeze({
  DEFAULT: 50,
  RACK: 40,
  DEVICE: 30
});

// Device ownership
export const DEVICE_OWNERSHIP = Object.freeze({
  OUR: 'Our department'
});

// Device statuses
export const DEVICE_STATUS = Object.freeze({
  ACTIVE: 'Device active',
  FAILED: 'Device failed',
  TURNED_OFF: 'Device turned off',
  NOT_IN_USE:'Device not in use',
  RESERVED: 'Units reserved',
  NOT_AVAILABLE: 'Units not available',
});

// Matching object for id
export const MATCH_ID = Object.freeze({
  'device_vendor': () => 'deviceVendor',
  'device_model': () => 'deviceModel',
  'rack_vendor': () => 'rackVendor',
  'rack_model': () => 'rackModel',
  'default': () => console.log('Something wrong with props (itemsData.item_type) / setting id')
});

// Matching object for label
export const MATCH_LABEL = Object.freeze({
  'device_vendor': () => 'Device vendor',
  'device_model': () => 'Device model',
  'rack_vendor': () => 'Rack vendor',
  'rack_model': () => 'Rack model',
  'default': () => console.log('Something wrong with props (itemsData.item_type) / setting label')
});