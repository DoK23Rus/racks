<template>
  <li>
    <RegionTreeItem
      v-if="item.region_name"
      :regionName="item.region_name"
      :isOpen="isOpen"
      v-on:click="toggle()"
    />
    <DepartmentTreeItem
      v-if="item.department_name"
      :departmentId="item.id"
      :departmentName="item.department_name"
      :isOpen="isOpen"
      v-on:click="toggle()"
    />
    <SiteTreeItem
      v-if="item.site_name"
      :siteId="item.id"
      :siteName="item.site_name"
      :isOpen="isOpen"
      v-on:click="toggle()"
    />
    <BuildingTreeItem
      v-if="item.building_name"
      :buildingId="item.id"
      :buildingName="item.building_name"
      :isOpen="isOpen"
      v-on:click="toggle()"
    />
    <RoomTreeItem
      v-if="item.room_name"
      :roomId="item.id"
      :roomName="item.room_name"
      :isOpen="isOpen"
      v-on:click="toggle()"
    />
    <RackTreeItem
      v-if="item.rack_name"
      :rackId="item.id"
      :rackName="item.rack_name"
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
import { truncate } from '@/filters';
import RegionTreeItem from './RegionTreeItem.vue';
import DepartmentTreeItem from './DepartmentTreeItem.vue';
import SiteTreeItem from './SiteTreeItem.vue';
import BuildingTreeItem from './BuildingTreeItem.vue';
import RoomTreeItem from './RoomTreeItem.vue';
import RackTreeItem from './RackTreeItem.vue';
import { getCaretClass, getId } from '@/functions';


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
