<template>
  <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
    <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
      <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
        <h1 class="text-xl leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
          Authentication
        </h1>
        <template v-if="loginError.length">
          <text class="text-xs text-red-500">
            {{loginError}}
          </text>
        </template>
        <form
          class="space-y-4 md:space-y-6"
          v-on:submit.prevent="submitForm">
          <div>
            <label
              for="name"
              class="block mb-2 text-sm text-gray-900 dark:text-white"
            >
              Username:
            </label>
            <input
              v-model="name"
              name="name"
              id="e2e_username"
              class="bg-gray-50 border border-gray-300
              text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
              dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500
              dark:focus:border-blue-500"
              placeholder="username"
              required=""
            >
          </div>
          <div>
            <label
              for="password"
              class="block mb-2 text-sm text-gray-900 dark:text-white"
            >
              Password:
            </label>
            <input
              v-model="password"
              type="password"
              name="password"
              id="e2e_password"
              placeholder="••••••••"
              class="bg-gray-50 border border-gray-300
              text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700
              dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
              required=""
            >
          </div>
          <button
            type="submit"
            id="e2e_login"
            class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-primary-300
            rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600
            dark:hover:bg-primary-700 dark:focus:ring-primary-800"
          >
            Log in
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import {BASE_PATH, RESPONSE_STATUS} from "@/constants";


export default {
  name: 'LoginView',
  data() {
    return {
      name: '',
      password: '',
      loginError: ''
    }
  },
  methods: {
    /**
     * Submit form
     */
    submitForm() {
      const formData = {
        name: this.name,
        password: this.password
      };
      // Get and store token
      axios
        .post(`${BASE_PATH}/login`, formData)
        .then(response => {
          const token = response.data.access_token;
          this.$store.commit('setToken', token);
          axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
          localStorage.setItem('token', token);
          this.$router.push('/');
        })
        .catch(error => {
          if (error.response.status === RESPONSE_STATUS.UNAUTHORIZED) {
            this.loginError = "We couldn't verify your account details";
          } else {
            this.loginError = "Something went wrong, please refresh and try again";
          }
        });
    }
  }
}
</script>
