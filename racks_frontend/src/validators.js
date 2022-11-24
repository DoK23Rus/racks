const numericGTZOrNull = (value) => {
  if (typeof value === 'string') {
    let val = +value
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
}

const numericOrNull = (value) => {
  if (typeof value === 'string') {
    let val = +value
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
}

export { numericGTZOrNull, numericOrNull }