import { useContext, useEffect, useState } from "react";
import { CartContext } from "../CartContext";
import "../Catalogo.css";

const defaultImage = new URL("../assets/catalogo/camisa1.png", import.meta.url)
  .href;

export default function Catalogo() {
  const { addToCart } = useContext(CartContext)!;
  const [products, setProducts] = useState([]); // Todos los productos
  const [filteredProducts, setFilteredProducts] = useState([]); // Productos filtrados
  const [categories, setCategories] = useState([]); // Categorías únicas
  const [selectedCategory, setSelectedCategory] = useState("Todos"); // Categoría seleccionada
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState("");
  const [selectedProduct, setSelectedProduct] = useState(null); // Modal
  const [confirmationMessage, setConfirmationMessage] = useState(""); // Mensaje de confirmación

  useEffect(() => {
    const fetchProducts = async () => {
      try {
        const response = await fetch(
          "http://localhost/Backend/api.php?path=producto"
        );
        const data = await response.json();

        if (Array.isArray(data)) {
          const formattedProducts = data.map((product) => ({
            id: product.id,
            name: product.nombre,
            category: product.categoria,
            price: parseFloat(product.precio),
            description: product.descripcion,
            image:
              product.imagen !== "0"
                ? `http://localhost/Backend/uploads/${product.imagen}`
                : defaultImage,
          }));
          setProducts(formattedProducts);
          setFilteredProducts(formattedProducts); // Inicialmente todos
          const uniqueCategories = [
            "Todos",
            ...new Set(formattedProducts.map((product) => product.category)),
          ];
          setCategories(uniqueCategories);
        } else {
          setError("Error al obtener productos");
        }
      } catch (err) {
        console.error("Error al obtener productos:", err);
        setError("No se pudo cargar los productos");
      } finally {
        setLoading(false);
      }
    };

    fetchProducts();
  }, []);

  const handleCategoryChange = (category) => {
    setSelectedCategory(category);
    if (category === "Todos") {
      setFilteredProducts(products);
    } else {
      setFilteredProducts(
        products.filter((product) => product.category === category)
      );
    }
  };

  const openModal = (product) => {
    setSelectedProduct(product);
  };

  const closeModal = () => {
    setSelectedProduct(null);
  };

  // Manejar "Añadir al carrito"
  const handleAddToCart = (product) => {
    addToCart(product); // Añadir al carrito
    setConfirmationMessage(`${product.name} ha sido añadido al carrito`); // Mostrar mensaje de confirmación
    setTimeout(() => setConfirmationMessage(""), 3000); // Ocultar mensaje después de 3 segundos
  };

  return (
    <div>
      <div className="catalogo-container">
        <h4>Productos</h4>

        {/* Filtro por categoría */}
        <div className="filter-container">
          <label htmlFor="category-select">Filtrar por categoría:</label>
          <select
            id="category-select"
            value={selectedCategory}
            onChange={(e) => handleCategoryChange(e.target.value)}
          >
            {categories.map((category, index) => (
              <option key={index} value={category}>
                {category}
              </option>
            ))}
          </select>
        </div>

        {loading && <p>Cargando productos...</p>}
        {error && <p style={{ color: "red" }}>{error}</p>}

        {!loading && !error && (
          <div className="options-container">
            {filteredProducts.map((product) => (
              <div key={product.id} className="option">
                <img
                  src={product.image}
                  alt={product.name}
                  onClick={() => openModal(product)}
                  style={{ cursor: "pointer" }}
                />
                <p>
                  {product.name} - ${product.price}
                </p>
                <button onClick={() => handleAddToCart(product)}>
                  Añadir al carrito
                </button>
              </div>
            ))}
          </div>
        )}
      </div>

      {/* Mensaje de confirmación */}
      {confirmationMessage && (
        <div className="confirmation-message">{confirmationMessage}</div>
      )}

      {/* Modal de producto */}
      {selectedProduct && (
        <div className="modal-overlay" onClick={closeModal}>
          <div className="modal-content" onClick={(e) => e.stopPropagation()}>
            <h2>{selectedProduct.name}</h2>
            <p>{selectedProduct.description}</p>
            <button onClick={closeModal}>Cerrar</button>
          </div>
        </div>
      )}
    </div>
  );
}
