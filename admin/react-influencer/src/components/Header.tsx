import React from "react";
import { useSelector } from "react-redux";
import { useDispatch } from "react-redux";
import { Link } from "react-router-dom";
import { RootState } from "../redux/store";

const Header = () => {
  const dispatch = useDispatch();
  const user = useSelector((state: RootState) => state.user);
  const [title, setTitle] = React.useState("Welcome");
  const [description, setDescription] = React.useState(
    "Share Links And Earn 10% Of the Price"
  );
  let buttons;
  React.useEffect(() => {
    if (user.user.email.length > 2) {
      setTitle("$" + user.user.revenue);
      setDescription("Your Revenue");
    }
  }, [user]);
  if (user.user.email.length > 2) {
    buttons = (
      <>
        <Link className="btn btn-primary my-2" to="/stats">
          Stats
        </Link>
      </>
    );
  } else {
    buttons = (
      <>
        <Link className="btn btn-primary my-2" to="/login">
          Login
        </Link>
        <Link className="btn btn-secondary my-2" to="/register">
          Register
        </Link>
      </>
    );
  }
  return (
    <section className="jumbotron text-center">
      <div className="container">
        {user.user.email.length > 2 ? (
          <>
            <h1 className="jumbotron-heading">{title}</h1>
            <p className="lead text-muted">{description}</p>
          </>
        ) : (
          <>
            <h1 className="jumbotron-heading">Welcome</h1>
            <p className="lead text-muted">
              Share Links And Earn 10% Of the Price
            </p>
          </>
        )}
        {buttons}
      </div>
    </section>
  );
};

export default Header;
