import { Link } from "react-router-dom";
import { useEffect, useState } from "react"; // Importar hooks
import logo from "../assets/logo.png";
import search_icon from "../assets/search-b.png";
import "../NavBar.css";

export default function NavBar() {
  const [userName, setUserName] = useState("Iniciar Sesión"); // Estado para el nombre de usuario

  useEffect(() => {
    // Obtener el usuario almacenado en localStorage
    const user = JSON.parse(localStorage.getItem("user") || "null");
    if (user && user.nombre) {
      setUserName(user.nombre); // Actualizar con el nombre del usuario
    }
  }, []);

  return (
    <div className="navBar">
      <img src={logo} alt="logo" />

      <ul>
        <li>
          <Link to="/">Inicio</Link>
        </li>
        <li>
          <Link to="/catalogo">Catálogo</Link>
        </li>
        <li>
          <Link to="/ventas">Ventas</Link>
        </li>
      </ul>

      <div className="search-box">
        <input type="text" placeholder="Search" />
        <img src={search_icon} alt="" />
      </div>

      {/* Si el usuario está autenticado, muestra su nombre. Si no, muestra "Iniciar Sesión" */}
      <Link to="/usuario" className="user-link">
        {userName}
      </Link>
    </div>
  );
}
