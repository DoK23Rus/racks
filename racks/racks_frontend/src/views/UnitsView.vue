<template>
  <div class="min-h-screen">
    <div class="container px-4 mx-auto  justify-between text-xl pl-8 pt-4 font-sans font-light">
      Rack №{{ rack.id }}
      <router-link :to="{path: '/device_add/' + this.$route.params.id}" target="_blank">
        <button id="e2e_add_device" class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small rounded-lg text-xs 
          px-5 py-0.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
          Add new device
        </button>
      </router-link>
      <router-link :to="{path: '/rack/' + this.$route.params.id}" target="_blank">
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
    <table class='table-fixed rounded-t-lg drop-shadow-2xl font-sans mx-auto max-w-2xl w-full whitespace-nowrap
     bg-white divide-y divide-gray-300 overflow-hidden text-sm tracking-tight'>
      <thead class="bg-gray-500">
        <tr class="text-white text-center">
          <th class="font-semibold text-sm uppercase px-6 py-4 w-4">front side</th>
          <th class="font-semibold text-sm uppercase px-6 py-4 w-35"></th>
          <th class="font-semibold text-sm uppercase px-6 py-4 w-8"></th>
        </tr>
      </thead>
        <tbody class="divide-y-2 divide-gray-300">
        <template v-for="list in startList">
        <tr>
          <td class="px-4 py-2 text-black">{{ list }}</td>
          <template v-for="device in devicesFront">
            <template v-for="(first_unit, device_number) in firstUnitsFront">
              <template v-if="first_unit == list">
                <template v-if="device_number == device.id">
                  <template v-for="(rowspan, device_id) in rowSpansFront">
                    <template v-if="device_id == device.id">
                      <template v-if="device.status == 'Device active'">
                        <template v-if="device.ownership == 'Our department'">
                          <Unit
                            :className="`text-center text-white ${classNameOur}`"
                            :deviceVendor="device.device_vendor"
                            :deviceModel="device.device_model"
                            :deviceId="device.id"
                            :deviceType="device.device_type"
                            :rowspan="rowspan"
                          />
                        </template>
                        <template v-else>
                          <Unit
                            :className="`text-center text-white ${classNameAlien}`"
                            :deviceVendor="device.device_vendor"
                            :deviceModel="device.device_model"
                            :deviceId="device.id"
                            :deviceType="device.device_type"
                            :rowspan="rowspan"
                          />
                        </template>
                      </template>
                      <template v-else>
                        <template v-if="device.ownership == 'Our department'">
                          <Unit
                            :className="`text-center text-white ${classNameEmpty} ${classNameOur}`"
                            :deviceVendor="device.device_vendor"
                            :deviceModel="device.device_model"
                            :deviceId="device.id"
                            :deviceType="device.device_type"
                            :rowspan="rowspan"
                          />
                        </template>
                        <template v-else>
                          <Unit
                            :className="`text-center text-white ${classNameAlien} ${classNameEmpty}`"
                            :deviceVendor="device.device_vendor"
                            :deviceModel="device.device_model"
                            :deviceId="device.id"
                            :deviceType="device.device_type"
                            :rowspan="rowspan"
                          />
                        </template>
                      </template>
                    </template>
                  </template>
                </template>
              </template>
            </template>
          </template>
        </tr>
        </template>
      </tbody>
    </table>
    <br>
    <br>
    <table class='table-fixed rounded-t-lg drop-shadow-2xl font-sans mx-auto max-w-2xl w-full whitespace-nowrap
      bg-white divide-y divide-gray-300 overflow-hidden text-sm tracking-tight'>
      <thead class="bg-gray-500">
        <tr class="text-white text-center">
          <th class="font-semibold text-sm uppercase px-6 py-4 w-4">back side</th>
          <th class="font-semibold text-sm uppercase px-6 py-4 w-35"></th>
          <th class="font-semibold text-sm uppercase px-6 py-4 w-8"></th>
        </tr>
      </thead>
        <tbody class="divide-y-2 divide-gray-300">
        <template v-for="list in startList">
        <tr>
          <td class="px-4 py-2 text-black">{{ list }}</td>
          <template v-for="device in devicesBack">
            <template v-for="(first_unit, device_number) in firstUnitsBack">
              <template v-if="first_unit == list">
                <template v-if="device_number == device.id">
                  <template v-for="(rowspan, device_id) in rowSpansBack">
                    <template v-if="device_id == device.id">
                      <template v-if="device.status == 'Device active'">
                        <template v-if="device.ownership == 'Our department'">
                          <Unit
                            :className="`text-center text-white ${classNameOur}`"
                            :deviceVendor="device.device_vendor"
                            :deviceModel="device.device_model"
                            :deviceId="device.id"
                            :deviceType="device.device_type"
                            :rowspan="rowspan"
                          />
                        </template>
                        <template v-else>
                          <Unit
                            :className="`text-center text-white ${classNameAlien}`"
                            :deviceVendor="device.device_vendor"
                            :deviceModel="device.device_model"
                            :deviceId="device.id"
                            :deviceType="device.device_type"
                            :rowspan="rowspan"
                          />
                        </template>
                      </template>
                      <template v-else>
                        <template v-if="device.ownership == 'Our department'">
                          <Unit
                            :className="`text-center text-white ${classNameEmpty} ${classNameOur}`"
                            :deviceVendor="device.device_vendor"
                            :deviceModel="device.device_model"
                            :deviceId="device.id"
                            :deviceType="device.device_type"
                            :rowspan="rowspan"
                          />
                        </template>
                        <template v-else>
                          <Unit
                            :className="`text-center text-white ${classNameAlien} ${classNameEmpty}`"
                            :deviceVendor="device.device_vendor"
                            :deviceModel="device.device_model"
                            :deviceId="device.id"
                            :deviceType="device.device_type"
                            :rowspan="rowspan"
                          />
                        </template>
                      </template>
                    </template>
                  </template>
                </template>
              </template>
            </template>
          </template>
        </tr>
        </template>
      </tbody>
    </table>
    <br>
  </div>
