<template>

  <div class="step step-1" v-if="step === 1">

    <h4>Please enter your invitation code to continue.</h4>

    <input type="text" id="id"/><br/><br/>

    <button v-on:click="lookupGuest">Continue</button>

    <div class="error-message">{{ errorMessage }}</div>

  </div>

  <div class="step step-2" v-if="step === 2">

    <p>Hello <b>{{ guest.guest1FirstName }}</b>!</p>

    <p>Is this your email?</p>

    <input type="text" v-model="guest.email"/><br/><br/>

    <button v-on:click="next">Continue</button>
  </div>

  <div class="step step-3" v-if="step === 3">

    <h4>Please check your meal preference.</h4>

    <div class="input-row">
      <input type="radio" name="meal" value="veg" id="meal-veg" v-model="guest.guest1Meal"/>
      <label for="meal-veg">Vegetable</label>
      <input type="radio" name="meal" value="beef" id="meal-beef" v-model="guest.guest1Meal"/>
      <label for="meal-beef">Beef</label>
      <input type="radio" name="meal" value="chicken" id="meal-chicken" v-model="guest.guest1Meal"/>
      <label for="meal-chicken">Chicken</label>
    </div>

    <h4>Any dietary notes? (allergies, restrictions, etc.?)</h4>

    <div class="input-row">
      <textarea spellcheck="false" v-model="guest.guest1DietaryNotes"></textarea>
    </div>

    <button v-on:click="next">Continue</button>
  </div>

  <div class="step step-4" v-if="step === 4">

    <h4>Please check your alcohol preference.</h4>
    <div class="input-row">
      <input type="radio" name="alcohol" value="none" id="alcohol-none" v-model="guest.guest1AlcoholPref"/>
      <label for="alcohol-none">None</label>
      <input type="radio" name="alcohol" value="beer" id="alcohol-beer" v-model="guest.guest1AlcoholPref"/>
      <label for="alcohol-beer">Beer</label>
      <input type="radio" name="alcohol" value="wine" id="alcohol-wine" v-model="guest.guest1AlcoholPref"/>
      <label for="alcohol-wine">Wine</label>
    </div>

    <button v-on:click="modifyGuest">Continue</button>
  </div>

  <div class="step step-5" v-if="step === 5">

    <h3>Thank you!</h3>

    <button v-on:click="reset">Let's do it all over again</button>
  </div>

</template>

<script>
import axios from "axios";

const baseURL = 
  process.env.NODE_ENV === 'development' ? 'http://localhost:3000/guests/' : 'guests/'

export default {
  data() {
    return this.initialState();
  },
  methods: {
    prev() {
      this.step--;
    },
    next() {
      this.step++;
    },
    initialState() {
      return {
        step: 1,
        errorMessage: null,
        guest: []
      }
    },
    reset() {
        Object.assign(this.$data, this.initialState());
    },
    lookupGuest() {

      const guestID = document.getElementById('id').value;

      if (guestID) {
        console.log('Guest ID: ' + guestID);

        axios.get(`${baseURL}${guestID}`)
          .then(response => {
            this.guest = response.data;
            console.log('success');
            console.log(response);
            this.next();
          })
          .catch(error => {
            //console.log(error);
            this.errorMessage = 'Something went wrong. (' + error + ')';
          });
      }
      else
      {
        this.errorMessage = 'Please enter an ID.';
      }

    },
    modifyGuest() {

      axios.put(`${baseURL}${this.guest.id}`, this.guest)
        .then(response => {
          console.log('success');
          console.log(response);
          this.next();
        })
        .catch(error => {
          console.log(error);
        });
    }
  }
};
</script>

<style lang="scss">

