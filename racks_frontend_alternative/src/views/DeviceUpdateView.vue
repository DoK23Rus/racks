<template>
  <div class="container px-4 mx-auto justify-between pl-8 font-sans font-thin text-xl">
    <TheMessage :messageProps="messageProps" />
  </div>
  <div class="container px-4 mx-auto justify-between pl-8 font-sans font-light text-sm">
    <template v-if="formProps.oldFirstUnit">
      <DeviceForm 
        :formProps="formProps" 
        v-on:on-submit="submitForm" 
      />
    </template>
  </div>
</template>

<script>
import DeviceForm from '@/components/DeviceForm.vue';
import TheMessage from '@/components/TheMessage.vue';
import { putObject, getObject } from '@/api';


export default {
  name: 'DeviceUpdateView',
  components: {
    DeviceForm,
    TheMessage
  },
  data() {
    return {
      formProps: {
        oldFirstUnit: null,
        oldLastUnit: null,
        oldHasFrontsideLocation: true,
        oldStatus: 'Device active',
        oldType: 'Other',
        oldVendor: '',
        oldModel: '',
        oldHostname: '',
        oldIp: null,
        oldStack: null,
        oldPortsAmout: null,
        oldVersion: '',
        oldPowerType: 'IEC C14 socket',
        oldPowerW: null,
        oldPowerV: null,
        oldPowerACDC: 'AC',
        oldSerialNumber: '',
        oldDescription: '',
        oldProject: '',
        oldOwnership: '',
        oldResponsible: '',
        oldFinanciallyResponsiblePerson: '',
        oldInventoryNumber: '',
        oldFixedAsset: ''
      },
      rackId: null,
      messageProps: {
        message: ''
      }
    };
  },
  async created() {
    await this.getOldData();
  },
  methods: {
    /**
     * Submit device form
     * @param {Object} form Device form
     */
    async submitForm(form) {
      const formData = {
        id: this.$route.params.id,
        first_unit: parseInt(form.firstUnit),
        last_unit: parseInt(form.lastUnit),
        has_frontside_location: form.hasFrontsideLocation,
        status: form.status,
        type: form.type,
        vendor: form.vendor,
        model: form.model,
        hostname: form.hostname,
        ip: form.ip,
        stack: form.stack,
        ports_amout: form.portsAmout,
        version: form.version,
        power_type: form.powerType,
        power_w: form.powerW,
        power_v: form.powerV,
        power_ac_dc: form.powerACDC,
        serial_number: form.serialNumber,
        description: form.description,
        project: form.project,
        ownership: form.ownership,
        responsible: form.responsible,
        financially_responsible_person: form.financiallyResponsiblePerson,
        inventory_number: form.inventoryNumber,
        fixed_asset: form.fixedAsset,
        rack_id: this.rack_id
      };
      this.messageProps.message = await putObject('device', `/device/${this.$route.params.id}/update/`, formData);
      window.scrollTo({top: 0, behavior: 'smooth'});
    },
    /**
     * Fetch and set device old data
     */
    async getOldData() {
      const response = await getObject('device', '/device/', this.$route.params.id);
      this.messageProps.message = response;
      this.formProps.oldFirstUnit = response.first_unit;
      this.formProps.oldLastUnit = response.last_unit;
      this.formProps.oldHasFrontsideLocation = response.has_frontside_location;
      this.formProps.oldStatus = response.status;
      this.formProps.oldType = response.type;
      this.formProps.oldVendor = response.vendor;
      this.formProps.oldModel = response.model;
      this.formProps.oldHostname = response.hostname;
      this.formProps.oldIp = response.ip;
      this.formProps.oldStack = response.stack;
      this.formProps.oldPortsAmout = response.ports_amout;
      this.formProps.oldVersion = response.version;
      this.formProps.oldPowerType = response.power_type;
      this.formProps.oldPowerW = response.power_w;
      this.formProps.oldPowerV = response.power_v;
      this.formProps.oldPowerACDC = response.power_ac_dc;
      this.formProps.oldSerialNumber = response.serial_number;
      this.formProps.oldDescription = response.description;
      this.formProps.oldProject = response.project;
      this.formProps.oldOwnership = response.ownership;
      this.formProps.oldResponsible = response.responsible;
      this.formProps.oldFinanciallyResponsiblePerson = response.financially_responsible_person;
      this.formProps.oldInventoryNumber = response.inventory_number;
      this.formProps.oldFixedAsset = response.fixed_asset;
      this.rackId = response.rack_id;
    }
  }
};
</script>