<template>
  <div class="min-h-screen">
    <div class="container px-4 mx-auto  justify-between text-xl pl-8 pt-4 font-sans font-light">
      Rack №{{rack.id}}
      <router-link
        :to="{path: `/device/create/${this.$route.params.id}`}"
        target="_blank"
      >
        <button
          id="e2e_add_device"
          class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small rounded-lg text-xs
          px-5 py-0.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
        >
          Add new device
        </button>
      </router-link>
      <router-link
        :to="{path: `/rack/${this.$route.params.id}`}"
        target="_blank"
      >
        <button class=" text-white bg-blue-400 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small rounded-lg text-xs
          px-5 py-0.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
          Rack info
        </button>
      </router-link>
      <br>
      <div class="text-base">
        Name: {{rack.name}}
        <br>
        Row: {{rack.row}}
        <br>
        Place: {{rack.place}}
      </div>
      <br>
      <div class="rack">
        <RackSideItem
          :side="`front side`"
          :devices="devicesFront"
          :firstUnits="firstUnitsFront"
          :rowSpans="rowSpansFront"
          :startList="startList"
        />
        <RackSideItem
          :side="`back side`"
          :devices="devicesBack"
          :firstUnits="firstUnitsBack"
          :rowSpans="rowSpansBack"
          :startList="startList"
        />
      </div>
    </div>
    <br>
  </div>
</template>

<script>
import RackSideItem from '@/components/RackSideItem.vue';
import {getObject, getObjectsForParent, logIfNotStatus} from '@/api';
import {getDevicesForSide, getFirstUnits, getRowSpans, getStartList} from '@/functions';
import {RESPONSE_STATUS} from "@/constants";


export default {
  name: 'UnitsView',
  components: {
    RackSideItem
  },
  data() {
    return {
      objectExist: true,
      devices: [],
      rack: {}
    }
  },
  created() {
    this.setDevices();
    this.setRack();
  },
  computed: {
    /**
     * Devices front side
     */
    devicesFront() {
      return this.getDevicesForSide(this.devices).front
    },
    /**
     * Devices back side
     */
    devicesBack() {
      return this.getDevicesForSide(this.devices).back
    },
    /**
     * Devices first units front side
     */
    firstUnitsFront() {
      return this.getFirstUnits(this.devicesFront, this.rack.numbering_from_top_to_bottom)
    },
    /**
     * Devices first units back side
     */
    firstUnitsBack() {
      return this.getFirstUnits(this.devicesBack, this.rack.numbering_from_top_to_bottom)
    },
    /**
     * Rowspans front side
     */
    rowSpansFront() {
      return this.getRowSpans(this.devicesFront)
    },
    /**
     * Rowsspans back side
     */
    rowSpansBack() {
      return this.getRowSpans(this.devicesBack)
    },
    /**
     * Starting units list
     */
    startList() {
      return this.getStartList(this.rack);
    }
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
      this.rack = response.data.data
    },
    /**
     * Fetch and set devices data
     */
    async setDevices() {
      const response = await getObjectsForParent('devices', 'rack', this.$route.params.id);
      logIfNotStatus(response, RESPONSE_STATUS.OK, 'Unexpected response!');
      this.devices = response.data.data
    },
    getRowSpans: getRowSpans,
    getFirstUnits: getFirstUnits,
    getStartList: getStartList,
    getDevicesForSide: getDevicesForSide
  }
}
</script>

<style>
.rack {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
}

@media screen and (max-width: 600px) {
  .rack {
    flex-direction: column;
    align-items: center;
  }
}
</style>
