'use client'

import { useEffect, useState } from 'react'
import ProductList from '@/components/products/ProductList'
import { LoadingProducts, LoadingCategories } from '@/components/home/LoadingComponents'
import { productsAPI, categoriesAPI } from '@/lib/api'
import Link from 'next/link'

/**
 * Featured Products Section
 */
function FeaturedProductsWrapper() {
  const [products, setProducts] = useState([])
  const [loading, setLoading] = useState(true)

  useEffect(() => {
    const fetchProducts = async () => {
      try {
        const response = await productsAPI.getAll({ limit: 4 })
        console.log('Featured Products API Response:', response.data)
        const products = response.data?.products || []
        setProducts(products)
      } catch (error) {
        console.error('Error fetching featured products:', error)
      } finally {
        setLoading(false)
      }
    }

    fetchProducts()
  }, [])

  if (loading) return <LoadingProducts />

  return <ProductList products={products} />
}

export function FeaturedProductsSection() {
  return (
    <section className="py-12 bg-gray-50">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center">
          <h2 className="text-3xl font-extrabold text-gray-900 sm:text-4xl">Featured Products</h2>
          <p className="mt-3 max-w-2xl mx-auto text-xl text-gray-500 sm:mt-4">
            Check out our latest and most popular products
          </p>
        </div>

        <div className="mt-12">
          <FeaturedProductsWrapper />
        </div>

        <div className="mt-8 text-center">
          <Link
            href="/products"
            className="inline-flex items-center gap-2 px-6 py-3 font-medium text-white bg-gradient-to-r from-indigo-500 to-indigo-700 rounded-lg shadow-lg hover:from-indigo-600 hover:to-indigo-800 transition"
          >
            <span>View All Products</span>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              className="w-5 h-5"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                strokeLinecap="round"
                strokeLinejoin="round"
                strokeWidth={2}
                d="M17 8l4 4m0 0l-4 4m4-4H3"
              />
            </svg>
          </Link>
        </div>
      </div>
    </section>
  )
}

/**
 * Categories Section
 */
function CategoriesWrapper() {
  const [categories, setCategories] = useState([])
  const [loading, setLoading] = useState(true)

  useEffect(() => {
    const fetchCategories = async () => {
      try {
        const response = await categoriesAPI.getAll()
        console.log('Categories API Response:', response.data)
        setCategories(response.data || [])
      } catch (error) {
        console.error('Error fetching categories:', error)
      } finally {
        setLoading(false)
      }
    }

    fetchCategories()
  }, [])

  if (loading) return <LoadingCategories />

  return (
    <div className="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
      {categories.map((category) => (
        <div
          key={category.id}
          className="py-2 px-3 border rounded-lg shadow-sm hover:shadow-lg transition hover:bg-gray-50 cursor-pointer"
        >
          <h3 className="text-lg font-semibold text-center">{category.name}</h3>
        </div>
      ))}
    </div>
  )
}

export function CategoriesSection() {
  return (
    <section className="py-12 bg-white">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center">
          <h2 className="text-3xl font-extrabold text-gray-900 sm:text-4xl">Shop by Category</h2>
          <p className="mt-3 max-w-2xl mx-auto text-xl text-gray-500 sm:mt-4">
            Browse our wide range of product categories
          </p>
        </div>

        <div className="mt-12">
          <CategoriesWrapper />
        </div>
      </div>
    </section>
  )
}

/**
 * POS System Info Section
 */
export function PosInfoSection() {
  return (
    <section className="py-12 bg-indigo-50">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center">
          <h2 className="text-3xl font-extrabold text-gray-900 sm:text-4xl">
            About Our POS System
          </h2>
          <p className="mt-3 max-w-2xl mx-auto text-xl text-gray-500 sm:mt-4">
            Our POS system is designed to streamline your business operations — whether in retail,
            restaurants, or wholesale.
          </p>
        </div>

        <div className="mt-10 grid grid-cols-1 md:grid-cols-3 gap-8">
          <div className="p-6 bg-white rounded-lg shadow hover:shadow-lg transition">
            <h3 className="text-xl font-semibold">Easy Checkout</h3>
            <p className="mt-2 text-gray-600">
              Quick and efficient checkout process to improve customer satisfaction.
            </p>
          </div>
          <div className="p-6 bg-white rounded-lg shadow hover:shadow-lg transition">
            <h3 className="text-xl font-semibold">Inventory Management</h3>
            <p className="mt-2 text-gray-600">
              Track stock levels and restock automatically to avoid shortages.
            </p>
          </div>
          <div className="p-6 bg-white rounded-lg shadow hover:shadow-lg transition">
            <h3 className="text-xl font-semibold">Sales Reports</h3>
            <p className="mt-2 text-gray-600">
              Generate detailed sales reports to make data-driven business decisions.
            </p>
          </div>
        </div>
      </div>
    </section>
  )
}
