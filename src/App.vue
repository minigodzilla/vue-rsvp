<template>
  <GuestManager/>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import GuestManager from './components/GuestManager.vue';

export default defineComponent({
  name: 'App',
  components: {
    GuestManager
  }
});
</script>

<style lang="scss">
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  //text-align: center;
  color: #2c3e50;
  margin: 60px;
}
</style>
