<template>
  <div class="min-h-screen">
    <div class="container px-4 mx-auto justify-between pl-8 font-sans font-thin text-xl">
      <TheMessage :messageProps="messageProps"/>
    </div>
    <div class="container px-4 mx-auto justify-between pl-8 font-sans font-light text-sm">
      <template v-if="formProps.oldBuildingName">
        <BuildingForm
          :formProps="formProps"
          v-on:on-submit="submitForm"
        />
      </template>
    </div>
  </div>
</template>

<script>
import BuildingForm from '@/components/BuildingForm.vue';
import TheMessage from '@/components/TheMessage.vue';
import {getObject, logIfNotStatus, putObject} from '@/api';
import {RESPONSE_STATUS} from "@/constants";


export default {
  name: 'BuildingUpdateView',
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
				message: '',
				success: false,
			}
		}
	},
  async created() {
    await this.setOldData();
  },
  methods: {
    /**
     * Submit building form
     * @param {Object} form Building form
     */
    async submitForm(form) {
      const formData = {
        name: form.name
      };
        const response = await putObject('building', this.$route.params.id, formData);
        if (response.status === RESPONSE_STATUS.ACCEPTED) {
					this.messageProps.success = true;
					this.messageProps.message = `Building ${response.data.data.name} updated successfully`;
        } else {
					this.messageProps.message = response.data.data.message;
        }
        window.scrollTo({top: 0, behavior: 'smooth'});
    },
    /**
     * Fetch and set building old data
     */
    async setOldData() {
			const response = await getObject('building', this.$route.params.id);
			logIfNotStatus(response, RESPONSE_STATUS.OK, 'Unexpected response!');
			if (response.status === RESPONSE_STATUS.NOT_FOUND) {
				this.$router.push('/404');
			}
			this.formProps.oldName = response.data.data.name
    }
  }
};
</script>
