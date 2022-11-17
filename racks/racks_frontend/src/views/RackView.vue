<template>
  <div class="container px-4 mx-auto  justify-between text-xl pl-8 pt-4 font-sans font-light">
    <div class="container px-4 mx-auto justify-between pl-8 font-sans font-light text-xl">
      <Message :messageProps="messageProps" />
    </div>
    Rack №{{ rack.id }}
    <router-link :to="{path: '/rack_upd/' + rack.id}" target="_blank">
      <button class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small rounded-lg text-xs 
        px-5 py-0.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
        Edit
      </button>
    </router-link>
    <button class="text-white bg-blue-400 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small rounded-lg text-xs 
      px-5 py-0.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" 
      @click="deleteRack(rack.id, rack.rackName)">
      Delete
    </button>
  <div class="text-base">
      Rack name: <text class="text-slate-500">{{ rack.rackName }}</text>
    <br>
      Responsible: <text class="text-slate-500">{{ rack.responsible }}</text>
    <br>
      Row: <text class="text-slate-500">{{ rack.row }}</text>
    <br>
      Place: <text class="text-slate-500">{{ rack.place }}</text>
    <br>
      Description: <text class="text-slate-500">{{ rack.rackDescription }}</text>
    <br>
      Inventory number: <text class="text-slate-500">{{ rack.rackInventoryNumber }}</text>
    <br>
      Financially responsible: <text class="text-slate-500">{{ rack.rackFinanciallyResponsiblePerson }}</text>
    <br>
      Fixed asset: <text class="text-slate-500">{{ rack.fixedAsset }}</text>
    <br>
      <template v-if="rack.link">
        Link to docs: 
        <a class="text-slate-500" href="{{ rack.link }}">
          <text class="text-blue-300">&#9873; </text>
          {{ rack.link }}
        </a>
      </template>
      <template v-else>
        Link to docs:
      </template>
    <br>
    <br>
      Vendor: <text class="text-slate-500">{{ rack.rackVendor }}</text>
    <br>
      Model: <text class="text-slate-500">{{ rack.rackModel }}</text>
    <br>
      Rack amount (units): <text class="text-slate-500">{{ rack.rackAmount }}</text>
    <br>
      <template v-if="rack.numberingFromBottomToTop == true">
        Numbering: <text class="text-slate-500">from bottom to top</text>
      </template>
      <template v-else>
        Numbering: <text class="text-slate-500">from top to bottom</text>
      </template>
    <br>
      <template v-if="rack.rackHeight != null">
        Rack height (mm): <text class="text-slate-500">{{ rack.rackHeight }}</text>
      </template>
      <template v-else>
        Rack height (mm):
      </template>
    <br>
      <template v-if="rack.rackWidth != null">
        Rack width (mm): <text class="text-slate-500">{{ rack.rackWidth }}</text>
      </template>
      <template v-else>
        Rack width (mm):
      </template>
    <br>
      <template v-if="rack.rackDepth != null">
        Rack depth (mm): <text class="text-slate-500">{{ rack.rackDepth }}</text>
      </template>
      <template v-else>
        Rack depth (mm):
      </template>
    <br>
      <template v-if="rack.rackUnitWidth != null">
        Useful rack width (inches): <text class="text-slate-500">{{ rack.rackUnitWidth }}</text>
      </template>
      <template v-else>
        Useful rack width (inches):
      </template>
    <br>
      <template v-if="rack.rackUnitDepth != null">
        Useful rack depth (mm): <text class="text-slate-500">{{ rack.rackUnitDepth }}</text>
      </template>
      <template v-else>
        Useful rack depth (mm):
      </template>
    <br>
      Execution variant: <text class="text-slate-500">{{ rack.rackType }}</text>
    <br>
      Construction: <text class="text-slate-500">{{ rack.rackFrame }}</text>
    <br>
      Location type: <text class="text-slate-500">{{ rack.rackPalceType }}</text>
    <br>
      <template v-if="rack.maxLoad != null">
        Max load (kilo): <text class="text-slate-500">{{ rack.maxLoad }}</text>
      </template>
      <template v-else>
        Max load (kilo):
      </template>
    <br>
      <template v-if="rack.powerSockets != null">
        Free power sockets: <text class="text-slate-500">{{ rack.powerSockets }}</text>
      </template>
      <template v-else>
        Free power sockets:
      </template>
    <br>
      <template v-if="rack.powerSocketsUps != null">
        Free UPS power sockets: <text class="text-slate-500">{{ rack.powerSocketsUps }}</text>
      </template>
      <template v-else>
        Free UPS power sockets:
      </template>
    <br>
      <template v-if="rack.cooler">
        Active ventilation: <text class="text-slate-500">Yes</text>
      </template>
      <template v-else>
        Active ventilation: <text class="text-slate-500">No</text>
      </template>
    <br>
      <template v-if="rack.externalUps">
        External power backup supply system: <text class="text-slate-500">Yes</text>
      </template>
      <template v-else>
        External power backup supply system: <text class="text-slate-500">No</text>
      </template>
    <br>
      TOTAL power consumption: <text class="text-slate-500">{{ rack.totalPowerW }}</text>
    <br>
    <br>
      Room: <text class="text-slate-500">{{ rack.roomName }}</text>
    <br>
      Building: <text class="text-slate-500">{{ rack.buildingName }}</text>
    <br>
      Site: <text class="text-slate-500">{{ rack.siteName }}</text>
    <br>
      Department: <text class="text-slate-500">{{ rack.departmentName }}</text>
    <br>
      Region: <text class="text-slate-500">{{ rack.regionName }}</text>
    <br>
    <br>
    <div class="text-xs">
        Updated by: {{ rack.updatedBy }}
      <br>
        Updated at: {{ rack.updatedAt }}
    </div>
  </div>
  </div>
