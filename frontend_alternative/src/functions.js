/**
 * Get devices for one rack side
 * @param {Object} devices Devices for single rack
 * @returns {Object.<string, [Object]>} Devices for side
 */
export const getDevicesForSide = (devices) => {
  let devicesForSide = {
    front: [],
    back: []
  };
  devices.forEach((device) => {
    if (device.has_backside_location) {
      devicesForSide.back.push(device);
    } else {
      devicesForSide.front.push(device);
    }
  });
  return devicesForSide
};

/**
 * Get list of rack units in numbering order
 * @param {Object} rack Rack object
 * @returns {Array.<number>} List of rack units
 */
export const getStartList = (rack) => {
  const arr = Array.from({length: rack.amount}, (_, i) => i + 1);
  if (rack.has_numbering_from_top_to_bottom) {
    return arr;
  } else {
    return arr.reverse();
  }
};

/**
 * Get devices first units
 * @param {Object} devices Devices for one side
 * @param {Boolean} direction Numbering direction
 * @returns {Object.<number, number>} Devices first units
 */
export const getFirstUnits = (devices, direction) => {
  let firstUnits = {};
  for (const device of devices) {
    const units = JSON.parse(device.units);
    if (direction) {
      firstUnits[device.id] = units[0];
    } else {
      firstUnits[device.id] = units[units.length - 1];
    }
  }
  return firstUnits;
};

/**
 * Get rowspans for each device
 * @param {Object} devices Devices for one side
 * @returns {Object.<number, number>} Rowspans for each device
 */
export const getRowSpans = (devices) => {
  let rowSpans = {};
  for (const device of devices) {
    const units = JSON.parse(device.units);
    rowSpans[device.id] = units[units.length - 1] - units[0] + 1;
  }
  return rowSpans;
};

/**
 *
 * @param {Number} formFirstUnit First unit
 * @param {Number} formLastUnit Last unit
 * @returns {Array.<number>} Units array
 */
export const getUnitsArray = (formFirstUnit, formLastUnit) => {
  let firstUnit = formFirstUnit;
  let lastUnit = formLastUnit;
  if (firstUnit > lastUnit) {
    firstUnit = formLastUnit;
    lastUnit = formFirstUnit;
  }
  let units = [];
  for (let i = firstUnit; i <= lastUnit; i++) {
    units.push(i);
  }
  return units;
};

/**
 * Set empty string to null in form for validation
 * @param {Array} arr Array of field names
 * @param {Object} form Form
 */
export const setEmptyStringToNull = (arr, form) => {
  arr.forEach((element) => {
    if (form[element] === "") {
      form[element] = null;
    }
  })
};

/**
 * Get data from object that contains match
 * @param {String} itemType Item type from vendors/models/etc objects
 * @param {Object} matchObject Objects from helpers
 * @returns {String} Matching string
 */
export const getDataFromMatch = (itemType, matchObject) => {
  return (matchObject[itemType] || matchObject['default'])();
};

/**
 * Get caret class for tree expand
 * @param {String} status Caret status string
 * @returns {String} Caret class
 */
export const getCaretClass = (status) => {
  return `caret ${status? 'down' : ''}`
};

/**
 * Get custom id for e2e testing
 * @param {String} itemName  Item name
 * @param {String} action Action (fe add)
 * @param {String} element Element (fe button)
 * @returns {String} Custom id string for e2e testing
 */
export const getId = (itemName, action, element) => {
  const baseId = `e2e_${itemName.replaceAll(' ', '_')}`;
  if (action && element) {
    return`${baseId}_${action}_${element}`
  }
  return baseId
};
