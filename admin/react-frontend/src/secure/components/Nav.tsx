import axios from 'axios';
import React, { Component } from 'react';
import { Redirect } from 'react-router';
import { Link } from 'react-router-dom';

class Nav extends Component {
  state = {
      redirect: false
  }

  handleClick = async () => {
      await axios.post('logout', {});

      this.setState({
          redirect: true
      })
  }

  render() {
      if (this.state.redirect) {
          return <Redirect to={'/login'}/>
      }

      return (
          <nav className="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
              <a className="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="#">Company name</a>

              <ul className="my-2 my-md-0 mr-md-3">

                  <a className="p-2 text-white" onClick={this.handleClick}>Sign out</a>
              </ul>
          </nav>
      )
  }
}

export default Nav;