'use client'

import { useState } from 'react'

export default function ProductImage({
  src,
  alt,
  fill = false,
  width,
  height,
  className = '',
  sizes,
  priority = false,
  ...props
}) {
  const [error, setError] = useState(false)

  // Base64 encoded placeholder image (a simple gray square)
  const placeholderImage =
    "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Crect width='100' height='100' fill='%23f3f4f6'/%3E%3Ctext x='50' y='50' font-family='sans-serif' font-size='12' text-anchor='middle' dominant-baseline='middle' fill='%239ca3af'%3ENo Image%3C/text%3E%3C/svg%3E"

  // Process image URL to handle different formats
  const processImageUrl = (imageUrl) => {
    if (!imageUrl || imageUrl === 'null' || imageUrl === 'undefined') {
      return placeholderImage
    }

    // If it's already a data URL, return as is
    if (imageUrl.startsWith('data:')) {
      return imageUrl
    }

    // If it's already a full URL, return as is
    if (imageUrl.startsWith('http://') || imageUrl.startsWith('https://')) {
      return imageUrl
    }

    // If it starts with /, treat as absolute path from backend
    if (imageUrl.startsWith('/')) {
      return `http://localhost:8000${imageUrl}`
    }

    // If it's just a filename, construct the full URL
    if (!imageUrl.includes('/')) {
      return `http://localhost:8000/storage/product_pics/${imageUrl}`
    }

    // Default case - construct full URL
    return `http://localhost:8000/storage/${imageUrl}`
  }

  const imageSrc = error ? placeholderImage : processImageUrl(src)

  // Handle image load error
  const handleError = (e) => {
    'Image load error:', e.target.src
    setError(true)
  }

  // Debug logging
  'ProductImage - Original src:', src
  'ProductImage - Processed imageSrc:', imageSrc

  // Test if image URL is accessible
  if (imageSrc && !imageSrc.startsWith('data:')) {
    'Testing image URL accessibility:', imageSrc
  }

  if (fill) {
    return (
      <div className={`relative ${className}`} {...props}>
        <img
          src={imageSrc}
          alt={alt || 'Product image'}
          className={`absolute inset-0 w-full h-full object-cover ${error ? 'object-contain' : ''}`}
          onError={handleError}
          loading={priority ? 'eager' : 'lazy'}
        />
      </div>
    )
  }

  return (
    <img
      src={imageSrc}
      alt={alt || 'Product image'}
      width={width || 300}
      height={height || 300}
      className={className}
      onError={handleError}
      loading={priority ? 'eager' : 'lazy'}
      {...props}
    />
  )
}