</template>

<script>
import { getObject, deleteObject } from '@/api';


export default {
  name: 'RackView',
  data() {
    return {
      rack: {
        id: this.$route.params.id,
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
        totalPowerW: null,
        updatedBy: '',
        updatedAt: '',
        roomName: '',
        buildingName: '',
        siteName: '',
        departmentName: '',
        regionName: ''
      },
      messageProps: {
        message: ''
      },
    }
  },
  mounted() {
    this.getRack();
  },
  methods: {
    // Get rack data
    async getRack() {
      const response = await getObject('rack', '/rack/', this.$route.params.id);
      this.message = response
      this.rack.rackName = response.rack_name;
      this.rack.rackAmount = response.rack_amount;
      this.rack.rackVendor = response.rack_vendor;
      this.rack.rackModel = response.rack_model;
      this.rack.rackDescription = response.rack_description;
      this.rack.numberingFromBottomToTop = response.mumbering_from_bottom_to_top;
      this.rack.responsible = response.responsible;
      this.rack.rackFinanciallyResponsiblePerson = response.rack_financially_responsible_person;
      this.rack.rackInventoryNumber = response.rack_inventory_number;
      this.rack.fixedAsset = response.fixed_asset;
      this.rack.link = response.link;
      this.rack.row = response.row;
      this.rack.place = response.place;
      this.rack.rackHeight = response.rack_height;
      this.rack.rackWidth = response.rack_width;
      this.rack.rackDepth = response.rack_depth;
      this.rack.rackUnitWidth = response.rack_unit_width;
      this.rack.rackUnitDepth = response.rack_unit_depth;
      this.rack.rackType = response.rack_type;
      this.rack.rackFrame = response.rack_frame;
      this.rack.rackPalceType = response.rack_palce_type;
      this.rack.maxLoad = response.max_load;
      this.rack.powerSockets = response.power_sockets;
      this.rack.powerSocketsUps = response.power_sockets_ups;
      this.rack.externalUps = response.external_ups;
      this.rack.cooler = response.cooler;
      this.rack.totalPowerW = response.total_power_w;
      this.rack.updatedBy = response.updated_by;
      this.rack.updatedAt = response.updated_at;
      this.rack.roomId = response.room_id;
      this.rack.roomName = response.room_name;
      this.rack.buildingName = response.building_name;
      this.rack.siteName = response.site_name;
      this.rack.departmentName = response.department_name;
      this.rack.regionName = response.region_name;
    },
    async deleteRack(id, rackName) {
      const payload = {
        id: id,
      }
      if (confirm(`Do you really want to delete rack ${rackName} and all releated items?`)) {
        this.messageProps.message = await deleteObject('rack', '/rack_del', payload);
        if (this.messageProps.message.sucsess) {
          alert(this.messageProps.message.sucsess);
          this.$router.push('/tree');
        }
      }
    },
  }
}
</script>