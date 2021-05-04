<template>
  <div class="tap-overlay" v-on:click="cameraZoomOut()"></div>
  <div class="thank-you" :class="{'shown' : (step == 2)}">
    <span class="thank">Thank</span>
    <span class="you">You</span>
  </div>
  <div class="card" id="card" :class="{'completed flipped' : (step == 2)}" v-touch:swipe="swipeHandler">
    <div class="face front" v-on:click="cardFlipToBack()">
      <img draggable="false" class="img img-photo" src="/assets/photo.jpg"/>
      <div class="caption">Save The Date</div>
    </div>
    <div class="face back">
      <div class="left-side" v-on:click="cardFlipToFront()">
        <div class="small-caps" style="font-size: 1.25em;">Sunday, September 5, 2021</div>
        <div class="italic" style="font-size: 0.8125em; letter-spacing: 0.0625em; margin-bottom: 2em;">For the wedding celebration of</div>
        <img draggable="false" class="img img-logo" src="/assets/jenn-and-steve.svg"/>
        <div class="small-caps" style="margin-top: 2em; line-height: 1.25; text-transform: lowercase; letter-spacing: 0.125em;">Toronto, Ontario</div>
        <div class="small-caps" style="line-height: 1.25; text-transform: lowercase; letter-spacing: 0.125em;">Canada</div>
      </div>
      <div class="right-side">
        <div style="font-size: 0.8125em; letter-spacing: 0.03125em; line-height: 1;">Please register to receive updates.</div>
        <div class="name-field">
          <input class="input box" placeholder="Your Name" ref="name" type="text" id="name" v-model="guest.name"/>
        </div>
        <div class="email-field">
          <input class="input box" placeholder="Your Email Address" ref="email" type="text" id="email" v-model="guest.email"/>
        </div>
        <div class="location-field">
          <input class="input box" placeholder="Your Location" ref="location" id="location" v-model="guest.location"/>
          <select class="select" v-model="guest.location">
            <option disabled selected></option>
            <option>Within Ontario</option>
            <option>Within Canada</option>
            <option>United States</option>
            <option>International</option>
          </select>
        </div>
        <div class="comment-field">
          <input class="input box" placeholder="Your Comment" ref="comment" type="comment" id="comment"/>
        </div>
        <button class="btn" v-on:click="submitGuest()">
          Register
        </button>
        <div class="error-message small-caps">{{ this.errorMessage }}</div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

const baseURL = 
  process.env.NODE_ENV === 'development' ? '//localhost:3000/guests/' : 'guests/'
  // process.env.NODE_ENV === 'development' ? 'https://jennandsteve.ca/guests/' : 'guests/'

export default {
  data() {
    return this.initialState();
  },
  mounted() {
    this.initialCamera();
    // this.focusInput('name');
  },
  methods: {
    next() {
      this.step++;
      this.cameraZoomOut();
    },
    initialState() {
      return {
        step: 1,
        hasErrors: false,
        errorMessage: '',
        guest: {
          name: '',
          email: '',
          location: ''
        }
      }
    },
    reset() {
        Object.assign(this.$data, this.initialState());
    },
    submitGuest() {

      const commentField = document.getElementById('comment');
      const regex = /^([a-zA-Z0-9_.\-+])+@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

      this.hasErrors = false;
      this.errorMessage = '';

      // validate name and email

      if (!this.guest.name) {
        this.hasErrors = true;
        this.errorMessage = 'Please enter your name.';
        return false;
      }

      if (!this.guest.email) {
        this.hasErrors = true;
        this.errorMessage = 'Please enter your email address.';
        return false;
      }

      if(!regex.test(this.guest.email)) {
        this.hasErrors = true;
        this.errorMessage = 'Please enter a valid email address.';
        return false;
      }

      if (!this.guest.location) {
        this.hasErrors = true;
        this.errorMessage = 'Please tell us where you are located.';
        return false;
      }

      if (commentField.value) {
        // it's a faaaake
        this.next();
        return false;
      }

      // all errors checked, posting to API

      if(this.hasErrors == false) {
        axios.post(`${baseURL}`, this.guest)
          .then(response => {
            this.next();
          })
          .catch(error => {
            this.errorMessage = error.message;
          });
      }

    },
    initialCamera() {

      const app = document.getElementById('app');
      const card = document.getElementById('card');

      setTimeout(function() {
        card.classList.add('presented');
      }, 50);

      setTimeout(function() {
        card.classList.add('flipped');
      }, 5000);


      setTimeout(function() {
        app.classList.remove('pointer-events-none');
        app.classList.add('pan','left');
      }, 5000);
 
      setTimeout(function() {
        app.classList.remove('left');
        app.classList.add('right');
      }, 10000);
 
    },
    cameraZoomOut() {

      const app = document.getElementById('app');

      app.classList.remove('pan');

    },
    cameraPanRight() {

      const app = document.getElementById('app');

      app.classList.remove('left');
      app.classList.add('pan','right');

    },
    cameraPanLeft() {

      const app = document.getElementById('app');

      app.classList.remove('right');
      app.classList.add('pan','left');

    },
    cardFlipToFront() {

      const app = document.getElementById('app');
      const card = document.getElementById('card');

      app.classList.remove('pan');
      card.classList.remove('flipped');

    },
    cardFlipToBack() {

      const app = document.getElementById('app');
      const card = document.getElementById('card');

      app.classList.add('pan');
      card.classList.add('flipped');

    },
    swipeHandler(direction) {

      const app = document.getElementById('app');

      if (direction == 'right') {
        this.cameraPanLeft();
      }

      if (direction == 'left') {
        this.cameraPanRight();
      }
    }
  }
};
</script>

