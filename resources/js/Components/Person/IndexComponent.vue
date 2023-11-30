<script setup>
import ShowComponent from "@/Components/Person/ShowComponent.vue"
import EditComponent from "@/Components/Person/EditComponent.vue";
import axios from "axios";
import {computed, onMounted, ref, watch} from "vue";

let people = ref(0);
const editVisible = ref(false);
const indexVisible = ref(0);
//let index, person = ref(null);
const name = ref(null);
const age = ref(null);
const job = ref(null);
const id = ref(null);

defineExpose({getPeople});

let props = defineProps(['upd']);
console.log(props.upd);


function getPeople() {
    axios.get('/api/people').then(res => {
        people.value = res.data;

    });

};

function fillInput(id, name, age, job) {
    console.log(editVisible);


};



getPeople();
</script>


<script>
import axios from "axios";
import EditComponent from "@/Components/Person/EditComponent.vue";


// export default {
//     name: 'IndexComponent',
//     data() {
//         return {
//             people: null,
//             editVisible: false,
//             indexVisible: null,
//             name: null,
//             age: null,
//             job: null,
//             id:null,
//         }
//     }
//     ,
//     mounted() {
//
//         this.getPeople();
//
//     },
//     components:{
//         EditComponent,
//     },
//     methods:
//         {
//             getPeople() {
//                 axios.get('/api/people').then(res => {
//                     this.people = res.data;
//                 })
//             },
//
//             fillInput(id, name, age, job) {
//                 for (let i = 0; i < this.people.length; i++) {
//                     this.$refs.editRef[i].name = name;
//                     this.$refs.editRef[i].age = age;
//                     this.$refs.editRef[i].job = job;
//
//                 }
//                 console.log(this.upd);
//             },
//             deletePerson(id) {
//
//                 axios.delete(`/api/people/${id}`).then(res => {
//                     console.log(res);
//                     this.getPeople();
//                 });
//             },
//
//         },
//     props:["upd"],
//
//
//
//
// }

</script>

<template>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Name</th>
                <th scope="col">Age</th>
                <th scope="col">Job</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
            </tr>
            </thead>
            <tbody>
            <template v-for="(person,index) in people">
                <ShowComponent :person="person"  v-on:editVisible="editVisible=true,indexVisible=index" v-on:del="getPeople()" > </ShowComponent>
                <edit-component :person="person"
                                :settings="{'editVisible':editVisible,'indexVisible':indexVisible,'index':index}"
                                 v-on:editComp="editVisible=false,indexVisible=null,getPeople()"
                ></edit-component>
            </template>

            </tbody>


        </table>
        <div>
            {{ indexVisible }}
        </div>
    </div>

</template>

<style scoped>

table {
    border: 1px solid grey;
}

</style>
