<template>
  <h1>Jenn and Steve's Wedding RSVP</h1>
  <GuestCollector/>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import GuestCollector from './components/GuestCollector.vue';

export default defineComponent({
  name: 'App',
  components: {
    GuestCollector
  }
});
</script>

<style lang="scss">

// @import url('https://fonts.googleapis.com/css2?family=Spectral+SC:wght@200;300;400;500;600;700;800&family=Spectral:wght@200;300;400;500;600;700;800&display=swap');
// @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap');
// @import url('https://fonts.googleapis.com/css2?family=Homemade+Apple&display=swap');

@import url('https://fonts.googleapis.com/css2?family=IM+Fell+DW+Pica+SC&family=IM+Fell+DW+Pica:ital@0;1&display=swap');
@import url('https://fonts.googleapis.com/css2?family=IM+Fell+Double+Pica+SC&family=IM+Fell+Double+Pica:ital@0;1&display=swap');

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
  font-family: 'IM Fell DW Pica', serif;
  font-size: 1.75vw;
  line-height: 1.75;
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

  &::before
  {
    content: '';
    position: absolute;
    z-index: -1;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-image: url('data:image/png;base64,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');
    background-size: 64px;
    opacity: 0.75;
  }
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

}

.italic {
  font-style: italic;
}

.small-caps {
  font-family: 'IM Fell DW Pica SC', serif;
}

h1 {
  display: none;
}


@media only screen and (max-width: 567px) {

  .vignette {
    background-image: radial-gradient(circle, rgba(0,0,0,0) 50%, rgba(0,0,0,1) 100%);
  }

  #app {
    transition: transform 2s cubic-bezier(0.645, 0.045, 0.355, 1);
  }

  #app.initial {
    transform: scale(2.5) translateX(-20%);
  }

  #app.zoom-out {
    transform: scale(1) translateX(0);
  }

  #app.pan.left {
    transform: scale(2.5) translateX(20%);
  }

  #app.pan.right {
    transform: scale(2.5) translateX(-20%);
  }

}

</style>
