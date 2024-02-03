<template>
  <div class="min-h-screen">
    <div class="text-lg font-sans font-light my-auto items-center flex flex-col pt-8">
      <br>
			<text class="text-4xl pb-8 font-thin">
				Welcome {{user.full_name}} !
			</text>
      <br>
      <div class="pb-4 text-base">
        <button
          id="e2e_racks_map"
          class="text-white w-48  bg-blue-400 border-b-4 border-blue-700
          hover:border-blue-500 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small text-base
          px-7 py-2 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
          type="submit"
          v-on:click="$router.push('/tree')"
        >
          Racks map
        </button>
      <br>
        <button
          class="text-white w-48  bg-blue-400 border-b-4 border-blue-700
          hover:border-blue-500 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small text-base
          px-7 py-2 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
          type="submit"
          id="button"
          v-on:click="downloadReport('devices', 'devices_report.csv')"
        >
          Export devices
        </button>
      <br>
        <button
          class="text-white w-48 bg-blue-400 border-b-4 border-blue-700
          hover:border-blue-500 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small text-base
          px-7 py-2 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
          type="submit"
          id="button"
          v-on:click="downloadReport('racks', 'racks_report.csv')"
        >
          Export racks
        </button>
      <br>
        <button
          class="text-white w-48 bg-blue-400 border-b-4 border-blue-700 hover:border-blue-500
          hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small text-base
          px-7 py-2 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
          type="submit"
          id="button"
          v-on:click="logout"
        >
          Logout
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import {getUnique, logIfNotStatus} from '@/api';
import axios from 'axios';
import {RESPONSE_STATUS} from "@/constants";

export default {
  name: 'HomeView',
  data() {
		return {
			data: {},
			user: {},
			mySVG: require('@/assets/logo-svg.svg')
		}
  },
  created() {
    this.setUser();
  },
  methods: {
    /**
     * Logout
     */
    logout() {
      localStorage.removeItem('token');
      this.$router.push('/login');
    },
    /**
     * Download report
     * @param {String} reportName Report name
     * @param {String} fileName File name
     */
    async downloadReport(reportName, fileName) {
      alert('Download will start in a few seconds');
      await axios({
        url: `${process.env.VUE_APP_AXIOS_URL}/export/${reportName}`,
        method: 'GET',
        responseType: 'blob',
      })
			.then(response => {
				const data = new Blob([response.data]);
				const downloadUrl = window.URL.createObjectURL(data);
				const link = document.createElement('a');
				link.href = downloadUrl;
				link.setAttribute('download', fileName);
				document.body.appendChild(link);
				link.click();
				link.remove();
			});
    },
    /**
     * Fetch and set user
     */
    async setUser() {
      const response = await getUnique('user', 'user');
			logIfNotStatus(response, RESPONSE_STATUS.OK, 'Unexpected response!');
			this.user = response.data.data
    },
  }
}
</script>
