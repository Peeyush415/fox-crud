<script setup>
import { ref } from 'vue';
import axios from 'axios';

const emit = defineEmits(['registered']);
const form = ref({
    name: '',
    email: '',
    password: '',
    password_confirmation: ''
});

const errors = ref({});
const generalError = ref('');
const loading = ref(false);

function register() {
    loading.value = true;
    errors.value = {};
    generalError.value = '';

    axios.get('/sanctum/csrf-cookie')
        .then(() => axios.post('/register', form.value))
        .then(() => {
            emit('registered');
        })
        .catch(error => {
            if (error.response?.status === 422) {
                errors.value = error.response.data.errors || {};
            } else {
                generalError.value = 'Unable to register. Please try again.';
            }
        })
        .finally(() => {
            loading.value = false;
        });
}
</script>

<template>
    <form @submit.prevent="register" class="mb-6 space-y-4 rounded-lg bg-white p-6 shadow-md">
        <h2 class="text-lg font-semibold text-gray-800">Register</h2>

        <div>
            <input v-model="form.name" placeholder="Name" class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            <p v-if="errors.name" class="mt-1 text-sm text-red-600">{{ errors.name[0] }}</p>
        </div>

        <div>
            <input v-model="form.email" type="email" placeholder="Email" class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            <p v-if="errors.email" class="mt-1 text-sm text-red-600">{{ errors.email[0] }}</p>
        </div>

        <div>
            <input v-model="form.password" type="password" placeholder="Password" class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            <p v-if="errors.password" class="mt-1 text-sm text-red-600">{{ errors.password[0] }}</p>
        </div>

        <div>
            <input v-model="form.password_confirmation" type="password" placeholder="Confirm Password" class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <p v-if="generalError" class="text-sm text-red-600">{{ generalError }}</p>

        <button
            type="submit"
            :disabled="loading"
            class="w-full rounded-md bg-blue-600 py-2 font-medium text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50"
        >
            {{ loading ? 'Registering...' : 'Register' }}
        </button>
    </form>
</template>
