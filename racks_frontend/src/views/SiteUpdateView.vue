<template>
  <div class="min-h-screen">
    <div class="container px-4 mx-auto justify-between pl-8 font-sans font-thin text-xl">
      <TheMessage :messageProps="messageProps" />
    </div>
    <div class="container px-4 mx-auto justify-between pl-8 font-sans font-light text-sm">
      <template v-if="formProps.oldSiteName">
        <SiteForm 
          :formProps="formProps" 
          v-on:on-submit="submitForm" 
        />
      </template>
    </div>
  </div>
</template>

<script>
import { putObject, getObject } from '@/api';
import SiteForm from '@/components/SiteForm.vue';
import TheMessage from '@/components/TheMessage.vue';


export default {
  name: 'SiteUpdateView',
  components: {
    SiteForm,
    TheMessage
  },
  data() {
    return {
      formProps: {
        oldSiteName: ''
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
    async submitForm(form) {
      const formData = {
        id: this.$route.params.id,
        name: form.siteName
      };
      this.messageProps.message = await putObject('site', `/site/${this.$route.params.id}/update/`, formData)
      if (this.messageProps.message.name == "Site with this Site already exists.") {
        this.messageProps.message = {invalid: "Site with this name already exists."};
      }
    },
    async getOldData() {
      // Get site old data
      const response = await getObject('site', '/site/', this.$route.params.id);
      this.messageProps.message = response;
      this.formProps.oldSiteName = response.name;
    }
  }
};
</script>