import axios from 'axios';


const BASE_PATH = '/api/v1';

function logError(error, objName, method) {
  console.log(`Something went wrong, cant ${method} ${objName}`);
  console.error(error.response.data);
};

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

export async function postObject(objName, path, formData) {
  try {
    const response = await axios.post(`${BASE_PATH}${path}`, formData);
    return response.data;
  } catch (error) {
    logError(error, objName, 'post');
    return error.response.data;
  }
};

export async function putObject(objName, path, formData) {
  try {
    const response = await axios.put(`${BASE_PATH}${path}`, formData);
    return response.data;
  } catch (error) {
    logError(error, objName, 'put');
    return error.response.data;
  }
};

export async function deleteObject(objName, path, payload) {
  try {
    const response = await axios.delete(`${BASE_PATH}${path}`, { data: payload });
    return response.data;
  } catch (error) {
    logError(error, objName, 'delete');
    return error.response.data;
  }
};

export async function getUser(objName) {
  try {
    const response = await axios.get(`${BASE_PATH}/user`);
    return response.data;
  } catch (error) {
    logError(error, objName, 'get');
    return error.response.data;
  }
};

export async function getUnique(objName, path) {
  // Get unique list (for vendors and models)
  try {
    const response = await axios.get(`${BASE_PATH}${path}`);
    return response.data;
  } catch (error) {
    logError(error, objName, 'get');
    return error.response.data;
  }
};

