<template>
  <div v-bind="{
    buildingId: buildingId,
    buildingName: buildingName,
    isOpen: isOpen
  }">
    <span 
      :class="getCaretClass(isOpen)" 
      :id="getId(buildingName)"
    >
      {{ truncate(buildingName, 50) }}
      <router-link
        :to="{path: `/room/create/${buildingId}`}" 
        target="_blank"
      >
        <button
          :id="getId(buildingName, 'add', 'button')"
          class="text-white font-light bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small rounded-lg text-xs 
          px-5 py-0.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
        >
          Add room
        </button>
      </router-link>
      <router-link 
        :to="{path: `/building/${buildingId}/update`}" 
        target="_blank">
        <button 
          class="text-white font-light bg-blue-400 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small rounded-lg text-xs 
          px-5 py-0.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
        >
          Edit
        </button>
      </router-link>
      <button
        class="text-white font-light bg-blue-400 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small rounded-lg text-xs 
        px-5 py-0.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" 
        v-on:click="deleteItem(buildingId, buildingName, 'building')"
      >
        Delete
      </button>
    </span>
  </div>
</template>
  
<script>
import { getCaretClass, getId } from '@/functions'
import { truncate } from '@/filters'

export default {
  name: 'BuildingTreeItem',
  props: {
    buildingId: Number,
    buildingName: String,
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