import "../Configuration.css";
import SellsLineChart from "./SellsLineChart";
import Grid from "@mui/material/Grid2";
import { Link, useNavigate } from "react-router-dom"; // 🔹 Importamos useNavigate para redirigir

export default function Configuration() {
  const navigate = useNavigate(); // Hook para redirigir

  // Función para cerrar sesión
  const handleLogout = () => {
    localStorage.removeItem("user"); // 🔹 Eliminar usuario de localStorage
    navigate("/login"); // 🔹 Redirigir a la página de login
  };

  return (
    <div className="configuration">
      <div className="options">
        <h4 className="option">Ventas</h4>
        <h4 className="option">
          <Link
            to="/compras"
            style={{ textDecoration: "none", color: "inherit" }}
          >
            Carrito de compras
          </Link>
        </h4>
        <h4 className="option">Preferencias</h4>
        <h4 className="option">Seguridad</h4>
        <h4 className="option">Términos y condiciones</h4>
        <h4 className="option">Accesibilidad</h4>
        <h4 className="option">Editar perfil</h4>
        {/* 🔹 Agregamos el evento onClick para cerrar sesión */}
        <h4
          className="option"
          onClick={handleLogout}
          style={{ cursor: "pointer", color: "red" }}
        >
          Cerrar sesión
        </h4>
      </div>
      <div className="Graphic">
        <Grid>
          <SellsLineChart />
        </Grid>
      </div>
    </div>
  );
}
