/**
 * Validator for numeric greater than zero or null
 * @param {*} value Validation value
 * @returns {Boolean} Pass or not
 */
export const numericGTZOrNull = (value) => {
  if (typeof value === 'string') {
    let val = +value;
    if (value === "") {
      return true
    } else if (!String(val).includes('.') && !value.includes('.0') && val > 0) {
      return true
    } else {
      return false
    }
  } else {
    return true
  }
};

/**
 * Validator for numeric greater than zero
 * @param {*} value Validation value
 * @returns {Boolean} Pass or not
 */
export const numericOrNull = (value) => {
  if (typeof value === 'string') {
    let val = +value;
    if (value === "") {
      return true
    } else if (!String(val).includes('.') && !value.includes('.0') && val >= 0) {
      return true
    } else {
      return false
    }
  } else {
    return true
  }
};