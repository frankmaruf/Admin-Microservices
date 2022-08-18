import React, { Component } from "react";
import Wrapper from "../Wrapper";
import axios from "axios";
import { Product } from "../../classes/product";
import { Link } from "react-router-dom";
import Paginator from "../components/Paginator";
import Deleter from "../components/Deleter";
import constants from "../../constants";

class Products extends Component {
  state = {
    products: [],
  };
  page = 1;
  last_page = 0;
  componentDidMount = async () => {
    const response = await axios.get(`${constants.BASE_URL}/products?page=${this.page}`);

    this.setState({
      products: response.data.data,
    });

    this.last_page = response.data.meta.last_page;
  };
  handleDelete = async (id: number) => {
    this.setState({
      products: this.state.products.filter((p: Product) => p.id !== id),
    });
  };
  handlePageChange = async (page: number) => {
    this.page = page;

    await this.componentDidMount();
  };
  render() {
    return (
      <Wrapper>
        <div className="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <div className="btn-toolbar mb-2 mb-md-0">
            <Link
              to={"/products/create"}
              className="btn btn-sm btn-outline-secondary"
            >
              Add
            </Link>
          </div>
        </div>
        <div className="table-responsive">
          <table className="table table-striped table-sm">
            <thead>
              <tr>
                <th>#</th>
                <th>Image</th>
                <th>Title</th>
                <th>Description</th>
                <th>Price</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              {this.state.products.map((product: Product) => {
                return (
                  <tr key={product.id}>
                    <td>{product.id}</td>
                    <td>
                      <img src={product.image} alt={product.name} width="50" />
                    </td>
                    <td>{product.name}</td>
                    <td>{product.description}</td>
                    <td>{product.price}</td>
                    <div className="btn-group mr-2">
                      <Link
                        to={`/products/${product.id}/edit`}
                        className="btn btn-sm btn-outline-secondary"
                      >
                        Edit
                      </Link>
                      <Deleter
                        id={product.id}
                        endpoint={"products"}
                        handleDelete={this.handleDelete}
                      />
                    </div>
                    {/* <td>{this.actions(product.id)}</td> */}
                  </tr>
                );
              })}
            </tbody>
          </table>
        </div>
        <Paginator
          lastPage={this.last_page}
          handlePageChange={this.handlePageChange}
        />
      </Wrapper>
    );
  }
}

export default Products;
