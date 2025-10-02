import axios from 'axios'
import Cookies from 'js-cookie'

// Define the API base URL
const API_URL = process.env.NEXT_PUBLIC_API_URL || 'http://127.0.0.1:8000/api'

// Create axios instance with default config
const api = axios.create({
  baseURL: API_URL,
  headers: {
    'Content-Type': 'application/json',
    Accept: 'application/json',
  },
})

// Add a request interceptor to include the auth token in all requests
api.interceptors.request.use(
  (config) => {
    const token = Cookies.get('token')
    if (token) {
      config.headers.Authorization = `Bearer ${token}`
    }
    return config
  },
  (error) => Promise.reject(error)
)

// Add a response interceptor to handle common errors
api.interceptors.response.use(
  (response) => response,
  (error) => {
    // Handle 401 Unauthorized errors (token expired, etc.)
    if (error.response && error.response.status === 401) {
      // Clear the token
      Cookies.remove('token')
    }
    return Promise.reject(error)
  }
)

// Auth API
export const authAPI = {
  login: (credentials) => api.post('/login', credentials),
  register: (userData) => api.post('/register', userData),
  getUser: () => api.get('/user'),
  logout: () => api.post('/logout'),
}

// Products API
export const productsAPI = {
  getAll: (params) => {
    'API Request - Products with params:', params
    // Add no-cache headers to prevent caching
    const config = {
      params,
      headers: {
        'Cache-Control': 'no-cache, no-store, must-revalidate',
        Pragma: 'no-cache',
        Expires: '0',
      },
    }
    return api
      .get('/products', config)
      .then((response) => {
        // Some Laravel resources wrap payload in { data: ... }
        // and our ProductCollection returns keys inside that.
        const raw = response?.data
        const payload = raw?.products ? raw : raw?.data

        // Normalize to a consistent shape expected by the app
        const normalized = {
          products: payload?.products || [],
          total: payload?.total ?? raw?.meta?.total ?? 0,
          current_page: payload?.current_page ?? raw?.meta?.current_page ?? 1,
          per_page:
            payload?.per_page ??
            raw?.meta?.per_page ??
            (Array.isArray(payload?.products) ? payload.products.length : 0),
        }

        // Overwrite response.data so callers can keep using response.data.products
        response.data = normalized
        'API Response - Products (normalized):', response.data
        return response
      })
      .catch((error) => {
        console.error('API Error - Products:', error.response?.data || error.message)
        throw error
      })
  },
  getById: (id) => api.get(`/products/${id}`),
  getByCategory: (categoryId, params) => api.get(`/categories/${categoryId}/products`, { params }),
  getByShop: (shopId, params) => api.get(`/shops/${shopId}/products`, { params }),
}

// Categories API
export const categoriesAPI = {
  getAll: () => api.get('/categories'),
  getById: (id) => api.get(`/categories/${id}`),
  getByShop: (shopId) => api.get(`/shops/${shopId}/categories`),
}

// Shops API
export const shopsAPI = {
  getAll: (params) => api.get('/shops', { params }),
  getById: (id) => api.get(`/shops/${id}`),
  getByUser: (userId) => api.get(`/users/${userId}/shop`),
}

// Orders API
// Orders API
export const ordersAPI = {
  getAll: (userId) => api.get('/orders', { params: { user_id: userId } }),
  getById: (id) => api.get(`/orders/${id}`),
  create: (orderData) => api.post('/orders', orderData),
  update: (id, orderData) => api.put(`/orders/${id}`, orderData),
  cancel: (id) => api.post(`/orders/${id}/cancel`),
}

// Order Details API
export const orderDetailsAPI = {
  getByOrder: (orderId) => api.get(`/orders/${orderId}/details`),
}

// Export the API instance for custom requests
export default api
