'use client';

import Link from 'next/link';
import ShopImage from './ShopImage';

export default function ShopCard({ shop }) {
  return (
    <div className="group relative bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow">
      <Link href={`/shops/${shop.id}`} className="block">
        <div className="relative h-48 w-full overflow-hidden">
          <ShopImage 
            src={shop.logo} 
            alt={shop.name}
            className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
          />
        </div>

        <div className="p-4">
          <h3 className="text-lg font-medium text-gray-900 truncate">{shop.name}</h3>
          
          <p className="mt-1 text-sm text-gray-500 line-clamp-2">
            {shop.description || 'No description available'}
          </p>
          
          <div className="mt-2 flex justify-between items-center">
            <div className="text-sm text-gray-600">
              {shop.productCount || 0} products
            </div>
            
            <div className="text-sm font-medium text-indigo-600 hover:text-indigo-500">
              View Shop
            </div>
          </div>
        </div>
      </Link>
    </div>
  );
}
