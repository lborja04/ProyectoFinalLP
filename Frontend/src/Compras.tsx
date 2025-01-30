import { useContext } from "react";
import { CartContext } from "./CartContext";
import NavUser from "./components/NavUser";
import "./Compras.css";

function Compras() {
  const { cart, removeFromCart, clearCart } = useContext(CartContext)!; // 🔹 Se agrega clearCart

  // Calcular el total del carrito
  const total = cart.reduce((acc, product) => acc + product.price, 0);

  // Función para manejar la transacción
  const handlePayment = async () => {
    clearCart(); // 🔹 Vaciar el carrito inmediatamente después de hacer clic en "Pagar"

    try {
      const user = JSON.parse(localStorage.getItem("user")); // Obtener usuario autenticado
      if (!user || !user.id) {
        alert("Error: No se encontró el usuario.");
        return;
      }

      const response = await fetch(
        "http://localhost/Backend/api.php?path=transaccion",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            productos: cart, // Lista de productos con sus ID
            comprador_id: user.id, // ID del usuario autenticado (comprador)
          }),
        }
      );

      const data = await response.json();
      if (data.success) {
        alert(data.message);
      } else {
        alert(data.message);
      }
    } catch (error) {
      console.error("Error al realizar la transacción:", error);
      alert("Ocurrió un error al realizar el pago.");
    }
  };

  return (
    <div className="container">
      <NavUser />
      <h2>🛒 Carrito de Compras</h2>
      {cart.length === 0 ? (
        <p>No has añadido nada al carrito aún.</p>
      ) : (
        <div className="compras-container">
          {cart.map((product) => (
            <div key={product.id} className="compras-item">
              <img src={product.image} alt={product.name} width="50" />
              <p>
                {product.name} - ${product.price}
              </p>
              <button
                className="remove-btn"
                onClick={() => removeFromCart(product.id)}
              >
                ❌
              </button>
            </div>
          ))}
        </div>
      )}
      {cart.length > 0 && (
        <div className="cart-summary">
          <p>Total: ${total.toFixed(2)}</p>
          <button className="pay-btn" onClick={handlePayment}>
            Pagar
          </button>
        </div>
      )}
    </div>
  );
}

export default Compras;
