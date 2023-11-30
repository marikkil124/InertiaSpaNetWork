
<script setup>
import axios from "axios";
import {ref} from "vue";
const people = null;
const name= ref(null);
const age = ref(null);
const job = ref(null);
const upd = false;
 const addPersons =function ()
 {
     axios.post('api/people',{name:this.name,age:this.age,job:this.job}).then(res=>{

                   this.name = null;
                   this.age =null;
                   this.job =null;
                   //чтоб обновить индекс компонент после добавления
                   this.upd=true;
                   emit('createIndex',this.upd);
                 console.log(this.upd);
                   });

 }

const emit = defineEmits(['createIndex']);

</script>


<script>
// import axios from "axios";
// import indexComponent from "@/Components/Person/IndexComponent.vue";


// export default {
//     name: 'CreateComponent',
//     data(){
//         return{
//             people:null,
//             name:null,
//             age:null,
//             job:null,
//             upd: false
//         }
//     },
//     methods:
//         {
//             addPersons(){
//                axios.post('api/people',{name:this.name,age:this.age,job:this.job}).then(res=>{
//                    this.name =null;
//                    this.age =null;
//                    this.job =null;
//                    //чтоб обновить индекс компонент после добавления
//                    this.upd=true;
//                    this.$emit('createIndex',this.upd);
//                    console.log(res)});
//             },
//             getPeople() {
//                 axios.get('/api/people').then(res => {
//                     this.people = res.data;
//                 })
//             }
//
//
//         },
//
//
//
// }

</script>

<template>
    <div class="w-25">
        <div class="mb-3">
            <input type="text" class="form-control"  v-model="name" id="name" placeholder="name">
        </div>
        <div class="mb-3">
            <input type="number" class="form-control"  v-model = "age" id="age" placeholder="age">
        </div>
        <div class="mb-3">
            <input type="text" class="form-control"  v-model = "job" id="job" placeholder="job">
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary"  v-on:click.prevent="addPersons()" value="Добавить">Добаить</button>
        </div>


<!--<show-component></show-component>-->
    </div>

</template>

<style scoped>

table {
    border: 1px solid grey;
}

</style>
