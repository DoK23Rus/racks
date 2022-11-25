import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import axios from 'axios'
import './assets/tailwind.css'


axios.defaults.baseURL = 'http://127.0.0.1:8000';

axios.interceptors.response.use((response) => {
  return response;
}, (error) => {
  if (error.response) {
    switch (error.response.status) {
      case 401:
        localStorage.removeItem('token');
        router.push('/login');
        window.location.reload();
    }
    return Promise.reject(error);
  }
});

createApp(App).use(store).use(router, axios).mount('#app')

