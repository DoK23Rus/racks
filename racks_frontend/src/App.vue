<template>
  <div id="App">
    <Header />
    <router-view />
  </div>
</template>

<script>
import axios from 'axios'
import Header from '@/components/Header.vue'


export default {
  name: 'App',
  components: {
    Header
  },
  beforeCreate() {
    this.$store.commit('initializeStore');
    const token = this.$store.state.token;
    if (token) {
      axios.defaults.headers.common['Authorization'] = "Token " + token;
    } else {
      axios.defaults.headers.common['Authorization'] = '';
    }
  },
}
</script>

<style lang="scss">
#app {
  background-color:#F4F8FE;
  background-image:
  radial-gradient(circle at 100% 150%, #F4F8FE 24%, white 24%, white 28%, #F4F8FE 28%, #F4F8FE 36%, white 36%, white 40%, transparent 40%, transparent),
  radial-gradient(circle at 0    150%, #F4F8FE 24%, white 24%, white 28%, #F4F8FE 28%, #F4F8FE 36%, white 36%, white 40%, transparent 40%, transparent),
  radial-gradient(circle at 50%  100%, white 10%, #F4F8FE 10%, #F4F8FE 23%, white 23%, white 30%, #F4F8FE 30%, #F4F8FE 43%, white 43%, white 50%, #F4F8FE 50%, #F4F8FE 63%, white 63%, white 71%, transparent 71%, transparent),
  radial-gradient(circle at 100% 50%, white 5%, #F4F8FE 5%, #F4F8FE 15%, white 15%, white 20%, #F4F8FE 20%, #F4F8FE 29%, white 29%, white 34%, #F4F8FE 34%, #F4F8FE 44%, white 44%, white 49%, transparent 49%, transparent),
  radial-gradient(circle at 0    50%, white 5%, #F4F8FE 5%, #F4F8FE 15%, white 15%, white 20%, #F4F8FE 20%, #F4F8FE 29%, white 29%, white 34%, #F4F8FE 34%, #F4F8FE 44%, white 44%, white 49%, transparent 49%, transparent);
  background-size: 75%;
  background-attachment:scroll
}
</style>
