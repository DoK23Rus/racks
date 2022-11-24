<template>
  <div class="min-h-screen">
    <div class="container px-4 mx-auto justify-between pl-8 font-sans font-thin text-xl">
      <Message :messageProps="messageProps" />
    </div>
    <div class="container px-4 mx-auto justify-between pl-8 font-sans font-light text-sm">
      <template v-if="formProps.oldRoomName">
        <RoomForm :formProps="formProps" @on-submit="submitForm" />
      </template>
    </div>
  </div>
</template>

<script>
import { putObject, getObject } from '@/api';
import RoomForm from '@/components/RoomForm.vue';
import Message from '@/components/Message.vue';


export default {
  name: 'RoomUpdateView',
  components: {
    RoomForm,
    Message
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
      this.messageProps.message = await putObject('room', '/room_upd', formData);
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