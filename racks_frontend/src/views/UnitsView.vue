<template>
  <div class="min-h-screen">
    <div class="container px-4 mx-auto  justify-between text-xl pl-8 pt-4 font-sans font-light">
      Rack №{{ rack.id }}
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
          Name: {{ rack.rack_name }} 
        <br>
          Row: {{ rack.row }}
        <br>
          Place: {{ rack.place }}
      </div>
    </div>
    <br>
    <RackSideItem
      :side="`front side`"
      :devices="devicesFront"
      :firstUnits="firstUnitsFront"
      :rowSpans="rowSpansFront"
      :startList="startList"
    />
    <br>
    <br>
    <RackSideItem
      :side="`back side`"
      :devices="devicesBack"
      :firstUnits="firstUnitsBack"
      :rowSpans="rowSpansBack"
      :startList="startList"
    />
    <br>
    <br>
  </div>
</template>

<script>
import { getObject } from '@/api';
import RackSideItem from '@/components/RackSideItem.vue';
import { getRowSpans, getFirstUnits, getStartList, getDevicesForSide } from '@/functions';


export default {
  name: 'UnitsView',
  components: {
    RackSideItem
  },
  data() {
    return {
      rack: [],
      devices: []
    }
  },
  created () {
    this.setRack();
    this.setDevices();
  },
  computed: {
    devicesFront() {
      return this.getDevicesForSide(this.devices).front
    },
    devicesBack() { 
      return this.getDevicesForSide(this.devices).back
    },
    firstUnitsFront() {
      return this.getFirstUnits(this.devicesFront, this.rack.numbering_from_bottom_to_top)
    },
    firstUnitsBack() {
      return this.getFirstUnits(this.devicesBack, this.rack.numbering_from_bottom_to_top)
    },
    rowSpansFront() {
      return this.getRowSpans(this.devicesFront)
    },
    rowSpansBack() {
      return this.getRowSpans(this.devicesBack)
    },
    startList() {
      return this.getStartList(this.rack);
    }
  },
  methods: {
    async setRack() {
      this.rack = await getObject('rack', '/rack/', this.$route.params.id);
    },
    async setDevices() {
      this.devices = await getObject('devices', '/rack/', this.$route.params.id, '/devices');
    },
    getRowSpans: getRowSpans,
    getFirstUnits: getFirstUnits,
    getStartList: getStartList,
    getDevicesForSide: getDevicesForSide
  }
}
</script>
