import HeroSection from '@/components/home/HeroSection'
import {
  FeaturedProductsSection,
  CategoriesSection,
  PosInfoSection,
} from '@/components/home/HomePageSections'

export default function Home() {
  return (
    <div className="min-h-screen">
      {/* Hero Section */}
      <HeroSection />

      {/* Featured Products Section */}
      <FeaturedProductsSection />

      {/* Categories Section */}
      <CategoriesSection />
      <PosInfoSection />
    </div>
  )
}
