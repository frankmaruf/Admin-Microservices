import React, { PropsWithRef } from "react";
import { connect, useSelector } from "react-redux";
import { Link } from "react-router-dom";
import axios from "axios";
import { RootState } from "../redux/store";
import { useDispatch } from "react-redux";
import setUser from "../redux/actions/setUserAction";
import { User } from "../classes/user";
import constants from "../constants";
const Nav = (props: PropsWithRef<any>) => {
  const dispatch = useDispatch()
   const user = useSelector((state: RootState) => state.user)
  const handleClick = async () => {
    await axios.post(`${constants.BASE_URL}/logout`, {}).then(res => {
      console.log(res);
      localStorage.clear();
      dispatch(setUser(new User()))
      // @ts-ignore
      // dispatch(setUser(null))
    })
}
  let menu;
  // check  user name length
  if (user.user.email.length > 2) {
    console.log("user", user.user);
    
    menu = (
      <>
        <Link className="nav-link" to="/profile">
          {user.user.name}
        </Link>
        <Link className="nav-link" to="/rankings">
          Rankings
        </Link>
        <Link className="nav-link" onClick={handleClick} to="/">
          Logout
        </Link>
      </>
    );
  } else {
    menu = (
      <>
        <Link to="/login" className="btn btn-outline-primary">
          Login
        </Link>
        <Link className="btn btn-outline-secondary" to="/register">
          Register
        </Link>
      </>
    );
  }
  return (
    <>
      <div className="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 border-bottom shadow-sm">
        <Link
          to="/"
          className="navbar-brand my-0 mr-md-auto font-weight-normal"
        >
          Influencer
        </Link>
        {menu}
      </div>
    </>
  );
};


// @ts-ignore
// export default connect(state => ({user: state.user}))(Nav);
export default Nav;