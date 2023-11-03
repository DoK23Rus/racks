import axios from 'axios';


const BASE_PATH = '/api/v1';

/**
 * Log error
 * @param {Object} error Error object
 * @param {String} objName Object name
 * @param {String} method Metod name
 */
function logError(error, objName, method) {
  console.log(`Something went wrong, cant ${method} ${objName}`);
  console.error(error.response.data);
};

/**
 * GET object
 * @param {String} objName Object name
 * @param {String} path Path
 * @param {String} id Object id
 * @param {String} subPath Sub path
 * @returns {Object} Response data or error
 */
export async function getObject(objName, path, id, subPath) {
  const pk = (!id) ? '' : id;
  const sPath = (!subPath) ? '' : subPath;
  try {
    const response = await axios.get(`${BASE_PATH}${path}${pk}${sPath}`);
    return response.data;
  } catch (error) {
    logError(error, objName, 'get');
    return error.response.data;
  }
};

/**
 * POST object
 * @param {String} objName Object name
 * @param {String} path Path
 * @param {Object} formData Form data
 * @returns {Object} Response data or error
 */
export async function postObject(objName, path, formData) {
  try {
    const response = await axios.post(`${BASE_PATH}${path}`, formData);
    return response.data;
  } catch (error) {
    logError(error, objName, 'post');
    return error.response.data;
  }
};

/**
 * PUT object
 * @param {String} objName Object name
 * @param {String} path Path
 * @param {Object} formData Form data
 * @returns {Object} Response data or error
 */
export async function putObject(objName, path, formData) {
  try {
    const response = await axios.put(`${BASE_PATH}${path}`, formData);
    return response.data;
  } catch (error) {
    logError(error, objName, 'put');
    return error.response.data;
  }
};

/**
 * DELETE object
 * @param {String} objName Object name
 * @param {String} path Path
 * @param {Object} payload Payload
 * @returns {Object} Response data or error
 */
export async function deleteObject(objName, path, payload) {
  try {
    const response = await axios.delete(`${BASE_PATH}${path}`, { data: payload });
    return response.data;
  } catch (error) {
    logError(error, objName, 'delete');
    return error.response.data;
  }
};

/**
 * GET User
 * @param {String} objName User name
 * @returns {Object} Response data or error
 */
export async function getUser(objName) {
  try {
    const response = await axios.get(`${BASE_PATH}/user`);
    return response.data;
  } catch (error) {
    logError(error, objName, 'get');
    return error.response.data;
  }
};

/**
 * GET object unique endpoint
 * @param {String} objName Object name
 * @param {String} path Path
 * @returns {Object} Response data or error
 */
export async function getUnique(objName, path) {
  // 
  try {
    const response = await axios.get(`${BASE_PATH}${path}`);
    return response.data;
  } catch (error) {
    logError(error, objName, 'get');
    return error.response.data;
  }
};
