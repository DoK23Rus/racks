<template>
  <div class="container px-4 mx-auto justify-between pl-8 font-sans font-thin text-xl">
    <TheMessage :messageProps="messageProps" />
  </div>
  <div class="container px-4 mx-auto justify-between pl-8 font-sans font-light text-sm">
    <template v-if="formProps.oldRackName">
      <RackForm 
        :formProps="formProps" 
        v-on:on-submit="submitForm" 
      />
    </template>
  </div>
</template>

<script>
import { putObject, getObject } from '@/api';
import RackForm from '@/components/RackForm.vue';
import TheMessage from '@/components/TheMessage.vue';


export default {
  name: 'RackUpdateView',
  components: {
    RackForm,
    TheMessage
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
        oldRackPlaceType: 'Floor standing',
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
        room_id: this.roomId
      };
      this.messageProps.message = await putObject('rack', `/rack/${this.$route.params.id}/update/`, formData);
      window.scrollTo({top: 0, behavior: 'smooth'});
    },
    async getOldData() {
      // Get rack old data
      const response = await getObject('rack', '/rack/', this.$route.params.id);
      this.messageProps.message = response;
      this.formProps.oldRackName = response.name;
      this.formProps.oldRackAmount = response.amount;
      this.formProps.oldRackVendor = response.vendor;
      this.formProps.oldRackModel = response.model;
      this.formProps.oldRackDescription = response.description;
      this.formProps.oldNumberingFromBottomToTop = response.mumbering_from_bottom_to_top;
      this.formProps.oldResponsible = response.responsible;
      this.formProps.oldRackFinanciallyResponsiblePerson = response.financially_responsible_person;
      this.formProps.oldRackInventoryNumber = response.inventory_number;
      this.formProps.oldFixedAsset = response.fixed_asset;
      this.formProps.oldLink = response.link;
      this.formProps.oldRow = response.row;
      this.formProps.oldPlace = response.place;
      this.formProps.oldRackHeight = response.height;
      this.formProps.oldRackWidth = response.width;
      this.formProps.oldRackDepth = response.depth;
      this.formProps.oldRackUnitWidth = response.unit_width;
      this.formProps.oldRackUnitDepth = response.unit_depth;
      this.formProps.oldRackType = response.type;
      this.formProps.oldRackFrame = response.frame;
      this.formProps.oldRackPlaceType = response.place_type;
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