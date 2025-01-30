import Paper from "@mui/material/Paper";
import { LineChart } from "@mui/x-charts/LineChart";
import { useEffect, useState } from "react";

export default function SellsLineChart() {
  const [sells, setSells] = useState<number[]>([]); // Ventas mensuales
  const [loading, setLoading] = useState<boolean>(true);
  const [error, setError] = useState<string>("");
  const xLabels = [
    "Enero",
    "Febrero",
    "Marzo",
    "Abril",
    "Mayo",
    "Junio",
    "Julio",
    "Agosto",
    "Septiembre",
    "Octubre",
    "Noviembre",
    "Diciembre",
  ];

  useEffect(() => {
    const fetchSells = async () => {
      try {
        const user = JSON.parse(localStorage.getItem("user") || "{}");
        const vendedorId = user.id;

        if (!vendedorId) {
          setError("No se pudo identificar al usuario actual.");
          setLoading(false);
          return;
        }

        const response = await fetch(
          `http://localhost/Backend/api.php?path=ventas&vendedor_id=${vendedorId}`
        );
        console.log("Respuesta cruda de la API:", response);

        if (!response.ok) {
          throw new Error("Error al obtener los datos de ventas.");
        }

        const data = await response.json();
        console.log("Datos crudos obtenidos de la API:", data);

        // Convertir los datos en un array de ventas por mes
        const processedSells = Array.from(
          { length: 12 },
          (_, i) => data[i + 1] || 0
        );
        console.log("Datos procesados para el gráfico:", processedSells);

        setSells(processedSells);
      } catch (err: any) {
        console.error("Error al obtener datos de ventas:", err.message);
        setError("No se pudieron cargar los datos de ventas.");
      } finally {
        setLoading(false);
      }
    };

    fetchSells();
  }, []);

  return (
    <Paper
      sx={{
        p: 2,
        display: "flex",
        flexDirection: "column",
        alignItems: "center",
        justifyContent: "center",
        backgroundColor: "#f9f9f9",
        border: "1px solid #ddd",
        borderRadius: "10px",
        boxShadow: "0px 4px 6px rgba(0, 0, 0, 0.1)",
        maxWidth: "800px",
        margin: "20px auto",
      }}
    >
      <h2
        style={{
          fontSize: "24px",
          fontWeight: "bold",
          color: "#3c1786",
          marginBottom: "20px",
        }}
      >
        Ventas Mensuales
      </h2>

      {loading && <p>Cargando datos...</p>}
      {error && <p style={{ color: "red" }}>{error}</p>}

      {!loading && !error && (
        <LineChart
          width={600}
          height={450}
          series={[
            {
              data: sells.map((value) => (value > 10 ? 10 : value)), // Limitar a 10 ventas
              label: "Ventas mensuales",
            },
          ]}
          xAxis={[{ scaleType: "point", data: xLabels }]}
          yAxis={[
            {
              min: 0,
              max: 10, // Limitar el eje Y a 10
              ticks: [0, 2, 4, 6, 8, 10],
            },
          ]}
        />
      )}
    </Paper>
  );
}
