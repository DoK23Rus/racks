<template>
  <div v-bind="{
    id: id,
    name: name,
    isOpen: isOpen,
    deleteItem: deleteItem
  }">
    <span
      :class="getCaretClass(isOpen)"
      :id="getId(name)"
    >
      {{ truncate(name, truncationLength.DEFAULT) }}
      <router-link
        :to="{path: `/room/create/${id}`}"
        target="_blank"
      >
        <button
          :id="getId(name, 'add', 'button')"
          class="text-white font-light bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small rounded-lg text-xs
          px-5 py-0.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
        >
          Add room
        </button>
      </router-link>
      <router-link
        :to="{path: `/building/${id}/update`}"
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
        v-on:click="deleteItem(id, name, 'building')"
      >
        Delete
      </button>
    </span>
  </div>
</template>

<script>
import {getCaretClass, getId} from '@/functions'
import {truncate} from '@/filters'
import {TRUNCATION_LENGTH} from "@/constants";

export default {
  name: 'BuildingTreeItem',
	data () {
		return {
			truncationLength: TRUNCATION_LENGTH
		}
	},
  props: {
    id: Number,
    name: String,
    isOpen: Boolean,
      deleteItem: Function
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
