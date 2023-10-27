/**
 * Get devices for one rack side
 * @param {Object} devices Devices for single rack
 * @returns {Object} Devices for side
 */
const getDevicesForSide = (devices) => {
  let devicesForSide = {
    front: [],
    back: []
  }
  devices.forEach((device) => {
    if (!device.frontside_location) {
      devicesForSide.back.push(device);
    }
    devicesForSide.front.push(device);
  });
  return devicesForSide
}

/**
 * Get list of rack units in numbering order
 * @param {Object} rack Rack object
 * @returns {Array} List of rack units
 */
const getStartList = (rack) => {
  const arr = Array.from({length: rack.amount}, (_, i) => i + 1);
  if (!rack.numbering_from_bottom_to_top) {
    return arr;
  } else {
    return arr.reverse();
  };
}

/**
 * Get devices first units
 * @param {Object} devices Devices for one side
 * @param {Boolean} direction Numbering direction
 * @returns {Object} Devices first units
 */
const getFirstUnits = (devices, direction) => {
  let firstUnits = {};
  for (const device of devices) {
    let lastUnit = device.last_unit;
    let firstUnit = device.first_unit;
    if (direction) {
      if (lastUnit > firstUnit) {
        firstUnit = device.last_unit;
      }
      firstUnits[device.id] = firstUnit;
    } else {
      if (lastUnit < firstUnit) {
        firstUnit = device.last_unit;
      }
      firstUnits[device.id] = firstUnit;
    }
  }
  return firstUnits;
}

/**
 * Get rowspans for each device
 * @param {Object} devices Devices for one side
 * @returns {Object} Rowspans for each device
 */
const getRowSpans = (devices) => {
  let rowSpans = {};
  for (const device of devices) {
    let lastUnit = device.last_unit;
    let firstUnit = device.first_unit;
    if (lastUnit < firstUnit) {
      firstUnit = device.last_unit;
      lastUnit = device.first_unit;
    }
    rowSpans[device.id] = lastUnit - firstUnit + 1;
  }
  return rowSpans;
}

/**
 * Set empty string to null in form for validation
 * @param {Array} arr Array of field names
 * @param {Object} form Form
 */
const setEmptyStringToNull = (arr, form) => {
  arr.forEach((element) => {
    if (form[element] === "") {
      form[element] = null;
    }
  })
}

/**
 * Get data from object that contains match
 * @param {String} itemType Item type from vendors/models/etc objects
 * @param {Object} matchObject Objects from helpers
 * @returns {String} Matching string
 */
const getDataFromMatch = (itemType, matchObject) => {
  return (matchObject[itemType] || matchObject['default'])();
}

/**
 * Get caret class for tree expand
 * @param {String} status Caret status string
 * @returns {String} Caret class
 */
const getCaretClass = (status) => {
  return `caret ${status? 'down' : ''}`
}

/**
 * Get custom id for e2e testing
 * @param {String} itemName  Item name
 * @param {String} action Action (fe add)
 * @param {String} element Element (fe button)
 * @returns {String} Custom id string for e2e testing
 */
const getId = (itemName, action, element) => {
  const baseId = `e2e_${itemName.replaceAll(' ', '_')}`
  if (action && element) {
    return`${baseId}_${action}_${element}`
  }
  return baseId
}

export { 
  getRowSpans, 
  getFirstUnits, 
  getStartList, 
  getDevicesForSide,
  setEmptyStringToNull,
  getDataFromMatch,
  getCaretClass,
  getId
}