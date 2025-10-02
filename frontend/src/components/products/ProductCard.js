'use client'

import Link from 'next/link'
import { FaShoppingCart } from 'react-icons/fa'
import { useCart } from '@/lib/hooks/useCart'
import ProductImage from '@/components/ui/ProductImage'

export default function ProductCard({ product }) {
  const { addItem } = useCart()

  // Calculate discounted price if discount exists
  const discountedPrice = product.discount
    ? product.price - (product.price * product.discount) / 100
    : null

  // Get the first image from the pics array or use a placeholder
  const getProductImage = () => {
    // Handle different pic formats
    if (product.pics) {
      // If pics is an array
      if (Array.isArray(product.pics) && product.pics.length > 0) {
        return product.pics[0]
      }
      // If pics is a string (comma-separated or single image)
      if (typeof product.pics === 'string' && product.pics.trim() !== '') {
        const images = product.pics.split(',').map((img) => img.trim())
        return images[0]
      }
    }
    return null // Let ProductImage component handle the placeholder
  }

  const productImage = getProductImage()

  // Debug logging for ProductCard
  'ProductCard - Product:', product.name
  'ProductCard - Product pics:', product.pics
  'ProductCard - Selected image:', productImage

  const handleAddToCart = (e) => {
    e.preventDefault()
    e.stopPropagation()
    addItem(product, 1)
    confirm(`${product.name} added to cart`)
  }

  return (
    <div className="group relative bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow">
      <Link href={`/products/${product.id}`} className="block">
        <div className="h-48 w-full overflow-hidden">
          <ProductImage
            src={productImage}
            alt={product.name}
            width={300}
            height={192}
            className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
          />
          {product.discount > 0 && (
            <div className="absolute top-2 right-2 bg-red-500   text-xs font-bold px-2 py-1 rounded">
              {product.discount}% OFF
            </div>
          )}
        </div>

        <div className="p-4">
          <h3 className="text-sm font-medium text-gray-900 truncate">{product.name}</h3>

          <div className="mt-2 flex justify-between items-center">
            <div>
              {discountedPrice ? (
                <div className="flex items-center">
                  <span className="text-sm font-medium text-gray-900">
                    ${discountedPrice.toFixed(2)}
                  </span>
                  <span className="ml-2 text-xs text-gray-500 line-through">${product.price}</span>
                </div>
              ) : (
                <span className="text-sm font-medium text-gray-900">${product.price}</span>
              )}
            </div>

            <button
              onClick={handleAddToCart}
              className="p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
              aria-label="Add to cart"
            >
              <FaShoppingCart className="h-5 w-5" />
            </button>
          </div>

          {product.stock <= 5 && product.stock > 0 ? (
            <p className="mt-1 text-xs text-orange-600">Only {product.stock} left in stock</p>
          ) : product.stock === 0 ? (
            <p className="mt-1 text-xs text-red-600">Out of stock</p>
          ) : null}
        </div>
      </Link>
    </div>
  )
}
