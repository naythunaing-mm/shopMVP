// Test raw API response structure
const axios = require('axios')

async function testRawResponse() {
  try {
    const response = await axios.get('http://localhost:8000/api/products/1')
    ;('Raw Response:')
    JSON.stringify(response.data, null, 2)
  } catch (error) {
    console.error('Error:', error.message)
  }
}

testRawResponse()
