<template>
  <div class="container px-4 mx-auto  justify-between text-xl pl-8 pt-4 font-sans font-light">
		<div class="container px-4 mx-auto justify-between pl-8 font-sans font-light text-xl">
      <TheMessage :messageProps="messageProps"/>
    </div>
    Rack №{{rack.id}}
    <router-link
      :to="{path: `/rack/${rack.id}/update`}"
      target="_blank"
    >
      <button class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small rounded-lg text-xs
        px-5 py-0.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
        Edit
      </button>
    </router-link>
    <button
      class="text-white bg-blue-400 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small rounded-lg text-xs
      px-5 py-0.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
      v-on:click="deleteRack(rack.id, rack.name)"
    >
      Delete
    </button>
    <br>
      <div class="text-xs pb-4 text-slate-500">
        {{location.regionName}} &#9002; {{location.departmentName}} &#9002;
        {{location.siteName}} &#9002; {{location.buildingName}} &#9002; {{location.roomName}}
      </div>
  	<div class="text-base">
      Rack name:
			<text class="text-slate-500">
				{{rack.name}}
			</text>
    	<br>
      Responsible:
			<text class="text-slate-500">
				{{rack.responsible}}
			</text>
    	<br>
      Row:
			<text class="text-slate-500">
				{{rack.row}}
			</text>
    	<br>
      Place:
			<text class="text-slate-500">
				{{rack.place}}
			</text>
    	<br>
      Description:
			<text class="text-slate-500">
				{{rack.description}}
			</text>
    	<br>
      Inventory number:
			<text class="text-slate-500">
				{{rack.inventoryNumber}}
			</text>
    	<br>
      Financially responsible:
			<text class="text-slate-500">
				{{rack.financiallyResponsiblePerson}}
			</text>
    	<br>
      Fixed asset:
			<text class="text-slate-500">
				{{rack.fixedAsset}}
			</text>
    	<br>
      <template v-if="rack.link_to_docs">
        Link to docs:
        <a
          class="text-slate-500"
          v-bind:href="rack.link_to_docs"
        >
          <text class="text-blue-300">
            &#9873;
          </text>
          {{rack.link_to_docs}}
        </a>
      </template>
      <template v-else>
        Link to docs:
      </template>
    	<br>
    	<br>
      Vendor:
			<text class="text-slate-500">
				{{rack.vendor}}
			</text>
    	<br>
      Model:
			<text class="text-slate-500">
				{{rack.model}}
			</text>
    	<br>
      Rack amount (units):
			<text class="text-slate-500">
				{{rack.amount}}
			</text>
    	<br>
      <template v-if="rack.hasNumberingFromTopToBottom">
        Numbering:
				<text class="text-slate-500">
					from top to bottom
				</text>
      </template>
      <template v-else>
        Numbering:
				<text class="text-slate-500">
					from bottom to top
				</text>
      </template>
    	<br>
      <template v-if="rack.height">
        Rack height (mm):
				<text class="text-slate-500">
					{{rack.height}}
				</text>
      </template>
      <template v-else>
        Rack height (mm):
      </template>
    	<br>
      <template v-if="rack.width">
        Rack width (mm):
				<text class="text-slate-500">
					{{rack.width}}
				</text>
      </template>
      <template v-else>
        Rack width (mm):
      </template>
    	<br>
      <template v-if="rack.depth">
        Rack depth (mm):
				<text class="text-slate-500">
					{{rack.depth}}
				</text>
      </template>
      <template v-else>
        Rack depth (mm):
      </template>
    	<br>
      <template v-if="rack.unitWidth">
        Useful rack width (inches):
				<text class="text-slate-500">
					{{rack.unitWidth}}
				</text>
      </template>
      <template v-else>
        Useful rack width (inches):
      </template>
    	<br>
      <template v-if="rack.unitDepth">
        Useful rack depth (mm):
				<text class="text-slate-500">
					{{rack.unitDepth}}
				</text>
      </template>
      <template v-else>
        Useful rack depth (mm):
      </template>
    	<br>
      Execution variant:
			<text class="text-slate-500">
				{{rack.type}}
			</text>
    	<br>
      Construction:
			<text class="text-slate-500">
				{{rack.frame}}
			</text>
    	<br>
      Location type:
			<text class="text-slate-500">
				{{rack.placeType}}
			</text>
    	<br>
      <template v-if="rack.maxLoad">
        Max load (kilo):
				<text class="text-slate-500">
					{{rack.maxLoad}}
				</text>
      </template>
      <template v-else>
        Max load (kilo):
      </template>
    	<br>
      <template v-if="rack.powerSockets">
        Free power sockets:
				<text class="text-slate-500">
					{{rack.powerSockets}}
				</text>
      </template>
      <template v-else>
        Free power sockets:
      </template>
    	<br>
      <template v-if="rack.powerSocketsUps">
        Free UPS power sockets:
				<text class="text-slate-500">
					{{rack.powerSocketsUps}}
				</text>
      </template>
      <template v-else>
        Free UPS power sockets:
      </template>
    	<br>
      <template v-if="rack.hasCooler">
        Active ventilation:
				<text class="text-slate-500">
					Yes
				</text>
      </template>
      <template v-else>
        Active ventilation:
				<text class="text-slate-500">
					No
				</text>
      </template>
    	<br>
      <template v-if="rack.hasExternalUps">
        External power backup supply system:
				<text class="text-slate-500">
					Yes
				</text>
      </template>
      <template v-else>
        External power backup supply system:
				<text class="text-slate-500">
					No
				</text>
      </template>
    	<br>
    	<br>
    	<div class="text-xs">
        Updated by:
				<text class="text-slate-500">
					{{rack.updatedBy}}
				</text>
      <br>
        Updated at:
				<text class="text-slate-500">
					{{rack.updatedAt}}
				</text>
    	</div>
    	<br>
  	</div>
  </div>
