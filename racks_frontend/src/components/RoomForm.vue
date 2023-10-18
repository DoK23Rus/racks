<template>
    <form v-on:submit.prevent="emitData">
      <br>
        <label for="roomName">
          Room Name:
        </label>
        <input
          id="e2e_room_name"
          class="block w-96"
          placeholder="Enter room name here" 
          name="roomName" 
          type="text" 
          v-model="form.roomName"
        />
        <p
          v-for="error of v$.form.roomName.$errors"
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
        roomName: ''
      }
    }
  },
  created() {
    this.setRoomFormProps();
  },
  validations() {
    return {
      form: {
        roomName: {required},
      }
    }
  },
  methods: {
    setRoomFormProps() {
      if (this.formProps.oldRoomName) {
        this.form.roomName = this.formProps.oldRoomName;
      }
    },
    submit() {
      this.v$.$touch();
    },
    emitData() {
      if (this.v$.$errors.length == 0) {
        this.$emit('on-submit', this.form);
      }
    },
  }
}
</script>