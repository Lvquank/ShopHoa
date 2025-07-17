import { BrowserRouter } from "react-router-dom"
import AppRoutes from "./routes"
import "./App.css"
import ScrollToTop from "./components/ScrollToTop"
import { UserProvider } from './context/UserContext'

function App() {
  return (
    <UserProvider>
      <BrowserRouter>
        <ScrollToTop />
        <div className="App">
          <AppRoutes />
        </div>
      </BrowserRouter>
    </UserProvider>
  )
}

export default App
