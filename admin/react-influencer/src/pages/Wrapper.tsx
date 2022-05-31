import React, { PropsWithChildren, useEffect,Dispatch, Children, PropsWithRef } from 'react'
import Header from '../components/Header'
import Nav from '../components/Nav'
import axios from 'axios'
import { User } from '../classes/user'
import { connect } from 'react-redux'
import setUser from '../redux/actions/setUserAction'
import { useSelector, useDispatch } from 'react-redux'
import { RootState } from '../redux/store'


const Wrapper = (props: PropsWithChildren<any>) => {
  // const user = useSelector((state: RootState) => state.user)
  const dispatch = useDispatch()
//   useEffect(() => {
//     (async () => {
//         try {
//             const response = await axios.get('user');
//             const user: User = response.data.data;
//             dispatch(setUser(user))
//             console.log(user)
//             props.setUser(new User(
//                 user.id,
//                 user.first_name,
//                 user.last_name,
//                 user.email,
//                 user.revenue
//             ));
//         } catch (e) {
//             setUser(new User())}
//              props.setUser(null);
//     })();
// }, []);








useEffect(() => {
  (async () => {
      try {
        await axios.get('user').then(res => {
          // console.log(res);
          dispatch(setUser(res.data.data))
        })
      } catch (e) {
        // @ts-ignore
        dispatch(setUser(null))}
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

// export default connect( (state: RootState) => ({ user: state.user.user }), (dispatch: Dispatch<any>) => ({  setUser: (user: User) => dispatch(setUser(user)) }))(Wrapper)