<template>
  <div class="container px-4 mx-auto justify-between pl-8 font-sans font-thin text-xl">
    <TheMessage :messageProps="messageProps" />
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
import { postObject } from '@/api';


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
        hasFrontsideLocation: true,
        status: 'Device active',
        type: 'Other',
        vendor: '',
        model: '',
        hostname: '',
        ip: null,
        stack: null,
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
      messageProps: {
          message: ''
      }
    };
  },
  methods: {
    /**
     * Submit device form
     * @param {Object} form Device form
     */
    async submitForm(form) {
      const formData = {
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
        rack_id: parseInt(this.$route.params.rack_id)
      };
      this.messageProps.message = await postObject('device', '/device/create/', formData);
      window.scrollTo({top: 0, behavior: 'smooth'});
    },
  }
};
</script>