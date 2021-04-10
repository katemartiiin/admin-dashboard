<template>
    <div class="border border-dark p-3 mx-auto">
        <input type="text" id="product_name" :value="product.name" />
        <input type="text" id="product_category" :value="product.category" />
        <input type="text" id="product_description" :value="product.description" />
        <input type="datetime-local" id="product_datetime" />
        <button @click="updateProduct()">Update</button>
    </div>
</template>
<script>
import moment from 'moment';
export default {
    data: function () {
        return {
            product: []
        }
    },
    methods: {
        getProduct() {
            axios.get('http://localhost:8000/api' + window.location.pathname)
            .then(response => {
                this.product = response.data;
                document.getElementById('product_datetime').value = moment(String(response.data.date_time)).format('YYYY-MM-DDThh:mm');
                
            })
            .catch(error => {
                console.log(error);
            });
        },
        updateProduct() {
            var name = document.getElementById('product_name').value;
            var category = document.getElementById('product_category').value;
            var description = document.getElementById('product_description').value;
            var date_time = document.getElementById('product_datetime').value;
            axios.put('http://localhost:8000/api/product/' + this.product.id, {
                product: {
                    name: name,
                    category: category,
                    description: description,
                    date_time: date_time
                }
            })
            .then(response => {
                if (response.status == 200){
                    window.location.href = 'http://localhost:8000/products';
                }
            })
            .catch(error => {
                console.log(error);
            });
        }
    },
    created() {
        this.getProduct();
    }
}
</script>