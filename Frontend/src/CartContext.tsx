import { createContext, useState, ReactNode } from "react";

// Tipo de producto
interface Product {
  id: number;
  name: string;
  price: number;
  image: string;
}

// Tipo de contexto del carrito
interface CartContextType {
  cart: Product[];
  addToCart: (product: Product) => void;
  removeFromCart: (id: number) => void;
  clearCart: () => void; // 🔹 Nueva función para vaciar el carrito completamente
}

// Crear el contexto del carrito
export const CartContext = createContext<CartContextType | undefined>(
  undefined
);

export function CartProvider({ children }: { children: ReactNode }) {
  const [cart, setCart] = useState<Product[]>([]);

  // Función para agregar un producto al carrito
  const addToCart = (product: Product) => {
    setCart([...cart, product]);
  };

  // Función para eliminar un producto del carrito
  const removeFromCart = (id: number) => {
    setCart(cart.filter((product) => product.id !== id));
  };

  // 🔹 Función para vaciar completamente el carrito
  const clearCart = () => {
    setCart([]); // 🔹 Ahora vacía completamente el carrito después del pago
  };

  return (
    <CartContext.Provider
      value={{ cart, addToCart, removeFromCart, clearCart }}
    >
      {children}
    </CartContext.Provider>
  );
}
