import React from "react";
import logo from "./logo.svg";
import "./App.css";
import { Routes, Route, Link,BrowserRouter } from "react-router-dom";
import Login from "./public/Login";
import Register from "./public/Register";
import Main from "./pages/Main";
import axios from "axios";
import Rankings from "./pages/Rankings";
import Stats from "./pages/Stats";

axios.defaults.baseURL = "http://localhost:8070/api/influencer";
axios.defaults.withCredentials =true

function App() {
  return (
    <div className="App">
      <BrowserRouter>
      <Routes>
        <Route path={"/"} element={<Main/>} />
        <Route path={"/login"} element={<Login/>} />
        <Route path={"/register"} element={<Register/>} />
        <Route path={"/rankings"} element={<Rankings/>} />
        <Route path={"/stats"} element={<Stats/>} />
      </Routes>
      </BrowserRouter>
    </div>
  );
}

export default App;
