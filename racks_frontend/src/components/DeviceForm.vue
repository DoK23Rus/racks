<template>
  <form v-on:submit.prevent="emitData">
    <br>
      <label for="firstUnit">
        First unit: 
      </label>
      <input 
        id="e2e_first_unit"
        class="block w-96"
        placeholder="Order doesn't matter"
        name="firstUnit"
        type="text"
        v-model="form.firstUnit"
      />
      <p
        v-for="error of v$.form.firstUnit.$errors"
        :key="error.$uid"
      >
      <div class="text-red-500">
        {{ error.$message }}
      </div>
      </p>
    <br>
      <label for="lastUnit">Last unit: </label>
      <input 
        id="e2e_last_unit"
        class="block w-96"
        placeholder="Order doesn't matter"
        name="lastUnit"
        type="text"
        v-model="form.lastUnit"
      />
      <p
        v-for="error of v$.form.lastUnit.$errors"
        :key="error.$uid"
      >
        {{ error.$message }}
      </p>
    <br>
      <label for="frontsideLocation">
        Installed on the front: 
      </label>
      <input
        class="block"
        name="frontsideLocation"
        type="checkbox"
        v-model="form.frontsideLocation"
      />    
    <br>
      <label for="status">
        Status: 
      </label>
      <select
        class="block"
        v-model="form.status"
      >
        <option 
          value="Device active"
          selected="selected"
        >
          Device active
        </option>
        <option value="Device failed">
          Device failed
        </option>
        <option value="Device turned off">
          Device turned off
        </option>
        <option value="Device not in use">
          Device not in use
        </option>
        <option value="Units reserved">
          Units reserved
        </option>
        <option value="Units not available">
          Units not available
        </option>
      </select>
    <br>
      <label for="status">
        Device type: 
      </label>
      <select 
        class="block"
        v-model="form.type"
      >
        <option
          value="Other"
          selected="selected"
        >
          Other
        </option>
        <option value="Switch">
          Switch
        </option>
        <option value="Router">
          Router
        </option>
        <option value="Firewall">
          Firewall
        </option>
        <option value="Security Gateway">
          Security Gateway
        </option>
        <option value="Fiber optic patch panel">
          Fiber optic patch panel
        </option>
        <option value="RJ45 patch panel">
          RJ45 patch panel
        </option>
        <option value="Organizer">
          Organizer
        </option>
        <option value="Rack shelf">
          Rack shelf
        </option>
        <option value="UPS">
          UPS
        </option>
        <option value="Server">
          Server
        </option>
        <option value="KVM console">
          KVM console
        </option>
      </select>
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
      <label for="hostname">
        Hostname: 
      </label>
      <input
        class="block w-96"
        name="hostname"
        type="text" v-model="form.hostname"
      />
    <br>
      <label for="ip">
        IP-address: 
      </label>
      <input 
        class="block w-96" 
        name="ip" 
        type="text" 
        v-model="form.ip"
      />
      <p
        v-for="error of v$.form.ip.$errors"
        :key="error.$uid"
      >
        {{ error.$message }}
      </p>
    <br>
      <label for="stack">
        Stack/Reserve (reserve ID): 
      </label>
      <input 
        class="block w-96" 
        name="stack" 
        type="text" 
        v-model="form.stack"
      />
      <p
        v-for="error of v$.form.stack.$errors"
        :key="error.$uid"
      >
      <div class="text-red-500">
        {{ numericOrNullValidationError }}
      </div>
      </p>
    <br>
      <label for="portsAmount">
        Port capacity: 
      </label>
      <input 
        class="block w-96" 
        placeholder="For switches, patch panels, etc." 
        name="portsAmount" 
        type="text" 
        v-model="form.portsAmout"
      />
      <p
        v-for="error of v$.form.portsAmout.$errors"
        :key="error.$uid"
      >
      <div class="text-red-500">
        {{ numericOrNullValidationError }}
      </div>
      </p>
    <br>
      <label for="version">
        Software version: 
      </label>
      <input 
        class="block w-96" 
        name="version" 
        type="text" 
        v-model="form.version"
      />
    <br>
      <label for="powerType">
        Socket type: 
      </label>
      <select 
        class="block" 
        v-model="form.powerType"
      >
        <option 
          value="IEC C14 socket" 
          selected="selected"
        >
          IEC C14 socket
        </option>
        <option value="External power supply">
          External power supply
        </option>
        <option value="Clamps">
          Clamps
        </option>
        <option value="Passive equipment">
          Passive equipment
        </option>
        <option value="Other">
          Other
        </option>
      </select>
    <br>
      <label for="powerW">
        Power requirement (W): 
      </label>
      <input 
        class="block w-96" 
        name="powerW" 
        type="text" 
        v-model="form.powerW"
      />
      <p
        v-for="error of v$.form.powerW.$errors"
        :key="error.$uid"
      >
      <div class="text-red-500">
        {{ numericOrNullValidationError }}
      </div>
      </p>
    <br>
      <label for="powerV">
        Voltage (V): 
      </label>
      <input
        class="block w-96" 
        name="powerV" 
        type="text" 
        v-model="form.powerV"
      />
      <p
        v-for="error of v$.form.powerV.$errors"
        :key="error.$uid"
      >
      <div class="text-red-500">
        {{ numericOrNullValidationError }}
      </div>
      </p>
    <br>
      <label for="powerACDC">
        AC/DC: 
      </label>
      <select 
        class="block" 
        v-model="form.powerACDC"
      >
        <option 
          value="AC" 
          selected="selected"
        >
          AC
        </option>
        <option value="DC">
          DC
        </option>
      </select>
    <br>
      <label for="serialNumber">
        Serial number: 
      </label>
      <input 
        class="block w-96" 
        name="serialNumber" 
        type="text" 
        v-model="form.serialNumber"
      />
    <br>
      <label for="description">
        Description: 
      </label>
      <input 
        class="block w-96" 
        placeholder="Device purpose" 
        name="description" 
        type="text" 
        v-model="form.description"
      />
    <br>
      <label for="project">
        Project: 
      </label>
      <input 
        class="block w-96" 
        name="project" 
        type="text" 
        v-model="form.project"
      />
    <br>
      <label for="ownership">
        Ownership: 
      </label>
      <input 
        class="block w-96" 
        name="ownership" 
        type="text" 
        v-model="form.ownership"
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
        v-model="form.link"
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
import { required, numeric, minValue, ipAddress } from '@vuelidate/validators';
import { getUnique } from '@/api';
import { numericGTZOrNull } from '@/validators';
import { setEmptyStringToNull } from '@/functions';


