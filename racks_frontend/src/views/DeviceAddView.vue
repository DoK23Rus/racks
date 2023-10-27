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
import { postObject } from '@/api';
import DeviceForm from '@/components/DeviceForm.vue';
import TheMessage from '@/components/TheMessage.vue';


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
        frontsideLocation: true,
        status: 'Device active',
        deviceType: 'Other',
        deviceVendor: '',
        deviceModel: '',
        deviceHostname: '',
        ip: null,
        deviceStack: null,
        portsAmout: null,
        version: '',
        powerType: 'IEC C14 socket',
        powerW: null,
        powerV: null,
        powerACDC: 'AC',
        deviceSerialNumber: '',
        deviceDescription: '',
        project: '',
        ownership: 'Our department',
        responsible: '',
        financiallyResponsiblePerson: '',
        deviceInventoryNumber: '',
        fixedAsset: ''
      },
      messageProps: {
          message: ''
      }
    };
  },
  methods: {
    async submitForm(form) {
      const formData = {
        first_unit: parseInt(form.firstUnit),
        last_unit: parseInt(form.lastUnit),
        frontside_location: form.frontsideLocation,
        status: form.status,
        type: form.deviceType,
        vendor: form.deviceVendor,
        model: form.deviceModel,
        hostname: form.deviceHostname,
        ip: form.ip,
        stack: form.deviceStack,
        ports_amout: form.portsAmout,
        version: form.version,
        power_type: form.powerType,
        power_w: form.powerW,
        power_v: form.powerV,
        power_ac_dc: form.powerACDC,
        serial_number: form.deviceSerialNumber,
        description: form.deviceDescription,
        project: form.project,
        ownership: form.ownership,
        responsible: form.responsible,
        financially_responsible_person: form.financiallyResponsiblePerson,
        inventory_number: form.deviceInventoryNumber,
        fixed_asset: form.fixedAsset,
        rack_id: parseInt(this.$route.params.rack_id)
      };
      this.messageProps.message = await postObject('device', '/device/create/', formData);
      window.scrollTo({top: 0, behavior: 'smooth'});
    },
  }
};
</script>