<template>
  <div class="min-h-screen">
    <div class="container px-4 mx-auto  justify-between text-xl pl-8 pt-4 font-sans font-light">
      Rack №{{ rack.id }}
      <router-link
        :to="{path: '/device/create/' + this.$route.params.id}"
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
        :to="{path: '/rack/' + this.$route.params.id}"
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
    <RackSide
      :side="`front side`"
      :devices="this.devicesFront"
      :firstUnits="this.firstUnitsFront"
      :rowSpans="this.rowSpansFront"
      :startList="this.startList"
    />
    <br>
    <br>
    <RackSide
      :side="`back side`"
      :devices="this.devicesBack"
      :firstUnits="this.firstUnitsBack"
      :rowSpans="this.rowSpansBack"
      :startList="this.startList"
    />
    <br>
  </div>
</template>

<script>
import { getObject } from '@/api';
import RackSide from '@/components/RackSide.vue';


export default {
  name: 'UnitsView',
  components: {
    RackSide
  },
  data() {
    return {
      rack: [],
      startList: [],
      devicesFront: [],
      devicesBack: [],
      firstUnitsFront: {},
      firstUnitsBack: {},
      rowSpansFront: [],
      rowSpansBack: []
    }
  },
  created () {
    this.setRackData();
    this.setDevicesData();
  },
  methods: {
    async setRackData() {
      this.rack = await getObject('rack', '/rack/', this.$route.params.id);
      this.startList = this.setStartList()
    },
    async setDevicesData() {
      const devices = await getObject('devices', '/rack/', this.$route.params.id, '/devices');
      this.setDevicesForSide(devices)
      this.firstUnitsFront = this.firstUnits(this.devicesFront)
      this.firstUnitsBack = this.firstUnits(this.devicesBack)
      this.rowSpansFront = this.rowSpans(this.devicesFront)
      this.rowSpansBack = this.rowSpans(this.devicesBack)
    },
    setDevicesForSide(devices) {
      // Devices for side
      devices.forEach((device) => {
          if (!device.frontside_location) {
            this.devicesBack.push(device);
          }
          this.devicesFront.push(device);
      });
    },
    setStartList() {
      // List of rack units
      const arr = Array.from({length: this.rack.rack_amount}, (_, i) => i + 1);
      if (!this.rack.numbering_from_bottom_to_top) {
        return arr;
      } else {
        return arr.reverse();
      };
    },
    firstUnits(devices) {
      // Devices first units
      let firstUnits = {};
      for (const device of devices) {
        let lastUnit = device.last_unit;
        let firstUnit = device.first_unit;
        if (this.rack.numbering_from_bottom_to_top) {
          if (lastUnit > firstUnit) {
            firstUnit = device.last_unit;
          }
          firstUnits[device.id] = firstUnit;
        } else {
          if (lastUnit < firstUnit) {
            firstUnit = device.last_unit;
          }
          firstUnits[device.id] = firstUnit;
        }
      }
      return firstUnits;
    },
    rowSpans(devices) {
      // Rowspans for each device
      let rowSpans = {};
      for (const device of devices) {
        let lastUnit = device.last_unit;
        let firstUnit = device.first_unit;
        if (lastUnit < firstUnit) {
          firstUnit = device.last_unit;
          lastUnit = device.first_unit;
        }
        rowSpans[device.id] = lastUnit - firstUnit + 1;
      }
      return rowSpans;
    },
  }
}
</script>
