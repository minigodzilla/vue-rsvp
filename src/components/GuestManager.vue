<template>

  <h3>Lookup</h3>

  <label>ID</label>
  <input type="text" id="id"/><br/><br/>
  <label></label><button v-on:click="lookupGuest">Lookup</button>
  <div class="error-message"></div>

  <br/>

  <div v-if="guest.id">

    <h3>Display</h3>

    <div><label>ID</label> <b>{{ guest.id }}</b></div>
    <div><label>email</label> <b>{{ guest.email }}</b></div>
    <div><label>guest1FirstName</label> <b>{{ guest.guest1FirstName }}</b></div>
    <div><label>guest1LastName</label> <b>{{ guest.guest1LastName }}</b></div>
    <div><label>guest1Meal</label> <b>{{ guest.guest1Meal }}</b></div>
    <div><label>guest1DietaryNotes</label> <b>{{ guest.guest1DietaryNotes }}</b></div>
    <div><label>guest1AlcoholPref</label> <b>{{ guest.guest1AlcoholPref }}</b></div>

    <br/>

    <h3>Modify</h3>

    <label>email</label>
    <input type="text" v-model="guest.email"/><br/>

    <label>guest1FirstName</label>
    <input type="text" v-model="guest.guest1FirstName"/><br/>

    <label>guest1LastName</label>
    <input type="text" v-model="guest.guest1LastName"/><br/>

    <label>guest1Meal</label>
    <input type="text" v-model="guest.guest1Meal"/><br/>

    <label>guest1DietaryNotes</label>
    <input type="text" v-model="guest.guest1DietaryNotes"/><br/>

    <label>guest1AlcoholPref</label>
    <input type="text" v-model="guest.guest1AlcoholPref"/><br/><br/>

    <label></label><button v-on:click="modifyGuest">Modify</button>
      
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
    initialState() {
      return {
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
          })
          .catch(error => {
            console.log(error);
          });
      }
      else
      {
        console.log('put in an ID you dummy');
      }

    },
    modifyGuest() {

      axios.put(`${baseURL}${this.guest.id}`, this.guest)
        .then(response => {
          console.log('success');
          console.log(response);
          //reset();
        })
        .catch(error => {
          console.log(error);
        });
    }
  }
};
</script>

<style>
label {
  display: inline-block;
  width: 10em;
}
</style>