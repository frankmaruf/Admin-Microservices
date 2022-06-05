import axios from 'axios';
import React, { useEffect, useState } from 'react'
import Wrapper from './Wrapper'

const Rankings = () => {
    const [rankings, setRankings] = useState([]);

    useEffect(() => {
        (
            async () => {
                const response = await axios.get('rankings');

                setRankings(response.data);
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
                            {rankings.map((r: { name: string, revenue: number }, index:number) => {
                                return (
                                    <tr key={index}>
                                        <td>{index + 1}</td>
                                        <td>{r.name}</td>
                                        <td>{r.revenue}</td>
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

export default Rankings;