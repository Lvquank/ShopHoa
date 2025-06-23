import { BrowserRouter } from "react-router-dom"
import AppRoutes from "./routes"
import "./App.css"
import ScrollToTop from "./components/ScrollToTop"

function App() {
  return (
    <BrowserRouter>
      <ScrollToTop />
      <div className="App">
        <AppRoutes />
      </div>
    </BrowserRouter>
  )
}

export default App
