<script setup>

import axios from "axios";
import {ref} from "vue";

const props = defineProps(["person"]);

const emit = defineEmits(['editVisible','del']);

function setEmit (){
    emit('editVisible');
}
function deletePerson(id) {

    axios.delete(`/api/people/${id}`).then(res => {
        console.log(res);
        emit('del');
    });
};
</script>


<script>


</script>

<template>
    <tr>
        <th scope="row">{{ person.id }}</th>
        <td>{{ person.name }}</td>
        <td>{{ person.age }}</td>
        <td>{{ person.job }}</td>
        <td v-on:click="setEmit">
            <a href="#" class="btn btn-success">Edit</a></td>
        <td v-on:click="deletePerson(person.id)"><a href="#" class="btn btn-success">Delete</a></td>
    </tr>

</template>

<style scoped>

table {
    border: 1px solid grey;
}

</style>
