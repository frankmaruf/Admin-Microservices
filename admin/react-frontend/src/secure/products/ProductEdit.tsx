import React, {Component, SyntheticEvent} from 'react';
import Wrapper from "../Wrapper";
import axios from 'axios';
import {Redirect} from 'react-router-dom';
import ImageUpload from "../components/ImageUpload";
import {Product} from "../../classes/product";

class ProductEdit extends Component<{ match: any }> {
    state = {
        name: '',
        description: '',
        image: '',
        price: 0,
        redirect: false
    }
    id = 0;
    name = '';
    description = '';
    image = '';
    price = 0;

    componentDidMount = async () => {
        this.id = this.props.match.params.id;

        const response = await axios.get(`products/${this.id}`);

        const product: Product = response.data.data;

        this.setState({
            name: product.name,
            description: product.description,
            image: product.image,
            price: product.price
        })
    }


    submit = async (e: SyntheticEvent) => {
        e.preventDefault();

        await axios.put(`products/${this.id}`, {
            name: this.state.name,
            description: this.state.description,
            image: this.state.image,
            price: this.state.price,
        });

        this.setState({
            redirect: true
        })
    }

    imageChanged = (image: string) => {
        this.image = image;

        this.setState({
            image: this.image
        })
    }

    render() {
        if (this.state.redirect) {
            return <Redirect to={'/products'}/>;
        }

        return (
            <Wrapper>
                <form onSubmit={this.submit}>
                    <div className="form-group">
                        <label>Name</label>
                        <input type="text" className="form-control" name="name"
                               defaultValue={this.state.name}
                               onChange={e => this.setState({name: e.target.value})}
                        />
                    </div>
                    <div className="form-group">
                        <label>Description</label>
                        <textarea className="form-control" name="description"
                                  defaultValue={this.state.description}
                                  onChange={e => this.setState({description: e.target.value})}
                        ></textarea>
                    </div>
                    <div className="form-group">
                        <label>Image</label>
                        <ImageUpload value={this.image = this.state.image} imageChanged={this.imageChanged}/>
                    </div>
                    <div className="form-group">
                        <label>Price</label>
                        <input type="number" className="form-control" name="price"
                               value={this.price = this.state.price}
                               onChange={e => this.setState({price: e.target.value})}
                        />
                    </div>

                    <button className="btn btn-outline-secondary">Save</button>
                </form>
            </Wrapper>
        );
    }
}

export default ProductEdit;