<template>
    <div class="bg-card pb-5">
        <div class="row">
            <div class="col-8">
                <h4 class="text-info">{{ product.name }}</h4>
                <p class="m-0 fs-14">{{ product.description }}</p>
                <br>
                <p class="m-0 fs-14"><strong>Product Category: </strong>{{ product.category }}</p>
                <p class="m-0 fs-14"><strong>Date and Time: </strong>{{ product.date_time }}</p>
                <p class="m-0 fs-14"><strong>Created by: </strong>{{ product.created_by }}</p>
            </div>
            <div class="col-4 text-right">
                <router-link :to="{ name: 'edit', params: {id: product.id } }" class="fs-14 btnEdit">Edit</router-link>
                <button @click="removeProduct()" class="bg-transparent border-0"><i class="fa fa-trash text-danger"></i></button>
            </div>
        </div>
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
<style scoped>
.bg-card{
    background-color: #FFFFFF;
    border-radius: .5rem;
    padding: 20px 40px;
    box-shadow: 1px 1px 5px 1px rgba(0, 0, 0, 0.1);
}
.fs-14{
    font-size: 14px;
}
.btnEdit {
    background-color: #007bff;
    color: #ffffff;
    padding: 0px 7px;
}
.btnEdit:hover{
    text-decoration: none !important;
    background-color: #0062cc;
}
</style>