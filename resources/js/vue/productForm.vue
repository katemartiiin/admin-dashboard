<template>
    <div class="addItem">
        <input type="text" v-model="product.name" />
        <input type="text" v-model="product.category" />
        <input type="text" v-model="product.description" />
        <input type="text" v-model="product.date_time" />
        <input type="text" v-model="product.created_by" />
        <button @click="addItem()">Add</button>
    </div>
</template>
<script>
export default {
    data: function () {
        return {
            product: {
                name: "",
                category: "",
                description: "",
                date_time: "",
                created_by: ""
            }
        }
    },
    methods: {
        addItem() {
            if (this.product.name == '') {
                return;
            }

            axios.post('api/product/store', {
                product: this.product
            })
            .then( response => {
                if (response.status == 201) {
                    // this.$emit('reloadList');
                    window.location.href = 'http://localhost:8000/products';
                }
            })
            .catch(error => {
                console.log(error);
            });
        }
    }
}
</script>