</template>

<script>
import TheMessage from '@/components/TheMessage.vue';
import {deleteObject, getObject, getObjectLocation, getResponseMessage, logIfNotStatus} from '@/api';
import {RESPONSE_STATUS} from "@/constants";


export default {
  name: 'RackView',
  components: {
    TheMessage
  },
  data() {
    return {
      rack: {
        id: this.$route.params.id,
        name: '',
        amount: null,
        vendor: '',
        model: '',
        description: '',
        hasNumberingFromTopToBottom: true,
        responsible: '',
        financiallyResponsiblePerson: '',
        inventoryNumber: '',
        fixedAsset: '',
        linkToDocs: '',
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
        totalPowerW: null,
        updatedBy: '',
        updatedAt: ''
      },
			messageProps: {
				message: '',
				success: false,
			},
      location: {
        roomName: '',
        buildingName: '',
        siteName: '',
        departmentName: '',
        regionName: ''
      }
    }
  },
  mounted() {
    this.setRack();
    this.setRackLocation();
  },
  methods: {
    /**
     * Fetch and set rack data
     */
    async setRack() {
			const response = await getObject('rack', this.$route.params.id);
			logIfNotStatus(response, RESPONSE_STATUS.OK, 'Unexpected response!');
			if (response.status === RESPONSE_STATUS.NOT_FOUND) {
				this.$router.push('/404');
			}
			const rack = response.data.data;
      this.rack.name = rack.name;
      this.rack.amount = rack.amount;
      this.rack.vendor = rack.vendor;
      this.rack.model = rack.model;
      this.rack.description = rack.description;
      this.rack.hasNumberingFromTopToBottom = rack.has_numbering_from_top_to_bottom;
      this.rack.responsible = rack.responsible;
      this.rack.financiallyResponsiblePerson = rack.financially_responsible_person;
      this.rack.inventoryNumber = rack.inventory_number;
      this.rack.fixedAsset = rack.fixed_asset;
      this.rack.linkToDocs = rack.link_to_docs;
      this.rack.row = rack.row;
      this.rack.place = rack.place;
      this.rack.height = rack.height;
      this.rack.width = rack.width;
      this.rack.depth = rack.depth;
      this.rack.unitWidth = rack.unit_width;
      this.rack.unitDepth = rack.unit_depth;
      this.rack.type = rack.type;
      this.rack.frame = rack.frame;
      this.rack.placeType = rack.place_type;
      this.rack.maxLoad = rack.max_load;
      this.rack.powerSockets = rack.power_sockets;
      this.rack.powerSocketsUps = rack.power_sockets_ups;
      this.rack.hasExternalUps = rack.has_external_ups;
      this.rack.hasCooler = rack.has_cooler;
      this.rack.updatedBy = rack.updated_by;
      this.rack.updatedAt = rack.updated_at;
      this.rack.roomId = rack.room_id;
    },
    /**
     * Delete rack
     * @param {Number} id Rack id
     * @param {String} name Rack name
     */
    async deleteRack(id, name) {
      if (confirm(`Do you really want to delete rack ${name} and all related items?`)) {
				const response = await deleteObject('rack', this.$route.params.id);
				if (response.status === RESPONSE_STATUS.NO_CONTENT) {
					this.messageProps.success = true;
					this.messageProps.message = `Rack ${id} deleted successfully`;
					alert(this.messageProps.message);
					this.$router.push('/tree');
				} else {
					this.messageProps.success = false;
					this.messageProps.message = getResponseMessage(response);
				}
      }
    },
    /**
     * Fetch and set rack location
     */
    async setRackLocation() {
			const response = await getObjectLocation('rack', this.$route.params.id);
			logIfNotStatus(response, RESPONSE_STATUS.OK, 'Unexpected response!');
			const location = response.data.data;
      this.location.roomName = location.room_name;
      this.location.buildingName = location.building_name;
      this.location.siteName = location.site_name;
      this.location.departmentName = location.department_name;
      this.location.regionName = location.region_name;
    },
  }
}
</script>
