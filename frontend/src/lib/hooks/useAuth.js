import { create } from 'zustand';
import { persist } from 'zustand/middleware';
import axios from 'axios';
import Cookies from 'js-cookie';
import {authAPI} from "@/lib/api";

// Define the API base URL
const API_URL = process.env.NEXT_PUBLIC_API_URL || 'http://localhost:8000/api';

// Create the auth store with Zustand
const useAuthStore = create(
  persist(
    (set) => ({
      user: null,
      token: null,
      loading: false,
      error: null,

      // Initialize function to check token in cookies and set state accordingly
      initialize: async () => {
        const token = Cookies.get('token');
        if (!token) {
          set({ user: null, token: null });
          return null;
        }

        try {
          // Set axios default headers for authenticated requests
          axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

          const response = await axios.get(`${API_URL}/user`);
          const user = response.data;

          set({ user, token, loading: false });
          return user;
        } catch (error) {
          // If unauthorized, clear the user data
          if (error.response?.status === 401) {
            Cookies.remove('token');
            delete axios.defaults.headers.common['Authorization'];
            set({ user: null, token: null, loading: false });
          }
          return null;
        }
      },

      // Login function
      login: async (email, password) => {
        set({ loading: true, error: null });
        try {
          const response = await authAPI.login({ email, password });
          const { user, token } = response.data;

          // Set the token in cookies for API requests
          Cookies.set('token', token, { expires: 7 });

          // Set axios default headers for authenticated requests
          axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

          set({ user, token, loading: false });
          return user;
        } catch (error) {
          set({ 
            loading: false, 
            error: error.response?.data?.message || 'Failed to login. Please try again.' 
          });
          throw error;
        }
      },

      // Register function
      register: async (userData) => {
        set({ loading: true, error: null });
        try {
          const response = await axios.post(`${API_URL}/register`, userData);
          const { user, token } = response.data;

          // Set the token in cookies for API requests
          Cookies.set('token', token, { expires: 7 });

          // Set axios default headers for authenticated requests
          axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

          set({ user, token, loading: false });
          return user;
        } catch (error) {
          set({ 
            loading: false, 
            error: error.response?.data?.message || 'Failed to register. Please try again.' 
          });
          throw error;
        }
      },

      // Logout function
      logout: () => {
        // Remove token from cookies
        Cookies.remove('token');

        // Remove Authorization header
        delete axios.defaults.headers.common['Authorization'];

        set({ user: null, token: null });
      },

      // Get current user profile
      getProfile: async () => {
        set({ loading: true, error: null });
        try {
          const token = Cookies.get('token');

          if (!token) {
            set({ loading: false });
            return null;
          }
          // Set axios default headers for authenticated requests
          axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

          const response = await axios.get(`${API_URL}/user`);
          const user = response.data;

          set({ user, token, loading: false });
          return user;
        } catch (error) {
          // If unauthorized, clear the user data
          if (error.response?.status === 401) {
            Cookies.remove('token');
            delete axios.defaults.headers.common['Authorization'];
            set({ user: null, token: null, loading: false });
          } else {
            set({ 
              loading: false, 
              error: error.response?.data?.message || 'Failed to get user profile.' 
            });
          }
          return null;
        }
      },
    }),
    {
      name: 'auth-storage', // name of the item in the storage
      getStorage: () => localStorage, // (optional) by default, 'localStorage' is used
    }
  )
);

// Custom hook to use the auth store
export const useAuth = () => {
  const { 
    user, 
    token, 
    loading, 
    error, 
    initialize,
    login, 
    register, 
    logout, 
    getProfile 
  } = useAuthStore();

  return {
    user,
    token,
    isAuthenticated: !!user,
    loading,
    error,
    initialize,
    login,
    register,
    logout,
    getProfile,
  };
};
