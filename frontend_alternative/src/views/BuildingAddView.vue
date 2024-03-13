<template>
  <div class="min-h-screen">
    <div class="container px-4 mx-auto justify-between pl-8 font-sans font-thin text-xl">
      <TheMessage :messageProps="messageProps"/>
    </div>
    <div class="container px-4 mx-auto justify-between pl-8 font-sans font-light text-sm">
      <BuildingForm
        :formProps="formProps"
        v-on:on-submit="submitForm"
      />
    </div>
  </div>
</template>

<script>
import BuildingForm from '@/components/BuildingForm.vue';
import TheMessage from '@/components/TheMessage.vue';
import {getResponseMessage, postObject} from '@/api';
import {RESPONSE_STATUS} from "@/constants";


export default {
  name: 'BuildingAddView',
  components: {
    BuildingForm,
    TheMessage
  },
  data() {
    return {
      formProps: {
        oldName: '',
        oldDescription: ''
      },
      messageProps: {
        message: '',
        success: false,
      }
    }
  },
  methods: {
    /**
     * Submit building form
     * @param {Object} form Building form
     */
    async submitForm(form) {
      const formData = {
        name: form.name,
        description: form.description,
        site_id: this.$route.params.site_id
      };
        const response = await postObject('building', formData);
        if (response.status === RESPONSE_STATUS.CREATED) {
          this.messageProps.success = true;
          this.messageProps.message = `Building ${response.data.data.name} added successfully`;
        } else {
          this.messageProps.success = false;
          this.messageProps.message = getResponseMessage(response);
        }
        window.scrollTo({top: 0, behavior: 'smooth'});
    },
  }
};
</script>
