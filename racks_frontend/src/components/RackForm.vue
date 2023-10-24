<template>
  <form v-on:submit.prevent="emitData">
    <br>
      <label for="rackName">
        Rack Name: 
      </label>
      <input
        id="e2e_rack_name" 
        class="block w-96" 
        placeholder="Enter rack name here" 
        name="rackName" 
        type="text" 
        v-model="form.rackName"
      />
      <p
        v-for="error of v$.form.rackName.$errors"
        :key="error.$uid"
      >
      <div class="text-red-500">
        {{ error.$message }}
      </div>
      </p>
    <br>
      <template v-if="!form.update">
        <label for="rackAmount">
          Rack amount (units): 
        </label>
        <input
          id="e2e_rack_amount" 
          class="block w-96" 
          placeholder="Filled in once (cannot be changed later)" 
          name="rackAmount" 
          type="text" 
          v-model="form.rackAmount"
        />
        <p
          v-for="error of v$.form.rackAmount.$errors"
          :key="error.$uid"
        >
        <div class="text-red-500">
          {{ error.$message }}
        </div>
        </p>
      </template>
    <br>
      <template v-if="rackModels.item_type">
        <ChooseExistingItem
          :itemsData="rackModels"
          :isHidden="modelsIsHidden"
          v-model:modelValue="form.rackModel"
        />
      </template>
      <template v-else>
        <br>
        Please wait...
        <br>
      </template>
    <br>
      <template v-if="rackVendors.item_type">
        <ChooseExistingItem
          :itemsData="rackVendors"
          :isHidden="modelsIsHidden"
          v-model:modelValue="form.rackVendor"
        />
      </template>
      <template v-else>
        <br>
        Please wait...
        <br>
      </template>  
    <br>
      <label for="rackDescription">
        Description: 
      </label>
      <input 
        class="block w-96" 
        placeholder="Can be used for notes" 
        name="rackDescription" 
        type="text" 
        v-model="form.rackDescription"
      />
    <br>
      <label for="numberingFromBottomToTop">
        Numbering from bottom to top: 
      </label>
      <input 
        class="block" 
        name="rackModel" 
        type="checkbox" 
        v-model="form.numberingFromBottomToTop"
      />
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
      <label for="rackFinanciallyResponsiblePerson">
        Financially responsible: 
      </label>
      <input 
        class="block w-96" 
        name="rackFinanciallyResponsiblePerson" 
        type="text" 
        v-model="form.rackFinanciallyResponsiblePerson"
      />
    <br>
      <label for="rackInventoryNumber">
        Inventory number: 
      </label>
      <input 
        class="block w-96" 
        name="rackInventoryNumber" 
        type="text" 
        v-model="form.rackInventoryNumber"
      />
    <br>
      <label for="fixedAsset">
        Fixed asset: 
      </label>
      <input 
        class="block w-96" 
        name="fixedAsset" 
        type="text" 
        v-model="form.fixedAsset"
      />
    <br>
      <label for="link">
        Link to docs: 
      </label>
      <input 
        class="block w-96" 
        placeholder="Link to some documentation" 
        name="link" 
        type="text" 
        v-model="form.link"
      />
    <br>
      <label for="row">
        Row: 
      </label>
      <input 
        class="block w-96" 
        name="row" 
        type="text" 
        v-model="form.row"
      />
    <br>
      <label for="place">
        Place: 
      </label>
      <input 
        class="block w-96" 
        name="place" 
        type="text" 
        v-model="form.place"
      />
    <br>
      <label for="rackHeight">
        Rack height (mm): 
      </label>
      <input 
        class="block w-96" 
        name="rackHeight" 
        type="text" 
        v-model="form.rackHeight"
      />
      <p
        v-for="error of v$.form.rackHeight.$errors"
        :key="error.$uid"
      >
      <div class="text-red-500">
        {{ numericOrNullValidationError }}
      </div>
      </p>
    <br>
      <label for="rackWidth">
        Rack width (mm): 
      </label>
      <input 
        class="block w-96" 
        name="rackWidth" 
        type="text" 
        v-model="form.rackWidth"
      />
      <p
        v-for="error of v$.form.rackWidth.$errors"
        :key="error.$uid"
      >
      <div class="text-red-500">
        {{ numericOrNullValidationError }}
      </div>
      </p>
    <br>
      <label for="rackDepth">
        Rack depth (mm): 
      </label>
      <input 
        class="block w-96" 
        name="rackDepth" 
        type="text" 
        v-model="form.rackDepth"
      />
      <p
        v-for="error of v$.form.rackDepth.$errors"
        :key="error.$uid"
      >
      <div class="text-red-500">
        {{ numericOrNullValidationError }}
      </div>
      </p>
    <br>
      <label for="rackUnitWidth">
        Useful rack width (inches): 
      </label>
      <input
        class="block w-96" 
        placeholder="Frame width" 
        name="rackUnitWidth" 
        type="text" 
        v-model="form.rackUnitWidth"
      />
      <p
        v-for="error of v$.form.rackUnitWidth.$errors"
        :key="error.$uid"
      >
      <div class="text-red-500">
        {{ numericOrNullValidationError }}
      </div>
      </p>
    <br>
      <label for="rackUnitDepth">
        Useful rack depth (mm): 
      </label>
      <input 
        class="block w-96"
        placeholder="Depth from frame to frame" 
        name="rackUnitDepth" 
        type="text" 
        v-model="form.rackUnitDepth"
      />
      <p
        v-for="error of v$.form.rackUnitDepth.$errors"
        :key="error.$uid"
      >
      <div class="text-red-500">
        {{ numericOrNullValidationError }}
      </div>
      </p>
    <br>
      <label for="rackType">
        Execution variant: 
      </label>
      <select 
        class="block" 
        v-model="form.rackType"
      >
        <option 
          value="Rack" 
          selected="selected"
        >
          Rack
        </option>
        <option value="Protective cabinet">
          Protective cabinet
        </option>
      </select>
    <br>
      <label for="rackFrame">
        Construction: 
      </label>
      <select 
        class="block" 
        v-model="form.rackFrame"
      >
        <option
          value="Double frame"
          selected="selected"
        >
          Double frame
        </option>
        <option value="Single frame">
          Single frame
        </option>
      </select>
    <br>
      <label for="rackPalceType">
        Location type: 
      </label>
      <select 
        class="block" 
        v-model="form.rackPalceType"
      >
        <option 
          value="Floor standing" 
          selected="selected"
        >
          Floor standing
        </option>
        <option value="Wall mounted">
          Wall mounted
        </option>
      </select>
    <br>
      <label for="maxLoad">
        Max load (kilo): 
      </label>
      <input
        class="block w-96" 
        name="maxLoad" 
        type="text" 
        v-model="form.maxLoad"
      />
      <p
        v-for="error of v$.form.maxLoad.$errors"
        :key="error.$uid"
      >
      <div class="text-red-500">
        {{ numericOrNullValidationError }}
      </div>
      </p>
    <br>
      <label for="powerSockets">
        Free power sockets: 
      </label>
      <input
        class="block w-96"
        name="powerSockets"
        type="text"
        v-model="form.powerSockets"
      />
      <p
        v-for="error of v$.form.powerSockets.$errors"
        :key="error.$uid"
      >
      <div class="text-red-500">
        {{ numericOrNullValidationError }}
      </div>
      </p>
    <br>
      <label for="powerSocketsUps">
        Free UPS power sockets: 
      </label>
      <input 
        class="block w-96" 
        name="powerSocketsUps" 
        type="text" 
        v-model="form.powerSocketsUps"
      />
      <p
        v-for="error of v$.form.powerSocketsUps.$errors"
        :key="error.$uid"
      >
      <div class="text-red-500">
        {{ numericOrNullValidationError }}</div>
      </p>
    <br>
      <label for="externalUps">
        External power backup supply system: 
      </label>
      <input 
        class="block" 
        name="externalUps" 
        type="checkbox" 
        v-model="form.externalUps"
      />
    <br>
      <label for="cooler">
        Active ventilation: 
      </label>
      <input 
        class="block" 
        name="cooler" 
        type="checkbox" 
        v-model="form.cooler"
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
import ChooseExistingItem from './ChooseExistingItem.vue';
import { required, numeric, minValue } from '@vuelidate/validators';
import { getUnique } from '@/api';
import { numericGTZOrNull, numericOrNull } from '@/validators';
import { setEmptyStringToNull } from '@/functions';

