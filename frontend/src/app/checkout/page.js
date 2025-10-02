'use client'

import { useState, useEffect } from 'react'
import { useRouter } from 'next/navigation'
import Image from 'next/image'
import { FaArrowLeft, FaExclamationCircle, FaCheckCircle } from 'react-icons/fa'
import { useCart } from '@/lib/hooks/useCart'
import { useAuth } from '@/lib/hooks/useAuth'
import { ordersAPI } from '@/lib/api'
import Link from 'next/link'

export default function CheckoutPage() {
  const router = useRouter()
  const { items, total, clearCart } = useCart()
  const { user, isAuthenticated } = useAuth()

  const [formData, setFormData] = useState({
    shipping_address: '',
    billing_address: '',
    payment_method: 'credit_card',
    shipping_method: 'standard',
    card_number: '',
    card_expiry: '',
    card_cvc: '',
    card_name: '',
  })

  const [formError, setFormError] = useState('')
  const [isSubmitting, setIsSubmitting] = useState(false)
  const [orderComplete, setOrderComplete] = useState(false)
  const [orderId, setOrderId] = useState(null)

  // Redirect to login if not authenticated
  useEffect(() => {
    if (!isAuthenticated) {
      router.push('/login?redirect=/checkout')
    }
  }, [isAuthenticated, router])

  // Redirect to cart if no items
  useEffect(() => {
    if (items.length === 0 && !orderComplete) {
      router.push('/cart')
    }
  }, [items, router, orderComplete])

  const handleChange = (e) => {
    const { name, value } = e.target
    setFormData({
      ...formData,
      [name]: value,
    })
  }

  const handleSubmit = async (e) => {
    e.preventDefault()
    setFormError('')

    // Simple validation
    if (!formData.shipping_address || !formData.billing_address) {
      setFormError('Please fill in all required fields')
      return
    }

    if (formData.payment_method === 'credit_card') {
      if (
        !formData.card_number ||
        !formData.card_expiry ||
        !formData.card_cvc ||
        !formData.card_name
      ) {
        setFormError('Please fill in all credit card details')
        return
      }

      // Simple credit card validation
      if (!/^\d{16}$/.test(formData.card_number.replace(/\s/g, ''))) {
        setFormError('Invalid credit card number')
        return
      }

      if (!/^\d{2}\/\d{2}$/.test(formData.card_expiry)) {
        setFormError('Invalid expiry date (MM/YY)')
        return
      }

      if (!/^\d{3,4}$/.test(formData.card_cvc)) {
        setFormError('Invalid CVC code')
        return
      }
    }

    setIsSubmitting(true)

    try {
      // ✅ Prepare order data (matches Laravel validation rules)
      const orderData = {
        shop_id: items[0].shop_id, // Laravel takes user_id from auth()
        total_amount: total,
        shipping_address: formData.shipping_address,
        billing_address: formData.billing_address,
        payment_method: formData.payment_method,
        shipping_method: formData.shipping_method,
        order_details: items.map((item) => ({
          product_id: item.id,
          quantity: item.quantity,
          price: item.discount ? item.price - (item.price * item.discount) / 100 : item.price,
          total:
            item.quantity *
            (item.discount ? item.price - (item.price * item.discount) / 100 : item.price),
        })),
      }

      // ✅ Call your Laravel API
      const response = await ordersAPI.create(orderData)

      // ✅ Clear the cart after successful order
      clearCart()

      // ✅ Show success page (Laravel returns full order JSON)

      //setOrderId(response.order_number || response.id) // use order_number if available
      setOrderId(response.data.order_number || response.data.id)
      setOrderComplete(true)
    } catch (error) {
      setFormError(error.message || 'Failed to place order. Please try again.')
    } finally {
      setIsSubmitting(false)
    }
  }

  // If order is complete, show success page
  if (orderComplete) {
    return (
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div className="text-center py-16">
          {/* Success Icon */}
          <FaCheckCircle className="mx-auto h-12 w-12 text-green-500" aria-hidden="true" />

          {/* Title */}
          <h2 className="mt-2 text-3xl font-extrabold text-gray-900">Order Successful!</h2>

          {/* Message */}
          <p className="mt-4 text-lg text-gray-600">
            Thank you for your purchase. Your order has been placed successfully.
          </p>

          {/* Order ID */}
          {orderId && (
            <p className="mt-2 text-md text-gray-600">
              Order ID: <span className="font-medium">{orderId}</span>
            </p>
          )}

          {/* Actions */}
          <div className="mt-8 flex flex-col sm:flex-row justify-center gap-4">
            <Link
              href="/orders"
              className="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm bg-indigo-600 text-white hover:bg-indigo-700 transition"
            >
              View Your Orders
            </Link>
            <Link
              href="/products"
              className="inline-flex items-center justify-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition"
            >
              Continue Shopping
            </Link>
          </div>
        </div>
      </div>
    )
  }

  // If not authenticated or no items, show loading
  if (!isAuthenticated || items.length === 0) {
    return (
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div className="flex justify-center">
          <div
            className="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-indigo-500"
            role="status"
            aria-label="Loading"
          ></div>
        </div>
      </div>
    )
  }

  // Otherwise → show breadcrumb and checkout content
  return (
    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      {/* Breadcrumbs */}
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        {/* Breadcrumb */}
        <nav className="flex mb-8" aria-label="Breadcrumb">
          <ol className="flex items-center space-x-2">
            {/* Home */}
            <li>
              <Link href="/" className="text-gray-500 hover:text-gray-700">
                Home
              </Link>
            </li>

            {/* Cart */}
            <li className="flex items-center">
              <svg
                className="h-5 w-5 text-gray-400"
                fill="currentColor"
                viewBox="0 0 20 20"
                aria-hidden="true"
              >
                <path
                  fillRule="evenodd"
                  d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                  clipRule="evenodd"
                />
              </svg>
              <Link href="/cart" className="ml-2 text-gray-500 hover:text-gray-700">
                Cart
              </Link>
            </li>

            {/* Checkout */}
            <li className="flex items-center">
              <svg
                className="h-5 w-5 text-gray-400"
                fill="currentColor"
                viewBox="0 0 20 20"
                aria-hidden="true"
              >
                <path
                  fillRule="evenodd"
                  d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                  clipRule="evenodd"
                />
              </svg>
              <span className="ml-2 text-gray-900 font-medium">Checkout</span>
            </li>
          </ol>
        </nav>
      </div>

      {/* Page title */}
      <div className="mb-8">
        <h1 className="text-3xl font-extrabold text-gray-900">Checkout</h1>
        <p className="mt-2 text-lg text-gray-600">
          Complete your purchase by providing shipping and payment details
        </p>
      </div>

      <div className="mt-8 lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start xl:gap-x-16 bg-white p-8 rounded-lg shadow">
        {/* Checkout form */}
        <section aria-labelledby="checkout-heading" className="lg:col-span-7">
          <h2 id="checkout-heading" className="sr-only">
            Checkout form
          </h2>

          {/* Error message */}
          {formError && (
            <div className="mb-6 bg-red-50 border-l-4 border-red-400 p-4">
              <div className="flex">
                <div className="flex-shrink-0">
                  <FaExclamationCircle className="h-5 w-5 text-red-400" />
                </div>
                <div className="ml-3">
                  <p className="text-sm text-red-700">{formError}</p>
                </div>
              </div>
            </div>
          )}

          <form onSubmit={handleSubmit}>
            {/* Shipping Information */}
            <div className="border-t border-gray-200 pt-6">
              <h2 className="text-lg font-medium text-gray-900">Shipping information</h2>

              <div className="mt-4">
                <label
                  htmlFor="shipping_address"
                  className="block text-sm font-medium text-gray-700"
                >
                  Shipping Address
                </label>
                <div className="mt-1">
                  <textarea
                    id="shipping_address"
                    name="shipping_address"
                    rows={3}
                    required
                    value={formData.shipping_address}
                    onChange={handleChange}
                    className="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    placeholder="Enter your full shipping address"
                  />
                </div>
              </div>

              <div className="mt-4">
                <label
                  htmlFor="shipping_method"
                  className="block text-sm font-medium text-gray-700"
                >
                  bg-white
                </label>
                <select
                  id="shipping_method"
                  name="shipping_method"
                  value={formData.shipping_method}
                  onChange={handleChange}
                  className="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                >
                  <option value="standard">Standard Shipping (3-5 business days) - Free</option>
                  <option value="express">Express Shipping (1-2 business days) - $9.99</option>
                  <option value="overnight">Overnight Shipping (Next day) - $19.99</option>
                </select>
              </div>
            </div>

            {/* Billing Information */}
            <div className="border-t border-gray-200 pt-6 mt-6">
              <h2 className="text-lg font-medium text-gray-900">Billing information</h2>

              <div className="mt-4">
                <div className="flex items-center">
                  <input
                    id="same-as-shipping"
                    name="same-as-shipping"
                    type="checkbox"
                    className="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                    onChange={(e) => {
                      if (e.target.checked) {
                        setFormData({
                          ...formData,
                          billing_address: formData.shipping_address,
                        })
                      } else {
                        setFormData({
                          ...formData,
                          billing_address: '',
                        })
                      }
                    }}
                  />
                  <label htmlFor="same-as-shipping" className="ml-2 block text-sm text-gray-900">
                    Same as shipping address
                  </label>
                </div>
              </div>

              <div className="mt-4">
                <label
                  htmlFor="billing_address"
                  className="block text-sm font-medium text-gray-700"
                >
                  Billing Address
                </label>
                <div className="mt-1">
                  <textarea
                    id="billing_address"
                    name="billing_address"
                    rows={3}
                    required
                    value={formData.billing_address}
                    onChange={handleChange}
                    className="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    placeholder="Enter your full billing address"
                  />
                </div>
              </div>
            </div>

            {/* Payment Information */}
            <div className="border-t border-gray-200 pt-6 mt-6">
              <h2 className="text-lg font-medium text-gray-900">Payment method</h2>

              <div className="mt-4">
                <div className="flex items-center">
                  <input
                    id="payment-credit-card"
                    name="payment_method"
                    type="radio"
                    value="credit_card"
                    checked={formData.payment_method === 'credit_card'}
                    onChange={handleChange}
                    className="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                  />
                  <label htmlFor="payment-credit-card" className="ml-2 block text-sm text-gray-900">
                    Credit Card
                  </label>
                </div>

                <div className="flex items-center mt-2">
                  <input
                    id="payment-paypal"
                    name="payment_method"
                    type="radio"
                    value="paypal"
                    checked={formData.payment_method === 'paypal'}
                    onChange={handleChange}
                    className="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                  />
                  <label htmlFor="payment-paypal" className="ml-2 block text-sm text-gray-900">
                    PayPal
                  </label>
                </div>
              </div>

              {formData.payment_method === 'credit_card' && (
                <div className="mt-4 grid grid-cols-6 gap-4">
                  <div className="col-span-6">
                    <label htmlFor="card_name" className="block text-sm font-medium text-gray-700">
                      Name on card
                    </label>
                    <input
                      type="text"
                      id="card_name"
                      name="card_name"
                      value={formData.card_name}
                      onChange={handleChange}
                      className="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                      placeholder="John Doe"
                    />
                  </div>

                  <div className="col-span-6">
                    <label
                      htmlFor="card_number"
                      className="block text-sm font-medium text-gray-700"
                    >
                      Card number
                    </label>
                    <input
                      type="text"
                      id="card_number"
                      name="card_number"
                      value={formData.card_number}
                      onChange={handleChange}
                      className="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                      placeholder="4242 4242 4242 4242"
                    />
                  </div>

                  <div className="col-span-3">
                    <label
                      htmlFor="card_expiry"
                      className="block text-sm font-medium text-gray-700"
                    >
                      Expiration date (MM/YY)
                    </label>
                    <input
                      type="text"
                      id="card_expiry"
                      name="card_expiry"
                      value={formData.card_expiry}
                      onChange={handleChange}
                      className="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                      placeholder="12/25"
                    />
                  </div>

                  <div className="col-span-3">
                    <label htmlFor="card_cvc" className="block text-sm font-medium text-gray-700">
                      CVC
                    </label>
                    <input
                      type="text"
                      id="card_cvc"
                      name="card_cvc"
                      value={formData.card_cvc}
                      onChange={handleChange}
                      className="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                      placeholder="123"
                    />
                  </div>
                </div>
              )}
            </div>

            <div className="mt-8">
              <button
                type="submit"
                disabled={isSubmitting}
                className={`w-full bg-indigo-600 border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium  text-gray-800 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 ${
                  isSubmitting ? 'opacity-75 cursor-not-allowed' : ''
                }`}
              >
                {isSubmitting ? (
                  <span className="flex items-center justify-center">
                    <svg
                      className="animate-spin -ml-1 mr-2 h-4 w-4  "
                      xmlns="http://www.w3.org/2000/svg"
                      fill="none"
                      viewBox="0 0 24 24"
                    >
                      <circle
                        className="opacity-25"
                        cx="12"
                        cy="12"
                        r="10"
                        stroke="currentColor"
                        strokeWidth="4"
                      ></circle>
                      <path
                        className="opacity-75"
                        fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                      ></path>
                    </svg>
                    Processing...
                  </span>
                ) : (
                  'Place Order'
                )}
              </button>
            </div>
          </form>
        </section>

        {/* Order summary */}
        <section
          aria-labelledby="summary-heading"
          className="mt-16 bg-gray-50 rounded-lg px-4 py-6 sm:p-6 lg:p-8 lg:mt-0 lg:col-span-5"
        >
          <h2 id="summary-heading" className="text-lg font-medium text-gray-900">
            Order summary
          </h2>

          <div className="mt-6 space-y-4">
            <ul role="list" className="divide-y divide-gray-200">
              {items.map((item) => {
                // Calculate price with discount if available
                const price = item.discount
                  ? item.price - (item.price * item.discount) / 100
                  : item.price

                // Get the first image from the pics array or use a placeholder
                const productImage =
                  item.pics && item.pics.length > 0 ? item.pics[0] : '/placeholder-product.jpg'

                return (
                  <li key={item.id} className="flex py-4">
                    <div className="flex-shrink-0 relative w-16 h-16 border border-gray-200 rounded-md overflow-hidden">
                      <Image
                        src={productImage}
                        alt={item.name}
                        fill
                        className="object-cover object-center"
                        sizes="64px"
                      />
                    </div>

                    <div className="ml-4 flex-1 flex flex-col">
                      <div>
                        <div className="flex justify-between text-base font-medium text-gray-900">
                          <h3>
                            <Link href={`/products/${item.id}`}>{item.name}</Link>
                          </h3>
                          <p className="ml-4">${(price * item.quantity).toFixed(2)}</p>
                        </div>
                      </div>
                      <div className="flex-1 flex items-end justify-between text-sm">
                        <p className="text-gray-500">Qty {item.quantity}</p>
                      </div>
                    </div>
                  </li>
                )
              })}
            </ul>

            <div className="border-t border-gray-200 pt-4">
              <div className="flex justify-between text-sm">
                <dt className="text-gray-600">Subtotal</dt>
                <dd className="font-medium text-gray-900">${total.toFixed(2)}</dd>
              </div>

              <div className="flex justify-between text-sm mt-2">
                <dt className="text-gray-600">Shipping</dt>
                <dd className="font-medium text-gray-900">
                  {formData.shipping_method === 'standard'
                    ? 'Free'
                    : formData.shipping_method === 'express'
                    ? '$9.99'
                    : formData.shipping_method === 'overnight'
                    ? '$19.99'
                    : 'Free'}
                </dd>
              </div>

              <div className="flex justify-between text-sm mt-2">
                <dt className="text-gray-600">Tax</dt>
                <dd className="font-medium text-gray-900">${(total * 0.1).toFixed(2)}</dd>
              </div>

              <div className="flex justify-between text-base font-medium text-gray-900 mt-4 pt-4 border-t border-gray-200">
                <dt>Order total</dt>
                <dd>
                  $
                  {(
                    total +
                    (formData.shipping_method === 'express'
                      ? 9.99
                      : formData.shipping_method === 'overnight'
                      ? 19.99
                      : 0) +
                    total * 0.1
                  ).toFixed(2)}
                </dd>
              </div>
            </div>
          </div>

          <div className="mt-6">
            <Link
              href="/cart"
              className="text-sm text-indigo-600 hover:text-indigo-500 flex items-center"
            >
              <FaArrowLeft className="mr-2" />
              Return to cart
            </Link>
          </div>
        </section>
      </div>
    </div>
  )
}
