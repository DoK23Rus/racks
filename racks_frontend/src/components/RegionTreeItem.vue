<template>
  <div v-bind="{
    regionName: regionName,
    isOpen: isOpen
  }">
    <span 
      :class="getCaretClass(isOpen)" 
      :id="getId(regionName)"
    >
      {{ truncate(regionName, 50) }}
    </span>
  </div>
</template>

<script>
import { getCaretClass, getId } from '@/functions'
import { truncate } from '@/filters'

export default {
  name: 'RegionTreeItem',
  props: {
    regionName: String,
    isOpen: Boolean
  },
  methods: {
    getCaretClass: getCaretClass,
    getId: getId,
    truncate: truncate
  }
}
</script>

<style scoped>
  @import '@/css/tree.css';
</style>