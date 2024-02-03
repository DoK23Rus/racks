<template>
  <div class="container px-4 mx-auto justify-between pl-8 font-sans font-thin text-xl">
    <TheMessage :messageProps="messageProps"/>
  </div>
  <div class="container px-4 mx-auto justify-between pl-8 font-sans font-light text-sm">
    <DeviceForm
      :formProps="formProps"
      v-on:on-submit="submitForm"
    />
  </div>
</template>

<script>
import DeviceForm from '@/components/DeviceForm.vue';
import TheMessage from '@/components/TheMessage.vue';
import {postObject} from '@/api';
import {getUnitsArray} from "@/functions";
import {RESPONSE_STATUS} from "@/constants";


export default {
  name: 'DeviceAddView',
  components: {
    DeviceForm,
    TheMessage
  },
  data() {
    return {
      formProps: {
        firstUnit: null,
        lastUnit: null,
        hasBacksideLocation: false,
        status: 'Device active',
        type: 'Other',
        vendor: '',
        model: '',
        hostname: '',
        ip: null,
        stack: null,
        portsAmount: null,
        softwareVersion: '',
        powerType: 'IEC C14 socket',
        powerW: null,
        powerV: null,
        powerACDC: 'AC',
        serialNumber: '',
        description: '',
				linkToDocs: '',
        project: '',
        ownership: 'Our department',
        responsible: '',
        financiallyResponsiblePerson: '',
        inventoryNumber: '',
        fixedAsset: ''
      },
			messageProps: {
				message: '',
				success: false,
			}
    };
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
				link_to_docs: form.linkToDocs,
        project: form.project,
        ownership: form.ownership,
        responsible: form.responsible,
        financially_responsible_person: form.financiallyResponsiblePerson,
        inventory_number: form.inventoryNumber,
        fixed_asset: form.fixedAsset,
        rack_id: parseInt(this.$route.params.rack_id)
      };
      const response = await postObject('device', formData);
      if (response.status === RESPONSE_STATUS.CREATED) {
				this.messageProps.success = true;
				this.messageProps.message = `Device ${response.data.data.vendor} ${response.data.data.model} added successfully`;
      } else {
				this.messageProps.message = response.data.data.message;
      }
      window.scrollTo({top: 0, behavior: 'smooth'});
    },
  }
};
</script>