export default {
  name: 'RackForm',
  components: {
    ChooseExistingItem
  },
  props: {
    formProps: {
      type: Object
    }
  },
  data() {
    return {
      v$: useVuelidate(),
      vendorsIsHidden: true,
      modelsIsHidden: true,
      rackVendors: {},
      rackModels: {},
      form: {
        rackName: '',
        rackAmount: null,
        rackVendor: '',
        rackModel: '',
        rackDescription: '',
        numberingFromBottomToTop: true,
        responsible: '',
        rackFinanciallyResponsiblePerson: '',
        rackInventoryNumber: '',
        fixedAsset: '',
        link: '',
        row: '',
        place: '',
        rackHeight: null,
        rackWidth: null,
        rackDepth: null,
        rackUnitWidth: null,
        rackUnitDepth: null,
        rackType: 'Rack',
        rackFrame: 'Double frame',
        rackPalceType: 'Floor standing',
        maxLoad: null,
        powerSockets: null,
        powerSocketsUps: null,
        externalUps: false,
        cooler: false,
        update: false
      },
      numericOrNullValidationError: 'Value must be an integer and greater than zero',
      selectedModel: '',
      searchTerm: ''
    };
  },
  created() {
    this.getRackVendors();
    this.getRackModels();
    this.setRackFormProps();
    
  },
  validations() {
    return {
      form: {
        rackName: {required},
        rackAmount: {required, numeric, minValue: minValue(1)},
        rackHeight: {numericGTZOrNull},
        rackWidth: {numericGTZOrNull},
        rackDepth: {numericGTZOrNull},
        rackUnitWidth: {numericGTZOrNull},
        rackUnitDepth: {numericGTZOrNull},
        maxLoad: {numericGTZOrNull},
        powerSockets: {numericOrNull},
        powerSocketsUps: {numericOrNull}
      }
    }
  },
  methods: {
    submit() {
      this.v$.$touch();
    },
    async getRackVendors() {
      this.rackVendors = await getUnique('rack vendors', '/rack/vendors');
    },
    async getRackModels() {
      this.rackModels = await getUnique('rack models', '/rack/models');
    },
    setRackFormProps() {
      if (this.formProps.oldRackName) { 
        this.form.rackName = this.formProps.oldRackName;
        this.form.rackAmount = this.formProps.oldRackAmount;
        this.form.rackVendor = this.formProps.oldRackVendor;
        this.form.rackModel = this.formProps.oldRackModel;
        this.form.rackDescription = this.formProps.oldRackDescription;
        this.form.numberingFromBottomToTop =this.formProps.oldNumberingFromBottomToTop;
        this.form.responsible = this.formProps.oldResponsible;
        this.form.rackFinanciallyResponsiblePerson = this.formProps.oldRackFinanciallyResponsiblePerson;
        this.form.rackInventoryNumber = this.formProps.oldRackInventoryNumber;
        this.form.fixedAsset = this.formProps.oldFixedAsset;
        this.form.link = this.formProps.oldLink;
        this.form.row = this.formProps.oldRow;
        this.form.place = this.formProps.oldPlace;
        this.form.rackHeight = this.formProps.oldRackHeight;
        this.form.rackWidth = this.formProps.oldRackWidth;
        this.form.rackDepth = this.formProps.oldRackDepth;
        this.form.rackUnitWidth = this.formProps.oldRackUnitWidth;
        this.form.rackUnitDepth = this.formProps.oldRackUnitDepth;
        this.form.rackType = this.formProps.oldRackType;
        this.form.rackFrame = this.formProps.oldRackFrame;
        this.form.rackPalceType = this.formProps.oldRackPalceType;
        this.form.maxLoad = this.formProps.oldMaxLoad;
        this.form.powerSockets = this.formProps.oldPowerSockets;
        this.form.powerSocketsUps = this.formProps.oldPowerSocketsUps;
        this.form.externalUps = this.formProps.oldExternalUps;
        this.form.cooler = this.formProps.oldCooler;
        this.form.update = this.formProps.update;
      }
    },
    emitData() {
      if (this.v$.$errors.length == 0) {
        // Yes, this is a crutch, but quite simple and understandable
        const fieldNamesArr = [
          'rackHeight',
          'rackWidth',
          'rackDepth',
          'rackUnitWidth',
          'rackUnitDepth',
          'maxLoad',
          'powerSockets',
          'powerSocketsUps'
        ]
        this.setEmptyStringToNull(fieldNamesArr, this.form);
        this.$emit('on-submit', this.form);
      } else {
        confirm("Form not valid, please check the fields");
        window.scrollTo({top: 0, behavior: 'smooth'});
        return;
      }
    },
    setEmptyStringToNull: setEmptyStringToNull
  }
}
</script>