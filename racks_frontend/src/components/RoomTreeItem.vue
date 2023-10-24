<template>
  <div v-bind="{
    roomId: roomId,
    roomName: roomName,
    isOpen: isOpen
  }">
    <span 
      :class="getCaretClass(isOpen)" 
      :id="getId(roomName)"
    >
      {{ truncate(roomName, 50) }}
      <router-link
        :to="{path: `/rack/create/${roomId}`}" 
        target="_blank"
      >
        <button
          :id="getId(roomName, 'add', 'button')"
          class="text-white font-light bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small rounded-lg text-xs 
          px-5 py-0.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
        >
          Add rack
        </button>
      </router-link>
      <router-link 
        :to="{path: `/room/${roomId}/update`}" 
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
        v-on:click="deleteItem(roomId, roomName, 'room')"
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
  name: 'RoomTreeItem',
  props: {
    roomId: Number,
    roomName: String,
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