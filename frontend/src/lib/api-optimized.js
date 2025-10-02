import axios from 'axios';
import Cookies from 'js-cookie';

// Define the API base URL
const API_URL = process.env.NEXT_PUBLIC_API_URL || 'http://localhost:8000/api';

// Simple cache for API responses
const cache = new Map();
const CACHE_DURATION = 5 * 60 * 1000; // 5 minutes

// Create axios instance with default config
const api = axios.create({
  baseURL: API_URL,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
  timeout: 10000, // 10 second timeout
});

// Add a request interceptor to include the auth token in all requests
api.interceptors.request.use(
  (config) => {
    const token = Cookies.get('token');
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => Promise.reject(error)
);

// Add a response interceptor to handle common errors
api.interceptors.response.use(
  (response) => response,
  (error) => {
    // Handle 401 Unauthorized errors (token expired, etc.)
    if (error.response && error.response.status === 401) {
      // Clear the token
      Cookies.remove('token');
    }
    // Reduce console noise in production
    if (process.env.NODE_ENV === 'development') {
      console.error('API Error:', error.message);
    }
    return Promise.reject(error);
  }
);

// Helper function to create cache key
const createCacheKey = (url, params) => {
  const paramString = params ? JSON.stringify(params) : '';
  return `${url}${paramString}`;
};

// Helper function to get cached data
const getCachedData = (key) => {
  const cached = cache.get(key);
  if (cached && Date.now() - cached.timestamp < CACHE_DURATION) {
    return cached.data;
  }
  cache.delete(key);
  return null;
};

// Helper function to set cached data
const setCachedData = (key, data) => {
  cache.set(key, {
    data,
    timestamp: Date.now()
  });
};

// Auth API
export const authAPI = {
  login: (credentials) => api.post('/login', credentials),
  register: (userData) => api.post('/register', userData),
  getUser: () => api.get('/user'),
  logout: () => api.post('/logout'),
};

// Products API with caching
export const productsAPI = {
  getAll: async (params) => {
    const cacheKey = createCacheKey('/products', params);
    const cached = getCachedData(cacheKey);
    if (cached) return cached;
    
    const response = await api.get('/products', { params });
    setCachedData(cacheKey, response);
    return response;
  },
  getById: async (id) => {
    const cacheKey = createCacheKey(`/products/${id}`);
    const cached = getCachedData(cacheKey);
    if (cached) return cached;
    
    const response = await api.get(`/products/${id}`);
    setCachedData(cacheKey, response);
    return response;
  },
  getByCategory: (categoryId, params) => api.get(`/categories/${categoryId}/products`, { params }),
  getByShop: (shopId, params) => api.get(`/shops/${shopId}/products`, { params }),
};

// Categories API with caching
export const categoriesAPI = {
  getAll: async () => {
    const cacheKey = createCacheKey('/categories');
    const cached = getCachedData(cacheKey);
    if (cached) return cached;
    
    const response = await api.get('/categories');
    setCachedData(cacheKey, response);
    return response;
  },
  getById: (id) => api.get(`/categories/${id}`),
  getByShop: (shopId) => api.get(`/shops/${shopId}/categories`),
};

// Shops API
export const shopsAPI = {
  getAll: (params) => api.get('/shops', { params }),
  getById: (id) => api.get(`/shops/${id}`),
  getByUser: (userId) => api.get(`/users/${userId}/shop`),
};

// Orders API
export const ordersAPI = {
  getAll: () => api.get('/orders'),
  getById: (id) => api.get(`/orders/${id}`),
  create: (orderData) => api.post('/orders', orderData),
  update: (id, orderData) => api.put(`/orders/${id}`, orderData),
  cancel: (id) => api.post(`/orders/${id}/cancel`),
};

// Order Details API
export const orderDetailsAPI = {
  getByOrder: (orderId) => api.get(`/orders/${orderId}/details`),
};

// Export the API instance for custom requests
export default api;
