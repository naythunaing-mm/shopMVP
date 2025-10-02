'use client'

import { useState, useEffect } from 'react'
import { useRouter } from 'next/navigation'
import Link from 'next/link'
import Image from 'next/image'
import { FaExclamationCircle, FaShoppingBag, FaEye } from 'react-icons/fa'
import { useAuth } from '@/lib/hooks/useAuth'
import { ordersAPI } from '@/lib/api'

export default function OrdersPage() {
  const router = useRouter()
  const { user, isAuthenticated } = useAuth()

  const [mounted, setMounted] = useState(false) // Prevent hydration mismatch
  const [orders, setOrders] = useState([])
  const [loading, setLoading] = useState(true)
  const [error, setError] = useState('')

  useEffect(() => {
    setMounted(true)

    if (isAuthenticated === false) {
      router.push('/login?redirect=/orders')
    }
  }, [isAuthenticated, router])

  useEffect(() => {
    const fetchOrders = async () => {
      if (!isAuthenticated || !user?.id) return

      setLoading(true)
      try {
        const response = await ordersAPI.getAll(user.id)
        console.log('Orders API response:', response.data)

        const ordersData = Array.isArray(response.data.data) ? response.data.data : []

        setOrders(ordersData)
      } catch (err) {
        setError('Failed to fetch orders. Please try again.')
        console.error('Error fetching orders:', err)
      } finally {
        setLoading(false)
      }
    }

    fetchOrders()
  }, [isAuthenticated, user?.id])

  const formatDate = (dateString) => {
    if (!dateString) return 'Unknown date'
    const options = { year: 'numeric', month: 'long', day: 'numeric' }
    return new Date(dateString).toLocaleDateString(undefined, options)
  }

  const getStatusColor = (status) => {
    if (!status) return 'bg-gray-100 text-gray-800'
    switch (status.toLowerCase()) {
      case 'completed':
        return 'bg-green-100 text-green-800'
      case 'processing':
        return 'bg-blue-100 text-blue-800'
      case 'shipped':
        return 'bg-purple-100 text-purple-800'
      case 'cancelled':
        return 'bg-red-100 text-red-800'
      default:
        return 'bg-gray-100 text-gray-800'
    }
  }

  if (!mounted || isAuthenticated === null) {
    return (
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div className="flex justify-center items-center py-12">
          <div className="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-indigo-500"></div>
        </div>
      </div>
    )
  }

  if (!isAuthenticated) return null // Redirect handled in useEffect

  return (
    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      {/* Breadcrumb */}
      <nav className="flex mb-8" aria-label="Breadcrumb">
        <ol className="flex items-center space-x-2">
          <li>
            <Link href="/" className="text-gray-500 hover:text-gray-700">
              Home
            </Link>
          </li>
          <li className="flex items-center">
            <svg className="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
              <path
                fillRule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clipRule="evenodd"
              />
            </svg>
            <span className="ml-2 text-gray-900 font-medium">My Orders</span>
          </li>
        </ol>
      </nav>

      {/* Title */}
      <div className="mb-8">
        <h1 className="text-3xl font-extrabold text-gray-900">My Orders</h1>
        <p className="mt-2 text-lg text-gray-600">View and track your order history</p>
      </div>

      {/* Error */}
      {error && (
        <div className="mb-6 bg-red-50 border-l-4 border-red-400 p-4">
          <div className="flex">
            <FaExclamationCircle className="h-5 w-5 text-red-400" />
            <p className="ml-3 text-sm text-red-700">{error}</p>
          </div>
        </div>
      )}

      {/* Loading */}
      {loading ? (
        <div className="flex justify-center items-center py-12">
          <div className="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-indigo-500"></div>
        </div>
      ) : orders.length === 0 ? (
        <div className="text-center py-16 bg-white shadow-sm rounded-lg">
          <FaShoppingBag className="mx-auto h-12 w-12 text-gray-400" />
          <h3 className="mt-2 text-lg font-medium text-gray-900">No orders yet</h3>
          <p className="mt-1 text-sm text-gray-500">You haven't placed any orders yet.</p>
          <div className="mt-6">
            <Link
              href="/products"
              className="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-gray-800 bg-indigo-600 hover:bg-indigo-700"
            >
              Start Shopping
            </Link>
          </div>
        </div>
      ) : (
        <div className="bg-white shadow-sm rounded-lg overflow-hidden">
          <ul role="list" className="divide-y divide-gray-200">
            {orders.map((order) => (
              <li key={order.id} className="p-4 sm:p-6">
                {/* Order Header */}
                <div className="flex items-center justify-between">
                  <div>
                    <h3 className="text-lg font-medium text-gray-900">
                      Order #{order.order_number}
                    </h3>
                    <p className="text-sm text-gray-500">
                      Placed on {formatDate(order.created_at)}
                    </p>
                  </div>
                  <span
                    className={`inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${getStatusColor(
                      order.status
                    )}`}
                  >
                    {order.status
                      ? order.status.charAt(0).toUpperCase() + order.status.slice(1)
                      : 'Unknown'}
                  </span>
                </div>

                {/* Order Summary */}
                <div className="mt-4 border-t border-gray-200 pt-4">
                  <div className="flex justify-between text-sm">
                    <p className="text-gray-500">Total amount</p>
                    <p className="font-medium text-gray-900">
                      ${Number(order.total_amount || 0).toFixed(2)}
                    </p>
                  </div>
                </div>

                {/* Order Items */}
                <div className="mt-4">
                  <h4 className="sr-only">Items</h4>
                  <ul role="list" className="divide-y divide-gray-200">
                    {Array.isArray(order.items) &&
                      order.items.map((item) => (
                        <li key={item.id} className="py-4 flex">
                          <div className="flex-shrink-0 relative w-16 h-16 border border-gray-200 rounded-md overflow-hidden">
                            {item.product_image ? (
                              <Image
                                src={item.product_image}
                                alt={item.product_name || 'Product image'}
                                fill
                                className="object-cover object-center"
                                sizes="64px"
                              />
                            ) : (
                              <div className="w-16 h-16 bg-gray-100 flex items-center justify-center text-gray-400 text-xs">
                                No Image
                              </div>
                            )}
                          </div>
                          <div className="ml-4 flex-1 flex flex-col">
                            <div className="flex justify-between text-base font-medium text-gray-900">
                              <h5>
                                <Link href={`/products/${item.product_id}`}>
                                  {item.product_name}
                                </Link>
                              </h5>
                              <p className="ml-4">${Number(item.total || 0).toFixed(2)}</p>
                            </div>
                            <div className="flex-1 flex items-end justify-between text-sm">
                              <p className="text-gray-500">Qty {item.quantity}</p>
                            </div>
                          </div>
                        </li>
                      ))}
                  </ul>
                </div>
              </li>
            ))}
          </ul>
        </div>
      )}
    </div>
  )
}
