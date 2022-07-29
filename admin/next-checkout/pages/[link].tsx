import type { NextPage } from "next";
import Head from "next/head";
import { useRouter } from "next/router";
import React, { PropsWithChildren, PropsWithRef, SyntheticEvent, useEffect, useState } from "react";
import Wrapper from "../components/Wrapper";
import axios from "axios";
import constants from "../constants";
import { PayPalScriptProvider, PayPalButtons } from "@paypal/react-paypal-js";

const Home = () => {
  const router = useRouter();
  const { link } = router.query;
  const [user, setUser] = useState<any>(null);
  const [products, setProducts] = useState<any[]>([]);
  const [quantities, setQuantities] = useState<any[]>([]);
  const [firstName, setFirstName] = useState("");
  const [lastName, setLastName] = useState("");
  const [email, setEmail] = useState("");
  const [address, setAddress] = useState("");
  const [phone, setPhone] = useState("");
  const [country, setCountry] = useState("");
  const [city, setCity] = useState("");
  const [postalCode, setPostalCode] = useState("");
  const [payMent_Details, setPayMent_Details] = useState({
    payment_method: "",
    payment_id: "",
    payment_currency: "",
    payment_amount: "",
    payment_status_detail: "",
    payment_status: "",
    payment_transaction_type: "",
    payment_transaction_id: "",
    payment_transaction_status: "",
    payment_transaction_amount: "",
    payment_transaction_currency: "",
    payment_description: "",
    payment_created_at: "",
    payment_updated_at: "",
    completed: 0,
  });
  console.log("my_payment_details", payMent_Details);
  const initialOptions = {
    // from env file
    "client-id": constants.PAYPAL_SANDBOX_CLIENT_ID,
    currency: "USD"!,
    intent: "capture"!,
  };
  useEffect(() => {
    if (link !== undefined) {
      (async () => {
        const response = await axios.get(`${constants.endpoint}/links/${link}`);

        const data = response.data.data;

        setUser(data.user);

        setProducts(data.products);

        setQuantities(
          data.products.map(
            (p: {
              id: string;
              name: string;
              price: number;
              quantity: number;
              image: string;
            }) => {
              return {
                product_id: p.id,
                quantity: 0,
              };
            }
          )
        );
      })();
    }
  }, [link]);

  const quantity = (id: number) => {
    const q = quantities.find((q) => q.product_id === id);

    return q ? q.quantity : 0;
  };

  const change = (id: number, quantity: number) => {
    setQuantities(
      quantities.map((q) => {
        if (q.product_id === id) {
          return {
            product_id: id,
            quantity,
          };
        }

        return q;
      })
    );
  };
  const [totalMoney,setTotalMoney] = useState(100);

  const total = () => {
    let t = 0;
    quantities.forEach((q) => {
      const product = products.find((p) => p.id === q.product_id);
      t += q.quantity * parseFloat(product.price);
    });
    return t;
  };
      // useMemo for setTotalMoney
      const totalMoneym =  React.useMemo(() => {
        setTotalMoney(total());
      }
      , [quantities, products]);
    // useCallbackFunction for setTotalMoney
  // const totalMoneyC = React.useCallback(() => {
  //   setTotalMoney(total());
  // }
  // , [quantities, products]);
  
  const submit = async (e:SyntheticEvent) => {
    e.preventDefault();
    const response = await axios.post(`${constants.endpoint}/orders`, {
      first_name: firstName,
      last_name: lastName,
      email: email,
      address: address,
      phone: phone,
      country: country,
      city: city,
      postal_code: postalCode,
      link: link,
      items: quantities,
      payment_method: payMent_Details.payment_method,
      payment_status: payMent_Details.payment_status,
      payment_id: payMent_Details.payment_id,
      payment_amount: payMent_Details.payment_amount,
      payment_currency: payMent_Details.payment_currency,
      payment_description: payMent_Details.payment_description,
      payment_status_detail: payMent_Details.payment_status_detail,
      payment_created_at: payMent_Details.payment_created_at,
      payment_updated_at: payMent_Details.payment_updated_at,
      payment_transaction_id: payMent_Details.payment_transaction_id,
      payment_transaction_type: payMent_Details.payment_transaction_type,
      payment_transaction_status: payMent_Details.payment_transaction_status,
      payment_transaction_amount: payMent_Details.payment_transaction_amount,
      payment_transaction_currency:
        payMent_Details.payment_transaction_currency,
      completed: 1,
    });
    console.log(response.data);

    // stripe.redirectToCheckout({
    //   sessionId: response.data.id,
    // });
  };

  return (
    <Wrapper>
      <div className="py-5 text-center">
        <h2>Welcome</h2>
        <p className="lead">
          {user?.first_name} {user?.last_name} has invited you to buy this
          item(s).
        </p>
      </div>

      <div className="row">
        <div className="col-md-4 order-md-2 mb-4">
          <h4 className="d-flex justify-content-between align-items-center mb-3">
            <span className="text-muted">Products</span>
          </h4>
          <ul className="list-group mb-3">
            {products.map((p) => {
              return (
                <div key={p.id}>
                  <li className="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                      <h6 className="my-0">{p.name}</h6>
                      <small className="text-muted">{p.description}</small>
                    </div>
                    <span className="text-muted">${p.price}</span>
                  </li>
                  <li className="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                      <h6 className="my-0">Quantity</h6>
                    </div>

                    <input
                      type="number"
                      min="0"
                      className="text-muted form-control"
                      style={{ width: "65px" }}
                      defaultValue={quantity(p.id)}
                      onChange={(e) => change(p.id, parseInt(e.target.value))}
                    />
                  </li>
                </div>
              );
            })}

            <li className="list-group-item d-flex justify-content-between">
              <span>Total (USD)</span>
              <strong>${total()}</strong>
            </li>
          </ul>
        </div>
        <div className="col-md-8 order-md-1">
          <h4 className="mb-3">Payment Info</h4>
          <form className="needs-validation" onSubmit={submit}>
            <div className="row">
              <div className="col-md-6 mb-3">
                <label htmlFor="firstName">First name</label>
                <input
                  type="text"
                  className="form-control"
                  id="firstName"
                  placeholder="First Name"
                  onChange={(e) => setFirstName(e.target.value)}
                  required
                />
              </div>
              <div className="col-md-6 mb-3">
                <label htmlFor="lastName">Last name</label>
                <input
                  type="text"
                  className="form-control"
                  id="lastName"
                  placeholder="Last Name"
                  onChange={(e) => setLastName(e.target.value)}
                  required
                />
              </div>
            </div>

            <div className="mb-3">
              <label htmlFor="email">Email</label>
              <input
                type="email"
                className="form-control"
                id="email"
                placeholder="you@example.com"
                onChange={(e) => setEmail(e.target.value)}
              />
            </div>

            <div className="mb-3">
              <label htmlFor="address">Address</label>
              <input
                type="text"
                className="form-control"
                id="address"
                placeholder="1234 Main St"
                onChange={(e) => setAddress(e.target.value)}
                required
              />
            </div>

            <div className="mb-3">
              <label htmlFor="phone">Phone</label>
              <input
                type="text"
                className="form-control"
                id="phone"
                onChange={(e) => setPhone(e.target.value)}
                placeholder="+880"
              />
            </div>

            <div className="row">
              <div className="col-md-5 mb-3">
                <label htmlFor="country">Country</label>
                <input
                  type="text"
                  className="form-control"
                  id="country"
                  placeholder="Country"
                  onChange={(e) => setCountry(e.target.value)}
                />
              </div>
              <div className="col-md-4 mb-3">
                <label htmlFor="city">City</label>
                <input
                  type="text"
                  className="form-control"
                  id="city"
                  placeholder="City"
                  onChange={(e) => setCity(e.target.value)}
                />
              </div>
              <div className="col-md-3 mb-3">
                <label htmlFor="postal_code">Postal code</label>
                <input
                  type="text"
                  className="form-control"
                  id="postal_code"
                  placeholder="Postal Code"
                  required
                  onChange={(e) => setPostalCode(e.target.value)}
                />
              </div>
            </div>
              <PayPalScriptProvider options={initialOptions}>
                <PayPalButtons
                  createOrder={(data, actions) => {
                    return actions.order.create({
                      purchase_units: [
                        {
                          amount: {
                            value: '100',
                          },
                        },
                      ],
                    });
                  }}
                  onApprove={(data, actions) => {
                    return actions.order.capture().then((details) => {
                      const name = details.payer.name.given_name;
                      // alert(`Transaction completed by ${name}`);
                      console.log("details", details);
                      setPayMent_Details({
                        payment_method: data.paymentSource,
                        payment_status: details.status,
                        payment_id: details.id,
                        payment_amount: details.purchase_units[0].amount.value,
                        payment_description:
                          "seller_protection dispute_categories -> " +
                          details.purchase_units[0].payments?.captures[0]
                            .seller_protection.dispute_categories[1] +
                          " seller_protection status -> " +
                          details.purchase_units[0].payments?.captures[0]
                            .seller_protection.status,
                        payment_currency:
                          details.purchase_units[0].amount.currency_code,
                        payment_status_detail:
                          details.purchase_units[0].payments?.captures[0]
                            .status,
                        payment_created_at: details.create_time,
                        payment_updated_at: details.update_time,
                        payment_transaction_id: details.id,
                        payment_transaction_type: details.intent,
                        payment_transaction_status: details.status,
                        payment_transaction_amount:
                          details.purchase_units[0].amount.value,
                        payment_transaction_currency:
                          details.purchase_units[0].amount.currency_code,
                        completed: 1,
                      });
                    });
                  }}
                />
              </PayPalScriptProvider>
            {payMent_Details.payment_status === "COMPLETED" && (
              <button
                className="btn btn-primary btn-lg btn-block"
                type="submit"
              >
                Checkout
              </button>
            )}
          </form>
        </div>
      </div>
    </Wrapper>
  );
};

// @ts-ignore
export default Home;
