<template>
	<!-- <h1>Jenn and Steve's Wedding RSVP</h1> -->
	<Camera />
</template>

<script lang="ts">
import { defineComponent } from "vue";
import Camera from "./components/Camera.vue";

export default defineComponent({
	name: "App",
	components: {
		Camera,
	},
});
</script>

<style lang="scss">
* {
	box-sizing: border-box;
}

html {
	height: 100%;
	overflow: hidden;
}

body {
	background-color: #000;
	color: #fff;
	width: 100%;
	height: 100%;
	max-height: -webkit-fill-available;
	margin: 0;
	padding: 0;
	overflow: hidden;
}

.svg-defs {
	display: none;
}

#app {
	height: 100%;
}
</style>
