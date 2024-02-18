<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, useAttrs } from 'vue'
import Todo from './Todo.vue'
import axios from 'axios';
import { useToast } from "vue-toastification";

const todos = ref({});
const text = ref('')
const attrs = useAttrs()

function onEnter() {
    if (text.value.length === 0)
        return
    if (text.value.toLowerCase() == 'fuck you') {
        const toast = useToast();
        toast("Fuck you too", {
            type: 'error',
            position: 'bottom-center'
        })
        return;
    }
    axios.post('/api/add-todo', {
        content: text.value,
        isCompleted: false,
        apiToken: attrs.apiToken,
    })
    fetchTodos()
    text.value = ''
}

function fetchTodos() {
    axios.post('/api/get-todos', {
        apiToken: attrs.apiToken
    }).then((data) => {
        todos.value = data.data;
    }).catch(() => {
        const toast = useToast();
        toast("Can't featch data from API", {
            type: 'error',
            position: 'bottom-center'
        })
    })
}

fetchTodos()
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout :apiToken = $attrs.apiToken>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <input v-model="text" v-on:keyup.enter="onEnter" class="w-full mb-2" type="text" placeholder="Your todo...">
                        <div v-for="todo in todos">
                            <Todo :content=todo.content :id=todo.id :func="fetchTodos"></Todo>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
