'use client';

import Link from 'next/link';
import { useEffect, useState } from 'react';
import { 
  FaShoppingCart, 
  FaUser, 
  FaSignOutAlt, 
  FaSignInAlt, 
  FaStore, 
  FaBoxOpen, 
  FaChartLine,
  FaCog,
  FaBars,
  FaTimes
} from 'react-icons/fa';
import { useRouter } from 'next/navigation';
import { useAuth } from '@/lib/hooks/useAuth';
import { useCart } from '@/lib/hooks/useCart';

export default function Navbar() {
  const { user, logout, getProfile } = useAuth();
  const { items } = useCart();
  const [isMenuOpen, setIsMenuOpen] = useState(false);
  const [mounted, setMounted] = useState(false);
  const router = useRouter();

  const toggleMenu = () => {
    setIsMenuOpen(!isMenuOpen);
  };

  const handleLogout = async () => {
    await logout();
    router.push('/login');
  };

  useEffect(() => {
    const checkAuth = async () => {
      await getProfile();
    };
    checkAuth();
    setMounted(true);
  }, [getProfile]);

  // Check if user is a shop owner
  const isShopOwner = user?.role === 'admin' || user?.role === 'admin';

  return (
    <nav className="bg-white shadow-md">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex justify-between h-16">
          <div className="flex items-center">
            <div className="flex-shrink-0">
              <Link href="/" className="text-xl font-bold text-gray-800">
                ShopMVP
              </Link>
            </div>
            <div className="hidden sm:ml-6 sm:flex sm:space-x-8">
              <Link href="/" className="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                Home
              </Link>
              <Link href="/products" className="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                Products
              </Link>
              <Link href="/shops" className="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                Shops
              </Link>
            </div>
          </div>
          <div className="hidden sm:ml-6 sm:flex sm:items-center">
            <Link href="/cart" className="p-1 rounded-full text-gray-400 hover:text-gray-500 relative">
              <span className="sr-only">View cart</span>
              <FaShoppingCart className="h-6 w-6" />
              {mounted && items.length > 0 && (
                <span className="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none   transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                  {items.length}
                </span>
              )}
            </Link>
            {mounted ? (
              user ? (
                <div className="ml-3 relative">
                  <div className="relative">
                    <button 
                      onClick={toggleMenu} 
                      className="flex items-center space-x-2 focus:outline-none"
                      id="user-menu" 
                      aria-expanded={isMenuOpen}
                      aria-haspopup="true"
                    >
                      <div className="relative">
                        <div className="h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center overflow-hidden">
                          {user?.avatar ? (
                            <img className="h-full w-full object-cover" src={user.avatar} alt={user.name} />
                          ) : (
                            <FaUser className="h-6 w-6 text-gray-400" />
                          )}
                        </div>
                        {isShopOwner && (
                          <span className="absolute -bottom-1 -right-1 bg-green-100 text-green-800 text-xs px-2 py-0.5 rounded-full border border-white">
                            Shop Owner
                          </span>
                        )}
                      </div>
                      <div className="hidden md:block text-left">
                        <p className="text-sm font-medium text-gray-700">{user?.name || 'User'}</p>
                        <p className="text-xs text-gray-500">{isShopOwner ? 'Shop Owner' : 'Customer'}</p>
                      </div>
                      <svg className="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 9l-7 7-7-7" />
                      </svg>
                    </button>
                  </div>
                  {isMenuOpen && (
                    <div 
                      className="origin-top-right absolute right-0 mt-2 w-64 rounded-lg shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50 divide-y divide-gray-100" 
                      role="menu" 
                      aria-orientation="vertical" 
                      aria-labelledby="user-menu"
                    >
                      <div className="px-4 py-3">
                        <div className="flex items-center space-x-3">
                          <div className="h-10 w-10 rounded-full bg-gray-100 flex-shrink-0 flex items-center justify-center overflow-hidden">
                            {user?.avatar ? (
                              <img className="h-full w-full object-cover" src={user.avatar} alt={user.name} />
                            ) : (
                              <FaUser className="h-6 w-6 text-gray-400" />
                            )}
                          </div>
                          <div>
                            <p className="text-sm font-medium text-gray-900">{user?.name || 'User'}</p>
                            <p className="text-xs text-gray-500">{user?.email}</p>
                          </div>
                        </div>
                      </div>
                      
                      <div className="py-1">
                        <Link 
                          href="/profile" 
                          onClick={() => setIsMenuOpen(false)}
                          className="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" 
                          role="menuitem"
                        >
                          <FaUser className="mr-3 text-gray-400" />
                          Your Profile
                        </Link>
                        <Link 
                          href="/orders" 
                          onClick={() => setIsMenuOpen(false)}
                          className="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" 
                          role="menuitem"
                        >
                          <FaBoxOpen className="mr-3 text-gray-400" />
                          Orders
                        </Link>
                        
                        {isShopOwner && (
                          <>
                            <div className="border-t border-gray-100 my-1"></div>
                            <Link 
                              href="/dashboard" 
                              onClick={() => setIsMenuOpen(false)}
                              className="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" 
                              role="menuitem"
                            >
                              <FaChartLine className="mr-3 text-gray-400" />
                              Seller Dashboard
                            </Link>
                            <Link 
                              href="/products/manage" 
                              onClick={() => setIsMenuOpen(false)}
                              className="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" 
                              role="menuitem"
                            >
                              <FaBoxOpen className="mr-3 text-gray-400" />
                              Manage Products
                            </Link>
                            <Link 
                              href="/shops/manage" 
                              onClick={() => setIsMenuOpen(false)}
                              className="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" 
                              role="menuitem"
                            >
                              <FaStore className="mr-3 text-gray-400" />
                              My Shop
                            </Link>
                          </>
                        )}
                        
                        <div className="border-t border-gray-100 my-1"></div>
                        <button 
                          onClick={() => {
                            setIsMenuOpen(false);
                            handleLogout();
                          }} 
                          className="w-full text-left flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" 
                          role="menuitem"
                        >
                          <FaSignOutAlt className="mr-3 text-gray-400" />
                          Sign out
                        </button>
                      </div>
                    </div>
                  )}
                </div>
              ) : (
                <div className="ml-3 flex items-center">
                  <Link href="/login" className="text-gray-500 hover:text-gray-700 flex items-center">
                    <FaSignInAlt className="mr-1" />
                    Login
                  </Link>
                  <span className="mx-2 text-gray-300">|</span>
                  <Link href="/register" className="text-gray-500 hover:text-gray-700">
                    Register
                  </Link>
                </div>
              )
            ) : (
              <div className="ml-3 relative">
                <div>
                  <span className="max-w-xs bg-white flex items-center text-sm rounded-full">
                    <FaUser className="h-5 w-5 text-gray-400" />
                  </span>
                </div>
              </div>
            )}
          </div>
          <div className="-mr-2 flex items-center sm:hidden">
            <button 
              onClick={toggleMenu} 
              className="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" 
              aria-expanded={isMenuOpen}
              aria-label={isMenuOpen ? 'Close menu' : 'Open menu'}
            >
              {isMenuOpen ? (
                <FaTimes className="block h-6 w-6" aria-hidden="true" />
              ) : (
                <FaBars className="block h-6 w-6" aria-hidden="true" />
              )}
            </button>
          </div>
        </div>
      </div>

      {/* Mobile menu */}
      <div className={`${isMenuOpen ? 'block' : 'hidden'} sm:hidden`}>
        <div className="pt-2 pb-3 space-y-1">
          <Link 
            href="/" 
            onClick={() => setIsMenuOpen(false)}
            className="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800"
          >
            Home
          </Link>
          <Link 
            href="/products" 
            onClick={() => setIsMenuOpen(false)}
            className="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800"
          >
            Products
          </Link>
          <Link 
            href="/shops" 
            onClick={() => setIsMenuOpen(false)}
            className="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800"
          >
            Shops
          </Link>
          
          {/* Shop Owner Links - Mobile */}
          {isShopOwner && (
            <>
              <div className="border-t border-gray-200 my-2"></div>
              <h3 className="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Shop Owner</h3>
              <Link 
                href="/dashboard" 
                onClick={() => setIsMenuOpen(false)}
                className="flex items-center pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800"
              >
                <FaChartLine className="mr-3 text-gray-400" />
                Dashboard
              </Link>
              <Link 
                href="/products/manage" 
                onClick={() => setIsMenuOpen(false)}
                className="flex items-center pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800"
              >
                <FaBoxOpen className="mr-3 text-gray-400" />
                My Products
              </Link>
              <Link 
                href="/shops/manage" 
                onClick={() => setIsMenuOpen(false)}
                className="flex items-center pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800"
              >
                <FaStore className="mr-3 text-gray-400" />
                My Shop
              </Link>
            </>
          )}
        </div>
        <div className="pt-4 pb-3 border-t border-gray-200">
          {mounted ? (
            user ? (
              <div>
                <div className="flex items-center px-4">
                  <div className="flex-shrink-0">
                    <FaUser className="h-10 w-10 rounded-full text-gray-400" />
                  </div>
                  <div className="ml-3">
                    <div className="text-base font-medium text-gray-800">{user.name}</div>
                    <div className="text-sm font-medium text-gray-500">{user.email}</div>
                  </div>
                </div>
                <div className="mt-3 space-y-1">
                  <Link href="/profile" className="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                    Your Profile
                  </Link>
                  <Link href="/orders" className="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                    Orders
                  </Link>
                  <button onClick={handleLogout} className="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                    Sign out
                  </button>
                </div>
              </div>
            ) : (
              <div>
                <Link href="/login" className="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                  Login
                </Link>
                <Link href="/register" className="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                  Register
                </Link>
              </div>
            )
          ) : (
            <div className="flex items-center px-4">
              <div className="flex-shrink-0">
                <FaUser className="h-10 w-10 rounded-full text-gray-400" />
              </div>
              <div className="ml-3">
                <div className="text-base font-medium text-gray-800">Loading...</div>
              </div>
            </div>
          )}
        </div>
      </div>
    </nav>
  );
}