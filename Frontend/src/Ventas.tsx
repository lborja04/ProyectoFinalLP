import { useState } from "react";
import { useNavigate } from "react-router-dom";
import "./Ventas.css";

export default function Ventas() {
  const [nombre, setNombre] = useState("");
  const [categoria, setCategoria] = useState("");
  const [descripcion, setDescripcion] = useState("");
  const [precio, setPrecio] = useState<number | string>("");
  const [imagen, setImagen] = useState<File | null>(null);
  const [imagenPreview, setImagenPreview] = useState<string | null>(null);
  const [message, setMessage] = useState("");
  const navigate = useNavigate();

  const handleImageUpload = (e: React.ChangeEvent<HTMLInputElement>) => {
    if (e.target.files && e.target.files[0]) {
      const file = e.target.files[0];
      if (
        file.type === "image/png" ||
        file.type === "image/jpeg" ||
        file.type === "image/jpg"
      ) {
        setImagen(file);
        setImagenPreview(URL.createObjectURL(file));
        setMessage("");
      } else {
        setMessage("Solo se permiten archivos .png, .jpg o .jpeg");
      }
    }
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();

    const user = JSON.parse(localStorage.getItem("user") || "{}");
    const vendedorId = user.id;

    if (!imagen) {
      setMessage("Por favor, selecciona una imagen.");
      return;
    }

    const formData = new FormData();
    formData.append("nombre", nombre);
    formData.append("categoria", categoria);
    formData.append("descripcion", descripcion);
    formData.append("precio", precio.toString());
    formData.append("imagen", imagen);
    formData.append("vendedor_id", vendedorId.toString());

    try {
      const response = await fetch(
        "http://localhost/Backend/api.php?path=producto",
        {
          method: "POST",
          body: formData,
        }
      );

      const data = await response.json();
      if (data.success) {
        setMessage("Producto registrado exitosamente.");
        setNombre("");
        setCategoria("");
        setDescripcion("");
        setPrecio("");
        setImagen(null);
        setImagenPreview(null);

        // Mostrar la URL de la imagen
        console.log(
          "URL de la imagen:",
          `http://localhost/Backend/${data.imagen}`
        );
      } else {
        setMessage(
          data.message || "Ocurrió un error al registrar el producto."
        );
      }
    } catch (error) {
      console.error("Error al enviar los datos:", error);
      setMessage("Error al conectar con el servidor.");
    }
  };

  return (
    <div className="ventas-page">
      <div className="ventas-container">
        <button className="back-button" onClick={() => navigate("/")}>
          Regresar al inicio
        </button>
        <h2>Registrar una Prenda</h2>
        <form onSubmit={handleSubmit}>
          <input
            type="text"
            placeholder="Nombre de la prenda"
            value={nombre}
            onChange={(e) => setNombre(e.target.value)}
            required
          />
          <input
            type="text"
            placeholder="Categoría (ej. Camiseta, Pantalón)"
            value={categoria}
            onChange={(e) => setCategoria(e.target.value)}
            required
          />
          <textarea
            placeholder="Descripción"
            value={descripcion}
            onChange={(e) => setDescripcion(e.target.value)}
            required
          ></textarea>
          <input
            type="text"
            placeholder="Precio (en dólares)"
            value={precio}
            onChange={(e) => {
              const value = e.target.value;
              if (/^\d*\.?\d*$/.test(value)) {
                setPrecio(value);
              }
            }}
            required
          />
          <input
            type="file"
            accept=".png, .jpg, .jpeg"
            onChange={handleImageUpload}
            required
          />
          {imagenPreview && (
            <div className="image-preview">
              <img src={imagenPreview} alt="Vista previa" />
            </div>
          )}
          <button type="submit">Registrar Prenda</button>
        </form>
        {message && <p>{message}</p>}
      </div>
    </div>
  );
}
