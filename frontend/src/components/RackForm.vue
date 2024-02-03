<template>
  <form v-on:submit.prevent="emitData">
    <br>
      <label for="name">
        Rack name:
      </label>
      <input
        id="e2e_rack_name"
        class="block w-96"
        placeholder="Enter rack name here"
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
      <template v-if="!form.update">
        <label for="amount">
          Rack amount (units):
        </label>
        <input
          id="e2e_rack_amount"
          class="block w-96"
          placeholder="Filled in once (cannot be changed later)"
          name="amount"
          type="text"
          v-model="form.amount"
        />
        <p
          v-for="error of v$.form.amount.$errors"
          :key="error.$uid"
        >
        	<text class="text-red-500">
          	{{error.$message}}
        	</text>
        </p>
      </template>
    <br>
      <template v-if="models.item_type">
        <ChooseExistingItem
          :itemsData="models"
          :isHidden="modelsIsHidden"
          v-model:modelValue="form.model"
        />
      </template>
      <template v-else>
        <br>
        Please wait...
        <br>
      </template>
    <br>
      <template v-if="vendors.item_type">
        <ChooseExistingItem
          :itemsData="vendors"
          :isHidden="vendorsIsHidden"
          v-model:modelValue="form.vendor"
        />
      </template>
      <template v-else>
        <br>
        Please wait...
        <br>
      </template>
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
      <label for="hasNumberingFromBottomToTop">
        Numbering from bottom to top:
      </label>
      <input
        class="block"
        name="hasNumberingFromBottomToTop"
        type="checkbox"
        v-model="form.hasNumberingFromTopToBottom"
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
      <label for="financiallyResponsiblePerson">
        Financially responsible:
      </label>
      <input
        class="block w-96"
        name="financiallyResponsiblePerson"
        type="text"
        v-model="form.financiallyResponsiblePerson"
      />
    <br>
      <label for="inventoryNumber">
        Inventory number:
      </label>
      <input
        class="block w-96"
        name="inventoryNumber"
        type="text"
        v-model="form.inventoryNumber"
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
        v-model="form.linkToDocs"
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
      <label for="height">
        Rack height (mm):
      </label>
      <input
        class="block w-96"
        name="height"
        type="text"
        v-model="form.height"
      />
      <p
        v-for="error of v$.form.height.$errors"
        :key="error.$uid"
      >
      	<text class="text-red-500">
        	{{numericOrNullValidationError}}
      	</text>
      </p>
    <br>
      <label for="width">
        Rack width (mm):
      </label>
      <input
        class="block w-96"
        name="width"
        type="text"
        v-model="form.width"
      />
      <p
        v-for="error of v$.form.width.$errors"
        :key="error.$uid"
      >
      	<text class="text-red-500">
        	{{numericOrNullValidationError}}
      	</text>
      </p>
    <br>
      <label for="depth">
        Rack depth (mm):
      </label>
      <input
        class="block w-96"
        name="depth"
        type="text"
        v-model="form.depth"
      />
      <p
        v-for="error of v$.form.depth.$errors"
        :key="error.$uid"
      >
      	<text class="text-red-500">
        	{{numericOrNullValidationError}}
      	</text>
      </p>
    <br>
      <label for="unitWidth">
        Useful rack width (inches):
      </label>
      <input
        class="block w-96"
        placeholder="Frame width"
        name="unitWidth"
        type="text"
        v-model="form.unitWidth"
      />
      <p
        v-for="error of v$.form.unitWidth.$errors"
        :key="error.$uid"
      >
      	<text class="text-red-500">
        	{{numericOrNullValidationError}}
      	</text>
      </p>
    <br>
      <label for="unitDepth">
        Useful rack depth (mm):
      </label>
      <input
        class="block w-96"
        placeholder="Depth from frame to frame"
        name="unitDepth"
        type="text"
        v-model="form.unitDepth"
      />
      <p
        v-for="error of v$.form.unitDepth.$errors"
        :key="error.$uid"
      >
      	<text class="text-red-500">
        	{{numericOrNullValidationError}}
      	</text>
      </p>
    <br>
      <label for="type">
        Execution variant:
      </label>
      <select
        class="block"
        v-model="form.type"
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
      <label for="frame">
        Construction:
      </label>
      <select
        class="block"
        v-model="form.frame"
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
      <label for="placeType">
        Location type:
      </label>
      <select
        class="block"
        v-model="form.placeType"
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
      	<text class="text-red-500">
        	{{numericOrNullValidationError}}
      	</text>
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
      	<text class="text-red-500">
        	{{numericOrNullValidationError}}
      	</text>
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
      	<text class="text-red-500">
        	{{numericOrNullValidationError}}
      	</text>
      </p>
    <br>
      <label for="hasExternalUps">
        External power backup supply system:
      </label>
      <input
        class="block"
        name="hasExternalUps"
        type="checkbox"
        v-model="form.hasExternalUps"
      />
    <br>
      <label for="hasCooler">
        Active ventilation:
      </label>
      <input
        class="block"
        name="hasCooler"
        type="checkbox"
        v-model="form.hasCooler"
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
import ChooseExistingItem from './ChooseExistingItem.vue';
import useVuelidate from '@vuelidate/core';
import {minValue, numeric, required} from '@vuelidate/validators';
import {getUnique, logIfNotStatus} from '@/api';
import {numericGTZOrNull, numericOrNull} from '@/validators';
import {setEmptyStringToNull} from '@/functions';
import {RESPONSE_STATUS} from "@/constants";

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
      vendors: {},
      models: {},
      form: {
        name: '',
        amount: null,
        vendor: '',
        model: '',
        description: '',
        hasNumberingFromTopToBottom: false,
        responsible: '',
        financiallyResponsiblePerson: '',
        inventoryNumber: '',
        fixedAsset: '',
        linkToDocs: '',
        row: '',
        place: '',
        height: null,
        width: null,
        depth: null,
        unitWidth: null,
        unitDepth: null,
        type: 'Rack',
        frame: 'Double frame',
        placeType: 'Floor standing',
        maxLoad: null,
        powerSockets: null,
        powerSocketsUps: null,
        hasExternalUps: false,
        hasCooler: false,
        update: false
      },
      numericOrNullValidationError: 'Value must be an integer and greater than zero',
    };
  },
  created() {
    this.setRackVendors();
    this.setRackModels();
    this.setRackFormProps();

  },
  validations() {
    return {
      form: {
        name: {required},
        amount: {required, numeric, minValue: minValue(1)},
        height: {numericGTZOrNull},
        width: {numericGTZOrNull},
        depth: {numericGTZOrNull},
        unitWidth: {numericGTZOrNull},
        unitDepth: {numericGTZOrNull},
        maxLoad: {numericGTZOrNull},
        powerSockets: {numericOrNull},
        powerSocketsUps: {numericOrNull}
      }
    }
  },
  methods: {
    /**
     * Submit
     */
    submit() {
      this.v$.$touch();
    },
    /**
     * Fetch and set rack vendors
     */
    async setRackVendors() {
      const response = await getUnique('rack vendors', 'rack/vendors');
			logIfNotStatus(response, RESPONSE_STATUS.OK, 'Unexpected response!');
			this.vendors = response.data.data
    },
    /**
     * Fetch and set rack models
     */
    async setRackModels() {
			const response = await getUnique('rack models', 'rack/models');
			logIfNotStatus(response, RESPONSE_STATUS.OK, 'Unexpected response!');
			this.models = response.data.data
    },
    /**
     * Set rack form props
     */
    setRackFormProps() {
      if (this.formProps.oldName) {
        this.form.name = this.formProps.oldName;
        this.form.amount = this.formProps.oldAmount;
        this.form.vendor = this.formProps.oldVendor;
        this.form.model = this.formProps.oldModel;
        this.form.description = this.formProps.oldDescription;
        this.form.hasNumberingFromTopToBottom =this.formProps.oldHasNumberingFromTopToBottom;
        this.form.responsible = this.formProps.oldResponsible;
        this.form.financiallyResponsiblePerson = this.formProps.oldFinanciallyResponsiblePerson;
        this.form.inventoryNumber = this.formProps.oldInventoryNumber;
        this.form.fixedAsset = this.formProps.oldFixedAsset;
        this.form.linkToDocs = this.formProps.oldLinkToDocs;
        this.form.row = this.formProps.oldRow;
        this.form.place = this.formProps.oldPlace;
        this.form.height = this.formProps.oldHeight;
        this.form.width = this.formProps.oldWidth;
        this.form.depth = this.formProps.oldDepth;
        this.form.unitWidth = this.formProps.oldUnitWidth;
        this.form.unitDepth = this.formProps.oldUnitDepth;
        this.form.type = this.formProps.oldType;
        this.form.frame = this.formProps.oldFrame;
        this.form.placeType = this.formProps.oldPlaceType;
        this.form.maxLoad = this.formProps.oldMaxLoad;
        this.form.powerSockets = this.formProps.oldPowerSockets;
        this.form.powerSocketsUps = this.formProps.oldPowerSocketsUps;
        this.form.hasExternalUps = this.formProps.oldHasExternalUps;
        this.form.hasCooler = this.formProps.oldHasCooler;
        this.form.update = this.formProps.update;
      }
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
					'height',
					'width',
					'depth',
					'unitWidth',
					'unitDepth',
					'maxLoad',
					'powerSockets',
					'powerSocketsUps'
				];
				this.setEmptyStringToNull(fieldNamesArr, this.form);
				this.$emit('on-submit', this.form);
      }
    },
    setEmptyStringToNull: setEmptyStringToNull
  }
}
</script>
