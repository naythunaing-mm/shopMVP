// Quick test for single product API
const axios = require('axios')

async function quickTest() {
  try {
    const response = await axios.get('http://localhost:8000/api/products/1')
    '✅ API Response Status:', response.status
    ;('📦 Product Data:')
    '- ID:', response.data.id
    '- Name:', response.data.name
    '- Price:', response.data.price
    '- Description:', response.data.description
    '- Pics:', response.data.pics
    '- Types:', response.data.types
    '- Colors:', response.data.colors
    '- Stock:', response.data.stock
    '- Discount:', response.data.discount
  } catch (error) {
    console.error('❌ Error:', error.message)
    if (error.response) {
      console.error('Status:', error.response.status)
      console.error('Data:', error.response.data)
    }
  }
}

quickTest()
