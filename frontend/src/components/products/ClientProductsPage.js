'use client';

import Link from 'next/link';
import { useRouter, useSearchParams } from 'next/navigation';
import { useCallback, useState, useEffect } from 'react';
import ProductList from './ProductList';

export default function ClientProductsPage({ products, categories, searchParams }) {
  const router = useRouter();
  const searchParamsObj = useSearchParams();
  const [searchValues, setSearchValues] = useState({
    search: '',
    category: '',
    sort: 'newest'
  });

  // Initialize search values when searchParamsObj is ready
  useEffect(() => {
    setSearchValues({
      search: searchParamsObj.get('search') || '',
      category: searchParamsObj.get('category') || '',
      sort: searchParamsObj.get('sort') || 'newest'
    });
  }, [searchParamsObj]);

  const [debouncedSearch, setDebouncedSearch] = useState(searchParamsObj.get('search') || '');

  // Create a function to update URL with new search parameters
  const updateSearchParams = useCallback((params) => {
    const newSearchParams = new URLSearchParams(searchParamsObj.toString());

    // Update or add each parameter
    Object.entries(params).forEach(([key, value]) => {
      if (value === '' || value === null || value === undefined) {
        newSearchParams.delete(key);
      } else {
        newSearchParams.set(key, value);
      }
    });

    // Reset to page 1 when filters change
    if (!params.hasOwnProperty('page')) {
      newSearchParams.set('page', '1');
    }

    // Navigate to the new URL
    router.push(`/products?${newSearchParams.toString()}`);
  }, [router, searchParamsObj]);

  // Debounce search term changes
  useEffect(() => {
    const timer = setTimeout(() => {
      if (debouncedSearch !== searchParamsObj.get('search')) {
        updateSearchParams({ search: debouncedSearch });
      }
    }, 500); // 500ms delay

    return () => clearTimeout(timer);
  }, [debouncedSearch, updateSearchParams, searchParamsObj]);

  // Client-side event handlers
  const handleFilterChange = (filter) => {
    updateSearchParams({ category: filter.category });
  };

  const handleSortChange = (sort) => {
    updateSearchParams({ sort });
  };

  const handleSearchChange = (search) => {
    // Update the debounced search state
    // The useEffect hook will handle the actual URL update after the debounce period
    setDebouncedSearch(search);
  };

  return (
    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      {/* Breadcrumbs */}
      <nav className="flex mb-8" aria-label="Breadcrumb">
        <ol className="flex items-center space-x-2">
          <li>
            <Link href="/" className="text-gray-500 hover:text-gray-700">Home</Link>
          </li>
          <li className="flex items-center">
            <svg className="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
              <path fillRule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clipRule="evenodd" />
            </svg>
            <span className="ml-2 text-gray-900 font-medium">Products</span>
          </li>
        </ol>
      </nav>

      {/* Page title */}
      <div className="mb-8">
        <h1 className="text-3xl font-extrabold text-gray-900">All Products</h1>
        <p className="mt-2 text-lg text-gray-600">Browse our collection of products from various shops</p>
      </div>

      {/* Product list with filters */}
      <ProductList 
        products={products} 
        categories={categories}
        initialSearch={searchValues.search}
        initialCategory={searchValues.category}
        initialSort={searchValues.sort}
        onFilterChange={handleFilterChange}
        onSortChange={handleSortChange}
        onSearchChange={handleSearchChange}
      />
    </div>
  );
}
