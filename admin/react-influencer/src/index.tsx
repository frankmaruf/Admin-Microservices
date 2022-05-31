import React from 'react';
import ReactDOM from 'react-dom/client';
import './index.css';
import App from './App';
import reportWebVitals from './reportWebVitals';
import axios from "axios"
import { Provider } from 'react-redux';
import store from './redux/store';
// import configureStore from './redux/configureStore';
// import store from './redux/store';

axios.defaults.baseURL = "http://localhost:8070/api/influencer";
axios.defaults.withCredentials =true

const root = ReactDOM.createRoot(
  document.getElementById('root') as HTMLElement
);

root.render(
    <Provider store={store}>
    <App />
    </Provider>
);

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
reportWebVitals();
