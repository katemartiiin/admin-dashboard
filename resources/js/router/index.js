import Products from '../vue/Products'
import productForm from '../vue/productForm'
import editProduct from '../vue/editProduct'

export default {
    mode: 'history',
    routes: [
        {
            path: '/products',
            name: 'Products',
            component: Products
        },
        {
            path: '/new',
            name: 'New Product',
            component: productForm
        },
        {
            path: '/product/:id',
            name: 'edit',
            component: editProduct
        }
    ]
}