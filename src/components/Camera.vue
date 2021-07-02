<template>
  <div class="camera">
    <div id="player-container" class="player-container" v-on:click="takePicture()">
      <video id="player" controls autoplay muted playsinline></video>
    </div>
    <div id="gallery">
      <!-- <img id="photo" v-bind:src="photo" alt="The screen capture will appear in this box."> --> 
    </div>
    <div id="switch-cameras" v-on:click="changeCamera()">{{this.activeCam}}</div>
  </div>
  <canvas id="canvas" width="768" height="1024"></canvas>
</template>


<style lang="scss">

  * {
      box-sizing: border-box;
  }

  body {
    margin: 0;
  }

  .player-container {
    margin: 0 auto;
    position: relative;
    overflow: hidden;
    width: 100vw;
    height: 133.33vw;
    border: 5vw solid black;
    background-color: black;
  
    &::before {
      content: '';
      position: absolute;
      z-index: 2;
      top: -0.125em;
      right: -0.125em;
      bottom: -0.125em;
      left: -0.125em;
      background-image: url('/assets/viewfinder-glass-portrait.png');
      background-size: 100% 100%;
    }
  
    &::after {
      content: '';
      position: absolute;
      z-index: 2;
      top: -0.125em;
      right: -0.125em;
      bottom: -0.125em;
      left: -0.125em;
      background-image: url('/assets/viewfinder-vignette-portrait.png');
      background-size: 100% 100%;
    }
  
    video {
      display: block;
      width: 100%;
      height: 100%;
      object-fit: cover;
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
      animation-duration: 0.5s, 1s;
      animation-timing-function: ease;
      animation-fill-mode: both;
    }
  }
  
  canvas {
    display: none;
  }
  
  #gallery {
    display: flex;
    //flex-wrap:wrap;
    width: 100vw;
    height: 9em;
    overflow: hidden;
  }
  
  .photo {
    width: 25vw;
    height: 33.33vw;
  }

  #switch-cameras {
    position: absolute;
    background-color: red;
    bottom: 0;
    right: 0;
    width: 25vw;
    height: 25vw;
  }
  
  
  </style>

<script>
import axios from "axios";

const baseURL = 
  process.env.NODE_ENV === 'development' ? '//localhost:3000/photos/' : 'photos/'

export default {
  data() {
    return this.initialState();
  },
  mounted() {
    this.activeCam = "environment";
    this.player = document.getElementById('player');
    this.canvas = document.getElementById('canvas');
    this.constraints = {
      video: { facingMode: this.activeCam },
    };
    this.initializeCamera();
    //navigator.mediaDevices.enumerateDevices()
    // .then((devices) => {
    //   devices.forEach(function(device) {
    //     console.log(device.kind + ": " + device.label +
    //                 " id = " + device.deviceId);
    //   });
    // })
    // .catch((err)  => {
    //   console.log(err.name + ": " + err.message);
    // });
  },
  methods: {
    initialState() {
      return {

        player: '',
        photo: '',
        canvas: '',
        constraints: {},

      }
    },
    initializeCamera() {
      navigator.mediaDevices.getUserMedia(this.constraints)
        .then((stream) => {
          this.player.srcObject = stream;
        })
        .catch((err)  => {
          console.log(err.name + ": " + err.message);
        });
    },
    changeCamera() {
      if ( this.activeCam === "environment") {
        console.log('condition 1');
        this.activeCam = "user";
      }
      else {
        console.log('condition 2');
        this.activeCam = "environment";
      }
      console.log(this.activeCam);
      this.initializeCamera();
    },
    takePicture() {

      const context = this.canvas.getContext('2d');
      context.drawImage(this.player, 0, 0, this.canvas.width, this.canvas.height);

      this.photo = this.canvas.toDataURL('image/jpeg', 0.5);

      const container = document.getElementById('player-container');
      const gallery = document.getElementById('gallery');
      const img = document.createElement('img');
      const img2 = document.createElement('img');

      img.src = this.photo;
      img.classList.add('photo')
      container.appendChild(img);

      img2.src = this.photo;
      img2.classList.add('photo')
      gallery.prepend(img2);


      axios.post(`${baseURL}`, this.photo)
        .then(response => {
          console.log(response);
        })
        .catch(error => {
          console.log(error);
        });
    }
  }
};
</script>

