<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-md-6 px-3 my-2">
                        <select id="slct_category" class="custom-select" @change="productCategory()">
                            <option disabled selected>Category</option>
                            <option value="All">All</option>
                            <option v-for="(category, index) in categories" :key="index" :value="category.category">
                            {{ category.category }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-6 px-3 my-2 d-flex">
                    <input class="form-control" type="text" id="keyword" placeholder="Search product name or description" aria-label="Search">
                    <button class="btn btn-sidebar" @click="searchKeyword()">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                    </div>
                </div>
            
                <paginate
                    name="products"
                    :list="products"
                    :per="3"
                    >
                    <li v-for="product in paginated('products')">
                        <list-view 
                        :products="product" 
                        v-on:reloadList="getProducts()"
                        />
                    </li>
                </paginate>
                <paginate-links for="products" :show-step-links="true" class="d-flex"></paginate-links>
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
            products: [],
            categories: [],
            paginate: ['products']
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
        },
        getCategories() {
            axios.get('api/categories')
            .then(response => {
                this.categories = response.data
            })
            .catch(error => {
                console.log(error);
            });
        },
        productCategory() {
            var category = document.getElementById('slct_category').value;
            axios.get('api/category/' + category)
            .then(response => {
                this.products = response.data
            })
            .catch(error => {
                console.log(error);
            })
        },
        searchKeyword() {
            var keyword = document.getElementById('keyword').value;
            if (keyword != ''){
                axios.get('api/search/' + keyword)
                .then(response => {
                    this.products = response.data
                })
                .catch(error => {
                    console.log(error);
                })
            } else {
                axios.get('api/search/all')
                .then(response => {
                    this.products = response.data
                })
                .catch(error => {
                    console.log(error);
                })
            }
        }
    },
    created() {
        this.getProducts();
        this.getCategories();
    }
}
</script>
<style scoped>
ul, li {
    list-style: none !important;
    padding-inline-start: 0 !important;
}
</style>
<style>
ul.paginate-links > li.disabled > a {
    color: red;
}
ul.paginate-links > li.number > a {
    color: blue;
}
ul.paginate-links > li.number {
    margin-left: 5px;
    margin-right: 5px;
}
ul.paginate-links > li.number:hover, .left-arrow:hover, .right-arrow:hover{
    cursor: pointer;
}
ul.paginate-links > li.number.active > a {
    color: black !important;
}
ul.paginate-links > li.number {
    background-color: #ffffff;
    padding: 3px 5px;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    text-align: center;
}
</style>