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
    <label for="buildingFloor">
      Building floor:
    </label>
    <input
      id="e2e_room_floor"
      class="block w-96"
      placeholder="Building floor"
      name="buildingFloor"
      type="text"
      v-model="form.buildingFloor"
    />
    <br>
    <label for="description">
      Description:
    </label>
    <input
      class="block w-96"
      placeholder="Can be used for notes"
      name="description"
      type="text"
      v-model="form.description"
    />
    <br>
    <label for="numberOfRackSpaces">
      Number of rack spaces:
    </label>
    <input
      class="block w-96"
      name="number of rack spaces"
      type="text"
      v-model="form.numberOfRackSpaces"
    />
    <p
      v-for="error of v$.form.numberOfRackSpaces.$errors"
      :key="error.$uid"
    >
      <text class="text-red-500">
        {{numericOrNullValidationError}}
      </text>
    </p>
    <br>
    <label for="area">
      Area (sq. m):
    </label>
    <input
      class="block w-96"
      name="area"
      type="text"
      v-model="form.area"
    />
    <p
      v-for="error of v$.form.area.$errors"
      :key="error.$uid"
    >
      <text class="text-red-500">
        {{numericOrNullValidationError}}
      </text>
    </p>
    <br>
    <label for="responsible">
      Responsible:
    </label>
    <input
      class="block w-96"
      name="responsible"
      type="text"
      v-model="form.responsible"
    />
    <br>
    <label for="coolingSystem">
      Cooling system:
    </label>
    <select
      class="block"
      v-model="form.coolingSystem"
    >
      <option
        value="Centralized"
        selected="selected"
      >
        Centralized
      </option>
      <option value="Individual">
        Individual
      </option>
      <option value="None">
        None
      </option>
    </select>
    <br>
    <label for="fireSuppressionSystem">
      Fire suppression system:
    </label>
    <select
      class="block"
      v-model="form.fireSuppressionSystem"
    >
      <option
        value="Centralized"
        selected="selected"
      >
        Centralized
      </option>
      <option value="Individual">
        Individual
      </option>
      <option value="None">
        None
      </option>
      <option value="Alarm only">
        Alarm only
      </option>
    </select>
    <br>
    <label for="accessIsOpen">
      Access is open:
    </label>
    <input
      class="block"
      name="accessIsOpen"
      type="checkbox"
      v-model="form.accessIsOpen"
    />
    <br>
    <label for="hasRaisedFloor">
      Has raised floor:
    </label>
    <input
      class="block"
      name="hasRaisedFloor"
      type="checkbox"
      v-model="form.hasRaisedFloor"
    />
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
import {numericGTZOrNull} from "@/validators";
import {setEmptyStringToNull} from "@/functions";


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
        name: '',
        buildingFloor: '',
        description: '',
        numberOfRackSpaces: null,
        area: null,
        responsible: '',
        coolingSystem: 'Centralized',
        fireSuppressionSystem: 'Centralized',
        accessIsOpen: false,
        hasRaisedFloor: false
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
        buildingFloor: {required},
        numberOfRackSpaces: {numericGTZOrNull},
        area: {numericGTZOrNull}
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
        this.form.buildingFloor = this.formProps.oldBuildingFloor;
        this.form.description = this.formProps.oldDescription;
        this.form.numberOfRackSpaces = this.formProps.oldNumberOfRackSpaces;
        this.form.area = this.formProps.oldArea;
        this.form.responsible = this.formProps.oldResponsible;
        this.form.coolingSystem = this.formProps.oldCoolingSystem;
        this.form.fireSuppressionSystem = this.formProps.oldFireSuppressionSystem;
        this.form.accessIsOpen = this.formProps.oldAccessIsOpen;
        this.form.hasRaisedFloor = this.formProps.oldHasRaisedFloor;
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
      if (this.v$.$errors.length) {
        confirm("Form not valid, please check the fields");
        window.scrollTo({top: 0, behavior: 'smooth'});
      } else {
        // Yes, this is a crutch, but quite simple and understandable
        const fieldNamesArr = [
          'numberOfRackSpaces',
          'area'
        ];
        this.setEmptyStringToNull(fieldNamesArr, this.form);
        this.$emit('on-submit', this.form);
      }
    },
    setEmptyStringToNull: setEmptyStringToNull
  }
}
</script>
