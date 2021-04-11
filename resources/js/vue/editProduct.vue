<template>
    <div class="product-form col-md-12 py-4 px-3">
        <h5 class="ml-2">Edit product</h5>
        <div id="sOne" class="step--one px-5 pb-5 d-block mt-4">
            <div class="row">
                <div class="col-md-6 my-2">
                    <label>Product Name:</label>
                    <input type="text" class="form-control" id="prod_name" :value="product.name" placeholder="Enter product name" />
                </div>
                <div class="col-md-6 my-2">
                    <label>Product Category:</label>
                    <select id="product_category" class="custom-select">
                        <option disabled selected>Select category</option>
                        <option value="All">All</option>
                        <option v-for="(category, index) in categories" :key="index" :value="category.category" :selected="product.category === category.category">
                        {{ category.category }}
                        </option>
                    </select>
                </div>
                <div class="col-md-6 my-2">
                    <textarea class="form-control" placeholder="Enter product description" :value="product.description" id="prod_description"></textarea>
                </div>
            </div>
            <button class="my-3 float-right update-btn bg-primary" prev="sOne" curr="sOne" next="sTwo">Next >></button>
        </div>
        <div id="sTwo" class="step--two d-none px-5 pb-5 mt-4">
            <input @change="imageChange()" type="file" name="image" ref="files" class="my-5" multiple />
            <table class="table table-borderless table-striped fs-14">
                <thead class="thead-dark">
                    <tr>
                        <th>Images</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(picture, index) in pictures" :key="index">
                        <td>
                            <img v-for="(img, index) in picture.images" :key="index" :src="img" class="fluid" />
                        </td>
                        <td><button @click="removeImages(picture.id)" class="bg-transparent border-0"><i class="fa fa-trash text-danger"></i></button></td>
                    </tr>
                </tbody>
            </table>
            <button class="my-3 float-left prev-btn bg-secondary" prev="sOne" curr="sTwo"><< Prev</button>
            <button class="my-3 float-right update-btn bg-primary" curr="sTwo" next="sThree">Next >></button>
        </div>
        <div id="sThree" class="step--three d-none px-5 pb-5 mt-4">
            <label>Date and Time</label>
            <input type="datetime-local" class="form-control" id="product_datetime" />
            <button class="my-3 float-left prev-btn bg-secondary" prev="sTwo" curr="sThree"><< Prev</button>
            <button @click="updateProduct()" class="update-btn bg-info float-right" curr="sThree" next="sThree">Update</button>
        </div>
    </div>
</template>
<script>
$(document).ready(function(){
    $('.update-btn').click(function(){
        var nxt = $(this).attr('next');
        var curr = $(this).attr('curr');
        $('#' + nxt).removeClass('d-none').addClass('d-block');
        $('#' + curr).removeClass('d-block').addClass('d-none');
    });
    $('.prev-btn').click(function(){
        var prev = $(this).attr('prev');
        var curr = $(this).attr('curr');
        $('#' + prev).removeClass('d-none').addClass('d-block');
        $('#' + curr).removeClass('d-block').addClass('d-none');
    });
});
import moment from 'moment';
export default {
    data: function () {
        return {
            product: [],
            pictures: '',
            images: [],
            categories: []
        }
    },
    methods: {
        imageChange () {
            var arr = this.$refs.files.files.length
            for (let i = 0; i < arr; i++) {
                this.images.push(this.$refs.files.files[i]);
                console.log(this.images);
            }
        },
        getProduct() {
            axios.get('http://localhost:8000/api' + window.location.pathname)
            .then(response => {
                this.product = response.data;
                document.getElementById('product_datetime').value = moment(String(response.data.date_time)).format('YYYY-MM-DDThh:mm');
                this.getImages();
            })
            .catch(error => {
                console.log(error);
            });
        },
        updateProduct() {
            var name = document.getElementById('prod_name').value;
            var category = document.getElementById('product_category').value;
            var description = document.getElementById('prod_description').value;
            var date_time = document.getElementById('product_datetime').value;

            var self = this;
            let formData = new FormData();

            for (let i = 0; i < this.images.length; i++) {

                let file = self.images[i];
                formData.append('files[' + i + ']', file);
            }
            console.log(formData);
            const config = {
                headers: {
                    "content-type" : "multipart/form-data"
                }
            }

            axios.put('http://localhost:8000/api/product/' + this.product.id, {
                product: {
                    name: name,
                    category: category,
                    description: description,
                    date_time: date_time
                }
            })
            .then(response => {
                if (this.images.length != 0){
                    axios.post('http://localhost:8000/api/product/' + this.product.id + '/images', formData, config)
                    .then(response => {
                        if (response.status == 200) {
                            self.$refs.files.value = '';
                            self.images = [];
                            window.location.href = 'http://localhost:8000/products';
                        }
                    })
                    .catch(error => {
                        console.log(error);
                    })
                }
                if (response.status == 200) {
                    window.location.href = 'http://localhost:8000/products';
                }
            })
            .catch(error => {
                console.log(error);
            });
        },
        getImages() {
            axios.get('http://localhost:8000/api' + window.location.pathname + '/images')
            .then(response => {
                this.pictures = response.data.images;
            })
            .catch(error => {
                console.log(error);
            });
        },
        removeImages(id) {
            axios.delete('/api/images/'+ id)
            .then(response => {
                if (response.status == 200) {
                    this.getProduct();
                }
            })
            .catch(error => {
                console.log(error);
            });
        },
        getCategories() {
            axios.get('http://localhost:8000/api/categories')
            .then(response => {
                this.categories = response.data
            })
            .catch(error => {
                console.log(error);
            });
        }
    },
    created() {
        this.getProduct();
        this.getCategories();
    }
}
</script>
<style scoped>
.fluid {
    width: 200px;
    height: auto;
}
.fs-14{
    font-size: 14px;
}
.product-form{
    background-color: #ffffff;
}
label {
    font-size: 14px;
}
input, select, textarea {
    width: 75%;
    display: block;
}
.update-btn, .prev-btn {
    border: 0;
    outline: none;
    padding: 5px 15px;
    border-radius: .25rem;
}
</style>