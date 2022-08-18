import React, { Component, SyntheticEvent } from "react";
import {Navigate} from 'react-router-dom'
import "./Public.css";
import axios from "axios";
import constants from "../constants";
class Login extends Component{
  email = "";
  password = "";
  state = {
    redirect: false,
  };
  // "Content-Type": "application/x-www-form-urlencoded",
  submit = async (e: SyntheticEvent) => {
    e.preventDefault();
    const response = await axios.post(`${constants.USERS_URL}/login`, {
      email: this.email,
      password: this.password,
      scopes: "influencer",
    },
    );
    if (response.data.token) {
      axios.defaults.headers.Authorization = `Bearer ${localStorage.getItem(
        "token"
      )}`;
      localStorage.setItem("token", response.data.token);
      this.setState({ redirect: true });
    }
  };

  render() {
    if (this.state.redirect) {
      return <Navigate to="/" replace/>;
    }
    return (
      <>
      <form className="form-signin" onSubmit={this.submit}>
        <h1 className="h3 mb-3 font-weight-normal">Please sign in</h1>
        <label htmlFor="inputEmail" className="sr-only">
          Email address
        </label>
        <input
          type="email"
          id="inputEmail"
          className="form-control"
          placeholder="Email address"
          required
          onChange={(e) => (this.email = e.target.value)}
        />
        <label htmlFor="inputPassword" className="sr-only">
          Password
        </label>
        <input
          type="password"
          id="inputPassword"
          className="form-control"
          placeholder="Password"
          onChange={(e) => (this.password = e.target.value)}
          required
        />
        <button className="btn btn-lg btn-primary btn-block" type="submit">
          Sign in
        </button>
      </form>
        </>
    );
  }
}

export default Login;