<style lang="scss">

.pointer-events-none {
  pointer-events: none;
}

.tap-overlay {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
}

.thank-you {
  position: absolute;
  color: #bea684;
  font-family: 'Calamity Jane NF', serif;
  font-size: 6em;
  letter-spacing: -0.03125em;
  line-height: 0.78125;
  text-shadow: 0.03125em 0.03125em 0.0625em rgba(0,0,0,0.75);
  display: none;
  user-select: none;

  span {
    display: block;

    &.you {
      margin-left: 0.78125em;
    }
  }

  &.shown {
    display: block;
  }
}

.card {
  perspective: 100em;
  position: relative;
  width: 50em;
  height: 32em;
  transition: transform 2s ease;
  transform: translateY(75em) rotate(-22.5deg);

  &.flipped {

    .face {
      &.front {
        transform: rotateZ(2deg) rotateX(180deg);
      }

      &.back {
        transform: rotateZ(0deg) rotateX(0deg);
      }
    }
  }

  &.presented {
    transform: translateY(0) rotate(0);
    transition: transform 1s ease;
  }

  &.completed {
    transform: translateY(-75em) rotate(+22.5deg);
    transition: transform 1s ease;
  }

  .face {
    backface-visibility: hidden;
    background-color: #bea684;
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    //justify-content: start;
    padding: 0.75em;
    transition: transform 2s ease;
    box-shadow: 0.125em 0.08125em 0.75em rgba(0,0,0,0.5);

    &.front {
      transform: rotateZ(-2deg) rotateX(0deg);
    }

    &.back {
      transform: rotateZ(-2deg) rotateX(-180deg);
      background-image: linear-gradient(135deg,
        #3c487f 0%,
        #3c487f 19%,
        #bea684 19%,
        #bea684 25%,
        #bf514b 25%,
        #bf514b 44%,
        #bea684 44%,
        #bea684 50%,
        #3c487f 50%,
        #3c487f 69%,
        #bea684 69%,
        #bea684 75%,
        #bf514b 75%,
        #bf514b 94%,
        #bea684 94%,
        #bea684 100%
        );
      background-size: 10em 10em;

      &::before {
        content: '';
        position: absolute;
        z-index: 0;
        top: 0.75em;
        right: 0.75em;
        bottom: 0.75em;
        left: 0.75em;
        background-color: #bea684;
        background-image: url('/assets/stamp.jpg');
        background-repeat: no-repeat;
        background-position: 97% 5%;
        background-size: 12em;
      }
    }

    .img-photo {
      width: 100%;
      height: 90%;
      object-fit: cover;
      object-position: 50% 100%;
    }

    .img-logo {
      width: 65%;
      margin: 0 auto;
    }

    .caption {
      line-height: 1.5em;
      //font-family: 'IM Fell DW Pica SC', serif;
      font-family: 'Calamity Jane NF',serif;
      font-size: 2.5em;
      word-spacing: -0.2em;
    }

    > div,
    > img {
      user-select: none;
    }

    > div,
    > img,
    > input,
    > button {
      mix-blend-mode: multiply;
    }

    .img-small {
      display: block;
      margin: 0 auto;
      width: 100%;
    }

    .img-flourish {
      width: 10em;
      margin: 1em 0;
    }

    .img-full {
      max-height: 85%;
      max-width: 100%;
    }

    @keyframes reveal-form-field {
      0%    { height: 0;    opacity: 0; }
      50%   { height: 12em; opacity: 0; }
      100%  { height: 12em; opacity: 1; }
    }

    .left-side {
      position: absolute;
      width: 50%;
      top: 6em;
      left: 0;
      bottom: 6em;
      display: flex;
      flex-direction: column;
      justify-content: center;
      text-align: center;
      border-right: 0.03125em solid #000;
    }

    .right-side {
      position: absolute;
      width: 50%;
      top: 9em;
      right: 0;
      bottom: 0;
      text-align: center;

      &.date-place {
      }

      h4 {
        margin-top: 1em;
        margin-bottom: 1em;
      }

      &.hidden {
        height: 0;
        opacity: 0;
      }

      &.shown {
        animation-name: reveal-form-field;
        animation-duration: 1s;
        animation-timing-function: ease;
        animation-fill-mode: forwards;
      }
    }

    .error-message {
      color: #f00;
      position: absolute;
      width: 100%;
      margin-top: 1em;
      mix-blend-mode: multiply;
    }

    .comment-field {
      position: absolute;
      opacity: 0;
      pointer-events: none;
    }

    .input {
      appearance: none;
      width: 70%;
      border-radius: 0;
      border-width: 0 0 0.03125em 0;
      border-color: black;
      border-style: dashed;
      margin: 1em auto;
      padding: 0;
      font-family: 'IM Fell DW Pica', serif;
      font-size: 1.5em;
      font-style: italic;
      line-height: 1.25em;
      color: #26f;
      text-align: center;
      display: block;
      box-sizing: border-box;

      &::placeholder {
        font-family: 'IM Fell DW Pica SC', serif;
        font-size: 0.5em;
        font-style: normal;
        font-weight: 400;
        letter-spacing: 0.025em;
        color: #000;
      }
    }

    .location-field {
      position: relative;

      .input {
        pointer-events: none;
      }
    }

    .select,
    .select:focus {
      appearance: none;
      opacity: 0;
      position: absolute;
      top: 0;
      right: 0;
      bottom: 0;
      left: 0;
      width: 100%;
      font-size: 20px;
    }

    button {
      width: 10em;
      height: 3em;
      margin: 1em auto 0 auto;
      padding: 0;
      border: 0 none;
      background-color: transparent;
      background-image: url('/assets/btn.svg');
      background-position: 50% 50%;
      background-repeat: no-repeat;
      background-size: contain;
      font-family: 'IM Fell DW Pica SC', serif;
      font-size: 1em;
      //font-weight: 400;
      //text-transform: uppercase;
      cursor: pointer;
    }

    input:focus,
    textarea:focus,
    button:focus,
    input[type=radio]:focus + label {
      outline:none !important;
      box-shadow:none !important;
      // background-color: red;
    }
  }

  // .face {
  //   &::before {
  //     content: '';
  //     position: absolute;
  //     z-index: 0;
  //     top: 0;
  //     right: 0;
  //     bottom: 0;
  //     left: 0;
  //     background-image: url('/assets/page-tl.svg'), url('/assets/page-tr.svg'), url('/assets/page-bl.svg'), url('/assets/page-br.svg');
  //     background-position: 0 0, 100% 0, 0 100%, 100% 100%;
  //     background-repeat: no-repeat;
  //     background-size: 10vw;
  //   }
  // }
}

@media only screen and (max-width: 567px) {

  .thank-you {
    font-size: 16em;
  }

  .card .face {
    font-size: 1.25em;

    .img-photo {
      height: 78%;
    }
    .caption {
      font-size: 4em;
    }
    .right-side {
      top: 7.875em;
    }
    .input {
      width: 100%;
      margin: 0.0625em auto;
      font-size: 2em;
      transform: scale(0.75);
    }
  }
}

</style>