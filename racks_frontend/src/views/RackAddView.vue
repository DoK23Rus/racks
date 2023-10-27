<template>
  <div class="container px-4 mx-auto justify-between pl-8 font-sans font-thin text-xl">
    <TheMessage :messageProps="messageProps" />
  </div>
  <div class="container px-4 mx-auto justify-between pl-8 font-sans font-light text-sm">
    <RackForm 
      :formProps="formProps" 
      v-on:on-submit="submitForm" 
    />
  </div>
</template>

<script>
import { postObject } from '@/api';
import RackForm from '@/components/RackForm.vue';
import TheMessage from '@/components/TheMessage.vue';


export default {
  name: 'RackAddView',
  components: {
    RackForm,
    TheMessage
  },
  data() {
    return {
      formProps: {
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
        rackPlaceType: 'Floor standing',
        maxLoad: null,
        powerSockets: null,
        powerSocketsUps: null,
        externalUps: false,
        cooler: false,
        update: false
      },
      messageProps: {
        message: ''
      },
    };
  },
  methods: {
    async submitForm(form) {
      const formData = {
        name: form.rackName,
        amount: parseInt(form.rackAmount),
        vendor: form.rackVendor,
        model: form.rackModel,
        description: form.rackDescription,
        numbering_from_bottom_to_top: form.numberingFromBottomToTop,
        responsible: form.responsible,
        financially_responsible_person: form.rackFinanciallyResponsiblePerson,
        inventory_number: form.rackInventoryNumber,
        fixed_asset: form.fixedAsset,
        link: form.link,
        row: form.row,
        place: form.place,
        height: form.rackHeight,
        width: form.rackWidth,
        depth: form.rackDepth,
        unit_width: form.rackUnitWidth,
        unit_depth: form.rackUnitDepth,
        type: form.rackType,
        frame: form.rackFrame,
        place_type: form.rackPlaceType,
        max_load: form.maxLoad,
        power_sockets: form.powerSockets,
        power_sockets_ups: form.powerSocketsUps,
        external_ups: form.externalUps,
        cooler: form.cooler,
        room_id: parseInt(this.$route.params.room_id)
      };
      this.messageProps.message = await postObject('rack', '/rack/create/', formData);
      window.scrollTo({top: 0, behavior: 'smooth'});
    },
  }
};
</script>