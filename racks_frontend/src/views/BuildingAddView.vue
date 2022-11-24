<template>
  <div class="min-h-screen">
    <div class="container px-4 mx-auto justify-between pl-8 font-sans font-thin text-xl">
      <Message :messageProps="messageProps" />
    </div>
    <div class="container px-4 mx-auto justify-between pl-8 font-sans font-light text-sm">
      <BuildingForm :formProps="formProps" @on-submit="submitForm" />
    </div>
  </div>
</template>

<script>
import { postObject } from '@/api';
import BuildingForm from '@/components/BuildingForm.vue';
import Message from '@/components/Message.vue';


export default {
  name: 'BuildingAddView',
  components: {
    BuildingForm,
    Message
  },
  data() {
    return {
      formProps: {
        oldBuildingName: ''
      },
      messageProps: {
        message: ''
      },
    };
  },
  methods: {
    async submitForm(form) {
      const formData = {
        building_name: form.buildingName,
        site_id: this.$route.params.id
      };
      this.messageProps.message = await postObject('building', '/building_add', formData);
    },
  }
};
</script>