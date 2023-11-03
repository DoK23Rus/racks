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
import RackForm from '@/components/RackForm.vue';
import TheMessage from '@/components/TheMessage.vue';
import { postObject } from '@/api';


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
        hasNumberingFromBottomToTop: true,
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
        hasExternalUps: false,
        hasCooler: false,
        update: false
      },
      messageProps: {
        message: ''
      },
    };
  },
  methods: {
    /**
     * Submit rack form
     * @param {Object} form Rack form
     */
    async submitForm(form) {
      const formData = {
        name: form.name,
        amount: parseInt(form.amount),
        vendor: form.vendor,
        model: form.model,
        description: form.description,
        has_numbering_from_bottom_to_top: form.hasNumberingFromBottomToTop,
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
        has_external_ups: form.hasExternalUps,
        has_cooler: form.hasCooler,
        room_id: parseInt(this.$route.params.room_id)
      };
      this.messageProps.message = await postObject('rack', '/rack/create/', formData);
      window.scrollTo({top: 0, behavior: 'smooth'});
    },
  }
};
</script>