'use client';

import Link from 'next/link';

export default function CategoryCard({ category }) {
  return (
    <Link href={`/categories/${category.id}`} className="group">
      <div className="relative rounded-lg overflow-hidden bg-white shadow-md hover:shadow-lg transition-shadow">
        <div className="h-24 bg-gradient-to-r from-indigo-500 to-purple-600"></div>
        <div className="p-4">
          <h3 className="text-lg font-medium text-gray-900 group-hover:text-indigo-600 transition-colors">
            {category.name}
          </h3>
        </div>
      </div>
    </Link>
  );
}