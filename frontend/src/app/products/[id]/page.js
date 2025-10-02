// src/app/products/[id]/page.js

import Image from 'next/image'
import Link from 'next/link'
import { notFound } from 'next/navigation'
import AddToCartButton from '@/components/products/AddToCartButton'
import { productsAPI, shopsAPI } from '@/lib/api'

// ==============================
// Data fetching helpers
// ==============================
async function fetchData(fetcher, id) {
  try {
    const response = await fetcher(id)
    return response.data?.data || null
  } catch (error) {
    console.error(`Error fetching data for ID ${id}:`, error)
    return null
  }
}

async function getProduct(id) {
  return fetchData(productsAPI.getById, id)
}

async function getShop(id) {
  return fetchData(shopsAPI.getById, id)
}

// ==============================
// Loading Placeholder Component
// ==============================
function LoadingProductDetails() {
  return (
    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 animate-pulse">
      <div className="h-8 bg-gray-200 rounded w-3/4 mb-6"></div>
      <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div className="bg-gray-200 rounded-lg h-96"></div>
        <div>
          <div className="h-6 bg-gray-200 rounded w-1/2 mb-4"></div>
          <div className="h-6 bg-gray-200 rounded w-1/4 mb-6"></div>
          <div className="h-4 bg-gray-200 rounded mb-2"></div>
          <div className="h-4 bg-gray-200 rounded mb-2"></div>
          <div className="h-4 bg-gray-200 rounded mb-6"></div>
          <div className="h-10 bg-gray-200 rounded w-1/3 mb-6"></div>
          <div className="h-12 bg-gray-200 rounded mb-6"></div>
        </div>
      </div>
    </div>
  )
}

// ==============================
// Product Details Component
// ==============================
function ProductDetails({ product, shop }) {
  const discountedPrice = product.discount
    ? product.price - (product.price * product.discount) / 100
    : null

  const productImage = product.pics?.length > 0 ? product.pics[0] : '/placeholder-product.jpg'

  return (
    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      {/* Breadcrumb */}
      <Breadcrumb product={product} />

      {/* Product Info */}
      <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
        <ProductImage image={productImage} product={product} />
        <ProductInfo product={product} discountedPrice={discountedPrice} shop={shop} />
      </div>
    </div>
  )
}

// ==============================
// Breadcrumb Component
// ==============================
function Breadcrumb({ product }) {
  return (
    <nav className="flex mb-8" aria-label="Breadcrumb">
      <ol className="flex items-center space-x-2">
        <li>
          <Link href="/" className="text-gray-500 hover:text-gray-700">
            Home
          </Link>
        </li>
        <li className="flex items-center">
          <ChevronIcon />
          <Link href="/products" className="ml-2 text-gray-500 hover:text-gray-700">
            Products
          </Link>
        </li>
        <li className="flex items-center">
          <ChevronIcon />
          <span className="ml-2 font-medium">{product.name}</span>
        </li>
      </ol>
    </nav>
  )
}

function ChevronIcon() {
  return (
    <svg className="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
      <path
        fillRule="evenodd"
        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
        clipRule="evenodd"
      />
    </svg>
  )
}

// ==============================
// Product Image Component
// ==============================
function ProductImage({ image, product }) {
  return (
    <div className="relative rounded-lg overflow-hidden bg-gray-100 h-96">
      {image !== '/placeholder-product.jpg' ? (
        <Image
          src={image}
          alt={product.name}
          fill
          className="object-contain"
          sizes="(max-width: 768px) 100vw, 50vw"
          priority
        />
      ) : (
        <NoImagePlaceholder />
      )}
      {product.discount > 0 && (
        <div className="absolute top-4 right-4 bg-red-500 text-sm font-bold px-3 py-1 rounded-full">
          {product.discount}% OFF
        </div>
      )}
    </div>
  )
}

function NoImagePlaceholder() {
  return (
    <div className="flex items-center justify-center h-full text-gray-500">
      <div className="text-center">
        <svg
          className="mx-auto h-12 w-12 text-gray-400"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            strokeLinecap="round"
            strokeLinejoin="round"
            strokeWidth={2}
            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
          />
        </svg>
        <p className="mt-2 text-sm">No image available</p>
      </div>
    </div>
  )
}

// ==============================
// Product Info Component
// ==============================
function ProductInfo({ product, discountedPrice, shop }) {
  return (
    <div>
      <h1 className="text-3xl font-extrabold">{product.name}</h1>

      {/* Price */}
      <div className="mt-4">
        {discountedPrice ? (
          <div className="flex items-center">
            <span className="text-2xl font-bold">${discountedPrice.toFixed(2)}</span>
            <span className="ml-3 text-lg text-gray-500 line-through">
              ${parseFloat(product.price).toFixed(2)}
            </span>
          </div>
        ) : (
          <span className="text-2xl font-bold">${parseFloat(product.price).toFixed(2)}</span>
        )}
      </div>

      {/* Shop */}
      {shop && (
        <div className="mt-4">
          <Link
            href={`/shops/${shop.id}`}
            className="flex items-center text-indigo-600 hover:text-indigo-800"
          >
            Sold by: {shop.name}
          </Link>
        </div>
      )}

      {/* Description */}
      <Section title="Description">
        <p>{product.description || 'No description available'}</p>
      </Section>

      {/* Colors */}
      {product.colors?.length > 0 && (
        <Section title="Colors">
          <div className="flex flex-wrap gap-2">
            {product.colors.map((color, index) => (
              <Tag key={`${color}-${index}`} text={color} />
            ))}
          </div>
        </Section>
      )}

      {/* Types */}
      {product.types?.length > 0 && (
        <Section title="Types">
          <div className="flex flex-wrap gap-2">
            {product.types.map((type, index) => (
              <Tag key={`${type}-${index}`} text={type} />
            ))}
          </div>
        </Section>
      )}

      {/* Stock */}
      <StockStatus stock={product.stock} />

      {/* Add to Cart */}
      <div className="mt-8">
        <AddToCartButton product={product} />
      </div>
    </div>
  )
}

// ==============================
// Helper Components
// ==============================
function Section({ title, children }) {
  return (
    <div className="mt-6">
      <h3 className="text-lg font-medium text-gray-800">{title}</h3>
      <div className="mt-2">{children}</div>
    </div>
  )
}

function Tag({ text }) {
  return <span className="px-3 py-1 border border-gray-300 rounded-full text-sm">{text}</span>
}

function StockStatus({ stock }) {
  let message, color

  if (stock === 0) {
    message = 'Out of stock'
    color = 'text-red-600'
  } else if (stock <= 5) {
    message = `Only ${stock} left in stock - order soon`
    color = 'text-orange-600'
  } else {
    message = 'In Stock'
    color = 'text-green-600'
  }

  return <p className={`text-sm ${color} mt-6`}>{message}</p>
}

// ==============================
// Main Product Page Component
// ==============================
export default async function ProductPage({ params }) {
  const { id } = params
  const product = await getProduct(id)

  if (!product) {
    notFound()
  }

  const shop = product.shop_id ? await getShop(product.shop_id) : null

  return <ProductDetails product={product} shop={shop} />
}
