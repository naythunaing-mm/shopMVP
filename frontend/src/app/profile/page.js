'use client';

import { useEffect, useState } from 'react';
import { useRouter } from 'next/navigation';
import { useAuth } from '@/lib/hooks/useAuth';
import { ordersAPI } from "@/lib/api";
import ClientProfilePage from '@/components/profile/ClientProfilePage';

// Loading component
function LoadingProfile() {
  return (
    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div className="animate-pulse">
        <div className="h-8 bg-gray-200 rounded w-1/4 mb-6"></div>
        <div className="h-12 bg-gray-200 rounded mb-8"></div>
        <div className="bg-white shadow overflow-hidden sm:rounded-lg">
          <div className="px-4 py-5 sm:p-6">
            <div className="h-6 bg-gray-200 rounded w-1/3 mb-4"></div>
            <div className="h-4 bg-gray-200 rounded w-1/2 mb-6"></div>
            <div className="space-y-4">
              {[...Array(5)].map((_, i) => (
                <div key={i} className="h-4 bg-gray-200 rounded w-full"></div>
              ))}
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

// Main page component
export default function ProfilePage() {
  const router = useRouter();
  const { user, isAuthenticated, loading: authLoading } = useAuth();
  const [orders, setOrders] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    // Check if user is authenticated
    if (!authLoading && !isAuthenticated) {
      router.push('/login?redirect=/profile');
      return;
    }

    // Fetch orders if user is authenticated
    if (isAuthenticated && user) {
      const fetchOrders = async () => {
        try {
          // Check if ordersAPI.getAll exists before calling it
          if (typeof ordersAPI?.getAll === 'function') {
            const response = await ordersAPI.getAll();
            setOrders(Array.isArray(response?.data) ? response.data : []);
          } else {
            console.warn('ordersAPI.getAll is not a function');
            setOrders([]);
          }
        } catch (error) {
          console.error('Error fetching orders:', error);
          setOrders([]); // Set empty array on error
        } finally {
          setLoading(false);
        }
      };

      fetchOrders();
    } else {
      // If no user but authenticated, still set loading to false
      setLoading(false);
    }
  }, [user, isAuthenticated, authLoading, router]);

  // Show loading state while checking authentication or fetching data
  if (authLoading || (loading && !user)) {
    return <LoadingProfile />;
  }

  // If we have a user, render the profile page
  if (user) {
    return (
      <ClientProfilePage 
        user={user} 
        orders={Array.isArray(orders) ? orders : []}
      />
    );
  }

  // This should not be reached due to the redirect in useEffect,
  // but included as a fallback
  return <LoadingProfile />;
}
