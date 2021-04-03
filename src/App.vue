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
  overflow: hidden;
}

body {
  background-color: #222;
  width: 100%;
  height: 100%;
  margin: 0;
  padding: 0;
  overflow: hidden;
  touch-action: none;
}

.svg-defs {
  display: none;
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

#app {
  background-color: #222;
  color: #222;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  background-image: url('/assets/bg.jpg');
  background-position: 50% 50%;
  background-size: cover;
  font-family: 'Cormorant Garamond',serif;
  font-size: 1.5vw;

}

h1 {
  display: none;
}


@media only screen and (max-width: 567px) {

  .vignette {
    background-image: radial-gradient(circle, rgba(0,0,0,0) 50%, rgba(0,0,0,1) 100%);
  }

  #app {
    font-size: 2.25vw;
    transition: transform 2s cubic-bezier(0.645, 0.045, 0.355, 1);
  }

  #app.initial {
    transform: scale(2) translateX(-22.5%);
  }

  #app.zoom-out {
    transform: scale(1) translateX(0);
  }

  #app.pan.left {
    transform: scale(2) translateX(22.5%);
  }

  #app.pan.right {
    transform: scale(2) translateX(-22.5%);
  }

}

</style>
