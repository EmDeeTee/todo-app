<script setup>
import axios from 'axios';
import { ref } from 'vue'

const props = defineProps({
    content: String,
    isCompleted: Boolean,
    id: Number, // Database ID,
    func: Function
})

function onDeleteElement() {
    axios.post('/api/delete-todo', {
        id: props.id
    })
    props.func()
}

</script>

<template>
    <div class="flex relative flex-row p-2 items-center">
        <input @click="isCompleted = !isCompleted" class="cursor-pointer mr-1 size-8 " style="color: green;" type="checkbox" name="" id="">
        <p class="font-semibold ml-2" :class="{'line-through': isCompleted}">{{ content }}</p>
        <button @click="onDeleteElement()" class="absolute right-1 bg-red-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full ">Delete</button>
    </div>
</template>