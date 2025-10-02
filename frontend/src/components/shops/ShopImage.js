'use client'

import { useState } from 'react'

export default function ShopImage({ src, alt, className, ...props }) {
  const [imgSrc, setImgSrc] = useState(() => {
    if (!src) return '/placeholder-shop.jpg'

    // If it's already a full URL, use it as is
    if (src.startsWith('http://') || src.startsWith('https://')) {
      return src
    }

    // If it starts with /storage/, construct full URL
    if (src.startsWith('/storage/')) {
      return `http://localhost:8000${src}`
    }

    // If it starts with storage/, construct full URL
    if (src.startsWith('storage/')) {
      return `http://localhost:8000/${src}`
    }

    // For any other case, assume it's a filename and construct the path
    return `http://localhost:8000/storage/shops/${src}`
  })

  const handleError = () => {
    'Shop image failed to load:', imgSrc
    setImgSrc('/placeholder-shop.jpg')
  }

  return <img src={imgSrc} alt={alt} className={className} onError={handleError} {...props} />
}
