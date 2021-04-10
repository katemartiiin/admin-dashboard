<template>
    <div class="border border-dark p-3 mx-auto">
        <input type="text" id="product_name" :value="product.name" />
        <input type="text" id="product_category" :value="product.category" />
        <input type="text" id="product_description" :value="product.description" />
        <input type="datetime-local" id="product_datetime" />
        <input @change="imageChange()" type="file" name="image" ref="files" multiple />
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Images</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(picture, index) in pictures" :key="index">
                    <td>{{ picture.id }}</td>
                    <td>
                        <img v-for="(img, index) in picture.images" :key="index" :src="img" width="100px" height="100px" />
                    </td>
                    <td><button @click="removeImages(picture.id)">Remove</button></td>
                </tr>
            </tbody>
        </table>
        <button @click="updateProduct()">Update</button>
    </div>
</template>
<script>
import moment from 'moment';
export default {
    data: function () {
        return {
            product: [],
            pictures: '',
            images: []
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
            var name = document.getElementById('product_name').value;
            var category = document.getElementById('product_category').value;
            var description = document.getElementById('product_description').value;
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
        }
    },
    created() {
        this.getProduct();
    }
}
</script>