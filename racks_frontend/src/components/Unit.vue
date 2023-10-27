<template>
  <td v-bind="{
      rowspan: rowspan, 
      id: id, 
      vendor: vendor, 
      model: model,
      type: type,
      className: className
    }"
    :class="className"
    :rowspan="rowspan"
  >
    <router-link
      :to="{path: `/device/${id}`}"
      target="_blank"
    >
      <template v-if="vendor || model">
        <a>
          {{truncate(`${vendor} ${model}`, 30)}}
        </a>
      </template>
      <template v-else>
        {{ truncate(type, 30) }}
      </template>
    </router-link>    
  </td>
  <td 
    v-bind="{
      rowspan: rowspan,
      id: id
    }"
    class="text-center"
    :rowspan="rowspan"
  >
    <router-link
      :to="{path: `/device/${id}`}"
      target="_blank"
    >
      <a>
        №{{ id }}
      </a>
    </router-link> 
  </td>
</template>

<script>
import { truncate } from '@/filters'


export default {
  name: 'Unit',
  inheritAttrs: false,
  props: {
    vendor: {
      type: String,
      default: ''
    },
    model: {
      type: String,
      default: ''
    },
    type: {
      type: String,
      default: ''
    },
    id: {
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