<template>
  <div class="min-h-screen">
    <div class="container px-4 mx-auto justify-between pl-8 font-sans font-thin text-xl">
      <TheMessage :messageProps="messageProps"/>
    </div>
    <div class="container px-4 mx-auto justify-between pl-8 font-sans font-light text-sm">
      <template v-if="formProps.oldName">
        <RoomForm
          :formProps="formProps"
          v-on:on-submit="submitForm"
        />
      </template>
    </div>
  </div>
</template>

<script>
import RoomForm from '@/components/RoomForm.vue';
import TheMessage from '@/components/TheMessage.vue';
import {getObject, getResponseMessage, logIfNotStatus, putObject} from '@/api';
import {RESPONSE_STATUS} from "@/constants";


export default {
  name: 'RoomUpdateView',
  components: {
    RoomForm,
    TheMessage
  },
  data() {
    return {
      formProps: {
        oldName: '',
        oldBuildingFloor: '',
        oldDescription: '',
        oldNumberOfRackSpaces: null,
        oldArea: null,
        oldResponsible: '',
        oldCoolingSystem: 'Centralized',
        oldFireSuppressionSystem: 'Centralized',
        oldAccessIsOpen: false,
        oldHasRaisedFloor: false
      },
      buildingId: null,
      messageProps: {
        message: '',
        success: false,
      }
    };
  },
  async created() {
    await this.setOldData();
  },
  methods: {
    /**
     * Submit room form
     * @param {Object} form Room form
     */
    async submitForm(form) {
      const formData = {
        name: form.name,
        building_floor: form.buildingFloor,
        description: form.description,
        number_of_rack_spaces: form.numberOfRackSpaces,
        area: form.area,
        responsible: form.responsible,
        cooling_system: form.coolingSystem,
        fire_suppression_system: form.fireSuppressionSystem,
        access_is_open: form.accessIsOpen,
        has_raised_floor: form.hasRaisedFloor
      };
      const response = await putObject('room', this.$route.params.id, formData);
      if (response.status === RESPONSE_STATUS.ACCEPTED) {
        this.messageProps.success = true;
        this.messageProps.message = `Room ${response.data.data.name} updated successfully`;
      } else {
        this.messageProps.success = false;
        this.messageProps.message = getResponseMessage(response);
      }
      window.scrollTo({top: 0, behavior: 'smooth'});
    },
    /**
     * Fetch and set room old data
     */
    async setOldData() {
      const response = await getObject('room', this.$route.params.id);
      logIfNotStatus(response, RESPONSE_STATUS.OK, 'Unexpected response!');
      if (response.status === RESPONSE_STATUS.NOT_FOUND) {
        this.$router.push('/404');
      }
      const room = response.data.data;
      this.formProps.oldName = room.name;
      this.formProps.oldBuildingFloor = room.building_floor;
      this.formProps.oldDescription = room.description;
      this.formProps.oldNumberOfRackSpaces = room.number_of_rack_spaces;
      this.formProps.oldArea = room.area;
      this.formProps.oldResponsible = room.responsible;
      this.formProps.oldCoolingSystem = room.cooling_system;
      this.formProps.oldFireSuppressionSystem = room.fire_suppression_system;
      this.formProps.oldAccessIsOpen = room.access_is_open;
      this.formProps.oldHasRaisedFloor = room.has_raised_floor;
      this.buildingId = room.building_id;
    }
  }
};
</script>
