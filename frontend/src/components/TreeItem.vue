<template>
  <li>
    <RegionTreeItem
      v-if="item.region_name"
      :name="item.region_name"
      :isOpen="isOpen"
      v-on:click="toggle()"
    />
    <DepartmentTreeItem
      v-if="item.department_name"
      :id="item.id"
      :name="item.department_name"
      :isOpen="isOpen"
      v-on:click="toggle()"
    />
    <SiteTreeItem
      v-if="item.site_name"
      :id="item.id"
      :name="item.site_name"
      :isOpen="isOpen"
      :deleteItem="deleteItem"
      v-on:click="toggle()"
    />
    <BuildingTreeItem
      v-if="item.building_name"
      :id="item.id"
      :name="item.building_name"
      :isOpen="isOpen"
      :deleteItem="deleteItem"
      v-on:click="toggle()"
    />
    <RoomTreeItem
      v-if="item.room_name"
      :id="item.id"
      :name="item.room_name"
      :isOpen="isOpen"
      :deleteItem="deleteItem"
      v-on:click="toggle()"
    />
    <RackTreeItem
      v-if="item.rack_name"
      :id="item.id"
      :name="item.rack_name"
      :isOpen="isOpen"
      v-on:click="toggle()"
    />
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
import RegionTreeItem from './RegionTreeItem.vue';
import DepartmentTreeItem from './DepartmentTreeItem.vue';
import SiteTreeItem from './SiteTreeItem.vue';
import BuildingTreeItem from './BuildingTreeItem.vue';
import RoomTreeItem from './RoomTreeItem.vue';
import RackTreeItem from './RackTreeItem.vue';
import {truncate} from '@/filters';
import {getCaretClass, getId} from '@/functions';


export default {
  name: 'TreeItem',
  props: {
    item: Object,
    deleteItem: Function,
  },
  components: {
    RegionTreeItem,
    DepartmentTreeItem,
    SiteTreeItem,
    BuildingTreeItem,
    RoomTreeItem,
    RackTreeItem
  },
  data() {
    return {
      isOpen: false
    };
  },
  computed: {
    /**
     * Item has children?
     */
    hasChildren() {
      return this.item.children && this.item.children.length;
    }
  },
  methods: {
    /**
     * Open tree level
     */
    toggle() {
      if (this.hasChildren) {
        this.isOpen = !this.isOpen;
      }
    },
    getCaretClass: getCaretClass,
    getId: getId,
    truncate: truncate
  }
}
</script>

<style scoped>
  ul {
    padding-left: 1em;
    line-height: 1.5em;
  }
</style>
