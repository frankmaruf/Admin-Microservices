import axios from "axios";
import React from "react";
import Wrapper from "./Wrapper";
import { Product } from "../classes/product";
import { useSearchParams } from "react-router-dom";
import constants from "../constants";

const Main = () => {
  const [products, setProducts] = React.useState([]);
  const [searchText, setSearchText] = React.useState("");
  const [selectedProduct, setSelectedProduct] = React.useState([]);
  const [notify, setNotify] =  React.useState({
    show: false,
    error: false,
    message: ''
});
  React.useEffect(() => {
    (async () => {
      axios.get(`/products?search=${searchText}`).then((res) => {
        setProducts(res.data.data);
      });
    })();
  }, [searchText]);
  const isSelectedProduct = (id: number) =>
    selectedProduct.filter((s) => s === id).length > 0;

  const select = (id: number) => {
    if (isSelectedProduct(id)) {
      setSelectedProduct(selectedProduct.filter((s) => s !== id));
      return;
    }

    // @ts-ignore
    setSelectedProduct([...selectedProduct, id]);
  };
  const generate = async () => {
    try {
        const response = await axios.post('links', {
            products: selectedProduct
        });

        setNotify({
            show: true,
            error: false,
            message: `Link generated: ${constants.CHECKOUT_URL}/${response.data.data.link}`
        });
    } catch (e) {
        setNotify({
            show: true,
            error: true,
            message: 'You should be logged in to generate a link!'
        })
    } finally {
        setTimeout(() => {
            setNotify({
                show: false,
                error: false,
                message: ''
            });
        }, 10000);
    }
}

let button, info;

if (selectedProduct.length > 0) {
    button = (
        <div className="input-group-append">
            <button className="btn btn-info" onClick={generate}>Generate Link</button>
        </div>
    )
}

if (notify.show) {
    info = (
        <div className="col-md-12 mb-4">
            <div className={notify.error ? "alert alert-danger" : "alert alert-info"} role="alert">
                {notify.message}
            </div>
        </div>
    )
}

  return (
    <>
      <Wrapper>
        <div className="row">
          {info}
          <div className="col-md-12 mb-4 input-group">
            <input
              type="text"
              className="form-control"
              placeholder="Search"
              onKeyUp={(e) =>
                setSearchText((e.target as HTMLInputElement).value)
              }
            />
            {button}
          </div>
          {products.map((product: Product) => {
            return (
              <div className="col-md-4" key={product.id}>
                <div
                  className={
                    isSelectedProduct(product.id)
                      ? "card mb-4 shadow-sm selected"
                      : "card mb-4 shadow-sm"
                  }
                  onClick={() => select(product.id)}
                >
                  <img
                    src={product.image}
                    height="200"
                    className="card-img-top"
                    alt={product.name}
                  />
                  <div className="card-body">
                    <p className="card-text">{product.name}</p>
                    <div className="d-flex justify-content-between align-items-center">
                      <small className="text-muted">${product.price}</small>
                    </div>
                  </div>
                </div>
              </div>
            );
          })}
        </div>
      </Wrapper>
    </>
  );
};

export default Main;
