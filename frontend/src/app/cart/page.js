'use client'

import { useState, useEffect } from 'react'
import Link from 'next/link'
import Image from 'next/image'
import { FaTrash, FaArrowLeft, FaShoppingCart } from 'react-icons/fa'
import { useCart } from '@/lib/hooks/useCart'
import { useAuth } from '@/lib/hooks/useAuth'

export default function CartPage() {
  const [isClient, setIsClient] = useState(false)

  useEffect(() => {
    setIsClient(true)
  }, [])

  const { items, removeItem, updateQuantity, clearCart, total } = useCart()
  const { isAuthenticated } = useAuth()
  const [isUpdating, setIsUpdating] = useState(false)

  const handleQuantityChange = (productId, newQuantity) => {
    setIsUpdating(true)
    setTimeout(() => {
      updateQuantity(productId, newQuantity)
      setIsUpdating(false)
    }, 300)
  }

  const handleRemoveItem = (productId) => {
    setIsUpdating(true)
    setTimeout(() => {
      removeItem(productId)
      setIsUpdating(false)
    }, 300)
  }

  if (!isClient) return null

  if (items.length === 0) {
    return (
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div className="text-center py-16">
          <FaShoppingCart className="mx-auto h-12 w-12 text-gray-400" />
          <h2 className="mt-2 text-lg font-medium text-gray-900">Your cart is empty</h2>
          <p className="mt-1 text-sm text-gray-500">
            Looks like you haven't added any products to your cart yet.
          </p>
          <div className="mt-6">
            <Link
              href="/products"
              className="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-gray-800 bg-indigo-600 hover:bg-indigo-700"
            >
              <FaArrowLeft className="mr-2 -ml-1 h-4 w-4" />
              Continue Shopping
            </Link>
          </div>
        </div>
      </div>
    )
  }
  return (
    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      {/* Breadcrumbs */}
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
            <span className="ml-2 text-gray-900 font-medium">Shopping Cart</span>
          </li>
        </ol>
      </nav>

      {/* Page title */}
      <div className="mb-8">
        <h1 className="text-3xl font-extrabold text-gray-900">Your Shopping Cart</h1>
        <p className="mt-2 text-lg text-gray-600">Review and update your items before checkout</p>
      </div>

      <div className="mt-8 lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start xl:gap-x-16 bg-white p-8 rounded-lg shadow">
        <section aria-labelledby="cart-heading" className="lg:col-span-7">
          <h2 id="cart-heading" className="sr-only">
            Items in your shopping cart
          </h2>

          <ul role="list" className="border-t border-b border-gray-200 divide-y divide-gray-200">
            {items.map((item) => {
              // Calculate price with discount if available
              const price = item.discount
                ? item.price - (item.price * item.discount) / 100
                : item.price

              // Get the first image from the pics array or use a placeholder
              const productImage =
                item.pics && item.pics.length > 0 ? item.pics[0] : '/placeholder-product.jpg'

              return (
                <li key={item.id} className="py-6 flex">
                  <div className="flex-shrink-0 relative w-24 h-24 border border-gray-200 rounded-md overflow-hidden">
                    <Image
                      src={productImage}
                      alt={item.name}
                      fill
                      className="object-cover object-center"
                      sizes="96px"
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
                      {item.discount > 0 && (
                        <p className="mt-1 text-sm text-gray-500">
                          ${price.toFixed(2)} each (${item.discount}% off)
                        </p>
                      )}
                    </div>
                    <div className="flex-1 flex items-end justify-between text-sm">
                      <div className="flex items-center">
                        <label htmlFor={`quantity-${item.id}`} className="mr-2 text-gray-500">
                          Qty
                        </label>
                        <select
                          id={`quantity-${item.id}`}
                          name={`quantity-${item.id}`}
                          value={item.quantity}
                          onChange={(e) => handleQuantityChange(item.id, parseInt(e.target.value))}
                          className="max-w-full rounded-md border border-gray-300 py-1.5 text-base leading-5 font-medium text-gray-700 text-left shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        >
                          {[...Array(10)].map((_, i) => (
                            <option key={i + 1} value={i + 1}>
                              {i + 1}
                            </option>
                          ))}
                        </select>
                      </div>

                      <div className="flex">
                        <button
                          type="button"
                          onClick={() => handleRemoveItem(item.id)}
                          className="font-medium text-indigo-600 hover:text-indigo-500 flex items-center"
                        >
                          <FaTrash className="h-4 w-4 mr-1" />
                          Remove
                        </button>
                      </div>
                    </div>
                  </div>
                </li>
              )
            })}
          </ul>
        </section>

        {/* Order summary */}
        <section
          aria-labelledby="summary-heading"
          className="mt-16 bg-gray-50 rounded-lg px-4 py-6 sm:p-6 lg:p-8 lg:mt-0 lg:col-span-5"
        >
          <h2 id="summary-heading" className="text-lg font-medium text-gray-900">
            Order summary
          </h2>

          <dl className="mt-6 space-y-4">
            <div className="flex items-center justify-between">
              <dt className="text-sm text-gray-600">Subtotal</dt>
              <dd className="text-sm font-medium text-gray-900">${total.toFixed(2)}</dd>
            </div>
            <div className="border-t border-gray-200 pt-4 flex items-center justify-between">
              <dt className="text-base font-medium text-gray-900">Order total</dt>
              <dd className="text-base font-medium text-gray-900">${total.toFixed(2)}</dd>
            </div>
          </dl>

          <div className="mt-6">
            {isAuthenticated ? (
              <Link
                href="/checkout"
                className="w-full bg-indigo-600 border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium  text-gray-800 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
              >
                Checkout
              </Link>
            ) : (
              <Link
                href="/login?redirect=/checkout"
                className="w-full bg-indigo-600 border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium  text-gray-800 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
              >
                Login to Checkout
              </Link>
            )}
          </div>

          <div className="mt-6 text-sm text-center">
            <p>
              or{' '}
              <Link href="/products" className="text-indigo-600 font-medium hover:text-indigo-500">
                Continue Shopping<span aria-hidden="true"> &rarr;</span>
              </Link>
            </p>
          </div>
        </section>
      </div>

      {/* Loading overlay */}
      {isUpdating && (
        <div className="fixed inset-0 bg-gray-100 bg-opacity-30 flex items-center justify-center z-50">
          <div className="bg-white p-4 rounded-md shadow-lg">
            <div className="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-indigo-500 mx-auto"></div>
            <p className="mt-2 text-sm text-gray-600">Updating cart...</p>
          </div>
        </div>
      )}
    </div>
  )
}
