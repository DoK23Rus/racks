<template>
  <div class="min-h-screen">
    <div class="container px-4 mx-auto justify-between pl-8 font-sans font-thin text-xl">
      <TheMessage :messageProps="messageProps" />
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
import { postObject } from '@/api';
import SiteForm from '@/components/SiteForm.vue';
import TheMessage from '@/components/TheMessage.vue';


export default {
  name: 'SiteAddView',
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
  methods: {
    async submitForm(form) {
      const formData = {
        site_name: form.siteName,
        department_id: this.$route.params.department_id
      };
      this.messageProps.message = await postObject('site', '/site/create/', formData);
      if (this.messageProps.message.site_name == "Site with this Site already exists.") {
        this.messageProps.message = {invalid: "Site with this name already exists."};
      }
    },
  }
};
</script>