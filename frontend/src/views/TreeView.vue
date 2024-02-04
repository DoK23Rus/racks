<template>
  <div class="container px-4 mx-auto justify-between pl-8 font-sans font-thin text-2xl pb-4">
    <TheMessage :messageProps="messageProps"/>
  </div>
  <div class="container px-4 mx-auto  justify-between text-xl pl-8 pt-4 font-sans font-light"></div>
  <div class="container min-h-screen px-4 mx-auto flex flex-wrap justify-between text-xl pl-8 font-sans tracking-tight font-thin">
    <ul>
      <li v-for="treeData in regions">
        <TreeItem
          :item="treeData"
          :deleteItem="deleteItem"
        />
      </li>
    </ul>
  </div>
</template>

<script>
import TheMessage from '@/components/TheMessage.vue';
import TreeItem from '@/components/TreeItem.vue';
import {deleteObject, getResponseMessage, getUnique, logIfNotStatus} from '@/api';
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
    /**
     * Delete tree item
     * @param {Number} id Item id
     * @param {String} itemName Item name
     * @param {String} itemType Item type
     */
    async deleteItem(id, itemName, itemType) {
      if (confirm(`Do you really want to delete ${itemType} ${itemName} and all related items?`)) {
				const response = await deleteObject(itemType, id);
				if (response.status === RESPONSE_STATUS.NO_CONTENT) {
					this.messageProps.success = true;
					this.messageProps.message = `${itemType} ${itemName} deleted successfully`;
				}  else {
					this.messageProps.success = false;
					this.messageProps.message = getResponseMessage(response);
				}
        await this.getTreeData();
      }
    },
  }
}
</script>
