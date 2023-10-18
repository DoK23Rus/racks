<template>
  <li>
    <!-- REGIONS -->
    <span 
      v-if="item.region_name"
      :class="caret()" 
      :id="setId(item.region_name)"
      v-on:click="toggle()"
    >
      {{ truncate(item.region_name, 50) }}
    </span>
    <!-- DEPARTMENTS -->
    <span 
      v-else-if="item.department_name"
      :class="caret()" 
      :id="setId(item.department_name)"
      v-on:click="toggle()"
    >
      {{ truncate(item.department_name, 50) }}
      <router-link 
        :to="{path: `/site/create/${item.id}`}" 
        target="_blank"
      >
        <button 
          :id="setId(item.department_name, 'add', 'button')"
          type="button" 
          class="text-white font-light bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small rounded-lg text-xs 
          px-5 py-0.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
        >
          Add site
        </button>
      </router-link>
    </span>
    <!-- SITES -->
    <span 
      v-else-if="item.site_name"
      :class="caret()" 
      :id="setId(item.site_name)"
      v-on:click="toggle()"
    >
      {{ truncate(item.site_name, 50) }}
      <router-link
        :to="{path: `/building/create/${item.id}`}" 
        target="_blank"
      >
        <button
          :id="setId(item.site_name, 'add', 'button')"
          class="text-white font-light bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small rounded-lg text-xs 
          px-5 py-0.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
          Add building
        </button>
      </router-link>
      <router-link 
        :to="{path: `/site/${item.id}/update`}" 
        target="_blank">
        <button 
          class="text-white font-light bg-blue-400 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small rounded-lg text-xs 
          px-5 py-0.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
          Edit
        </button>
      </router-link>
      <button
        class="text-white font-light bg-blue-400 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small rounded-lg text-xs 
        px-5 py-0.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" 
        v-on:click="deleteItem(item.id, item.site_name, 'site')"
      >
        Delete
      </button>
    </span>
    <!-- BUILDINGS -->
    <span 
      v-else-if="item.building_name"
      :class="caret()" 
      :id="setId(item.building_name)"
      v-on:click="toggle()"
    >
      {{ truncate(item.building_name, 50) }}
      <router-link
        :to="{path: `/room/create/${item.id}`}" 
        target="_blank"
      >
        <button
          :id="setId(item.building_name, 'add', 'button')"
          class="text-white font-light bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small rounded-lg text-xs 
          px-5 py-0.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
          Add room
        </button>
      </router-link>
      <router-link 
        :to="{path: `/building/${item.id}/update`}" 
        target="_blank">
        <button 
          class="text-white font-light bg-blue-400 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small rounded-lg text-xs 
          px-5 py-0.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
          Edit
        </button>
      </router-link>
      <button
        class="text-white font-light bg-blue-400 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small rounded-lg text-xs 
        px-5 py-0.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" 
        v-on:click="deleteItem(item.id, item.building_name, 'building')"
      >
        Delete
      </button>
    </span>
    <!-- ROOMS -->
    <span 
      v-else-if="item.room_name"
      :class="caret()" 
      :id="setId(item.room_name)"
      v-on:click="toggle()"
    >
      {{ truncate(item.room_name, 50) }}
      <router-link
        :to="{path: `/rack/create/${item.id}`}" 
        target="_blank"
      >
        <button
          :id="setId(item.room_name, 'add', 'button')"
          class="text-white font-light bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small rounded-lg text-xs 
          px-5 py-0.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
          Add rack
        </button>
      </router-link>
      <router-link 
        :to="{path: `/room/${item.id}/update`}" 
        target="_blank">
        <button 
          class="text-white font-light bg-blue-400 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small rounded-lg text-xs 
          px-5 py-0.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
          Edit
        </button>
      </router-link>
      <button
        class="text-white font-light bg-blue-400 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small rounded-lg text-xs 
        px-5 py-0.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" 
        v-on:click="deleteItem(item.id, item.room_name, 'room')"
      >
        Delete
      </button>
    </span>
    <!-- RACKS -->
    <span 
      v-else-if="item.rack_name"
    >
      <router-link
        :to="{path: `/units/${item.id}`}"
        target="_blank"
      >
        <text
          class="text-blue-300"
        >
          &#9873;
        </text>
        <a 
          :id="setId(item.rack_name)"
          class="group transition duration-300"
        >
          {{ truncate(item.rack_name, 40) }}
          <span
            class="block max-w-0 group-hover:max-w-full transition-all duration-500 h-1 bg-blue-500"
          ></span>
        </a>
      </router-link>
    </span>
    <ul 
      v-show="isOpen" 
      v-if="hasChildren"
    >
      <TreeItem
        v-for="child in item.children"
        :item="child"
        :deleteItem="deleteItem"
      />
    </ul>
  </li>
</template>

<script>
import { truncate } from '@/filters'


export default {
  name: 'TreeItem',
  props: {
    item: Object,
    deleteItem: Function,
  },
  data() {
    return {
      isOpen: false
    };
  },
  computed: {
    hasChildren() {
      return this.item.children && this.item.children.length;
    }
  },
  methods: {
    toggle() {
      if (this.hasChildren) {
        this.isOpen = !this.isOpen;
      }
    },
    caret() {
      return `caret ${this.isOpen? 'down' : ''}`
    },
    setId(itemName, action, element) {
      const baseId = `e2e_${itemName.replaceAll(' ', '_')}`
      if (action && element) {
        return`${baseId}_${action}_${element}`
      }
      return baseId
    },
    truncate: truncate
  }
}
</script>

<style scoped>
ul {
  padding-left: 1em;
  line-height: 1.5em;
}
.caret {
  cursor: pointer;
  user-select: none;
}
.caret::before {
  content: "\232A";
  -webkit-text-stroke: 2px;
  font-size:12px;
  color: #70a7f8;
  display: inline-block;
  margin-right: 6px;
}
.caret.down::before {
  transform: rotate(30deg);
}
</style>