<template>
  <div class="min-h-screen">
    <div class="container px-4 mx-auto justify-between pl-8 font-sans font-thin text-xl">
      <TheMessage :messageProps="messageProps"/>
    </div>
    <div class="container px-4 mx-auto justify-between pl-8 font-sans font-light text-sm">
      <template v-if="formProps.oldName">
        <SiteForm
          :formProps="formProps"
          v-on:on-submit="submitForm"
        />
      </template>
    </div>
  </div>
</template>

<script>
import SiteForm from '@/components/SiteForm.vue';
import TheMessage from '@/components/TheMessage.vue';
import {getObject, logIfNotStatus, putObject} from '@/api';
import {RESPONSE_STATUS} from "@/constants";

export default {
  name: 'SiteUpdateView',
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
  async created() {
    await this.setOldData();
  },
  methods: {
    /**
     * Submit site form
     * @param {Object} form Site form
     */
    async submitForm(form) {
      const formData = {
        name: form.name
      };
			const response = await putObject('site', this.$route.params.id, formData);
			if (response.status === RESPONSE_STATUS.ACCEPTED) {
				this.messageProps.success = true;
				this.messageProps.message = `Site ${response.data.data.name} updated successfully`;
			} else {
				this.messageProps.message = response.data.data.message;
			}
			window.scrollTo({top: 0, behavior: 'smooth'});
    },
    /**
     * Fetch and set site old data
     */
    async setOldData() {
			const response = await getObject('site', this.$route.params.id);
			logIfNotStatus(response, RESPONSE_STATUS.OK, 'Unexpected response!');
			if (response.status === RESPONSE_STATUS.NOT_FOUND) {
				this.$router.push('/404');
			}
			this.formProps.oldName = response.data.data.name
    }
  }
};
</script>
