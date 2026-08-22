<script setup>
import { ref, watch } from 'vue';
import axios from 'axios';

const form = ref({
	'name': '',
	'description': '',
	'price': '',
	'stock': ''
})

const props = defineProps(['product']);
const emit = defineEmits(['saved']);

watch(() => props.product, (newProduct) => {
	console.log('Product prop changed:', newProduct);
	if (newProduct) {
		form.value = { ...newProduct };
	} else {
		form.value = {
			'name': '',
			'description': '',
			'price': '',
			'stock': ''
		};
	}
}, { immediate: true });

function submit() {
	console.log(form.value);

	if (props.product) {
		axios.put(`/api/products/${props.product.id}`, form.value)
			.then(response => {
				console.log('Product updated:', response.data);
				resetForm();
				emit('saved');
			});
	} else {
		axios.post('/api/products', form.value)
			.then(response => {
				console.log('Product created:', response.data);
				resetForm();
				emit('saved');
			});
	}
}

function resetForm() {
	form.value = {
		'name': '',
		'description': '',
		'price': '',
		'stock': ''
	};
}

</script>

<template>
	<form @submit.prevent="submit" class="mb-6 space-y-4 rounded-lg bg-white p-6 shadow-md">
		<h2 class="text-lg font-semibold text-gray-800">{{ product ? 'Edit Product' : 'Add Product' }}</h2>

		<input
			v-model="form.name"
			type="text"
			placeholder="Product Name"
			class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
		/>

		<input
			v-model="form.description"
			type="text"
			placeholder="Product Description"
			class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
		/>

		<input
			v-model="form.price"
			type="number"
			placeholder="Product Price"
			class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
		/>

		<input
			v-model="form.stock"
			type="number"
			placeholder="Product Stock"
			class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
		/>

		<button
			type="submit"
			class="w-full rounded-md bg-blue-600 py-2 font-medium text-white transition hover:bg-blue-700"
		>
			{{ product ? 'Update' : 'Create' }}
		</button>
	</form>
</template>
