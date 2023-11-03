<template>
  <div class="min-h-screen">
    <div class="container px-4 mx-auto justify-between pl-8 font-sans font-thin text-xl">
      <TheMessage :messageProps="messageProps" />
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
import { putObject, getObject } from '@/api';


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
        message: ''
      }
		}
	},
  async created() {
    await this.getOldData();
  },
  methods: {
    /**
     * Submit building form
     * @param {Object} form Building form
     */
    async submitForm(form) {
      const formData = {
        id: this.$route.params.id,
        name: form.name
      };
      this.messageProps.message = await putObject('building', `/building/${this.$route.params.id}/update/`, formData);
    },
    /**
     * Fetch and set building old data
     */
    async getOldData() {
      const response = await getObject('building', '/building/', this.$route.params.id);
      this.messageProps.message = response;
      this.formProps.oldName = response.name;
    }
  }
};
</script>