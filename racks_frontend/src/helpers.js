const getDevicesForSide = (devices) => {
  // Devices for side
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

const getStartList = (rack) => {
  // List of rack units
  const arr = Array.from({length: rack.rack_amount}, (_, i) => i + 1);
  if (!rack.numbering_from_bottom_to_top) {
    return arr;
  } else {
    return arr.reverse();
  };
}

const getFirstUnits = (devices, direction) => {
  // Devices first units
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

const getRowSpans = (devices) => {
  // Rowspans for each device
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

const setEmptyStringToNull = (arr, form) => {
  arr.forEach((element) => {
    if (form[element] === "") {
      form[element] = null;
    }
  })
}

const copyOnClick = (choice, id) => {
  // Fill texbox with existing name (from unique list)
  document.getElementById(id).value = document.getElementById(choice).innerText;
}

export { 
  getRowSpans, 
  getFirstUnits, 
  getStartList, 
  getDevicesForSide,
  setEmptyStringToNull,
  copyOnClick
}