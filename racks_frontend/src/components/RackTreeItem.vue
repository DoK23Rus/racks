<template>
  <div v-bind="{
    rackId: rackId,
    rackName: rackName,
    isOpen: isOpen
  }">
    <span>
      <router-link
        :to="{path: `/units/${rackId}`}"
        target="_blank"
      >
        <text class="text-blue-300">
          &#9873;
        </text>
        <a 
          :id="getId(rackName)"
          class="group transition duration-300"
        >
          {{ truncate(rackName, 40) }}
          <span class="block max-w-0 group-hover:max-w-full transition-all duration-500 h-1 bg-blue-500"></span>
        </a>
      </router-link>
    </span>
  </div>
</template>
    
<script>
import { getId } from '@/functions'
import { truncate } from '@/filters'

export default {
  name: 'RackTreeItem',
  props: {
    rackId: Number,
    rackName: String,
    isOpen: Boolean
  },
  methods: {
    getId: getId,
    truncate: truncate
  }
}
</script>

<style scoped>
  @import '@/css/tree.css';
</style>