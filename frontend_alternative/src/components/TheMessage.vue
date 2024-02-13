<template>
  <template v-if="messageProps.message.length && messageProps.success">
    <text>
      {{messageProps.message}}
    </text>
  </template>
  <template v-else-if="messageProps.message.length && !messageProps.success">
    <text class="text-red-500">
      {{messageProps.message}}
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
      message: String,
      success: false,
    }
  }
}
</script>
