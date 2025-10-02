import { create } from 'zustand';
import { persist } from 'zustand/middleware';

// Create the cart store with Zustand
const useCartStore = create(
  persist(
    (set, get) => ({
      items: [],
      
      // Add item to cart
      addItem: (product, quantity = 1) => {
        const { items } = get();
        const existingItem = items.find(item => item.id === product.id);
        
        if (existingItem) {
          // If item already exists, update quantity
          const updatedItems = items.map(item => 
            item.id === product.id 
              ? { ...item, quantity: item.quantity + quantity } 
              : item
          );
          set({ items: updatedItems });
        } else {
          // If item doesn't exist, add new item
          set({ items: [...items, { ...product, quantity }] });
        }
      },
      
      // Remove item from cart
      removeItem: (productId) => {
        const { items } = get();
        set({ items: items.filter(item => item.id !== productId) });
      },
      
      // Update item quantity
      updateQuantity: (productId, quantity) => {
        const { items } = get();
        
        if (quantity <= 0) {
          // If quantity is 0 or negative, remove the item
          set({ items: items.filter(item => item.id !== productId) });
        } else {
          // Otherwise update the quantity
          const updatedItems = items.map(item => 
            item.id === productId ? { ...item, quantity } : item
          );
          set({ items: updatedItems });
        }
      },
      
      // Clear cart
      clearCart: () => {
        set({ items: [] });
      },
      
      // Get cart total
      getTotal: () => {
        const { items } = get();
        return items.reduce((total, item) => {
          // Calculate price with discount if available
          const price = item.discount 
            ? item.price - (item.price * item.discount / 100) 
            : item.price;
          return total + (price * item.quantity);
        }, 0);
      },
      
      // Get cart item count
      getItemCount: () => {
        const { items } = get();
        return items.reduce((count, item) => count + item.quantity, 0);
      },
    }),
    {
      name: 'cart-storage', // name of the item in the storage
      getStorage: () => localStorage, // (optional) by default, 'localStorage' is used
    }
  )
);

// Custom hook to use the cart store
export const useCart = () => {
  const { 
    items, 
    addItem, 
    removeItem, 
    updateQuantity, 
    clearCart, 
    getTotal, 
    getItemCount 
  } = useCartStore();
  
  return {
    items,
    addItem,
    removeItem,
    updateQuantity,
    clearCart,
    total: getTotal(),
    itemCount: getItemCount(),
  };
};