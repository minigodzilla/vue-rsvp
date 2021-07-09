<template>
	<Camera />
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import Camera from './components/Camera.vue';

export default defineComponent({
	name: 'App',
	components: {
		Camera,
	},
});
</script>

<style lang="scss">
html {
	height: 100%;
	overflow: hidden;
	touch-action: none;
}

body {
	background-color: #000;
	background-image: url('/assets/bg-landscape-2.png'), url('/assets/change-camera-landscape.png'), url('/assets/change-camera-portrait.png'), url('/assets/shutter-landscape.png'), url('/assets/shutter-portrait.png'), url('/assets/timer-disabled-landscape.png'), url('/assets/timer-disabled-portrait.png'), url('/assets/timer-enabled-landscape.png'), url('/assets/timer-enabled-portrait.png'), url('/assets/timer.gif'), url('/assets/viewfinder-glass-landscape.png'), url('/assets/viewfinder-glass-portrait.png'), url('/assets/viewfinder-vignette-landscape.png'), url('/assets/viewfinder-vignette-portrait.png');
	background-position: -1000% -1000%;
	background-repeat: no-repeat;
	background-size: 0;
	color: #fff;
	width: 100%;
	height: 100%;
	max-height: -webkit-fill-available;
	margin: 0;
	padding: 0;
}

.svg-defs {
	display: none;
}

#app {
	height: 100%;
}
</style>
