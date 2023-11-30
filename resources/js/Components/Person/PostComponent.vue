<script setup>
import IndexComponent from "@/Components/Person/IndexComponent.vue";
import CreateComponent from "@/Components/Person/CreateComponent.vue";
import {ref} from "vue";

import Index from "@/Components/PostWithRouterVue/Index.vue";

let upd = null;

const ind = ref(null);

function createIndex(val)
{
    upd = val;
   ind.value.getPeople();

}


</script>
<script>
import CreateComponent from "@/Components/Person/CreateComponent.vue";
import IndexComponent from "@/Components/Person/IndexComponent.vue";
import axios from "axios";

// export default {
//     name: 'PostComponent',
//     data() {
//         return {
//             persons:
//                 null,
//             upd: false
//
//         }
//     },
//
//     mounted() {
//
//     }
//     ,
//     methods: {
//         createIndex(value) {
//             this.upd = value;
//
//
//     }
//     ,
//     components:
//         {
//             IndexComponent,
//             CreateComponent
//         }
//
// }
// }

</script>

<template>

    <create-component ref="ssss" v-on:createIndex="createIndex"></create-component>
    <index-component :upd="upd"  ref="ind" ></index-component>

</template>

<style scoped>
table {
    border: 1px solid grey;
}
</style>
