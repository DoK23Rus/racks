<template>
  <table
    v-bind="{
      side: side,
      devices: devices,
      firstUnits: firstUnits,
      rowSpans: rowSpans,
      startList: startList
    }"
    class='side table-fixed rounded-t-lg drop-shadow-2xl font-sans mx-auto max-w-2xl w-full whitespace-nowrap
    bg-white divide-y divide-gray-300 overflow-hidden text-sm tracking-tight'>
    <thead class="bg-gray-500">
      <tr class="text-white text-center">
        <th class="font-semibold text-sm uppercase px-6 py-4 w-4">
          {{side}}
        </th>
        <th class="font-semibold text-sm uppercase px-6 py-4 w-35"></th>
        <th class="font-semibold text-sm uppercase px-6 py-4 w-8"></th>
      </tr>
    </thead>
    <tbody class="divide-y-2 divide-gray-300">
      <template v-for="list in startList">
        <tr>
          <td class="px-4 py-2 text-black">
            {{list}}
          </td>
          <template v-for="device in devices">
            <template v-for="(firstUnit, deviceNumber) in firstUnits">
              <template v-if="firstUnit === list">
                <template v-if="keyToInt(deviceNumber) === device.id">
                  <template v-for="(rowspan, deviceId) in rowSpans">
                    <template v-if="keyToInt(deviceId) === device.id">
                      <template v-if="device.status === deviceStatus.ACTIVE">
                        <template v-if="device.ownership === deviceOwnership.OUR">
                          <Unit
                            :className="`text-center text-white ${classNameOur}`"
                            :vendor="device.vendor"
                            :model="device.model"
                            :id="device.id"
                            :type="device.type"
                            :rowspan="rowspan"
                          />
                        </template>
                        <template v-else>
                          <Unit
                            :className="`text-center text-white ${classNameAlien}`"
                            :vendor="device.vendor"
                            :model="device.model"
                            :id="device.id"
                            :type="device.type"
                            :rowspan="rowspan"
                          />
                        </template>
                      </template>
                      <template v-else>
                        <template v-if="device.ownership === deviceOwnership.OUR">
                          <Unit
                            :className="`text-center text-white ${classNameEmpty} ${classNameOur}`"
                            :vendor="device.vendor"
                            :model="device.model"
                            :id="device.id"
                            :type="device.type"
                            :rowspan="rowspan"
                          />
                        </template>
                        <template v-else>
                          <Unit
                            :className="`text-center text-white ${classNameAlien} ${classNameEmpty}`"
                            :vendor="device.vendor"
                            :model="device.model"
                            :id="device.id"
                            :type="device.type"
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
</template>

<script>
import Unit from '@/components/Unit.vue';
import {DEVICE_OWNERSHIP, DEVICE_STATUS} from "@/constants";

export default {
  name: 'RackSideItem',
  data () {
    return {
      deviceOwnership: DEVICE_OWNERSHIP,
      deviceStatus: DEVICE_STATUS
    }
  },
  components: {
    Unit
  },
  inheritAttrs: false,
  props: {
    side: {
      type: String,
      default: ''
    },
    devices: {
      type: Array,
      default: []
    },
    firstUnits: {
      type: Object,
      default: {}
    },
    rowSpans: {
      type: Object,
      default: {}
    },
    startList: {
      type: Array,
      default: []
    },
    classNameOur: {
      type: String,
      default: 'bg-blue-600'
    },
    classNameAlien: {
      type: String,
      default: 'bg-blue-400'
    },
    classNameEmpty: {
      type: String,
      default: 'line-through'
    },
  },
  methods: {
    keyToInt(value) {
      return parseInt(value)
    }
  }
}
</script>

<style>
.side {
  margin: 1rem;
}
</style>
