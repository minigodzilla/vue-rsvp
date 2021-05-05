<template>
  <div class="camera" v-on:click="takePicture()">
    <div id="player-container" class="player-container">
      <video id="player" controls autoplay></video>
    </div>
    <div>
      <button id="capture" v-on:click="takePicture()">Capture</button>
    </div>
    <div id="gallery">
      <!-- <img id="photo" v-bind:src="photo" alt="The screen capture will appear in this box."> --> 
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

      const container = document.getElementById('player-container');
      const gallery = document.getElementById('gallery');
      const img = document.createElement('img');
      const img2 = document.createElement('img');

      img.src = this.photo;
      img.classList.add('photo')
      container.appendChild(img);

      img2.src = this.photo;
      img2.classList.add('photo')
      gallery.appendChild(img2);

    }
  }
};
</script>

<style lang="scss">



.player-container {
  margin: 0 auto;
  position: relative;
  overflow: hidden;
  width: 24em;
  height: 18em;
  border: 1em solid black;
  background-color: black;

  &::before {
    content: '';
    position: absolute;
    top: -0.125em;
    right: -0.125em;
    bottom: -0.125em;
    left: -0.125em;
    background-image: url('/assets/viewfinder-glass.png');
    background-size: 100% 100%;
  }

  &::after {
    content: '';
    position: absolute;
    top: -0.125em;
    right: -0.125em;
    bottom: -0.125em;
    left: -0.125em;
    background-image: url('/assets/viewfinder-vignette.png');
    background-size: 100% 100%;
  }

  video {
    display: block;
    width: 100%;
    height: 100%;
  }

  @keyframes flash {
    0% {
      filter: brightness(10);
    }
    100% {
      filter: brightness(1);
    }
  }

  @keyframes slide {
    0% {
      transform: translateX(0);
    }
    100% {
      transform: translateX(100%);
    }
  }

  img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    animation-name: flash, slide;
    animation-duration: 1s;
    animation-timing-function: ease;
    animation-fill-mode: both;
  }
}

canvas {
  display: none;
}

.gallery {
  display: flex;
  flex-wrap:wrap;
}

.photo {
  width: 12em;
  height: 9em;
}


</style>