<template>
  <div class="min-h-screen">
    <div class="container px-4 mx-auto justify-between pl-8 font-sans font-thin text-xl">
      <TheMessage :messageProps="messageProps" />
    </div>
    <div class="container px-4 mx-auto justify-between pl-8 font-sans font-light text-sm">
      <RoomForm
        :formProps="formProps" 
        v-on:on-submit="submitForm" 
      />
    </div>
  </div>
</template>

<script>
import { postObject } from '@/api';
import RoomForm from '@/components/RoomForm.vue';
import TheMessage from '@/components/TheMessage.vue';


export default {
  name: 'RoomAddView',
  components: {
    RoomForm,
    TheMessage
  },
  data() {
    return {
      formProps: {
        oldName: ''
      },
      messageProps: {
        message: ''
      },
    };
  },
  methods: {
    async submitForm(form) {
      const formData = {
        name: form.name,
        building_id: this.$route.params.building_id
      };
      this.messageProps.message = await postObject('room', '/room/create/', formData);
    },
  }
};
</script>