<template>
  <div id="App">
    <TheHeader />
    <router-view />
  </div>
</template>

<script>
import axios from 'axios'
import TheHeader from '@/components/TheHeader.vue'


export default {
  name: 'App',
  components: {
    TheHeader
  },
  beforeCreate() {
    this.$store.commit('initializeStore');
    const token = this.$store.state.token;
    if (token) {
      axios.defaults.headers.common['Authorization'] = "Bearer " + token;
    } else {
      axios.defaults.headers.common['Authorization'] = '';
    }
  },
}
</script>
