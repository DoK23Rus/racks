<template>
  <div v-bind="{
      name: name,
      isOpen: isOpen
    }"
  >
    <span 
      :class="getCaretClass(isOpen)" 
      :id="getId(name)"
    >
      {{truncate(name, truncationLength.DEFAULT)}}
    </span>
  </div>
</template>

<script>
import {getCaretClass, getId} from '@/functions'
import {truncate} from '@/filters'
import {TRUNCATION_LENGTH} from "@/constants";

export default {
  name: 'RegionTreeItem',
  data () {
    return {
      truncationLength: TRUNCATION_LENGTH
    }
  },
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