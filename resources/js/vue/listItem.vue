<template>
    <div class="border border-dark p-3 mx-auto">
        <p><strong>Product Name: </strong>{{ product.name }}</p>
        <p><strong>Product Category: </strong>{{ product.category }}</p>
        <p><strong>Product Description: </strong>{{ product.description }}</p>
        <p><strong>Date and Time: </strong>{{ product.date_time }}</p>
        <p><strong>Created by: </strong>{{ product.created_by }}</p>
        <router-link to="/products/edit">Edit</router-link>
        <button @click="removeProduct()">Delete</button>
    </div>
</template>
<script>
export default {
    props: ['product'],
    methods: {
        removeProduct() {
            axios.delete('/api/product/' + this.product.id)
            .then(response => {
                if (response.status == 200) {
                    this.$emit('itemchanged');
                }
            })
            .catch(error => {
                console.log(error);
            });
        }
    }
}
</script>