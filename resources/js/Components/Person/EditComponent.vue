<script setup>

</script>

<script>
import axios from "axios";

export default {
    name: 'EditComponent',
    data() {
        return {

            name: null,
            age: null,
            job: null,
            id: null

        }
    }
    ,
    props:["person","settings"],
    mounted() {


    },
    methods:
        {
            updatePerson(id) {

                axios.patch(`/api/people/${id}`, {name: this.person.name, age: this.person.age, job: this.person.job}).then(res => {
                    console.log(res);
                    this.$emit('editComp');
                });
            },

        }
}
//

</script>

<template>
        <tr v-if="this.settings.editVisible && this.settings.indexVisible==this.settings.index">
        <th scope="row">{{ person.id}}</th>
        <td><input type="text" class="form-input" v-model="person.name"></td>
        <td><input type="number" class="form-input" v-model="person.age"></td>
        <td><input type="job" class="form-input" v-model="person.job"></td>
        <td v-on:click="updatePerson(person.id)"><a href="#" class="btn btn-info">Update</a>
        </td>
    </tr>


</template>

<style scoped>

table {
    border: 1px solid grey;
}

</style>
