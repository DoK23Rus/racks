const truncate = (string, lgth) => {
  // String truncation
  if (string.length > lgth) {
    return string.substr(0, lgth) + '...';
  }
  return string;
}

export { truncate }