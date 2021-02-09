<template>
  <h1>Jenn and Steve's Wedding RSVP</h1>
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

body {
  font-family: Avenir,sans-serif;
  padding: 50px;
}

</style>
