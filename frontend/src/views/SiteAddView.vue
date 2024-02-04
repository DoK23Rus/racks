<template>
  <div class="min-h-screen">
    <div class="container px-4 mx-auto justify-between pl-8 font-sans font-thin text-xl">
      <TheMessage :messageProps="messageProps"/>
    </div>
    <div class="container px-4 mx-auto justify-between pl-8 font-sans font-light text-sm">
      <SiteForm
        :formProps="formProps"
        v-on:on-submit="submitForm"
      />
    </div>
  </div>
</template>

<script>
import SiteForm from '@/components/SiteForm.vue';
import TheMessage from '@/components/TheMessage.vue';
import {getResponseMessage, postObject} from '@/api';
import {RESPONSE_STATUS} from "@/constants";


export default {
  name: 'SiteAddView',
  components: {
    SiteForm,
    TheMessage
  },
  data() {
    return {
      formProps: {
        oldName: ''
      },
			messageProps: {
				message: '',
				success: false,
			}
    };
  },
  methods: {
    /**
     * Submit site form
     * @param {Object} form Site form
     */
    async submitForm(form) {
      const formData = {
        name: form.name,
        department_id: this.$route.params.department_id
      };
			const response = await postObject('site', formData);
			if (response.status === RESPONSE_STATUS.CREATED) {
				this.messageProps.success = true;
				this.messageProps.message = `Site ${response.data.data.name} added successfully`;
			} else {
				this.messageProps.success = false;
				this.messageProps.message = getResponseMessage(response);
			}
			window.scrollTo({top: 0, behavior: 'smooth'});
    },
  }
};
</script>
