'use client';

import { useState, useEffect } from 'react';
import { useParams } from 'next/navigation';
import Link from 'next/link';
import ShopImage from '../../../components/shops/ShopImage';
import ProductImage from '../../../components/ui/ProductImage';

export default function ShopDetailPage() {
    const params = useParams();
    const shopId = params.id;

    const [shop, setShop] = useState(null);
    const [products, setProducts] = useState([]);
    const [categories, setCategories] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        const fetchShopData = async() => {
            try {
                setLoading(true);

                // Fetch shop details
                const shopResponse = await fetch(`http://localhost:8000/api/shops/${shopId}`);
                if (!shopResponse.ok) throw new Error('Failed to fetch shop');
                const shopData = await shopResponse.json();
                setShop(shopData);

                // Shop data already includes products from the show method
                if (shopData.products && Array.isArray(shopData.products)) {
                    setProducts(shopData.products);
                    
                    // Extract unique categories from products
                    const uniqueCategories = [...new Set(shopData.products.map(product => product.category?.name).filter(Boolean) || [])];
                    setCategories(uniqueCategories);
                } else {
                    // Fallback: fetch products separately if not included
                    const productsResponse = await fetch(`http://localhost:8000/api/shops/${shopId}/products`);
                    if (productsResponse.ok) {
                        const productsData = await productsResponse.json();
                        setProducts(productsData.data || []);
                        
                        const uniqueCategories = [...new Set((productsData.data || []).map(product => product.category?.name).filter(Boolean) || [])];
                        setCategories(uniqueCategories);
                    }
                }

            } catch (err) {
                setError(err.message);
            } finally {
                setLoading(false);
            }
        };

        if (shopId) {
            fetchShopData();
        }
    }, [shopId]);

    if (loading) {
        return (
            <div className="min-h-screen bg-gray-50 flex items-center justify-center">
                <div className="text-center">
                    <div className="animate-spin rounded-full h-32 w-32 border-b-2 border-indigo-600 mx-auto"></div>
                    <p className="mt-4 text-gray-600">Loading shop details...</p>
                </div>
            </div>
        );
    }

    if (error) {
        return (
            <div className="min-h-screen bg-gray-50 flex items-center justify-center">
                <div className="text-center">
                    <h1 className="text-2xl font-bold text-gray-900 mb-4">Shop Not Found</h1>
                    <p className="text-gray-600 mb-4">{error}</p>
                    <Link href="/shops" className="text-indigo-600 hover:text-indigo-500">
                        ← Back to All Shops
                    </Link>
                </div>
            </div>
        );
    }

    if (!shop) {
        return (
            <div className="min-h-screen bg-gray-50 flex items-center justify-center">
                <div className="text-center">
                    <h1 className="text-2xl font-bold text-gray-900 mb-4">Shop Not Found</h1>
                    <Link href="/shops" className="text-indigo-600 hover:text-indigo-500">
                        ← Back to All Shops
                    </Link>
                </div>
            </div>
        );
    }

    return (
        <div className="min-h-screen bg-gray-50">
            {/* Shop Header */}
            <div className="bg-white shadow">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    <div className="flex items-start space-x-6">
                        <div className="flex-shrink-0">
                            <div className="w-24 h-24 rounded-lg overflow-hidden">
                                <ShopImage 
                                    src={shop.logo}
                                    alt={shop.name}
                                    className="w-full h-full object-cover"
                                />
                            </div>
                        </div>
                        <div className="flex-1">
                            <h1 className="text-3xl font-bold text-gray-900">{shop.name}</h1>
                            <p className="mt-2 text-gray-600">{shop.description || 'No description available'}</p>

                            <div className="mt-4 flex items-center space-x-6 text-sm text-gray-500">
                                <span>{products.length} products</span>
                                <span>{categories.length} categories</span>
                            </div>

                            {shop.address && (
                                <div className="mt-2 text-sm text-gray-500">
                                    📍 {shop.address}
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </div>

            {/* Categories */}
            {categories.length > 0 && (
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                    <h2 className="text-xl font-semibold text-gray-900 mb-4">Categories</h2>
                    <div className="flex flex-wrap gap-2">
                        {categories.map((category, index) => (
                            <span 
                                key={index}
                                className="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800"
                            >
                                {category}
                            </span>
                        ))}
                    </div>
                </div>
            )}

            {/* Products */}
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div className="flex justify-between items-center mb-6">
                    <h2 className="text-xl font-semibold text-gray-900">Products</h2>
                    <Link href="/shops" className="text-indigo-600 hover:text-indigo-500">
                        ← Back to All Shops
                    </Link>
                </div>

                {products.length === 0 ? (
                    <div className="text-center py-12">
                        <p className="text-gray-500">No products available in this shop yet.</p>
                    </div>
                ) : (
                    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        {products.map((product) => (
                            <div 
                                key={product.id}
                                className="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow"
                            >
                                <Link href={`/products/${product.id}`}>
                                    <div className="relative h-48 w-full overflow-hidden">
                                        <ProductImage 
                                            src={product.images && product.images.length > 0 ? product.images[0] : (Array.isArray(product.pics) ? product.pics[0] : product.pics)}
                                            alt={product.name}
                                            className="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                                        />
                                    </div>

                                    <div className="p-4">
                                        <h3 className="text-lg font-medium text-gray-900 truncate">
                                            {product.name}
                                        </h3>

                                        <div className="mt-2 flex items-center justify-between">
                                            <div className="flex items-center space-x-2">
                                                <span className="text-lg font-bold text-gray-900">
                                                    ${parseFloat(product.price || 0).toFixed(2)}
                                                </span>
                                                {product.discount > 0 && (
                                                    <span className="text-sm text-red-600 bg-red-100 px-2 py-1 rounded">
                                                        -{product.discount}%
                                                    </span>
                                                )}
                                            </div>
                                        </div>

                                        {product.category && (
                                            <div className="mt-2">
                                                <span className="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">
                                                    {product.category.name}
                                                </span>
                                            </div>
                                        )}
                                    </div>
                                </Link>
                            </div>
                        ))}
                    </div>
                )}
            </div>
        </div>
    );
}