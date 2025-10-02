import { Suspense } from 'react'
import ClientProductsPage from '@/components/products/ClientProductsPage'
import { productsAPI, categoriesAPI } from '@/lib/api'

// Disable caching for this page to always fetch fresh data
export const dynamic = 'force-dynamic'
export const revalidate = 0

// Function to get products with pagination and filters
async function getProducts(searchParams) {
  const searchParamsObj = await searchParams
  // Add cache-busting timestamp to ensure fresh data
  const params = {
    ...searchParamsObj,
    _t: Date.now(),
    cache_bust: Math.random().toString(36),
  }

  try {
    const response = await productsAPI.getAll(params)
    'Server-side API Response:', response.data

    return {
      products: response.data.products || [],
      total: response.data.total || 0,
      page: response.data.current_page || 1,
      limit: response.data.per_page || 10,
    }
  } catch (error) {
    console.error('Server-side API Error:', error)
    return {
      products: [],
      total: 0,
      page: 1,
      limit: 10,
    }
  }
}

// Function to get categories
async function getCategories() {
  const response = await categoriesAPI.getAll()
  return response.data
}

// Loading component
function LoadingProducts() {
  return (
    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div className="animate-pulse">
        <div className="h-8 bg-gray-200 rounded w-1/4 mb-6"></div>
        <div className="h-12 bg-gray-200 rounded mb-8"></div>
        <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
          {[...Array(8)].map((_, i) => (
            <div key={i} className="bg-gray-200 rounded-lg h-64"></div>
          ))}
        </div>
      </div>
    </div>
  )
}

// Main page component
export default async function Page({ searchParams }) {
  return (
    <Suspense fallback={<LoadingProducts />}>
      {/* @ts-expect-error Async Server Component */}
      <ProductsPageWrapper searchParams={searchParams} />
    </Suspense>
  )
}

// Wrapper component to handle async data fetching
async function ProductsPageWrapper({ searchParams }) {
  const [productsData, categories] = await Promise.all([getProducts(searchParams), getCategories()])

  return (
    <ClientProductsPage
      products={productsData.products}
      categories={categories}
      searchParams={searchParams}
    />
  )
}
