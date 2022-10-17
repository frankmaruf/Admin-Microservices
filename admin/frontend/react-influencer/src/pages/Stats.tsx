import React, {useEffect, useState} from 'react';
import Wrapper from "./Wrapper";
import axios from 'axios';
import constants from "../constants";

const Stats = () => {
    const [stats, setStats] = useState([]);

    useEffect(() => {
        (
            async () => {
                const response = await axios.get(`${constants.BASE_URL}/stats`,{ withCredentials: true });
                setStats(response.data);
            }
        )();
    }, []);

    return (
        <Wrapper>
            <div className="album py-5 bg-light">
                <div className="container">
                    <div className="table-responsive">
                        <table className="table table-striped table-sm">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Revenue</th>
                            </tr>
                            </thead>
                            <tbody>
                            {stats.map((o: { link: string, revenue: number }, index) => {
                                return (
                                    <tr key={index}>
                                        <td>{`${constants.CHECKOUT_URL}/${o.link}`}</td>
                                        <td>{o.link}</td>
                                        <td>{o.revenue}</td>
                                    </tr>
                                );
                            })}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </Wrapper>
    );
};

export default Stats;