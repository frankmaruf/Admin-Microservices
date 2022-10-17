import React from 'react';
import Wrapper from '../Wrapper';
import axios from 'axios';
import constants from '../../constants';
var c3 = require('c3');
class Dashboard extends React.Component {

  componentDidMount = async () => {
      let chart = c3.generate({
          bindto: '#chart',
          data: {
              x: 'x',
              columns: [
                  ['x'],
                  ['Sales'],
              ],
              types: {
                  Sales: 'bar'
              }
          },
          axis: {
              x: {
                  type: 'timeseries',
                  tick: {
                      format: '%Y-%m-%d'
                  }
              }
          }
      });

      const response = await axios.get(`${constants.BASE_URL}/chart`);

      const records: { date: string, sum: number }[] = response.data.data;

      chart.load({
          columns: [
              ['x', ...records.map(r => r.date)],
              ['Sales', ...records.map(r => r.sum)]
          ]
      })
  }


  render() {
      return (
          <Wrapper>
              <h2>Daily Sales</h2>

              <div id="chart"/>
          </Wrapper>
      )
  }
}

export default Dashboard;
