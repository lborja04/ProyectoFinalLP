import { useState } from 'react'
import './App.css'
import NavBar from './components/NavBar'
import img1 from './assets/img1.png'
import img2 from './assets/img2.png'
import img3 from './assets/img3.png'

function App() {
  const [count, setCount] = useState(0)

  return (
    <div className='container'>
      <NavBar/>
      <div className="info-container">
        <h2>Bienvenido a Shopcloth</h2>
        <p>En ClothShop, nos especializamos en ofrecerte lo mejor de la moda actual con piezas diseñadas para resaltar tu estilo y personalidad. Nuestro objetivo es brindarte ropa de alta calidad, cómoda y a la vanguardia de las últimas tendencias.</p>
      </div>
      <div className='img-container'>
        <img src={img1} alt='img1' />
        <img src={img2} alt='img2' />
        <img src={img3} alt='img3' />
      </div>
    </div>

  )
}

export default App
