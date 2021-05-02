<template>
  <div class="thank-you" :class="{'shown' : (step == 2)}">Thank You</div>
  <div class="card" id="card" :class="{'completed flipped' : (step == 2)}">
    <div class="face front" v-on:click="cardFlip()">
      <img draggable="false" class="img img-photo" src="/assets/photo.jpg"/>
      <div class="caption">Save The Date</div>
    </div>
    <div class="face back">
      <div class="left-side" v-on:click="cardFlip()">
        <div class="small-caps" style="font-size: 1.25em;">Sunday, September 5, 2021</div>
        <div class="italic" style="font-size: 0.8125em; letter-spacing: 0.0625em; margin-bottom: 1.5em;">For the wedding celebration of</div>
        <img draggable="false" class="img img-logo" src="/assets/jenn-and-steve.svg"/>
        <div class="small-caps" style="margin-top: 1.5em; text-transform: lowercase; letter-spacing: 0.125em;">Toronto, Ontario</div>
        <div class="small-caps" style="text-transform: lowercase; letter-spacing: 0.125em;">Canada</div>
      </div>
      <div class="right-side">
        <div class="small-caps" style="letter-spacing: 0.03125em">Please register to receive updates.</div>
        <div class="name-field">
          <input class="input box" placeholder="Your Name" ref="name" type="text" id="name" v-model="guest.name"/>
        </div>
        <div class="email-field">
          <input class="input box" placeholder="Your Email" ref="email" type="text" id="email" v-model="guest.email"/>
        </div>
        <div class="location-field">
          <input class="input box" placeholder="Your Location" ref="location" type="text" id="location" v-model="guest.location" v-on:keyup.enter="submitGuest()"/>
        </div>
        <div class="comment-field">
          <input class="input box" placeholder="Your Comment" ref="comment" type="comment" id="comment"/>
        </div>
        <button class="btn" v-on:click="submitGuest()">
          Register
        </button>
        <div style="color: red;">{{ this.errorMessage }}</div>
        <!-- <img draggable="false" class="img img-small img-flourish" src="/assets/flourish-1.svg"/> -->
      </div>
    </div>
    <!-- <div class="page left">
      <img draggable="false" class="img img-photo" src="/assets/photo.jpg"/>
      <div class="body-text">
        Save the Date
      </div>
    </div>
    <div class="page right">
    </div> -->
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
    //this.focusInput('name');
  },
  methods: {
    focusInput(i) {
      this.$refs[i].focus();
    },
    prev(i) {
      this.step--;
      this.cameraPan();
      if (i) {
        this.focusInput(i);
      }
    },
    next(i) {
      this.step++;
      this.cameraPan();
      if (i) {
        this.focusInput(i);
      }
    },
    initialState() {
      return {
        step: 1,
        hasErrors: false,
        errorMessage: '',
        guest: {
          name: '',
          email: ''
        }
      }
    },
    reset() {
        Object.assign(this.$data, this.initialState());
    },
    submitGuest() {

      const commentField = document.getElementById('comment');

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
        this.errorMessage = 'Please enter your email.';
        return false;
      }

      if (commentField.value) {
        // it's a faaaake
        this.next();
        return false;
      }

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
    cameraPan() {

      const app = document.getElementById('app');

      app.classList.remove('pan','right');
      app.classList.add('zoom-out');

      setTimeout(function() {
        app.classList.remove('zoom-out');
        app.classList.add('pan','left');
      }, 2500);
 
      setTimeout(function() {
        app.classList.remove('left');
        app.classList.add('right');
      }, 5000);
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
        app.classList.add('pan','left');
      }, 5000);
 
      setTimeout(function() {
        app.classList.remove('left');
        app.classList.add('right');
      }, 10000);
 
    },
    cardFlip() {

      const card = document.getElementById('card');

      card.classList.toggle('flipped');

    }
  }
};
</script>

<style lang="scss">

.thank-you {
  position: absolute;
  color: #bea684;
  font-style: italic;
  font-family: 'IM Fell Double Pica', serif;
  font-size: 5em;
  text-shadow: 0.5vw 0.325vw 1.5vw rgba(0,0,0,0.5);
  display: none;

  &.shown {
    display: block;
  }
}

.card {
  perspective: 200vw;
  position: relative;
  width: 80vw;
  height: 55vw;
  transition: transform 2s ease;
  transform: translateY(150vw) rotate(-22.5deg);

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
  }

  &.completed {
    transform: translateY(-150vw) rotate(+22.5deg);
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
    justify-content: start;
    padding: 0.75em;
    transition: transform 2s ease;
    box-shadow: 0.5vw 0.325vw 1.5vw rgba(0,0,0,0.5);

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
      background-size: 8em 8em;

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
        background-size: 14em;
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
      line-height: 2.875em;
      font-family: 'IM Fell DW Pica SC', serif;
      font-size: 1.5em;
      letter-spacing: 0.125em;
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
      top: 5em;
      right: 0;
      bottom: 0;
      display: flex;
      flex-direction: column;
      justify-content: center;
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
      height: 1em;
      margin-top: 1em;
      font-size: 0.875em;
    }

    .comment-field {
      position: absolute;
      opacity: 0;
      pointer-events: none;
    }

    .input {
      appearance: none;
      width: 75%;
      border-width: 0 0 0.03125em 0;
      border-color: black;
      border-style: dashed;
      margin: 0.5em auto;
      padding: 0;
      font-family: 'IM Fell DW Pica', serif;
      font-size: 1.25em;
      font-style: italic;
      font-weight: 700;
      line-height: 2em;
      color: #26f;
      text-align: center;
      display: block;
      box-sizing: border-box;

      &::placeholder {
        font-family: 'IM Fell DW Pica SC', serif;
        font-size: 0.675em;
        font-style: normal;
        font-weight: 400;
        letter-spacing: 0.025em;
        color: #000;
      }
    }

    button {
      width: 10em;
      height: 3em;
      margin: 1.5em auto 0 auto;
      padding: 0;
      border: 0 none;
      background-color: transparent;
      background-image: url('/assets/btn.svg');
      background-position: 50% 50%;
      background-repeat: no-repeat;
      background-size: contain;
      font-family: 'IM Fell DW Pica SC', serif;
      font-size: 1em;
      font-weight: 700;
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

  .page .body-text {
    margin: 1em 0;
  }

  .book {
    height: 70vw;

    .spread-login .page .body-text,
    .spread-thank-you .page .body-text {
      width: 70%;
    } 
  }
}

</style>