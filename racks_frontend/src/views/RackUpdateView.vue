<template>
  <div class="container px-4 mx-auto justify-between pl-8 font-sans font-thin text-xl">
    <Message :messageProps="messageProps" />
  </div>
  <div class="container px-4 mx-auto justify-between pl-8 font-sans font-light text-sm">
    <template v-if="formProps.oldRackName">
      <RackForm :formProps="formProps" @on-submit="submitForm" />
    </template>
  </div>
</template>

<script>
import { putObject, getObject } from '@/api';
import RackForm from '@/components/RackForm.vue';
import Message from '@/components/Message.vue';


export default {
  name: 'RackUpdateView',
  components: {
    RackForm,
    Message
  },
  data() {
    return {
      formProps: {
        oldRackName: '',
        oldRackAmount: null,
        oldRackVendor: '',
        oldRackModel: '',
        oldRackDescription: '',
        oldNumberingFromBottomToTop: true,
        oldResponsible: '',
        oldRackFinanciallyResponsiblePerson: '',
        oldRackInventoryNumber: '',
        oldFixedAsset: '',
        oldLink: '',
        oldRow: '',
        oldPlace: '',
        oldRackHeight: null,
        oldRackWidth: null,
        oldRackDepth: null,
        oldRackUnitWidth: null,
        oldRackUnitDepth: null,
        oldRackType: 'Rack',
        oldRackFrame: 'Double frame',
        oldRackPalceType: 'Floor standing',
        oldMaxLoad: null,
        oldPowerSockets: null,
        oldPowerSocketsUps: null,
        oldExternalUps: false,
        oldCooler: false,
        update: true
      },
      roomId: null,
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
        room_id: this.roomId
      };
      this.messageProps.message = await putObject('rack', `/rack/${this.$route.params.id}/update/`, formData);
      window.scrollTo({top: 0, behavior: 'smooth'});
    },
    async getOldData() {
      // Get rack old data
      const response = await getObject('rack', '/rack/', this.$route.params.id);
      this.messageProps.message = response;
      this.formProps.oldRackName = response.rack_name;
      this.formProps.oldRackAmount = response.rack_amount;
      this.formProps.oldRackVendor = response.rack_vendor;
      this.formProps.oldRackModel = response.rack_model;
      this.formProps.oldRackDescription = response.rack_description;
      this.formProps.oldNumberingFromBottomToTop = response.mumbering_from_bottom_to_top;
      this.formProps.oldResponsible = response.responsible;
      this.formProps.oldRackFinanciallyResponsiblePerson = response.rack_financially_responsible_person;
      this.formProps.oldRackInventoryNumber = response.rack_inventory_number;
      this.formProps.oldFixedAsset = response.fixed_asset;
      this.formProps.oldLink = response.link;
      this.formProps.oldRow = response.row;
      this.formProps.oldPlace = response.place;
      this.formProps.oldRackHeight = response.rack_height;
      this.formProps.oldRackWidth = response.rack_width;
      this.formProps.oldRackDepth = response.rack_depth;
      this.formProps.oldRackUnitWidth = response.rack_unit_width;
      this.formProps.oldRackUnitDepth = response.rack_unit_depth;
      this.formProps.oldRackType = response.rack_type;
      this.formProps.oldRackFrame = response.rack_frame;
      this.formProps.oldRackPalceType = response.rack_palce_type;
      this.formProps.oldMaxLoad = response.max_load;
      this.formProps.oldPowerSockets = response.power_sockets;
      this.formProps.oldPowerSocketsUps = response.power_sockets_ups;
      this.formProps.oldCxternalUps = response.external_ups;
      this.formProps.oldCooler = response.cooler;
      this.roomId = response.room_id;
    }
  }
};
</script>