<template>
	<div class="container px-4 mx-auto justify-between pl-8 font-sans font-thin text-2xl pb-4">
    <TheMessage
			:messageProps="messageProps"
		/>
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
import { getUnique, deleteObject } from '@/api';
import TheMessage from '@/components/TheMessage.vue';
import TreeItem from '@/components/TreeItem.vue';


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
        message: ''
      }
		}
	},
	created() {
		this.getTreeData();
	},
	methods: {
		async getTreeData() {
			this.regions = await getUnique('tree', '/tree/')
		},
		async deleteItem(id, itemName, itemType) {
			const payload = {
				id: id,
			}
			if (confirm(`Do you really want to delete ${itemType} ${itemName} and all releated items?`)) {
				this.messageProps.message = await deleteObject(itemType, `/${itemType}/${id}/delete/`, payload);
				console.log(this.messageProps.message);
				this.getTreeData();
			}
		},
	}
}
</script>