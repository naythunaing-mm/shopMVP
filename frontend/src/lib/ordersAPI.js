export const ordersAPI = {
  create: async (orderData) => {
    const res = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/orders`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        Authorization: `Bearer ${localStorage.getItem('token')}`, // if you're using JWT auth
      },
      body: JSON.stringify(orderData),
    })

    if (!res.ok) {
      const error = await res.json()
      throw new Error(error.message || 'Failed to create order')
    }

    return res.json()
  },
}
