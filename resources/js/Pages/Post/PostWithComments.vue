<script setup>
import {onMounted, ref,} from "vue";
import {router} from "@inertiajs/vue3";

let data = ref({
    title: '',
    content: '',

})
const props = defineProps(['data','comments']);
const post = ref(props.data.post[0])

const RepostVisible = ref(false)
const Comments = ref(props.data.comments.data)
const CommentVisible = ref(false)
const deletePostId = ref(null)
const comment_body = ref()

const parentComment = ref(null)



function addComment(post) {
    let parent_id = parentComment.value != null ? parentComment.value.id : null;
    router.post(`/posts/${post.id}/comment`,
        {
            body: comment_body.value,
            post_id: post.id,
            parent_id: parent_id
        },
        {
            onSuccess: (page) => {
                console.log(page)
                comment_body.value=''
                Comments.value=props.data.comments.data
            },

        }
    )


}



</script>

<template>

    <div class="box-content h-32 w-96 p-4  mx-auto">
        <div class="mb-3" v-if="(deletePostId===null)">
            <h1 class="text-xl text-center  "> {{ post.title }}</h1>
            <img v-if="post.image_url" :src="post.image_url" :alt="post.title" width="400" height="400">
            <p class="break-words font-serif">{{ post.content }}</p>
            <div class="flex justify-between items-center mt-3">
                <p class="text-sm text-right 2 mt-2">{{ post.data }}</p>
            </div>
        </div>


        <div class="mt-4 ">
            <div class="mb-3">
                <input placeholder="comment" type="text" v-model="comment_body" ref="refToCommentBody"
                       class="form-input px-4 py-2 rounded-full border-2 border-gray-300 w-96">

                <div v-if="parentComment">
                    <p class="text-sm">Ответ {{ parentComment.user.name }}</p>
                    <p class="text-sm text-sky-500 cursor-pointer" @click="parentComment=null">Отменить</p>
                </div>

            </div>
            <!-- Добавление комментария -->
            <button class=" w-32  bg-blue-500  text-white  text-center border-1 rounded-3xl px-2 py-0.5
        hover:bg-white hover:text-black border border-gray-300 ml-72"
                    type="submit" @click="addComment(post)">
                Добавить
            </button>

            <div v-for="comment in Comments" class="items-center ml-auto justify-between">
                <div class="items-center   w-96">

                    <p class="">Пользователь:<span class="text-sky-500"> {{ comment.user.name }}</span></p>
                    <p class=""> {{ comment.comment }}</p>
                    <div class="items-center   w-96 bg-gray-100 box-content   border-l-4 border-l-sky-300 ml-10"
                         v-if="comment.parent_id">
                        <div v-for="comment_pId in props.Comments">
                            <div v-if="comment_pId.id==comment.parent_id">
                                <p class="">Пользователь:<span class="text-sky-500"> {{ comment_pId.user.name }}</span>
                                </p>
                                <p class=""> {{ comment_pId.comment }}</p>
                            </div>
                        </div>
                    </div>

                    <p class="cursor-pointer text-sm text-right text-sky-500" @click=addAnswer(comment)> ответить</p>
                    <p class="cursor-pointer text-sm text-right text-red-500"
                       v-if="comment.user.id===comment.auth_user_id" @click=deleteComment(comment)> удалить</p>
                    <p class=" text-sm text-right"> {{ comment.date }}</p>

                </div>

            </div>
        </div>


    </div>

</template>

<style scoped>

</style>
