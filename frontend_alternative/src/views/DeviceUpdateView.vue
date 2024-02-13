<template>
  <div class="container px-4 mx-auto justify-between pl-8 font-sans font-thin text-xl">
    <TheMessage :messageProps="messageProps"/>
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
import {getObject, getResponseMessage, logIfNotStatus, putObject} from '@/api';
import {getUnitsArray} from "@/functions";
import {RESPONSE_STATUS} from "@/constants";


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
        oldHasBacksideLocation: false,
        oldStatus: 'Device active',
        oldType: 'Other',
        oldVendor: '',
        oldModel: '',
        oldHostname: '',
        oldIp: null,
        oldStack: null,
        oldPortsAmount: null,
        oldSoftwareVersion: '',
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
        message: '',
        success: false,
      }
    };
  },
  async created() {
    await this.setOldData();
  },
  methods: {
    /**
     * Submit device form
     * @param {Object} form Device form
     */
    async submitForm(form) {
      const firstUnit = parseInt(form.firstUnit);
      const lastUnit = parseInt(form.lastUnit);
      const formData = {
        units: getUnitsArray(firstUnit, lastUnit),
        has_backside_location: form.hasBacksideLocation,
        status: form.status,
        type: form.type,
        vendor: form.vendor,
        model: form.model,
        hostname: form.hostname,
        ip: form.ip,
        stack: form.stack,
        ports_amount: form.portsAmount,
        software_version: form.softwareVersion,
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
        fixed_asset: form.fixedAsset
      };
      const response = await putObject('device', this.$route.params.id, formData);
      if (response.status === RESPONSE_STATUS.ACCEPTED) {
        this.messageProps.success = true;
        this.messageProps.message = `Device ${response.data.data.vendor} ${response.data.data.model} updated successfully`;
      } else {
        this.messageProps.success = false;
        this.messageProps.message = getResponseMessage(response);
      }
      window.scrollTo({top: 0, behavior: 'smooth'});
    },
    /**
     * Fetch and set device old data
     */
    async setOldData() {
      const response = await getObject('device', this.$route.params.id);
      logIfNotStatus(response, RESPONSE_STATUS.OK, 'Unexpected response!');
      if (response.status === RESPONSE_STATUS.NOT_FOUND) {
        this.$router.push('/404');
      }
      const device = response.data.data;
      this.formProps.oldFirstUnit = device.units[0];
      this.formProps.oldLastUnit = device.units[device.units.length - 1];
      this.formProps.oldHasBacksideLocation = device.has_backside_location;
      this.formProps.oldStatus = device.status;
      this.formProps.oldType = device.type;
      this.formProps.oldVendor = device.vendor;
      this.formProps.oldModel = device.model;
      this.formProps.oldHostname = device.hostname;
      this.formProps.oldIp = device.ip;
      this.formProps.oldStack = device.stack;
      this.formProps.oldPortsAmount = device.ports_amount;
      this.formProps.oldSoftwareVersion = device.software_version;
      this.formProps.oldPowerType = device.power_type;
      this.formProps.oldPowerW = device.power_w;
      this.formProps.oldPowerV = device.power_v;
      this.formProps.oldPowerACDC = device.power_ac_dc;
      this.formProps.oldSerialNumber = device.serial_number;
      this.formProps.oldDescription = device.description;
      this.formProps.oldProject = device.project;
      this.formProps.oldOwnership = device.ownership;
      this.formProps.oldResponsible = device.responsible;
      this.formProps.oldFinanciallyResponsiblePerson = device.financially_responsible_person;
      this.formProps.oldInventoryNumber = device.inventory_number;
      this.formProps.oldFixedAsset = device.fixed_asset;
      this.rackId = device.rack_id;
    }
  }
};
</script>
