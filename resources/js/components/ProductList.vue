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
	<div>
		<h1>Product List</h1>
		<ProductForm :product="editingProduct" @saved="onSaved"/>
		<table class="product-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="product in products" :key="product.id">
                    <td>{{ product.name }}</td>
                    <td>{{ product.price }}</td>
                    <td>{{ product.stock }}</td>
					<td>
						<button  @click="editProduct(product)" >Edit</button>
						-

						<button  @click="deleteProduct(product.id)" >Delete</button>
					</td>
                </tr>
            </tbody>
        </table>
	</div>
</template>


<style>

.product-table {
    border-collapse: collapse;
    width: 100%;
}
.product-table th,
.product-table td {
    border: 1px solid #333;
    padding: 8px;
}
</style>
