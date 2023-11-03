<template>
  <div v-bind="{
    name: name,
    isOpen: isOpen
  }">
    <span 
      :class="getCaretClass(isOpen)" 
      :id="getId(name)"
    >
      {{ truncate(name, 50) }}
    </span>
  </div>
</template>

<script>
import { getCaretClass, getId } from '@/functions'
import { truncate } from '@/filters'

export default {
  name: 'RegionTreeItem',
  props: {
    name: String,
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