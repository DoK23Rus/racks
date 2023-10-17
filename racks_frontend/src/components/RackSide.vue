<template>
  <table
    v-bind="{
      side: side,
      devices: devices,
      firstUnits: firstUnits,
      rowSpans: rowSpans,
      startList: startList
    }"
    class='table-fixed rounded-t-lg drop-shadow-2xl font-sans mx-auto max-w-2xl w-full whitespace-nowrap
    bg-white divide-y divide-gray-300 overflow-hidden text-sm tracking-tight'>
    <thead class="bg-gray-500">
      <tr class="text-white text-center">
        <th class="font-semibold text-sm uppercase px-6 py-4 w-4">
          {{ side }}
        </th>
        <th class="font-semibold text-sm uppercase px-6 py-4 w-35"></th>
        <th class="font-semibold text-sm uppercase px-6 py-4 w-8"></th>
      </tr>
    </thead>
      <tbody class="divide-y-2 divide-gray-300">
      <template v-for="list in startList">
      <tr>
        <td class="px-4 py-2 text-black">
          {{ list }}
        </td>
        <template v-for="device in devices">
          <template v-for="(first_unit, device_number) in firstUnits">
            <template v-if="first_unit == list">
              <template v-if="device_number == device.id">
                <template v-for="(rowspan, device_id) in rowSpans">
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
</template>

<script>
import Unit from '@/components/Unit.vue';

export default {
  name: 'RackSide',
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
  }
}
</script>