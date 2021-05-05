<template>
  <div class="camera">
    <div class="player-container">
      <video id="player" controls autoplay></video>
    </div>
    <div>
      <button id="capture" v-on:click="takePicture()">Capture</button>
    </div>
    <div>
      <img id="photo" v-bind:src="photo" alt="The screen capture will appear in this box."> 
    </div>
  </div>
  <canvas id="canvas" width=640 height=480></canvas>
</template>

<script>
export default {
  data() {
    return this.initialState();
  },
  mounted() {
    this.player = document.getElementById('player');
    this.canvas = document.getElementById('canvas');
    this.constraints = {
      video: true,
    };
    navigator.mediaDevices.getUserMedia(this.constraints)
    .then((stream) => {
      this.player.srcObject = stream;
    });
  },
  methods: {
    initialState() {
      return {

        player: '',
        photo: '',
        canvas: '',
        constraints: {}
      }
    },
    takePicture() {
      const context = this.canvas.getContext('2d');
      context.drawImage(this.player, 0, 0, this.canvas.width, this.canvas.height);
      this.photo = this.canvas.toDataURL('image/png');

    }
  }
};
</script>

<style lang="scss">



.player-container {
  margin: 0 auto;
  position: relative;
  width: 640px;
  height: 480px;

  &::after {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-image: url('/assets/viewfinder.png');
    background-size: 100% 100%;
  }

  video {
    display: block;
  }
}

canvas {
  display: none;
}

#photo {
  width: 320px;
  height: 240px;
}


</style>