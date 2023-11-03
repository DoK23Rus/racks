<template>
  <div class="min-h-screen">
    <div class="container px-4 mx-auto justify-between pl-8 font-sans font-thin text-xl">
      <TheMessage :messageProps="messageProps" />
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
import { putObject, getObject } from '@/api';


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
        message: ''
      },
    };
  },
  async created() {
    await this.getOldData();
  },
  methods: {
    /**
     * Submit site form
     * @param {Object} form Site form 
     */
    async submitForm(form) {
      const formData = {
        id: this.$route.params.id,
        name: form.name
      };
      this.messageProps.message = await putObject('site', `/site/${this.$route.params.id}/update/`, formData)
      if (this.messageProps.message.name == "Site with this Site already exists.") {
        this.messageProps.message = {invalid: "Site with this name already exists."};
      }
    },
    /**
     * Fetch and set site old data
     */
    async getOldData() {
      const response = await getObject('site', '/site/', this.$route.params.id);
      this.messageProps.message = response;
      this.formProps.oldName = response.name;
    }
  }
};
</script>