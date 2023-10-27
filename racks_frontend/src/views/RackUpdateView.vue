<template>
  <div class="container px-4 mx-auto justify-between pl-8 font-sans font-thin text-xl">
    <TheMessage :messageProps="messageProps" />
  </div>
  <div class="container px-4 mx-auto justify-between pl-8 font-sans font-light text-sm">
    <template v-if="formProps.oldName">
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
        oldName: '',
        oldAmount: null,
        oldVendor: '',
        oldModel: '',
        oldDescription: '',
        oldNumberingFromBottomToTop: true,
        oldResponsible: '',
        oldFinanciallyResponsiblePerson: '',
        oldInventoryNumber: '',
        oldFixedAsset: '',
        oldLink: '',
        oldRow: '',
        oldPlace: '',
        oldHeight: null,
        oldWidth: null,
        oldDepth: null,
        oldUnitWidth: null,
        oldUnitDepth: null,
        oldType: 'Rack',
        oldFrame: 'Double frame',
        oldPlaceType: 'Floor standing',
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
        room_id: this.roomId
      };
      this.messageProps.message = await putObject('rack', `/rack/${this.$route.params.id}/update/`, formData);
      window.scrollTo({top: 0, behavior: 'smooth'});
    },
    async getOldData() {
      // Get rack old data
      const response = await getObject('rack', '/rack/', this.$route.params.id);
      this.messageProps.message = response;
      this.formProps.oldName = response.name;
      this.formProps.oldAmount = response.amount;
      this.formProps.oldVendor = response.vendor;
      this.formProps.oldModel = response.model;
      this.formProps.oldDescription = response.description;
      this.formProps.oldNumberingFromBottomToTop = response.mumbering_from_bottom_to_top;
      this.formProps.oldResponsible = response.responsible;
      this.formProps.oldFinanciallyResponsiblePerson = response.financially_responsible_person;
      this.formProps.oldInventoryNumber = response.inventory_number;
      this.formProps.oldFixedAsset = response.fixed_asset;
      this.formProps.oldLink = response.link;
      this.formProps.oldRow = response.row;
      this.formProps.oldPlace = response.place;
      this.formProps.oldHeight = response.height;
      this.formProps.oldWidth = response.width;
      this.formProps.oldDepth = response.depth;
      this.formProps.oldUnitWidth = response.unit_width;
      this.formProps.oldUnitDepth = response.unit_depth;
      this.formProps.oldType = response.type;
      this.formProps.oldFrame = response.frame;
      this.formProps.oldPlaceType = response.place_type;
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