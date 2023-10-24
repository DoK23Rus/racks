<template>
  <div v-bind="{
    departmentId: departmentId,
    departmentName: departmentName,
    isOpen: isOpen
  }">
    <span 
      :class="getCaretClass(isOpen)" 
      :id="getId(departmentName)"
    >
      {{ truncate(departmentName, 50) }}
      <router-link 
        :to="{path: `/site/create/${departmentId}`}" 
        target="_blank"
      >
        <button 
          :id="getId(departmentName, 'add', 'button')"
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
import { getCaretClass, getId } from '@/functions'
import { truncate } from '@/filters'

export default {
  name: 'DepartmentTreeItem',
  props: {
    departmentId: Number,
    departmentName: String,
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