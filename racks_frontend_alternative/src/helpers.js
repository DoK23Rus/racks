// Helper objects

const matchId = {
  'device_vendor': () => 'deviceVendor',
  'device_model': () => 'deviceModel',
  'rack_vendor': () => 'rackVendor',
  'rack_model': () => 'rackModel',
  'default': () => console.log('Somthing wrong with props (itemsData.item_type) / setting id')
};

const matchLabel = {
  'device_vendor': () => 'Device vendor',
  'device_model': () => 'Device model',
  'rack_vendor': () => 'Rack vendor',
  'rack_model': () => 'Rack model',
  'default': () => console.log('Somthing wrong with props (itemsData.item_type) / setting label')
};


export { matchId, matchLabel }