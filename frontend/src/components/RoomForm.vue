<template>
	<form v-on:submit.prevent="emitData">
		<br>
		<label for="name">
			Room name:
		</label>
		<input
			id="e2e_room_name"
			class="block w-96"
			placeholder="Enter room name here"
			name="name"
			type="text"
			v-model="form.name"
		/>
		<p
			v-for="error of v$.form.name.$errors"
			:key="error.$uid"
		>
			<text class="text-red-500">
				{{error.$message}}
			</text>
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
import {required} from '@vuelidate/validators';


export default {
  name: 'RoomForm',
  props: {
    formProps: {
      type: Object
    }
  },
  data() {
    return {
      v$: useVuelidate(),
      form: {
        name: ''
      }
    }
  },
  created() {
    this.setRoomFormProps();
  },
  validations() {
    return {
      form: {
        name: {required},
      }
    }
  },
  methods: {
    /**
     * Set room form props
     */
    setRoomFormProps() {
      if (this.formProps.oldName) {
        this.form.name = this.formProps.oldName;
      }
    },
    /**
     * Submit
     */
    submit() {
      this.v$.$touch();
    },
    /**
     * Emit data
     */
    emitData() {
      if (!this.v$.$errors.length) {
        this.$emit('on-submit', this.form);
      }
    },
  }
}
</script>
