/**
 * Get truncated string
 * @param {String} string String
 * @param {Number} lgth String length
 * @returns {String} Truncated string
 */
export const truncate = (string, lgth) => {
  if (string.length > lgth) {
    return string.substring(0, lgth) + '...';
  }
  return string;
};