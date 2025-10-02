'use client'

import { useState, useEffect } from 'react'
import { FaSearch, FaFilter, FaSortAmountDown, FaSortAmountUp } from 'react-icons/fa'
import ProductCard from './ProductCard'

export default function ProductList({
  products = [],
  isLoading = false,
  error = null,
  categories = [],
  initialSearch = '',
  initialCategory = '',
  initialSort = 'newest',
  onFilterChange = () => {},
  onSortChange = () => {},
  onSearchChange = () => {},
}) {
  const [searchTerm, setSearchTerm] = useState(initialSearch)
  const [selectedCategory, setSelectedCategory] = useState(initialCategory)
  const [sortOrder, setSortOrder] = useState(initialSort)
  const [showFilters, setShowFilters] = useState(false)

  // Sync state with props when URL parameters change
  useEffect(() => {
    setSearchTerm(initialSearch)
    setSelectedCategory(initialCategory)
    setSortOrder(initialSort)
  }, [initialSearch, initialCategory, initialSort])

  // Handle search input change
  const handleSearchChange = (e) => {
    const value = e.target.value
    setSearchTerm(value)
    onSearchChange(value)
  }

  // Handle category filter change
  const handleCategoryChange = (e) => {
    const value = e.target.value
    setSelectedCategory(value)
    onFilterChange({ category: value })
  }

  // Handle sort order change
  const handleSortChange = (e) => {
    const value = e.target.value
    setSortOrder(value)
    onSortChange(value)
  }

  // Toggle filters visibility on mobile
  const toggleFilters = () => {
    setShowFilters(!showFilters)
  }

  return (
    <div className="w-full">
      {/* Search and filter bar */}
      {products.length !== 4 && (
        <div className="mb-6 bg-white p-4 rounded-lg shadow-sm">
          <div className="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            {/* Search input */}
            <div className="relative flex-grow">
              <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <FaSearch className="h-5 w-5 text-gray-400" />
              </div>
              <input
                type="text"
                className="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:text-gray-900 sm:text-sm"
                placeholder="Search products..."
                value={searchTerm}
                onChange={handleSearchChange}
              />
            </div>

            {/* Filter toggle button (mobile only) */}
            <div className="md:hidden">
              <button
                type="button"
                className="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                onClick={toggleFilters}
              >
                <FaFilter className="mr-2 h-4 w-4" />
                Filters
              </button>
            </div>

            {/* Desktop filters */}
            <div className="hidden md:flex md:items-center md:space-x-4">
              {/* Category filter */}
              <div>
                <select
                  className="block w-full pl-3 pr-10 py-2 text-base text-gray-900 border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:text-gray-900 sm:text-sm rounded-md"
                  value={selectedCategory}
                  onChange={handleCategoryChange}
                >
                  <option value="">All Categories</option>
                  {categories.map((category) => (
                    <option key={category.id} value={category.id}>
                      {category.name}
                    </option>
                  ))}
                </select>
              </div>

              {/* Sort order */}
              <div>
                <select
                  className="block w-full pl-3 pr-10 py-2 text-base text-gray-900 border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:text-gray-900 sm:text-sm rounded-md"
                  value={sortOrder}
                  onChange={handleSortChange}
                >
                  <option value="newest">Newest</option>
                  <option value="price_low">Price: Low to High</option>
                  <option value="price_high">Price: High to Low</option>
                  <option value="name_asc">Name: A to Z</option>
                  <option value="name_desc">Name: Z to A</option>
                </select>
              </div>
            </div>
          </div>

          {/* Mobile filters (collapsible) */}
          {showFilters && (
            <div className="mt-4 md:hidden space-y-4">
              {/* Category filter */}
              <div>
                <label
                  htmlFor="mobile-category"
                  className="block text-sm font-medium text-gray-700"
                >
                  Category
                </label>
                <select
                  id="mobile-category"
                  className="mt-1 block w-full pl-3 pr-10 py-2 text-base text-gray-900 border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:text-gray-900 sm:text-sm rounded-md"
                  value={selectedCategory}
                  onChange={handleCategoryChange}
                >
                  <option value="">All Categories</option>
                  {categories.map((category) => (
                    <option key={category.id} value={category.id}>
                      {category.name}
                    </option>
                  ))}
                </select>
              </div>

              {/* Sort order */}
              <div>
                <label htmlFor="mobile-sort" className="block text-sm font-medium text-gray-700">
                  Sort By
                </label>
                <select
                  id="mobile-sort"
                  className="mt-1 block w-full pl-3 pr-10 py-2 text-base text-gray-900 border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:text-gray-900 sm:text-sm rounded-md"
                  value={sortOrder}
                  onChange={handleSortChange}
                >
                  <option value="newest">Newest</option>
                  <option value="price_low">Price: Low to High</option>
                  <option value="price_high">Price: High to Low</option>
                  <option value="name_asc">Name: A to Z</option>
                  <option value="name_desc">Name: Z to A</option>
                </select>
              </div>
            </div>
          )}
        </div>
      )}
      {/* Loading state */}
      {isLoading && (
        <div className="flex justify-center items-center py-12">
          <div className="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-indigo-500"></div>
        </div>
      )}

      {/* Error state */}
      {error && (
        <div className="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
          <div className="flex">
            <div className="flex-shrink-0">
              <svg
                className="h-5 w-5 text-red-400"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
                fill="currentColor"
                aria-hidden="true"
              >
                <path
                  fillRule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                  clipRule="evenodd"
                />
              </svg>
            </div>
            <div className="ml-3">
              <p className="text-sm text-red-700">{error}</p>
            </div>
          </div>
        </div>
      )}

      {/* Empty state */}
      {!isLoading && !error && products.length === 0 && (
        <div className="text-center py-12">
          <svg
            className="mx-auto h-12 w-12 text-gray-400"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            aria-hidden="true"
          >
            <path
              strokeLinecap="round"
              strokeLinejoin="round"
              strokeWidth="2"
              d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
            />
          </svg>
          <h3 className="mt-2 text-sm font-medium text-gray-900">No products found</h3>
          <p className="mt-1 text-sm text-gray-500">
            Try adjusting your search or filter to find what you're looking for.
          </p>
        </div>
      )}

      {/* Product grid */}
      {!isLoading && !error && products.length > 0 && (
        <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
          {products.map((product) => (
            <ProductCard key={product.id} product={product} />
          ))}
        </div>
      )}
    </div>
  )
}