.book {
  position: relative;
  background: #393617;
  width: 90vw;
  height: 50vw;
  perspective: 200vw;
  border-radius: 0.5vw;
  box-shadow: 1.5vw 0.75vw 2vw #000, inset 0.125vw 0.125vw 0.1vw #757154, inset -0.125vw -0.125vw 0.1vw #0e0a07, inset -1vw -1vw 2vw rgba(0,0,0,0.5);

  &::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-image: url('/assets/leather.jpg');
    background-size: 15vw;
    mix-blend-mode: soft-light;
    border-radius: 0.5vw;
  }

  .spread {
    position: absolute;
    z-index: 1;
    top: 1vw;
    right: 1vw;
    bottom: 1vw;
    left: 1vw;
    transition: z-index 1s linear;


    .page {
      backface-visibility: hidden;
      position: absolute;
      top: 0;
      bottom: 0;
      width: 50%;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      transform: rotateY(0deg);
      transition: transform 1s cubic-bezier(0.645, 0.045, 0.355, 1), filter 1s cubic-bezier(0.645, 0.045, 0.355, 1);
      transform-origin: 0% 0%;
      filter: brightness(0.9) contrast(1.1);

      &.left {
        left: 0;
        background-image: linear-gradient(to left, #8f7c5f 0%, #ae9776 12.5%, #bea683 50%, #bea684 100%);
        transform-origin: 100% 0;
        transform: rotateY(180deg);
        z-index: 1;
      }

      &.right {
        right: 0;
        background-image: linear-gradient(to right, #a89373 0%, #c1aa87 1%, #c0a885 12.5%, #a28c6c 50%, #a58e6e 100%);
      }

      > div,
      > img {
        user-select: none;
      }

      > div,
      > img,
      > input {
        mix-blend-mode: multiply;
      }

      .img-small {
        display: block;
        margin: 0 auto;
        width: 25%;
        transform: translateX(-0.25vw);
      }

      .img-full {
        max-height: 85%;
        max-width: 100%;
      }

      @keyframes reveal-form-field {
        0%    { height: 0;    opacity: 0; }
        50%   { height: 8.25em; opacity: 0; }
        100%  { height: 8.25em; opacity: 1; }
      }

      .body-text {
        max-width: 35vw;
        text-align: center;
        overflow: hidden;
        margin-bottom: 1em;

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

      .input {
        appearance: none;
        font-size: 2em;
        font-family: serif;
        border-radius: 0;
        border-style: solid;
        border-width: 2px;
        border-color: #888;
        color: #333;
        margin: 1.5em 0;
        padding: 0;
        outline: none;
        width: 4em;
        text-align: center;
      }

      textarea {
        resize: none;
        width: 100%;
        height: 6em;
        background-color: transparent;
        background-image: url('/assets/textarea.svg');
        background-repeat: repeat;
        background-size: 2em;
        border: 0 none;
        margin-top: -0.5em;
        padding: 0 0.25em;
        font-family: 'homemade apple',script;
        font-size: 1em;
        line-height: 2em;
        color: #26f;
        text-align: center;

        &,
        &:focus {
          outline: none;
        }
      }

      button {
        appearance: none;
        border: 0 none;
        border-radius: 0;
        font-family: "cormorant Garamond",serif;
        font-size: 1em;
        font-weight: 400;
        outline: none;
        margin-top: 1em;
        padding: .5em 1em;
        background-color: #eee;

        &:active {
          background-color: #ccc;
        }
      }

      .input-row {
        //margin-bottom: 3em;
      }

      label {
        margin-right: 1em;

        &:last-of-type {
          margin-right: 0;
        }
      }

      @keyframes pageturn-reveal {
        to   { transform: scale(1.0); }
      }

      @keyframes pageturn-breathe {
        from { transform: scale(1); }
        to   { transform: scale(1.05); }
      }

      .page-turn {
        cursor: pointer;
        position: absolute;
        width: 70%;
        mix-blend-mode: soft-light;
        right: 0;
        bottom: 0;
        transform: scale(0);
        transform-origin: 100% 100%;
        animation-delay: 0s, 1s;
        animation-direction: normal, alternate-reverse;
        animation-duration: 1s, 1s;
        animation-iteration-count: 1, infinite;
        animation-timing-function: ease, linear;

        svg {
          display: block;
        }

        &.shown {
          animation-name: pageturn-reveal, pageturn-breathe; 
        }
      }

      @keyframes page-turn-tip-reveal {
        from { opacity: 0; }
        to   { opacity: 0.8; }
      }

      @keyframes page-turn-tip-breathe {
        from { opacity: 0.2; }
        to   { opacity: 0.8; }
      }

      .page-turn-tip {
        position: absolute;
        width: 100%;
        bottom: 2em;
        font-size: 0.875em;
        text-align: center;
        opacity: 0;
        animation-delay: 0s, 1s;
        animation-direction: normal, alternate-reverse;
        animation-duration: 1s, 1s;
        animation-iteration-count: 1, infinite;
        animation-timing-function: ease, linear;
      }

      .page-turn.shown ~ .page-turn-tip {
        animation-name: page-turn-tip-reveal, page-turn-tip-breathe;
      }
    }
  }

  &.show-1 {
    .spread-1 {
      z-index: 3;

      .page { filter: none; }

      .page.left {
        transform: rotateY(0deg);
      }
    }
    .spread-2 {
      z-index: 2;
    }
  }

  &.show-2 {
    .spread-1 {
      z-index: 2;

      .page.left {
        transform: rotateY(0deg);
      }

      .page.right {
        transform: rotateY(-180deg);
      }
    }
    .spread-2 {
      z-index: 3;

      .page { filter: none; }

      .page.left {
        transform: rotateY(0deg);
      }
    }
    .spread-3 {
      z-index: 2;

      .page.right {
        transform: rotateY(0deg);
      }
    }
  }

  &.show-3 {
    .spread-1 {
      z-index: 2;

      .page.left {
        transform: rotateY(0deg);
      }

      .page.right {
        transform: rotateY(-180deg);
      }
    }
    .spread-2 {
      z-index: 2;

      .page.left {
        transform: rotateY(0deg);
      }

      .page.right {
        transform: rotateY(-180deg);
      }
    }
    .spread-3 {
      z-index: 3;

      .page { filter: none; }

      .page.left {
        transform: rotateY(0deg);
      }
    }
  }

  &.show-4 {
    .spread-1 {
      z-index: 2;

      .page.left {
        transform: rotateY(0deg);
      }

      .page.right {
        transform: rotateY(-180deg);
      }
    }
    .spread-2 {
      z-index: 2;

      .page.left {
        transform: rotateY(0deg);
      }

      .page.right {
        transform: rotateY(-180deg);
      }
    }
    .spread-3 {
      z-index: 2;

      .page.left {
        transform: rotateY(0deg);
      }

      .page.right {
        transform: rotateY(-180deg);
      }
    }
    .spread-4 {
      z-index: 3;

      .page { filter: none; }

      .page.left {
        transform: rotateY(0deg);
      }
    }
  }
}
</style>