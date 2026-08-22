<script setup>
import { ref, watch, onMounted } from 'vue';
import axios from 'axios';
import ProductForm from './ProductForm.vue';

const products = ref([]);
const editingProduct = ref(null);

function editProduct(product) {
	console.log('Editing product:', product);
	editingProduct.value = product;
}


function deleteProduct(id) {
	if( ! confirm('Are you sure to delete this product ?')) return;

	axios.delete(`/api/products/${id}`)
		.then(response => {
			console.log('Product deleted:', response.data.data);
			fetchProducts(); // Refresh the product list after deletion
		});
}

function onSaved() {
    editingProduct.value = null;
    fetchProducts();
}

function fetchProducts() {
	axios.get('/api/products')
		.then(response => {
			console.log('Products fetched:', response.data);
			products.value = response.data.data;
		});
}

onMounted(fetchProducts);

</script>


<template>
	<div class="mx-auto max-w-6xl p-6">
		<h1 class="mb-4 text-2xl font-bold text-gray-800">Product List</h1>
		<div class="flex flex-col gap-6 md:flex-row md:items-start">
			<div class="md:w-1/3">
				<ProductForm :product="editingProduct" @saved="onSaved"/>
			</div>
			<table class="w-full overflow-hidden rounded-lg bg-white shadow-md md:w-2/3">
				<thead class="bg-gray-100">
					<tr>
						<th class="border-b border-gray-200 px-4 py-2 text-left">Name</th>
						<th class="border-b border-gray-200 px-4 py-2 text-left">Price</th>
						<th class="border-b border-gray-200 px-4 py-2 text-left">Stock</th>
						<th class="border-b border-gray-200 px-4 py-2 text-left">Action</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="product in products" :key="product.id" class="hover:bg-gray-50">
						<td class="border-b border-gray-100 px-4 py-2">{{ product.name }}</td>
						<td class="border-b border-gray-100 px-4 py-2">{{ product.price }}</td>
						<td class="border-b border-gray-100 px-4 py-2">{{ product.stock }}</td>
						<td class="border-b border-gray-100 px-4 py-2 space-x-3">
							<button @click="editProduct(product)" class="text-blue-600 hover:underline">Edit</button>
							<button @click="deleteProduct(product.id)" class="text-red-600 hover:underline">Delete</button>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</template>
