'use client'

import Link from 'next/link'
import {
  FaFacebookF,
  FaTwitter,
  FaInstagram,
  FaLinkedinIn,
  FaEnvelope,
  FaPhone,
  FaMapMarkerAlt,
  FaStar,
} from 'react-icons/fa'

const Footer = () => {
  const currentYear = new Date().getFullYear()

  // Centralized Shop Owner Data
  const shopOwner = {
    id: 'shop123',
    name: 'Angela',
    email: 'owner@shopmvp.com',
    phone: '+1 (555) 123-4567',
    address: '123 Shop Street, City, State 12345',
    avatar: '/img/shop-owner.jpg',
    rating: 4.8,
    shopName: 'Premium Shop',
  }

  // Define Navigation Links
  const navLinks = [
    { name: 'Home', href: '/' },
    { name: 'Products', href: '/products' },
    { name: 'Shops', href: '/shops' },
    { name: 'About Us', href: '/about' },
    { name: 'Privacy Policy', href: '/privacy' },
    { name: 'Terms of Service', href: '/terms' },
  ]

  // Define Social Media Links
  const socialLinks = [
    {
      icon: FaFacebookF,
      link: 'https://facebook.com',
      color: 'hover:text-blue-600',
    },
    {
      icon: FaInstagram,
      link: 'https://instagram.com',
      color: 'hover:text-pink-600',
    },
    {
      icon: FaTwitter,
      link: 'https://twitter.com',
      color: 'hover:text-blue-400',
    },
    {
      icon: FaLinkedinIn,
      link: 'https://linkedin.com',
      color: 'hover:text-blue-700',
    },
  ]

  return (
    // Redesign: Switched to a light background (White/Gray-100) for a cleaner, classic look
    <footer className="bg-gray-50 text-gray-700 border-t border-gray-200">
      <div className="container mx-auto px-6 py-16">
        {/* Top Section: Shop Info & CTA */}
        <div className="flex flex-col lg:flex-row justify-between items-center pb-12 border-b border-gray-200 mb-12">
          <div className="text-center lg:text-left mb-6 lg:mb-0">
            <h2 className="text-3xl font-extrabold text-gray-900 mb-2 tracking-tight">
              {shopOwner.shopName}
            </h2>
            <p className="text-gray-600 max-w-md mx-auto lg:mx-0">
              Your one-stop shop for all your needs. Quality products, fast delivery, and excellent
              customer service.
            </p>
          </div>
          {/* Call to Action */}
          <Link
            href="/products"
            className="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-full shadow-lg transition duration-300 ease-in-out transform hover:scale-105"
          >
            Shop Our Collection
          </Link>
        </div>

        {/* Main Grid: Links, Contact, Owner */}
        <div className="grid grid-cols-2 md:grid-cols-4 gap-10">
          {/* Quick Links Column 1 */}
          <div>
            <h3 className="text-lg font-semibold mb-4 text-gray-900 uppercase tracking-wider">
              Explore
            </h3>
            <ul className="space-y-3">
              {navLinks.slice(0, 3).map((link) => (
                <li key={link.name}>
                  <Link href={link.href} className="hover:text-blue-600 text-sm transition">
                    {link.name}
                  </Link>
                </li>
              ))}
            </ul>
          </div>

          {/* Quick Links Column 2 */}
          <div>
            <h3 className="text-lg font-semibold mb-4 text-gray-900 uppercase tracking-wider">
              Legal
            </h3>
            <ul className="space-y-3">
              {navLinks.slice(3).map((link) => (
                <li key={link.name}>
                  <Link href={link.href} className="hover:text-blue-600 text-sm transition">
                    {link.name}
                  </Link>
                </li>
              ))}
            </ul>
          </div>

          {/* Contact Info */}
          <div className="col-span-2 md:col-span-1">
            <h3 className="text-lg font-semibold mb-4 text-gray-900 uppercase tracking-wider">
              Get In Touch
            </h3>
            <div className="space-y-3 text-sm">
              <div className="flex items-start">
                <FaMapMarkerAlt className="mr-3 mt-1 text-blue-600 flex-shrink-0" />
                <span className="hover:text-gray-900 cursor-pointer">{shopOwner.address}</span>
              </div>
              <div className="flex items-center">
                <FaPhone className="mr-3 text-blue-600" />
                <a
                  href={`tel:${shopOwner.phone.replace(/[^\d+]/g, '')}`}
                  className="hover:text-gray-900 transition"
                >
                  {shopOwner.phone}
                </a>
              </div>
              <div className="flex items-center">
                <FaEnvelope className="mr-3 text-blue-600" />
                <a href={`mailto:${shopOwner.email}`} className="hover:text-gray-900 transition">
                  {shopOwner.email}
                </a>
              </div>
            </div>
          </div>

          {/* Shop Owner / Social Media (Combined) */}
          <div className="col-span-2 md:col-span-1">
            <h3 className="text-lg font-semibold mb-4 text-gray-900 uppercase tracking-wider">
              Meet the Owner
            </h3>
            <div className="flex items-center space-x-4 mb-4">
              {/* Owner Avatar */}
              <div className="w-16 h-16 rounded-full overflow-hidden border-2 border-blue-500 flex-shrink-0">
                {shopOwner.avatar ? (
                  <img
                    src={shopOwner.avatar}
                    alt={shopOwner.name}
                    className="object-cover w-full h-full"
                  />
                ) : (
                  <span className="text-2xl font-bold text-white flex items-center justify-center w-full h-full bg-blue-500">
                    {shopOwner.name
                      .split(' ')
                      .map((n) => n[0])
                      .join('')
                      .toUpperCase()
                      .slice(0, 2)}
                  </span>
                )}
              </div>
              {/* Owner Details */}
              <div>
                <h4 className="font-bold text-gray-900">{shopOwner.name}</h4>
                <p className="text-gray-600 text-sm">Owner, {shopOwner.shopName}</p>
                <div className="flex items-center text-yellow-500 text-sm">
                  <FaStar className="mr-1 w-3 h-3" />
                  <span>{shopOwner.rating} Rating</span>
                </div>
              </div>
            </div>

            {/* Social Icons */}
            <div className="flex space-x-4 mt-6">
              {socialLinks.map((social) => (
                <a
                  key={social.link}
                  href={social.link}
                  target="_blank"
                  rel="noopener noreferrer"
                  className={`p-2 rounded-full border border-gray-300 transition duration-300 ease-in-out text-gray-600 hover:border-blue-500 ${social.color}`}
                  aria-label={`Follow us on ${social.link.split('.')[1]}`}
                >
                  <social.icon className="w-5 h-5" />
                </a>
              ))}
            </div>
          </div>
        </div>

        {/* Copyright */}
        <div className="border-t border-gray-200 mt-12 pt-6 text-center text-gray-500 text-xs">
          <p>
            &copy; {currentYear} **ShopMVP**. All rights reserved. Built with ❤️ for e-commerce
            excellence.
          </p>
        </div>
      </div>
    </footer>
  )
}

export default Footer
