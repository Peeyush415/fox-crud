<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

import Login from './Login.vue';
import Register from './Register.vue';
import ProductList from './ProductList.vue';

const user = ref(null);
const showRegister = ref(false);
const checkingAuth = ref(true);

function checkAuth() {
    axios.get('/api/user')
        .then(response => {
            user.value = response.data;
        })
        .catch(() => {
            user.value = null;
        })
        .finally(() => {
            checkingAuth.value = false;
        });
}

function logout() {
    axios.post('/logout').then(() => {
        user.value = null;
    });
}

onMounted(checkAuth);
</script>

<template>
    <div v-if="checkingAuth" class="flex min-h-screen items-center justify-center text-gray-500">
        Loading...
    </div>

    <div v-else-if="user">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-6 pt-6">
            <span class="text-gray-800">Welcome, {{ user.name }}</span>
            <button @click="logout" class="rounded-md bg-gray-200 px-3 py-1 text-sm hover:bg-gray-300">Logout</button>
        </div>
        <ProductList />
    </div>

    <div v-else class="mx-auto max-w-md p-6">
        <Login v-if="!showRegister" @loggedIn="checkAuth" />
        <Register v-else @registered="checkAuth" />
        <button @click="showRegister = !showRegister" class="text-sm text-blue-600 hover:underline">
            {{ showRegister ? 'Already have an account? Login' : 'New user? Register' }}
        </button>
    </div>
</template>
