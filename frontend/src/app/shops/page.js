import { Suspense } from 'react';

// Function to get shops with pagination and filters
async function getShops(searchParams) {
  const searchParamsObj = await searchParams;
  const response = await shopsAPI.getAll(searchParamsObj);

  return {
    shops: response.data.shops || response.data,
    total: response.data.total,
    page: response.data.page,
    limit: response.data.limit
  };
}

// Loading component
function LoadingShops() {
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
  );
}

// Import the client component
import ClientShopsPage from '@/components/shops/ClientShopsPage';
import { shopsAPI } from "@/lib/api";

// Main page component
export default async function Page({ searchParams }) {
  return (
    <Suspense fallback={<LoadingShops />}>
      {/* @ts-expect-error Async Server Component */}
      <ShopsPageWrapper searchParams={searchParams} />
    </Suspense>
  );
}

// Wrapper component to handle async data fetching
async function ShopsPageWrapper({ searchParams }) {
  const shopsData = await getShops(searchParams);

  return (
    <ClientShopsPage 
      shops={shopsData.shops} 
      searchParams={searchParams}
    />
  );
}