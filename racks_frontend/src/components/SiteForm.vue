<template>
    <form v-on:submit.prevent="emitData">
      <br>
        <label for="siteName">
          Site Name:
        </label>
        <input
          id="e2e_site_name"
          class="block w-96" 
          placeholder="Enter site name here" 
          name="siteName" 
          type="text" 
          v-model="form.siteName"
        />
        <p
          v-for="error of v$.form.siteName.$errors"
          :key="error.$uid"
          >
        <div class="text-red-500">
          {{ error.$message }}
        </div>
        </p>
      <br>
        <button 
          class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small rounded-lg text-sm 
          px-7 py-0.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
          type="submit" 
          id="e2e_submit_button" 
          v-on:click="submit"
        >
          Submit data
        </button>
    </form>
</template>

<script>
import useVuelidate from '@vuelidate/core';
import { required } from '@vuelidate/validators';


export default {
  name: 'SiteForm',
  props: {
    formProps: {
      type: Object
    }
  },
  data() {
    return {
      v$: useVuelidate(),
      form: {
        siteName: ''
      }
    }
  },
  created() {
    this.setSiteFormProps();
  },
  validations() {
    return {
      form: {
        siteName: {required},
      }
    }
  },
  methods: {
    setSiteFormProps() {
      if (this.formProps.oldSiteName) {
        this.form.siteName = this.formProps.oldSiteName;
      }
    },
    submit() {
      this.v$.$touch();
    },
    emitData() {
      if (this.v$.$errors.length == 0) {
        this.$emit('on-submit', this.form);
      } else {
        confirm("Form not valid, please check the fields");
        window.scrollTo({top: 0, behavior: 'smooth'});
        return;
      }
    },
  }
}
</script>