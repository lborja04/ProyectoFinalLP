import { useEffect, useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import logo from '../assets/logo.png';
import '../NavBar.css';

export default function NavUser() {
    const [userName, setUserName] = useState("Invitado"); // Estado para el nombre del usuario
    const navigate = useNavigate(); // Hook para redirigir

    useEffect(() => {
        // Obtener el usuario almacenado en localStorage
        const user = JSON.parse(localStorage.getItem("user") || "null");
        if (user && user.nombre) {
            setUserName(user.nombre); // Actualizar con el nombre del usuario
        }
    }, []);

    // Función para cerrar sesión correctamente
    const handleLogout = () => {
        localStorage.removeItem("user"); // Eliminar usuario del localStorage
        navigate("/login", { replace: true }); // Redirigir al login sin volver atrás
    };

    return (
        <div className="navBar">
            <img src={logo} alt="logo" />
            <h2 className="user">Bienvenido {userName}</h2>

            {/* 🔹 "Salir" lleva al usuario a App.tsx */}
            <Link to="/" className="exit-link">Salir</Link>

        </div>
    );
}
