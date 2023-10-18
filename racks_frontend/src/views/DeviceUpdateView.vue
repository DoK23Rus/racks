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
import { putObject, getObject } from '@/api';
import DeviceForm from '@/components/DeviceForm.vue';
import TheMessage from '@/components/TheMessage.vue';

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
        oldFrontsideLocation: true,
        oldStatus: 'Device active',
        oldDeviceType: 'Other',
        oldDeviceVendor: '',
        oldDeviceModel: '',
        oldDeviceHostname: '',
        oldIp: null,
        oldDeviceStack: null,
        oldPortsAmout: null,
        oldVersion: '',
        oldPowerType: 'IEC C14 socket',
        oldPowerW: null,
        oldPowerV: null,
        oldPowerACDC: 'AC',
        oldDeviceSerialNumber: '',
        oldDeviceDescription: '',
        oldProject: '',
        oldOwnership: '',
        oldResponsible: '',
        oldFinanciallyResponsiblePerson: '',
        oldDeviceInventoryNumber: '',
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
    async submitForm(form) {
      const formData = {
        id: this.$route.params.id,
        first_unit: parseInt(form.firstUnit),
        last_unit: parseInt(form.lastUnit),
        frontside_location: form.frontsideLocation,
        status: form.status,
        device_type: form.deviceType,
        device_vendor: form.deviceVendor,
        device_model: form.deviceModel,
        device_hostname: form.deviceHostname,
        ip: form.ip,
        device_stack: form.deviceStack,
        ports_amout: form.portsAmout,
        version: form.version,
        power_type: form.powerType,
        power_w: form.powerW,
        power_v: form.powerV,
        power_ac_dc: form.powerACDC,
        device_serial_number: form.deviceSerialNumber,
        device_description: form.deviceDescription,
        project: form.project,
        ownership: form.ownership,
        responsible: form.responsible,
        financially_responsible_person: form.financiallyResponsiblePerson,
        device_inventory_number: form.deviceInventoryNumber,
        fixed_asset: form.fixedAsset,
        rack_id: this.rack_id
      };
      this.messageProps.message = await putObject('device', `/device/${this.$route.params.id}/update/`, formData);
      window.scrollTo({top: 0, behavior: 'smooth'});
    },
    async getOldData() {
      // Get device old data
      const response = await getObject('device', '/device/', this.$route.params.id);
      this.messageProps.message = response;
      this.formProps.oldFirstUnit = response.first_unit;
      this.formProps.oldLastUnit = response.last_unit;
      this.formProps.oldFrontsideLocation = response.frontside_location;
      this.formProps.oldStatus = response.status;
      this.formProps.oldDeviceType = response.device_type;
      this.formProps.oldDeviceVendor = response.device_vendor;
      this.formProps.oldDeviceModel = response.device_model;
      this.formProps.oldDeviceHostname = response.device_hostname;
      this.formProps.oldIp = response.ip;
      this.formProps.oldDeviceStack = response.device_stack;
      this.formProps.oldPortsAmout = response.ports_amout;
      this.formProps.oldVersion = response.version;
      this.formProps.oldPowerType = response.power_type;
      this.formProps.oldPowerW = response.power_w;
      this.formProps.oldPowerV = response.power_v;
      this.formProps.oldPowerACDC = response.power_ac_dc;
      this.formProps.oldDeviceSerialNumber = response.device_serial_number;
      this.formProps.oldDeviceDescription = response.device_description;
      this.formProps.oldProject = response.project;
      this.formProps.oldOwnership = response.ownership;
      this.formProps.oldResponsible = response.responsible;
      this.formProps.oldFinanciallyResponsiblePerson = response.financially_responsible_person;
      this.formProps.oldDeviceInventoryNumber = response.device_inventory_number;
      this.formProps.oldFixedAsset = response.fixed_asset;
      this.rackId = response.rack_id;
    }
  }
};
</script>