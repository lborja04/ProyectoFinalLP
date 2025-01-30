import { StrictMode } from "react";
import { createRoot } from "react-dom/client";
import {
  BrowserRouter as Router,
  Routes,
  Route,
  Navigate,
} from "react-router-dom";
import "./index.css";
import App from "./App.tsx";
import Login from "./Login.tsx";
import App2 from "./App2.tsx";
import App3 from "./App3.tsx";
import Compras from "./Compras.tsx";
import Ventas from "./Ventas.tsx";

import { CartProvider } from "./CartContext.tsx";

createRoot(document.getElementById("root")!).render(
  <StrictMode>
    <CartProvider>
      <Router>
        <Routes>
          {/* Si hay un usuario en localStorage, ir a App. Si no, ir a Login */}
          <Route path="/" element={<ProtectedRoute />} />
          <Route path="/login" element={<Login />} />
          <Route path="/catalogo" element={<App2 />} />
          <Route path="/usuario" element={<App3 />} />
          <Route path="/compras" element={<Compras />} />
          <Route path="/ventas" element={<Ventas />} />
        </Routes>
      </Router>
    </CartProvider>
  </StrictMode>
);

// Componente para proteger rutas
function ProtectedRoute() {
  const user = JSON.parse(localStorage.getItem("user") || "null");

  return user ? <App /> : <Navigate to="/login" replace />;
}
