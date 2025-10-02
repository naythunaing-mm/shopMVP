'use client';

import { useState, useEffect } from 'react';
import Image from 'next/image';
import { FaPaperPlane, FaUser, FaEnvelope, FaStore, FaTag, FaComment, FaPhone } from 'react-icons/fa';

export default function Contact({ shopId = null, shopOwnerName = null, shopName = null, productId = null, productName = null }) {
  const [formData, setFormData] = useState({
    name: '',
    email: '',
    subject: '',
    message: '',
    shopId: shopId || '',
    productId: productId || '',
    inquiryType: 'general'
  });

  const [shopInfo, setShopInfo] = useState({
    ownerName: shopOwnerName || '',
    shopName: shopName || ''
  });

  useEffect(() => {
    if (shopId) {
      setFormData(prev => ({ 
        ...prev, 
        shopId,
        productId: productId || '',
        inquiryType: productId ? 'product' : 'general'
      }));
      setShopInfo({
        ownerName: shopOwnerName || '',
        shopName: shopName || ''
      });
    }
  }, [shopId, shopOwnerName, shopName, productId]);

  const handleChange = (e) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value
    });
  };

  const handleSubmit = (e) => {
    e.preventDefault();
     ('Form submitted:', formData);
    
    if (shopId) {
      alert(`Thank you for your message! Your inquiry has been sent to ${shopInfo.shopName || 'the shop owner'}. They will get back to you soon.`);
    } else {
      alert('Thank you for your message! We will get back to you soon.');
    }
    
    setFormData({ 
      name: '', 
      email: '', 
      subject: '', 
      message: '',
      shopId: shopId || '',
      productId: productId || '',
      inquiryType: productId ? 'product' : 'general'
    });
  };

  return (
    <div className="min-h-screen bg-white">
      {/* Hero Section with Background Image */}
      <div className="relative h-64 md:h-96 bg-gray-900">
        <div className="absolute inset-0">
          <Image
            src="/images/contact-hero.jpg"
            alt="Contact Us"
            fill
            className="object-cover opacity-60"
            priority
          />
          <div className="absolute inset-0 bg-gradient-to-r from-purple-900 to-blue-800 mix-blend-multiply"></div>
        </div>
        <div className="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center">
          <div className="text-center w-full">
            <h1 className="text-4xl md:text-5xl font-bold   mb-4">
              Have Questions?
            </h1>
            <p className="text-xl text-gray-200">
              We're here to help and answer any questions you might have.
            </p>
          </div>
        </div>
      </div>

      {/* Main Content */}
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16 -mt-12 md:-mt-20 relative z-10">
        <div className="bg-white rounded-xl shadow-xl overflow-hidden">
          <div className="grid grid-cols-1 lg:grid-cols-2">
            {/* Contact Form */}
            <div className="p-8 md:p-12">
              <h2 className="text-2xl font-bold text-gray-900 mb-6">
                {shopId ? `Message ${shopInfo.shopName || 'Shop Owner'}` : 'Send Us a Message'}
              </h2>
              <form onSubmit={handleSubmit} className="space-y-6">
                {/* Hidden fields */}
                {shopId && (
                <input
                  type="hidden"
                  name="shopId"
                  value={formData.shopId}
                />
              )}
              {productId && (
                <input
                  type="hidden"
                  name="productId"
                  value={formData.productId}
                />
              )}
              <input
                type="hidden"
                name="inquiryType"
                value={formData.inquiryType}
              />
              
              {/* Shop Info Display */}
              {shopId && (
                <div className="bg-purple-50 border border-purple-200 rounded-lg p-4 mb-6">
                  <div className="flex items-center space-x-3">
                    <div className="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center">
                      <svg className="w-5 h-5  " fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                      </svg>
                    </div>
                    <div>
                      <p className="font-semibold text-gray-900">
                        {shopInfo.shopName || 'Shop Owner'}
                      </p>
                      {shopInfo.ownerName && (
                        <p className="text-sm text-gray-600">Owner: {shopInfo.ownerName}</p>
                      )}
                      <p className="text-xs text-purple-600 font-medium">Shop ID: {shopId}</p>
                      {productId && productName && (
                        <p className="text-xs text-green-600">Product: {productName}</p>
                      )}
                      {!shopInfo.shopName && !shopInfo.ownerName && (
                        <p className="text-xs text-gray-500">Contacting shop owner directly</p>
                      )}
                    </div>
                  </div>
                </div>
              )}

              {/* Shop ID Input Field */}
              {!shopId && (
                <div>
                  <label htmlFor="shopId" className="block text-sm font-medium text-gray-700 mb-2">
                    Shop ID (Optional)
                  </label>
                  <input
                    type="text"
                    name="shopId"
                    id="shopId"
                    value={formData.shopId}
                    onChange={handleChange}
                    className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                    placeholder="Enter shop ID to contact specific shop owner"
                  />
                  <p className="text-xs text-gray-500 mt-1">
                    Leave blank for general inquiry or enter a shop ID to contact a specific shop owner
                  </p>
                </div>
              )}

              <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div className="relative">
                  <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <FaUser className="h-5 w-5 text-gray-400" />
                  </div>
                  <input
                    type="text"
                    name="name"
                    id="name"
                    required
                    value={formData.name}
                    onChange={handleChange}
                    className="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                    placeholder="Your Name"
                  />
                </div>

                <div className="relative">
                  <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <FaEnvelope className="h-5 w-5 text-gray-400" />
                  </div>
                  <input
                    type="email"
                    name="email"
                    id="email"
                    required
                    value={formData.email}
                    onChange={handleChange}
                    className="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                    placeholder="Email Address"
                  />
                </div>
              </div>

              <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div className="relative">
                  <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <FaStore className="h-5 w-5 text-gray-400" />
                  </div>
                  <input
                    type="text"
                    name="shopId"
                    id="shopId"
                    value={formData.shopId}
                    onChange={handleChange}
                    className="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                    placeholder="Shop ID (Optional)"
                  />
                </div>

                <div className="relative">
                  <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <FaTag className="h-5 w-5 text-gray-400" />
                  </div>
                  <input
                    type="text"
                    name="subject"
                    id="subject"
                    required
                    value={formData.subject}
                    onChange={handleChange}
                    className="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                    placeholder="Subject"
                  />
                </div>
              </div>

              <div className="relative">
                <div className="absolute top-3 left-3">
                  <FaComment className="h-5 w-5 text-gray-400" />
                </div>
                <textarea
                  name="message"
                  id="message"
                  rows={6}
                  required
                  value={formData.message}
                  onChange={handleChange}
                  className="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                  placeholder="Your message..."
                />
              </div>

              <div className="pt-2">
                <button
                  type="submit"
                  className="w-full flex items-center justify-center space-x-2 py-3 px-6 border border-transparent rounded-lg shadow-sm text-base font-medium  text-gray-800 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-200"
                >
                  <FaPaperPlane className="h-5 w-5" />
                  <span>Send Message</span>
                </button>
              </div>

              {/* Inquiry Type Selection */}
              {(shopId || formData.shopId) && (
                <div>
                  <label htmlFor="inquiryType" className="block text-sm font-medium text-gray-700 mb-2">
                    Inquiry Type
                  </label>
                  <select
                    name="inquiryType"
                    id="inquiryType"
                    value={formData.inquiryType}
                    onChange={handleChange}
                    className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                  >
                    <option value="general">General Inquiry</option>
                    <option value="product">Product Question</option>
                    <option value="pricing">Pricing & Availability</option>
                    <option value="order">Order Support</option>
                  </select>
                </div>
              )}
            </form>
          </div>

          {/* Contact Info Sidebar */}
          <div className="bg-gradient-to-br from-purple-50 to-blue-50 p-8 md:p-12">
            <div className="space-y-8 h-full flex flex-col justify-center">
              <div>
                <h3 className="text-2xl font-bold text-gray-900 mb-6">Contact Information</h3>
                <p className="text-gray-600 mb-8">
                  Fill out the form and our team will get back to you within 24 hours. 
                  For urgent inquiries, please call us directly.
                </p>
              </div>
              
              <div className="space-y-6">
                <div className="flex items-start">
                  <div className="flex-shrink-0 h-12 w-12 rounded-full bg-purple-100 flex items-center justify-center">
                    <FaEnvelope className="h-5 w-5 text-purple-600" />
                  </div>
                  <div className="ml-4">
                    <h4 className="text-sm font-medium text-gray-500">Email</h4>
                    <p className="text-base text-gray-900">support@shopmvp.com</p>
                  </div>
                </div>
                
                <div className="flex items-start">
                  <div className="flex-shrink-0 h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center">
                    <FaPhone className="h-5 w-5 text-blue-600" />
                  </div>
                  <div className="ml-4">
                    <h4 className="text-sm font-medium text-gray-500">Phone</h4>
                    <p className="text-base text-gray-900">+1 (555) 123-4567</p>
                  </div>
                </div>
                
                <div className="flex items-start">
                  <div className="flex-shrink-0 h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center">
                    <FaStore className="h-5 w-5 text-indigo-600" />
                  </div>
                  <div className="ml-4">
                    <h4 className="text-sm font-medium text-gray-500">Office</h4>
                    <p className="text-base text-gray-900">123 Shop Street, City</p>
                    <p className="text-base text-gray-900">State, 12345</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
