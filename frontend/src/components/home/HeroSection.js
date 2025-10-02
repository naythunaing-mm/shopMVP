'use client'

import Link from 'next/link'
import { ShoppingCart, Store } from 'lucide-react'

export default function HeroSection() {
  return (
    // Centered, full-height container with a soft, dark background
    <div className="flex items-center justify-center min-h-[70vh] bg-gray-950 px-4 py-16 sm:px-6 lg:px-8">
      <div className="max-w-4xl mx-auto text-center z-10 relative">
        {' '}
        {/* z-10 ensures content is above the background effect */}
        {/*
          // Primary Heading: Bold, slightly larger, and centered for immediate impact
        */}
        <h1 className="text-6xl sm:text-7xl md:text-8xl font-extrabold tracking-tight text-white mb-6">
          <span className="block">Shop Smarter.</span>
          <span className="block text-sky-400">Live Better.</span>
        </h1>
        {/*
          // Sub-text: Clear, concise, and using a lighter gray for contrast
        */}
        <p className="mt-4 text-xl sm:text-2xl text-gray-300 max-w-2xl mx-auto">
          The curated marketplace for products you'll love. Discover, compare, and buy with
          confidence.
        </p>
        {/*
          // Call-to-Action Buttons: Now using your original '/products' and '/shops' hrefs
        */}
        <div className="mt-10 flex flex-col sm:flex-row justify-center gap-4">
          <Link
            href="/products" // <-- Your original link
            className="inline-flex items-center justify-center px-8 py-4 border border-transparent text-base font-semibold rounded-lg text-white bg-sky-600 shadow-xl transition duration-300 ease-in-out hover:bg-sky-700 hover:shadow-2xl md:text-lg"
          >
            <ShoppingCart className="w-5 h-5 mr-2" />
            Browse Products
          </Link>

          <Link
            href="/shops" // <-- Your original link
            className="inline-flex items-center justify-center px-8 py-4 border border-sky-600 text-base font-semibold rounded-lg text-sky-400 bg-transparent transition duration-300 ease-in-out hover:bg-sky-900/50 md:text-lg"
          >
            <Store className="w-5 h-5 mr-2" />
            View Shops
          </Link>
        </div>
      </div>
      Featured Products
      {/* Subtle background visual element */}
      <div className="absolute inset-0 z-0 overflow-hidden pointer-events-none">
        <div className="w-96 h-96 bg-sky-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 absolute top-1/4 left-1/4 animate-pulse-slow"></div>
      </div>
    </div>
  )
}
