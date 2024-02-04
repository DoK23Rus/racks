<template>
  <div class="container px-4 mx-auto justify-between pl-8 font-sans font-thin text-xl">
    <TheMessage :messageProps="messageProps"/>
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
import RackForm from '@/components/RackForm.vue';
import TheMessage from '@/components/TheMessage.vue';
import {getObject, getResponseMessage, logIfNotStatus, putObject} from '@/api';
import {RESPONSE_STATUS} from "@/constants";


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
        oldHasNumberingFromTopToBottom: false,
        oldResponsible: '',
        oldFinanciallyResponsiblePerson: '',
        oldInventoryNumber: '',
        oldFixedAsset: '',
        oldLinkToDocs: '',
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
        oldHasExternalUps: false,
        oldHasCooler: false,
        update: true
      },
      roomId: null,
			messageProps: {
				message: '',
				success: false,
			}
    };
  },
  async created() {
    await this.setOldData();
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
        room_id: this.roomId
      };
			const response = await putObject('rack', this.$route.params.id, formData);
			if (response.status === RESPONSE_STATUS.ACCEPTED) {
				this.messageProps.success =true;
				this.messageProps.message = `Rack ${response.data.data.name} updated successfully`;
			} else {
				this.messageProps.success = false;
				this.messageProps.message = getResponseMessage(response);
			}
			window.scrollTo({top: 0, behavior: 'smooth'});
    },
    /**
     * Fetch and set rack old data
     */
    async setOldData() {
			const response = await getObject('rack', this.$route.params.id);
			logIfNotStatus(response, RESPONSE_STATUS.OK, 'Unexpected response!');
			if (response.status === RESPONSE_STATUS.NOT_FOUND) {
				this.$router.push('/404');
			}
			const rack = response.data.data;
      this.formProps.oldName = rack.name;
      this.formProps.oldAmount = rack.amount;
      this.formProps.oldVendor = rack.vendor;
      this.formProps.oldModel = rack.model;
      this.formProps.oldDescription = rack.description;
      this.formProps.oldHasNumberingFromTopToBottom = rack.has_numbering_from_top_to_bottom;
      this.formProps.oldResponsible = rack.responsible;
      this.formProps.oldFinanciallyResponsiblePerson = rack.financially_responsible_person;
      this.formProps.oldInventoryNumber = rack.inventory_number;
      this.formProps.oldFixedAsset = rack.fixed_asset;
      this.formProps.oldLinkToDocs = rack.link_to_docs;
      this.formProps.oldRow = rack.row;
      this.formProps.oldPlace = rack.place;
      this.formProps.oldHeight = rack.height;
      this.formProps.oldWidth = rack.width;
      this.formProps.oldDepth = rack.depth;
      this.formProps.oldUnitWidth = rack.unit_width;
      this.formProps.oldUnitDepth = rack.unit_depth;
      this.formProps.oldType = rack.type;
      this.formProps.oldFrame = rack.frame;
      this.formProps.oldPlaceType = rack.place_type;
      this.formProps.oldMaxLoad = rack.max_load;
      this.formProps.oldPowerSockets = rack.power_sockets;
      this.formProps.oldPowerSocketsUps = rack.power_sockets_ups;
      this.formProps.oldHasExternalUps = rack.has_external_ups;
      this.formProps.oldHasCooler = rack.has_cooler;
      this.roomId = rack.room_id;
    }
  }
};
</script>
