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

@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Homemade+Apple&display=swap');

html {
  height: 100%;
}

body {
  background-color: #222;
  color: #222;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  background-image: url('assets/bg.jpg');
  background-position: 50% 50%;
  background-size: cover;
  font-family: 'Cormorant Garamond',serif;
  font-size: 1.5vw;
}

.vignette {
  position: fixed;
  z-index:10;
  pointer-events: none;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  background-image: radial-gradient(circle, rgba(0,0,0,0) 0%, rgba(0,0,0,1) 100%);
  mix-blend-mode: soft-light;
  opacity: 0.75;
}

</style>
