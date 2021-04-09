<template>
    <div class="border border-dark p-3 mx-auto">
        <p><strong>Product Name: </strong>{{ product.name }}</p>
        <p><strong>Product Category: </strong>{{ product.category }}</p>
        <p><strong>Product Description: </strong>{{ product.description }}</p>
        <p><strong>Date and Time: </strong>{{ product.date_time }}</p>
        <p><strong>Created by: </strong>{{ product.created_by }}</p>
    </div>
</template>
<script>
export default {
    props: ['product']
}
</script>
<style scoped>
div {
    width: 500px;
}
p {
    font-size: 14px;
}
</style>