export default {
  name: 'DeviceForm',
  props: {
    formProps: {
      type: Object
    }
  },
  components: {
    ChooseExistingItem
  },
  data() {
    return {
      v$: useVuelidate(),
      vendorsIsHidden: true,
      modelsIsHidden: true,
      vendors: {},
      models: {},
      form: {
        firstUnit: null,
        lastUnit: null,
        frontsideLocation: true,
        status: 'Device active',
        type: 'Other',
        vendor: '',
        model: '',
        hostname: '',
        ip: null,
        deviceStack: '',
        portsAmout: null,
        version: '',
        powerType: 'IEC C14 socket',
        powerW: null,
        powerV: null,
        powerACDC: 'AC',
        serialNumber: '',
        description: '',
        project: '',
        ownership: 'Our department',
        responsible: '',
        financiallyResponsiblePerson: '',
        inventoryNumber: '',
        fixedAsset: ''
      },
      numericOrNullValidationError: 'Value must be an integer and greater than zero',
      selectedModel: '',
      searchTerm: ''
    };
  },
  created() {
    this.getVendors();
    this.getModels();
    this.setDeviceFormProps();
    
  },
  validations() {
    return {
      form: {
        firstUnit: {required, numeric, minValue: minValue(1)},
        lastUnit: {required, numeric, minValue: minValue(1)},
        ip: {ipAddress},
        stack: {numericGTZOrNull},
        portsAmout: {numericGTZOrNull},
        powerW: {numericGTZOrNull},
        powerV: {numericGTZOrNull}
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
     * Fetch and set device vendors
     */
    async getVendors() {
      this.vendors = await getUnique('device vendors', '/device/vendors');
    },
    /**
     * Fetch and set device models
     */
    async getModels() {
      this.models= await getUnique('device models', '/device/models');
    },
    /**
     * Set device form props
     */
    setDeviceFormProps() {
      if (this.formProps.oldFirstUnit) { 
        this.form.firstUnit = this.formProps.oldFirstUnit;
        this.form.lastUnit = this.formProps.oldLastUnit;
        this.form.frontsideLocation = this.formProps.oldFrontsideLocation;
        this.form.status = this.formProps.oldStatus;
        this.form.type = this.formProps.oldType;
        this.form.vendor = this.formProps.oldVendor;
        this.form.model = this.formProps.oldModel;
        this.form.hostname = this.formProps.oldHostname;
        this.form.ip = this.formProps.oldIp;
        this.form.stack = this.formProps.oldStack;
        this.form.portsAmout = this.formProps.oldPortsAmout;
        this.form.version = this.formProps.oldVersion;
        this.form.powerType = this.formProps.oldPowerType;
        this.form.powerW = this.formProps.oldPowerW;
        this.form.powerV = this.formProps.oldPowerV;
        this.form.powerACDC = this.formProps.oldPowerACDC;
        this.form.serialNumber = this.formProps.oldSerialNumber;
        this.form.description = this.formProps.oldDescription;
        this.form.project = this.formProps.oldProject;
        this.form.ownership = this.formProps.oldOwnership;
        this.form.responsible = this.formProps.oldResponsible;
        this.form.financiallyResponsiblePerson = this.formProps.oldFinanciallyResponsiblePerson;
        this.form.inventoryNumber = this.formProps.oldInventoryNumber;
        this.form.fixedAsset = this.formProps.oldFixedAsset;
      }
    },
    /**
     * Emit data
     */
    emitData() {
      if (this.v$.$errors.length == 0) {
        //Yes, this is a crutch, but quite simple and understandable
        const fieldNamesArr = [
          'stack',
          'portsAmout',
          'powerW',
          'powerV'
        ]
        this.setEmptyStringToNull(fieldNamesArr, this.form);
        this.$emit('on-submit', this.form);
      } else {
        console.log(this.v$.$errors)
        confirm("Form not valid, please check the fields");
        window.scrollTo({top: 0, behavior: 'smooth'});
        return;
      }
    },
    setEmptyStringToNull: setEmptyStringToNull,
  }
}
</script>