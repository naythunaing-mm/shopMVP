'use client'

import { useState } from 'react'
import { FaShoppingCart, FaMinus, FaPlus } from 'react-icons/fa'
import { useCart } from '@/lib/hooks/useCart'

export default function AddToCartButton({ product }) {
  const [quantity, setQuantity] = useState(1)
  const [isAdding, setIsAdding] = useState(false)
  const [showSuccess, setShowSuccess] = useState(false)
  const { addItem } = useCart()

  const increaseQuantity = () => {
    setQuantity((prev) => Math.min(prev + 1, product.stock))
  }

  const decreaseQuantity = () => {
    setQuantity((prev) => Math.max(prev - 1, 1))
  }

  const handleQuantityChange = (e) => {
    const value = parseInt(e.target.value, 10)
    if (!isNaN(value)) {
      setQuantity(Math.min(Math.max(value, 1), product.stock))
    }
  }

  const handleAddToCart = () => {
    if (product.stock === 0) return
    setIsAdding(true)

    // Simulate API call
    setTimeout(() => {
      addItem(product, quantity)
      setIsAdding(false)
      setShowSuccess(true)

      setTimeout(() => setShowSuccess(false), 3000)
    }, 500)
  }

  if (product.stock === 0) {
    return (
      <button
        disabled
        className="w-full py-3 px-6 rounded-md bg-gray-300 text-gray-500 font-medium cursor-not-allowed"
      >
        Out of Stock
      </button>
    )
  }

  return (
    <div className="space-y-4">
      {/* Quantity Selector */}
      <div className="flex items-center gap-3">
        <div className="flex items-center border border-gray-300 rounded-md overflow-hidden">
          <button
            type="button"
            onClick={decreaseQuantity}
            disabled={quantity <= 1}
            className={`px-3 py-2 ${
              quantity <= 1 ? 'text-gray-400' : 'text-gray-600 hover:bg-gray-100'
            }`}
            aria-label="Decrease quantity"
          >
            <FaMinus className="w-4 h-4" />
          </button>

          <input
            type="number"
            value={quantity}
            onChange={handleQuantityChange}
            className="w-14 text-center border-none focus:ring-0 text-gray-800"
            aria-label="Quantity"
            min={1}
            max={product.stock}
          />

          <button
            type="button"
            onClick={increaseQuantity}
            disabled={quantity >= product.stock}
            className={`px-3 py-2 ${
              quantity >= product.stock ? 'text-gray-400' : 'text-gray-600 hover:bg-gray-100'
            }`}
            aria-label="Increase quantity"
          >
            <FaPlus className="w-4 h-4" />
          </button>
        </div>
        <span className="text-sm text-gray-500">{product.stock} available</span>
      </div>

      {/* Add to Cart Button */}
      <button
        type="button"
        onClick={handleAddToCart}
        disabled={isAdding}
        className={`w-full flex items-center justify-center gap-2 py-3 px-6 rounded-md bg-indigo-600 text-white font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 ${
          isAdding ? 'opacity-75 cursor-not-allowed' : ''
        }`}
      >
        {isAdding ? (
          <span className="flex items-center gap-2">
            <Spinner /> Adding...
          </span>
        ) : (
          <>
            <FaShoppingCart className="w-5 h-5" />
            Add to Cart
          </>
        )}
      </button>

      {/* Success Message */}
      {showSuccess && (
        <div className="p-2 bg-green-50 border border-green-200 rounded-md text-center">
          <p className="text-sm text-green-700">Added to cart successfully!</p>
        </div>
      )}
    </div>
  )
}

// Spinner Component
function Spinner() {
  return (
    <svg
      className="animate-spin h-4 w-4 text-white"
      xmlns="http://www.w3.org/2000/svg"
      fill="none"
      viewBox="0 0 24 24"
    >
      <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4" />
      <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z" />
    </svg>
  )
}
