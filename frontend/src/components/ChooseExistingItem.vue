<template>
	<div v-bind="{
      itemsData: itemsData,
      isHidden: isHidden
  	}"
	>
		<label :for="inputId">
			{{label}}:
		</label>
		<input
			class="block w-96"
			:id="inputId"
			type="text"
			:value="modelValue"
			@input="$emit('update:modelValue', $event.target.value)"
		/>
		<button
			type="button"
			class="pb-2 text-slate-500 pl-56"
			v-on:click="isHidden = !isHidden"
		>
			<text class="text-blue-300">
				&#9873;
			</text>
			Choose from existing
		</button>
		<div v-if="!isHidden">
			<template v-for="item in itemsData.items">
				<template v-if="item.length">
					<button
						type="button"
						class="text-white font-light bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-small rounded-lg text-xs
             px-5 py-0.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
						:id="item"
						v-on:click="copyOnClick(item, inputId)"
					>
						{{item}}
					</button>
				</template>
			</template>
		</div>
	</div>
</template>

<script>
import {MATCH_ID, MATCH_LABEL} from '@/constants';
import {getDataFromMatch} from '@/functions'

export default {
  name: 'ChooseExistingItem',
  props: {
    itemsData: Object,
    isHidden: Boolean,
    modelValue: String
  },
  data() {
    return {
      inputId: '',
      label: ''
    }
  },
  created() {
    this.inputId = this.getDataFromMatch(this.itemsData.item_type, MATCH_ID);
    this.label = this.getDataFromMatch(this.itemsData.item_type, MATCH_LABEL);
  },
  methods: {
    /**
     * Copy button text to input
     * @param {String} choice Button id
     * @param {String} id Input id
     */
    copyOnClick(choice, id) {
			let event = new Event("input");
      let input = document.getElementById(id);
      input.value = document.getElementById(choice).innerText;
      input.dispatchEvent(event);
    },
    getDataFromMatch: getDataFromMatch
  }
}
</script>