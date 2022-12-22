<template>
  <div class="min-h-screen">
    <div class="container px-4 mx-auto justify-between pl-8 font-sans font-thin text-xl">
      <Message :messageProps="messageProps" />
    </div>
    <div class="container px-4 mx-auto justify-between pl-8 font-sans font-light text-sm">
      <RoomForm :formProps="formProps" @on-submit="submitForm" />
    </div>
  </div>
</template>

<script>
import { postObject } from '@/api';
import RoomForm from '@/components/RoomForm.vue';
import Message from '@/components/Message.vue';


export default {
  name: 'RoomAddView',
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
      },
    };
  },
  methods: {
    async submitForm(form) {
      const formData = {
        room_name: form.roomName,
        building_id: this.$route.params.building_id
      };
      this.messageProps.message = await postObject('room', '/room/create', formData);
    },
  }
};
</script>