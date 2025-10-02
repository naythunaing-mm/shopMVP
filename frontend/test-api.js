// Comprehensive API viewer to display all product details
const axios = require('axios')

async function testAPI() {
  try {
    '='.repeat(80)
    ;('LARAVEL API COMPLETE RESPONSE VIEWER')
    '='.repeat(80)

    const response = await axios.get('http://localhost:8000/api/products', {
      headers: {
        Accept: 'application/json',
        'Cache-Control': 'no-cache',
      },
    })

    ;('\n📊 API RESPONSE SUMMARY')
    '-'.repeat(40)
    ;`Status Code: ${response.status}`
    ;`Total Products in DB: ${response.data.total}`
    ;`Products Returned: ${response.data.products?.length || 0}`
    ;`Current Page: ${response.data.current_page}`
    ;`Per Page: ${response.data.per_page}`
    ;`Last Page: ${response.data.last_page}`

    if (response.data.products && response.data.products.length > 0) {
      ;('\n📦 ALL PRODUCT DETAILS')
      '='.repeat(80)

      response.data.products.forEach((product, index) => {
        ;`\n${index + 1}. PRODUCT ID: ${product.id}`
        '-'.repeat(50)
        ;`Name: ${product.name}`
        ;`Description: ${product.description || 'No description'}`
        ;`Price: $${product.price}`
        ;`Discount: ${product.discount}%`
        ;`Stock: ${product.stock}`
        ;`Types: ${product.types || 'Not specified'}`
        ;`Colors: ${product.colors || 'Not specified'}`
        ;`Video: ${product.video || 'No video'}`
        ;`Image URL: ${product.pics || 'No image'}`
        ;`Status: ${product.status || 'active'}`
        ;`Featured: ${product.is_featured ? 'Yes' : 'No'}`

        if (product.category) {
          ;`Category: ${product.category.name} (ID: ${product.category.id})`
        }

        if (product.shop) {
          ;`Shop: ${product.shop.name} (ID: ${product.shop.id})`
        }

        ;`Created: ${product.created_at}`
        ;`Updated: ${product.updated_at}`
      })

      ;('\n🔍 FILTERING RULES APPLIED')
      '-'.repeat(40)
      ;('✅ Only ACTIVE products shown')
      ;('✅ Only products with STOCK > 0 shown')
      ;('✅ Only FIRST image URL returned')

      ;('\n📋 COMPLETE JSON RESPONSE')
      '='.repeat(80)
      JSON.stringify(response.data, null, 2)
    }

    return response.data
  } catch (error) {
    console.error('\n❌ API ERROR')
    console.error('-'.repeat(20))
    console.error('Error Message:', error.message)
    if (error.response) {
      console.error('Response Status:', error.response.status)
      console.error('Response Data:', JSON.stringify(error.response.data, null, 2))
    }
    return null
  }
}

testAPI()
