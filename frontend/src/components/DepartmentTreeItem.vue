<template>
  <div v-bind="{
    id: id,
    name: name,
    isOpen: isOpen
  }">
    <span 
      :class="getCaretClass(isOpen)" 
      :id="getId(name)"
    >
      {{ truncate(name, truncationLength.DEFAULT) }}
      <router-link 
        :to="{path: `/site/create/${id}`}" 
        target="_blank"
      >
        <button 
          :id="getId(name, 'add', 'button')"
          type="button" 
          class="text-white font-light bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small rounded-lg text-xs 
          px-5 py-0.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
        >
          Add site
        </button>
      </router-link>
    </span>
  </div>
</template>

<script>
import {getCaretClass, getId} from '@/functions'
import {truncate} from '@/filters'
import {TRUNCATION_LENGTH} from "@/constants";

export default {
  name: 'DepartmentTreeItem',
	data () {
		return {
			truncationLength: TRUNCATION_LENGTH
		}
	},
  props: {
    id: Number,
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