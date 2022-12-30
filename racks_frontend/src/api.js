import axios from 'axios';


const BASE_URL = '/api/v1';

function logError(error, objName, method) {
  console.log(`Something went wrong, cant ${method} ${objName}`);
  console.error(error.response.data);
};

export async function getObject(objName, url, id, location) {
  const pk = (!id) ? '' : id;
  const prefix = (!location) ? '' : location;
  try {
    const response = await axios.get(`${BASE_URL}${url}${pk}${prefix}`);
    return response.data;
  } catch (error) {
    logError(error, objName, 'get');
    return error.response.data;
  }
};

export async function postObject(objName, url, formData) {
  try {
    const response = await axios.post(`${BASE_URL}${url}`, formData);
    return response.data;
  } catch (error) {
    logError(error, objName, 'post');
    return error.response.data;
  }
};

export async function putObject(objName, url, formData) {
  try {
    const response = await axios.put(`${BASE_URL}${url}`, formData);
    return response.data;
  } catch (error) {
    logError(error, objName, 'put');
    return error.response.data;
  }
};

export async function deleteObject(objName, url, payload) {
  try {
    const response = await axios.delete(`${BASE_URL}${url}`, { data: payload });
    return response.data;
  } catch (error) {
    logError(error, objName, 'delete');
    return error.response.data;
  }
};

export async function getUser(objName) {
  try {
    const response = await axios.get(`${BASE_URL}/user`);
    return response.data;
  } catch (error) {
    logError(error, objName, 'get');
    return error.response.data;
  }
};

export async function getUnique(objName, url) {
  // Get unique list (for vendors and models)
  try {
    const response = await axios.get(`${BASE_URL}${url}`);
    return response.data;
  } catch (error) {
    logError(error, objName, 'get');
    return error.response.data;
  }
};

