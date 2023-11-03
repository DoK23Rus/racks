<template>
  <template v-if="messageProps.message.sucsess">
    <text>
      {{ messageProps.message.sucsess }}
    </text>
  </template>
  <template v-else-if="messageProps.message.invalid">
    <text class="text-red-500">
      {{ messageProps.message.invalid }}
    </text>
  </template>
  <template v-else>
    <text></text>
  </template>
</template>

<script>
export default {
  name: 'TheMessage',
  props: {
    messageProps: {
      type: Object
    }
  }
}
</script>