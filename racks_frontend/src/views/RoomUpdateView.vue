<template>
  <div class="min-h-screen">
    <div class="container px-4 mx-auto justify-between pl-8 font-sans font-thin text-xl">
      <TheMessage :messageProps="messageProps" />
    </div>
    <div class="container px-4 mx-auto justify-between pl-8 font-sans font-light text-sm">
      <template v-if="formProps.oldRoomName">
        <RoomForm 
          :formProps="formProps" 
          v-on:on-submit="submitForm" 
        />
      </template>
    </div>
  </div>
</template>

<script>
import { putObject, getObject } from '@/api';
import RoomForm from '@/components/RoomForm.vue';
import TheMessage from '@/components/TheMessage.vue';


export default {
  name: 'RoomUpdateView',
  components: {
    RoomForm,
    TheMessage
  },
  data() {
    return {
      formProps: {
        oldRoomName: ''
      },
      messageProps: {
        message: ''
      }
    };
  },
  async created() {
    await this.getOldData();
  },
  methods: {
    async submitForm(form) {
      const formData = {
        id: this.$route.params.id,
        room_name: form.roomName
      };
      this.messageProps.message = await putObject('room', `/room/${this.$route.params.id}/update/`, formData);
    },
    async getOldData() {
      // Get room old data
      const response = await getObject('room', '/room/', this.$route.params.id);
      this.messageProps.message = response;
      this.formProps.oldRoomName = response.room_name;
    }
  }
};
</script>