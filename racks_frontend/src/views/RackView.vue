<template>
  <div class="container px-4 mx-auto  justify-between text-xl pl-8 pt-4 font-sans font-light">
    <div class="container px-4 mx-auto justify-between pl-8 font-sans font-light text-xl">
      <TheMessage :messageProps="messageProps" />
    </div>
    Rack №{{ rack.id }}
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
        {{ location.regionName }} &#9002; {{ location.departmentName }} &#9002; 
        {{ location.siteName }} &#9002; {{ location.buildingName }} &#9002; {{ location.roomName }}
      </div>
  <div class="text-base">
      Rack name: 
        <text class="text-slate-500">
          {{ rack.name }}
        </text>
    <br>
      Responsible: 
        <text class="text-slate-500">
          {{ rack.responsible }}
        </text>
    <br>
      Row: 
        <text class="text-slate-500">
          {{ rack.row }}
        </text>
    <br>
      Place: 
        <text class="text-slate-500">
          {{ rack.place }}
        </text>
    <br>
      Description: 
        <text class="text-slate-500">
          {{ rack.description }}
        </text>
    <br>
      Inventory number: 
        <text class="text-slate-500">
          {{ rack.inventoryNumber }}
        </text>
    <br>
      Financially responsible: 
        <text class="text-slate-500">
          {{ rack.financiallyResponsiblePerson }}
        </text>
    <br>
      Fixed asset: 
        <text class="text-slate-500">
          {{ rack.fixedAsset }}
        </text>
    <br>
      <template v-if="rack.link">
        Link to docs: 
        <a 
          class="text-slate-500" 
          v-bind:href="rack.link"
        >
          <text class="text-blue-300">
            &#9873; 
          </text>
          {{ rack.link }}
        </a>
      </template>
      <template v-else>
        Link to docs:
      </template>
    <br>
    <br>
      Vendor: 
        <text class="text-slate-500">
          {{ rack.vendor }}
        </text>
    <br>
      Model: 
        <text class="text-slate-500">
          {{ rack.model }}
        </text>
    <br>
      Rack amount (units): 
        <text class="text-slate-500">
          {{ rack.amount }}
        </text>
    <br>
      <template v-if="rack.numberingFromBottomToTop == true">
        Numbering: 
          <text class="text-slate-500">
            from bottom to top
          </text>
      </template>
      <template v-else>
        Numbering: 
          <text class="text-slate-500">
            from top to bottom
          </text>
      </template>
    <br>
      <template v-if="rack.height != null">
        Rack height (mm): 
          <text class="text-slate-500">
            {{ rack.height }}
          </text>
      </template>
      <template v-else>
        Rack height (mm):
      </template>
    <br>
      <template v-if="rack.width != null">
        Rack width (mm): 
          <text class="text-slate-500">
            {{ rack.width }}
          </text>
      </template>
      <template v-else>
        Rack width (mm):
      </template>
    <br>
      <template v-if="rack.depth != null">
        Rack depth (mm): 
          <text class="text-slate-500">
            {{ rack.depth }}
          </text>
      </template>
      <template v-else>
        Rack depth (mm):
      </template>
    <br>
      <template v-if="rack.unitWidth != null">
        Useful rack width (inches): 
          <text class="text-slate-500">
            {{ rack.unitWidth }}
          </text>
      </template>
      <template v-else>
        Useful rack width (inches):
      </template>
    <br>
      <template v-if="rack.unitDepth != null">
        Useful rack depth (mm): 
          <text class="text-slate-500">
            {{ rack.unitDepth }}
          </text>
      </template>
      <template v-else>
        Useful rack depth (mm):
      </template>
    <br>
      Execution variant: 
        <text class="text-slate-500">
          {{ rack.type }}
        </text>
    <br>
      Construction: 
        <text class="text-slate-500">
          {{ rack.frame }}
        </text>
    <br>
      Location type: 
        <text class="text-slate-500">
          {{ rack.placeType }}
        </text>
    <br>
      <template v-if="rack.maxLoad != null">
        Max load (kilo): 
          <text class="text-slate-500">
            {{ rack.maxLoad }}
          </text>
      </template>
      <template v-else>
        Max load (kilo):
      </template>
    <br>
      <template v-if="rack.powerSockets != null">
        Free power sockets: 
          <text class="text-slate-500">
            {{ rack.powerSockets }}
          </text>
      </template>
      <template v-else>
        Free power sockets:
      </template>
    <br>
      <template v-if="rack.powerSocketsUps != null">
        Free UPS power sockets: 
          <text class="text-slate-500">
            {{ rack.powerSocketsUps }}
          </text>
      </template>
      <template v-else>
        Free UPS power sockets:
      </template>
    <br>
      <template v-if="rack.cooler">
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
      <template v-if="rack.externalUps">
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
            {{ rack.updatedBy }}
          </text>
      <br>
        Updated at: 
          <text class="text-slate-500">
            {{ rack.updatedAt }}
          </text>
    </div>
    <br>
  </div>
  </div>
</template>

<script>
import { getObject, deleteObject } from '@/api';
import TheMessage from '@/components/TheMessage.vue';


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
        totalPowerW: null,
        updatedBy: '',
        updatedAt: ''
      },
      messageProps: {
        message: ''
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
    this.getRack();
    this.getRackLocation();
  },
  methods: {
    // Get rack data
    async getRack() {
      const response = await getObject('rack', '/rack/', this.$route.params.id);
      this.message = response
      this.rack.name = response.name;
      this.rack.amount = response.amount;
      this.rack.vendor = response.vendor;
      this.rack.model = response.model;
      this.rack.description = response.description;
      this.rack.numberingFromBottomToTop = response.mumbering_from_bottom_to_top;
      this.rack.responsible = response.responsible;
      this.rack.financiallyResponsiblePerson = response.financially_responsible_person;
      this.rack.inventoryNumber = response.inventory_number;
      this.rack.fixedAsset = response.fixed_asset;
      this.rack.link = response.link;
      this.rack.row = response.row;
      this.rack.place = response.place;
      this.rack.height = response.height;
      this.rack.width = response.width;
      this.rack.depth = response.depth;
      this.rack.unitWidth = response.unit_width;
      this.rack.unitDepth = response.unit_depth;
      this.rack.type = response.type;
      this.rack.frame = response.frame;
      this.rack.placeType = response.place_type;
      this.rack.maxLoad = response.max_load;
      this.rack.powerSockets = response.power_sockets;
      this.rack.powerSocketsUps = response.power_sockets_ups;
      this.rack.externalUps = response.external_ups;
      this.rack.cooler = response.cooler;
      this.rack.totalPowerW = response.total_power_w;
      this.rack.updatedBy = response.updated_by;
      this.rack.updatedAt = response.updated_at;
      this.rack.roomId = response.room_id;
    },
    async deleteRack(id, name) {
      const payload = {
        id: id,
      }
      if (confirm(`Do you really want to delete rack ${name} and all releated items?`)) {
        this.messageProps.message = await deleteObject('rack', `/rack/${this.$route.params.id}/delete/`, payload);
        if (this.messageProps.message.sucsess) {
          alert(this.messageProps.message.sucsess);
          this.$router.push('/tree');
        }
      }
    },
    async getRackLocation() {
      // Get rack location
      const response = await getObject('rack', '/rack/', this.$route.params.id, '/location/');
      this.location.roomName = response.room_name;
      this.location.buildingName = response.building_name;
      this.location.siteName = response.site_name;
      this.location.departmentName = response.department_name;
      this.location.regionName = response.region_name;
    },
  }
}
</script>