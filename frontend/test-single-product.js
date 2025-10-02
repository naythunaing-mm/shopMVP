// Test single product API endpoint
const axios = require('axios')

async function testSingleProduct() {
  try {
    '='.repeat(80)
    ;('TESTING SINGLE PRODUCT API ENDPOINT')
    '='.repeat(80)

    // Test product ID 1
    const response = await axios.get('http://localhost:8000/api/products/1', {
      headers: {
        Accept: 'application/json',
        'Cache-Control': 'no-cache',
      },
    })

    ;('\n📊 SINGLE PRODUCT API RESPONSE')
    '-'.repeat(40)
    ;`Status Code: ${response.status}`
    ;('\n📦 PRODUCT DETAILS')
    '='.repeat(50)

    const product = response.data
    ;`ID: ${product.id}`
    ;`Name: ${product.name}`
    ;`Description: ${product.description || 'No description'}`
    ;`Price: $${product.price}`
    ;`Discount: ${product.discount}%`
    ;`Stock: ${product.stock}`
    ;`Types: ${product.types || 'Not specified'}`
    ;`Colors: ${product.colors || 'Not specified'}`
    ;`Video: ${product.video || 'No video'}`
    ;`Image (pics): ${product.pics || 'No image'}`
    ;`Status: ${product.status || 'active'}`

    if (product.category) {
      ;`Category: ${product.category.name} (ID: ${product.category.id})`
    }

    if (product.shop) {
      ;`Shop: ${product.shop.name} (ID: ${product.shop.id})`
    }

    ;`Created: ${product.created_at}`
    ;`Updated: ${product.updated_at}`

    ;('\n📋 COMPLETE JSON RESPONSE')
    '='.repeat(80)
    JSON.stringify(response.data, null, 2)

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

testSingleProduct()
