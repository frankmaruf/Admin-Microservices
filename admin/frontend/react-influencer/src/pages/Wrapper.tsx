import React, { PropsWithChildren, useEffect,Dispatch, Children, PropsWithRef } from 'react'
import Header from '../components/Header'
import Nav from '../components/Nav'
import axios from 'axios'
import { User } from '../classes/user'
import { connect } from 'react-redux'
import setUser from '../redux/actions/setUserAction'
import { useSelector, useDispatch } from 'react-redux'
import { RootState } from '../redux/store'
import constants from '../constants'


const Wrapper = (props: PropsWithChildren<any>) => {
  const dispatch = useDispatch()
useEffect(() => {
  (async () => {
      try {
        axios.defaults.headers.Authorization = `Bearer ${localStorage.getItem(
          "token"
        )}`;
        await axios.get(`${constants.BASE_URL}/user`,{ withCredentials: true }).then(res => {
          dispatch(setUser(res.data.data))
        })
      } catch (e) {
        dispatch(setUser(new User()))
      
      // dispatch(setUser(null))
      }
  })();
}, []);

  return (
    <>
<Nav/>
<main role="main">
<Header/>
  <div className="album py-5 bg-light">
    <div className="container">
    {props.children}
    </div>
  </div>

</main>
    </>
  )
}

export default Wrapper;