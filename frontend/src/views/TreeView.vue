<template>
  <div class="min-h-screen">
    <div class="container px-4 mx-auto  justify-between text-xl pl-8 pt-4 font-sans font-light"></div>
    <div class="container min-h-screen px-4 mx-auto flex flex-wrap justify-between text-xl pl-8 font-sans tracking-tight font-thin">
      <ul>
        <li v-for="treeData in regions">
          <TreeItem
            :item="treeData"
          />
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import TheMessage from '@/components/TheMessage.vue';
import TreeItem from '@/components/TreeItem.vue';
import {getUnique, logIfNotStatus} from '@/api';
import {RESPONSE_STATUS} from "@/constants";


export default {
  name: 'TreeView',
  components: {
    TreeItem,
    TheMessage
  },
  data() {
    return {
      regions: {},
      messageProps: {
        message: '',
        success: false,
      }
    }
  },
  created() {
    this.getTreeData();
  },
  methods: {
    /**
     * Fetch and set tree data
     */
    async getTreeData() {
      const response = await getUnique('tree', 'tree');
      logIfNotStatus(response, RESPONSE_STATUS.OK, 'Unexpected response!');
      this.regions = response.data.data
    },
  }
}
</script>
