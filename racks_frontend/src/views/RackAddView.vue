<template>
  <div class="container px-4 mx-auto justify-between pl-8 font-sans font-thin text-xl">
    <Message :messageProps="messageProps" />
  </div>
  <div class="container px-4 mx-auto justify-between pl-8 font-sans font-light text-sm">
    <RackForm :formProps="formProps" @on-submit="submitForm" />
  </div>
</template>

<script>
import { postObject } from '@/api';
import RackForm from '@/components/RackForm.vue';
import Message from '@/components/Message.vue';


export default {
  name: 'RackAddView',
  components: {
    RackForm,
    Message
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
        rackPalceType: 'Floor standing',
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
        rack_name: form.rackName,
        rack_amount: parseInt(form.rackAmount),
        rack_vendor: form.rack_vendor,
        rack_model: form.rackModel,
        rack_description: form.rackDescription,
        numbering_from_bottom_to_top: form.numberingFromBottomToTop,
        responsible: form.responsible,
        rack_financially_responsible_person: form.rackFinanciallyResponsiblePerson,
        rack_inventory_number: form.rackInventoryNumber,
        fixed_asset: form.fixedAsset,
        link: form.link,
        row: form.row,
        place: form.place,
        rack_height: form.rackHeight,
        rack_width: form.rackWidth,
        rack_depth: form.rackDepth,
        rack_unit_width: form.rackUnitWidth,
        rack_unit_depth: form.rackUnitDepth,
        rack_type: form.rackType,
        rack_frame: form.rackFrame,
        rack_palce_type: form.rackPalceType,
        max_load: form.maxLoad,
        power_sockets: form.powerSockets,
        power_sockets_ups: form.powerSocketsUps,
        external_ups: form.externalUps,
        cooler: form.cooler,
        room_id: parseInt(this.$route.params.id)
      };
      this.messageProps.message = await postObject('rack', '/rack_add', formData);
      window.scrollTo({top: 0, behavior: 'smooth'});
    },
  }
};
</script>