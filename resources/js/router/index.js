import Products from '../vue/Products'
import productForm from '../vue/productForm'

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
        }
    ]
}