</template>

<script>
import { getObject } from '@/api';
import Unit from '@/components/Unit.vue';


export default {
  name: 'UnitsView',
  components: {
    Unit
  },
  data() {
    return {
      devices: [],
      rack: [],
      classNameOur: 'bg-blue-600',
      classNameAlien: 'bg-blue-400',
      classNameEmpty: 'line-through'
    }
  },
  created () {
    this.setDevices();
    this.setRack();
  },
  computed: {
    startList() {
      // List of rack units
      const arr = Array.from({length: this.rack.rack_amount}, (_, i) => i + 1);
      if (!this.rack.numbering_from_bottom_to_top) {
        return arr;
      } else {
        return arr.reverse();
      };
    },
    devicesFront() {
      // Devices for front side
      let devicesFront = [];
      this.devices.forEach((device) => {
          if (device.frontside_location) {
            devicesFront.push(device);
          }
      })
      return devicesFront 
    },
    devicesBack() {
      // Devices for back side
      let devicesBack = [];
      this.devices.forEach((device) => {
          if (!device.frontside_location) {
            devicesBack.push(device);
          }
      });
      return devicesBack;
    },
    firstUnitsFront() {
      // First units for front side devices
      return this.firstUnits(this.devicesFront);
    },
    firstUnitsBack() {
      // First units for back side devices
      return this.firstUnits(this.devicesBack);
    },
    rowSpansFront() {
      // Rowspans for devices (front)
      return this.rowSpans(this.devicesFront);
    },
    rowSpansBack() {
      // Rowspans for devices (back)
      return this.rowSpans(this.devicesBack);
    }
  },
  methods: {
    async setDevices() {
      this.devices = await getObject('devices', '/rack_devices/', this.$route.params.id);
    },
    async setRack() {
      this.rack = await getObject('rack', '/rack_detail/', this.$route.params.id);
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
