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
				emit('saved');
			});
	} else {
		axios.post('/api/products', form.value)
			.then(response => {
				console.log('Product created:', response.data);
				emit('saved');
			});
	}
}

</script>

<template>
	<form @submit.prevent="submit">
		<input
			v-model="form.name"
			type="text"
			placeholder="Product Name"
		/>

		<input
			v-model="form.description"
			type="text"
			placeholder="Product Description"
		/>

		<input
			v-model="form.price"
			type="number"
			placeholder="Product Price"
		/>

		<input
			v-model="form.stock"
			type="number"
			placeholder="Product Stock"
		/>
		<button type="submit">{{ product ? 'Update' : 'Create' }}</button>
	</form>

</template>

<style>
</style>
