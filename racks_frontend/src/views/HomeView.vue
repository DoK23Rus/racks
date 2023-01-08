<template>
  <div class="min-h-screen">
    <div class="text-lg font-sans font-light my-auto items-center flex flex-col pt-8">
      <br>
        <text class="text-4xl pb-8 font-thin">Welcome {{ username.user }}!</text>
      <br>
      <div class="pb-4 text-base">
        <button id="e2e_racks_map" class="text-white w-48  bg-blue-400 border-b-4 border-blue-700 hover:border-blue-500
        hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small text-base 
          px-7 py-2 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
          type="submit" @click="$router.push('/tree')">
          Racks map
        </button>
      <br>
        <button class="text-white w-48  bg-blue-400 border-b-4 border-blue-700 hover:border-blue-500
        hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small text-base 
          px-7 py-2 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
          type="submit" id="button" @click="downloadReport('device', 'devices_report.csv')">
          Export devices
        </button>
      <br>
        <button class="text-white w-48 bg-blue-400 border-b-4 border-blue-700 hover:border-blue-500
        hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small text-base 
          px-7 py-2 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
          type="submit" id="button" @click="downloadReport('rack', 'racks_report.csv')">
          Export racks
        </button>
      <br>
        <button class="text-white w-48 bg-blue-400 border-b-4 border-blue-700 hover:border-blue-500
        hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small text-base 
          px-7 py-2 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
          type="submit" id="button" @click="logout">
          Logout
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { getObject, getUser } from '@/api';
import axios from 'axios';

export default {
  name: 'HomeView',
  data() {  
      return {
        data: {},
        username: '',
        mySVG: require('@/assets/logo-svg.svg')
      }
  },
  created() {
    this.fetchUser();
  },
  methods: {
    logout() {
      localStorage.removeItem("token");
      this.$router.push('/login');
    },
    async downloadReport(reportName, fileName) {
      alert("Download will start in a few seconds");
      await axios({
        url: `${process.env.VUE_APP_AXIOS_URL}/api/v1/${reportName}/report/`,
        method: 'GET',
        responseType: 'blob',
      }).then((response) => {
        const downloadUrl = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement('a');
        link.href = downloadUrl;
        link.setAttribute('download', fileName);
        document.body.appendChild(link);
        link.click();
        link.remove();
      });
    },
    async fetchUser () {
      this.username = await getUser('username');
    },
  }
}
</script>
