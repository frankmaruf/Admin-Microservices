import React from 'react';
import './App.css';
import Dashboard from './secure/dashboard/Dashboard';
import {BrowserRouter as Router, Route} from 'react-router-dom'
import Users from './secure/users/Users';
import Login from './public/Login';
import Register from './public/Register';
import RedirectToDashboard from './secure/RedirectToDashboard';
import UserCreate from './secure/users/UserCreate';
import UserEdite from './secure/users/UserEdite';
import Roles from './secure/roles/Roles';
import RoleCreate from './secure/roles/RoleCreate';
import RoleEdit from './secure/roles/RoleEdit';
import Products from './secure/products/Products';
import ProductCreate from './secure/products/ProductCreate';
function App() {
  return (
    <React.Fragment>
      
      <div className="App">
      <Router>
      <Route path={"/"} component={RedirectToDashboard} exact/>
          <Route path={"/dashboard"} component={Dashboard} exact/>
          <Route path={"/login"} component={Login}/>
          <Route path={"/register"} component={Register}/>
          <Route path={"/users"} exact component={Users}/>
          <Route path={"/users/create"} component={UserCreate}/>
          <Route path={"/users/:id/edit"} component={UserEdite}/>
          <Route path={"/roles"} exact component={Roles}/>
          <Route path={"/roles/create"} exact component={RoleCreate}/>
          <Route path={"/roles/:id/edit"} exact component={RoleEdit}/>
          <Route path={"/products"} exact component={Products}/>
          <Route path={"/products/create"} component={ProductCreate}/>
      </Router>
</div>
    </React.Fragment>
  );
}

export default App;
