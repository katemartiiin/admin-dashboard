<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <list-view 
                    :products="products" 
                    v-on:reloadList="getProducts()"
                    />
            </div>
        </div>
    </div>
</template>
<script>
import listView from './listView'
export default {
    components: {
        listView
    },
    data: function () {
        return {
            products: []
        }
    },
    methods: {
        getProducts() {
            axios.get('api/products')
            .then(response => {
                this.products = response.data
            })
            .catch(error => {
                console.log(error);
            })
        }
    },
    created() {
        this.getProducts();
    }
}
</script>