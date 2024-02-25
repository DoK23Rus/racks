<template>
  <div class="min-h-screen">
    <div class="container px-4 mx-auto  justify-between text-xl pl-8 pt-4 font-sans font-light">
      <div class="container px-4 mx-auto justify-between pl-8 font-sans font-light text-xl">
        <TheMessage :messageProps="messageProps"/>
      </div>
      Building №{{building.id}}
      <router-link
        :to="{path: `/building/${building.id}/update`}"
        target="_blank"
      >
        <button class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small rounded-lg text-xs
          px-5 py-0.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
          Edit
        </button>
      </router-link>
      <button
        class="text-white bg-blue-400 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small rounded-lg text-xs
        px-5 py-0.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
        v-on:click="deleteBuilding(building.id, building.name)"
      >
        Delete
      </button>
      <br>
      <div class="text-xs pb-4 text-slate-500">
        {{location.regionName}} &#9002; {{location.departmentName}} &#9002;
        {{location.siteName}}
      </div>
      <div class="text-base">
        Building name:
        <text class="text-slate-500">
          {{building.name}}
        </text>
        <br>
        Description:
        <text class="text-slate-500">
          {{building.description}}
        </text>
        <br>
        <br>
        <div class="text-xs">
          Updated by:
          <text class="text-slate-500">
            {{building.updatedBy}}
          </text>
          <br>
          Updated at:
          <text class="text-slate-500">
            {{building.updatedAt}}
          </text>
        </div>
        <br>
      </div>
    </div>
  </div>
</template>

<script>
import TheMessage from '@/components/TheMessage.vue';
import {deleteObject, getObject, getObjectLocation, getResponseMessage, logIfNotStatus} from '@/api';
import {RESPONSE_STATUS} from "@/constants";


export default {
  name: 'BuildingView',
  components: {
    TheMessage
  },
  data() {
    return {
      building: {
        id: this.$route.params.id,
        name: '',
        description: '',
        updatedBy: '',
        updatedAt: ''
      },
      messageProps: {
        message: '',
        success: false,
      },
      location: {
        siteName: '',
        departmentName: '',
        regionName: ''
      }
    }
  },
  mounted() {
    this.setBuilding();
    this.setBuildingLocation();
  },
  methods: {
    /**
     * Fetch and set building data
     */
    async setBuilding() {
      const response = await getObject('building', this.$route.params.id);
      logIfNotStatus(response, RESPONSE_STATUS.OK, 'Unexpected response!');
      if (response.status === RESPONSE_STATUS.NOT_FOUND) {
        this.$router.push('/404');
      }
      const building = response.data.data;
      this.building.name = building.name;
      this.building.description = building.description;
      this.building.updatedBy = building.updated_by;
      this.building.updatedAt = building.updated_at;
      this.building.siteId = building.site_id;
    },
    /**
     * Delete building
     * @param {Number} id Building id
     * @param {String} name Building name
     */
    async deleteBuilding(id, name) {
      if (confirm(`Do you really want to delete building ${name} and all related items?`)) {
        const response = await deleteObject('building', this.$route.params.id);
        if (response.status === RESPONSE_STATUS.NO_CONTENT) {
          this.messageProps.success = true;
          this.messageProps.message = `Building ${id} deleted successfully`;
          alert(this.messageProps.message);
          this.$router.push('/tree');
        } else {
          this.messageProps.success = false;
          this.messageProps.message = getResponseMessage(response);
        }
      }
    },
    /**
     * Fetch and set building location
     */
    async setBuildingLocation() {
      const response = await getObjectLocation('building', this.$route.params.id);
      logIfNotStatus(response, RESPONSE_STATUS.OK, 'Unexpected response!');
      const location = response.data.data;
      this.location.siteName = location.site_name;
      this.location.departmentName = location.department_name;
      this.location.regionName = location.region_name;
    },
  }
}
</script>
