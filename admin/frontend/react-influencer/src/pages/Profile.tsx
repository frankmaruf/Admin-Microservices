import React, {
  Component,
  Dispatch,
  SyntheticEvent,
  useEffect,
  useState,
} from "react";
import axios from "axios";
import { User } from "../classes/user";
import { connect } from "react-redux";
import constants from "../constants";
import { useDispatch } from "react-redux";
import Wrapper from "./Wrapper";
import setUser from "../redux/actions/setUserAction";
import { useSelector } from "react-redux";
import { RootState } from "../redux/store";
const Profile = () => {
  const storeUser = useSelector((state: RootState) => state.user);
  const [user] = useState({
    first_name: storeUser.user.first_name,
    last_name: storeUser.user.last_name,
    email: storeUser.user.email,
    id: storeUser.user.id,
    revenue: storeUser.user.revenue,
  });
  const [pass] = useState({
    password: "",
    password_confirm: "",
  });

  const updateInfo = async (e: SyntheticEvent) => {
    e.preventDefault();
    await axios.put(
      `${constants.USERS_URL}/user/info`,
      {
        first_name: user.first_name,
        last_name: user.last_name,
        email: user.email,
      },
      { withCredentials: true }
    );
  };
  const updatePassword = async (e: SyntheticEvent) => {
    e.preventDefault();
    await axios.put(`${constants.USERS_URL}user/password`, {
      password: pass.password,
      password_confirm: pass.password_confirm,
    });
  };

  return (
    <Wrapper>
      <h2>Account Information</h2>
      <hr />
      <form onSubmit={updateInfo}>
        <div className="form-group">
          <label>First Name</label>
          <input
            type="text"
            className="form-control"
            name="first_name"
            defaultValue={user.first_name}
            onChange={(e) => (user.first_name = e.target.value)}
          />
        </div>
        <div className="form-group">
          <label>Last Name</label>
          <input
            type="text"
            className="form-control"
            name="last_name"
            defaultValue={user.last_name}
            onChange={(e) => (user.last_name = e.target.value)}
          />
        </div>
        <div className="form-group">
          <label>Email</label>
          <input
            type="text"
            className="form-control"
            name="email"
            defaultValue={user.email}
            onChange={(e) => (user.email = e.target.value)}
          />
        </div>

        <button className="btn btn-outline-secondary">Save</button>
      </form>

      <h2 className="mt-4">Change Password</h2>
      <hr />
      <form onSubmit={updatePassword}>
        <div className="form-group">
          <label>Password</label>
          <input
            type="password"
            className="form-control"
            name="password"
            onChange={(e) => (pass.password = e.target.value)}
          />
        </div>
        <div className="form-group">
          <label>Password Confirm</label>
          <input
            type="password"
            className="form-control"
            name="password_confirm"
            onChange={(e) => (pass.password_confirm = e.target.value)}
          />
        </div>

        <button className="btn btn-outline-secondary">Save</button>
      </form>
    </Wrapper>
  );
};
export default Profile;
