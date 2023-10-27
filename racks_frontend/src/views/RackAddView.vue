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
        name: '',
        amount: null,
        vendor: '',
        model: '',
        description: '',
        numberingFromBottomToTop: true,
        responsible: '',
        financiallyResponsiblePerson: '',
        inventoryNumber: '',
        fixedAsset: '',
        link: '',
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
        name: form.name,
        amount: parseInt(form.amount),
        vendor: form.vendor,
        model: form.model,
        description: form.description,
        numbering_from_bottom_to_top: form.numberingFromBottomToTop,
        responsible: form.responsible,
        financially_responsible_person: form.financiallyResponsiblePerson,
        inventory_number: form.inventoryNumber,
        fixed_asset: form.fixedAsset,
        link: form.link,
        row: form.row,
        place: form.place,
        height: form.height,
        width: form.width,
        depth: form.depth,
        unit_width: form.unitWidth,
        unit_depth: form.unitDepth,
        type: form.type,
        frame: form.frame,
        place_type: form.placeType,
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