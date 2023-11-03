<template>
  <div class="min-h-screen">
    <div class="container px-4 mx-auto justify-between pl-8 font-sans font-thin text-xl">
      <TheMessage :messageProps="messageProps" />
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
import { postObject } from '@/api';


export default {
  name: 'BuildingAddView',
  components: {
    BuildingForm,
    TheMessage
  },
  data() {
		return {
			formProps: {
        oldName: ''
      },
			messageProps: {
        message: ''
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
        site_id: this.$route.params.site_id
      };
      this.messageProps.message = await postObject('building', '/building/create/', formData);
    },
  }
};
</script>