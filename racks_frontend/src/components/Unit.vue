<template>
  <td v-bind="{
    rowspan: rowspan, 
    deviceId: deviceId, 
    deviceVendor: deviceVendor, 
    deviceModel: deviceModel,
    deviceType: deviceType,
    className: className
    }" :class="className" :rowspan="rowspan">
    <router-link  :to="{path: '/device/' + deviceId}" target="_blank">
      <template v-if="deviceVendor || deviceModel">
        <a >{{truncate(`${deviceVendor} ${deviceModel}`, 30)}}</a>
      </template>
      <template v-else>
        {{ truncate(deviceType, 30) }}
      </template>
    </router-link>    
  </td>
  <td v-bind="{
    rowspan: rowspan,
    deviceId: deviceId
    }" class="text-center" :rowspan="rowspan">
    <router-link :to="{path: '/device/' + deviceId}" target="_blank">
      <a>№{{ deviceId }}</a>
    </router-link> 
  </td>
</template>

<script>
import { truncate } from '@/filters'


export default {
  name: 'Unit',
  inheritAttrs: false,
  props: {
    deviceVendor: {
      type: String,
      default: ''
    },
    deviceModel: {
      type: String,
      default: ''
    },
    deviceType: {
      type: String,
      default: ''
    },
    deviceId: {
      type: Number,
      default: null
    },
    className: {
      type: String,
      default: ''
    },
    rowspan: {
      type: Number,
      default: null
    },
  },
  methods: {
    truncate: truncate
  }
}
</script>