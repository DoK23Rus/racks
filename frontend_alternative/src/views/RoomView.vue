<template>
  <div class="min-h-screen">
    <div class="container px-4 mx-auto  justify-between text-xl pl-8 pt-4 font-sans font-light">
      <div class="container px-4 mx-auto justify-between pl-8 font-sans font-light text-xl">
        <TheMessage :messageProps="messageProps"/>
      </div>
      Room №{{room.id}}
      <router-link
        :to="{path: `/room/${room.id}/update`}"
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
        v-on:click="deleteRoom(room.id, room.name)"
      >
        Delete
      </button>
      <br>
      <div class="text-xs pb-4 text-slate-500">
        {{location.regionName}} &#9002; {{location.departmentName}} &#9002;
        {{location.siteName}} &#9002; {{location.buildingName}}
      </div>
      <div class="text-base">
        Room name:
        <text class="text-slate-500">
          {{room.name}}
        </text>
        <br>
        Building floor:
        <text class="text-slate-500">
          {{room.buildingFloor}}
        </text>
        <br>
        Description:
        <text class="text-slate-500">
          {{room.description}}
        </text>
        <br>
        Number of rack spaces:
        <text class="text-slate-500">
          {{room.numberOfRackSpaces}}
        </text>
        <br>
        Area (sq. m):
        <text class="text-slate-500">
          {{room.area}}
        </text>
        <br>
        Responsible:
        <text class="text-slate-500">
          {{room.responsible}}
        </text>
        <br>
        Cooling system:
        <text class="text-slate-500">
          {{room.coolingSystem}}
        </text>
        <br>
        Fire suppression system:
        <text class="text-slate-500">
          {{room.fireSuppressionSystem}}
        </text>
        <br>
        <template v-if="room.accessIsOpen">
          Active ventilation:
          <text class="text-slate-500">
            Yes
          </text>
        </template>
        <template v-else>
          Active ventilation:
          <text class="text-slate-500">
            No
          </text>
        </template>
        <br>
        <template v-if="room.hasRaisedFloor">
          Active ventilation:
          <text class="text-slate-500">
            Yes
          </text>
        </template>
        <template v-else>
          Active ventilation:
          <text class="text-slate-500">
            No
          </text>
        </template>
        <br>
        <br>
        <div class="text-xs">
          Updated by:
          <text class="text-slate-500">
            {{room.updatedBy}}
          </text>
          <br>
          Updated at:
          <text class="text-slate-500">
            {{room.updatedAt}}
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
  name: 'RoomView',
  components: {
    TheMessage
  },
  data() {
    return {
      room: {
        id: this.$route.params.id,
        name: '',
        buildingFloor: '',
        description: '',
        numberOfRackSpaces: null,
        area: null,
        responsible: '',
        coolingSystem: 'Centralized',
        fireSuppressionSystem: 'Centralized',
        accessIsOpen: false,
        hasRaisedFloor: false,
        updatedBy: '',
        updatedAt: ''
      },
      messageProps: {
        message: '',
        success: false,
      },
      location: {
        buildingName: '',
        siteName: '',
        departmentName: '',
        regionName: ''
      }
    }
  },
  mounted() {
    this.setRoom();
    this.setRoomLocation();
  },
  methods: {
    /**
     * Fetch and set room data
     */
    async setRoom() {
      const response = await getObject('room', this.$route.params.id);
      logIfNotStatus(response, RESPONSE_STATUS.OK, 'Unexpected response!');
      if (response.status === RESPONSE_STATUS.NOT_FOUND) {
        this.$router.push('/404');
      }
      const room = response.data.data;
      this.room.name = room.name;
      this.room.buildingFloor = room.building_floor;
      this.room.description = room.description;
      this.room.numberOfRackSpaces = room.number_of_rack_spaces;
      this.room.area = room.area;
      this.room.responsible = room.responsible;
      this.room.coolingSystem = room.cooling_system;
      this.room.fireSuppressionSystem = room.fire_suppression_system;
      this.room.accessIsOpen = room.access_is_open;
      this.room.hasRaisedFloor = room.has_raised_floor;
      this.room.updatedBy = room.updated_by;
      this.room.updatedAt = room.updated_at;
      this.room.buildingId = room.building_id;
    },
    /**
     * Delete room
     * @param {Number} id Room id
     * @param {String} name Room name
     */
    async deleteRoom(id, name) {
      if (confirm(`Do you really want to delete room ${name} and all related items?`)) {
        const response = await deleteObject('room', this.$route.params.id);
        if (response.status === RESPONSE_STATUS.NO_CONTENT) {
          this.messageProps.success = true;
          this.messageProps.message = `Room ${id} deleted successfully`;
          alert(this.messageProps.message);
          this.$router.push('/tree');
        } else {
          this.messageProps.success = false;
          this.messageProps.message = getResponseMessage(response);
        }
      }
    },
    /**
     * Fetch and set room location
     */
    async setRoomLocation() {
      const response = await getObjectLocation('room', this.$route.params.id);
      logIfNotStatus(response, RESPONSE_STATUS.OK, 'Unexpected response!');
      const location = response.data.data;
      this.location.buildingName = location.building_name;
      this.location.siteName = location.site_name;
      this.location.departmentName = location.department_name;
      this.location.regionName = location.region_name;
    },
  }
}
</script>
