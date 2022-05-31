import { configureStore } from '@reduxjs/toolkit';
import { Type } from 'typescript'
import { User } from '../classes/user'
import setUserReducer from './reducers/setUserReducer'

// const store = configureStore<typeof setUserReducer>({
//   reducer:{
//     user :setUserReducer
//   }
// })
// export default store;



const store = configureStore({
  reducer:{
    user: (state = {user: new User()}, action: { type: string, user: User }) => {
      switch (action.type) {
          case "SET_USER":
              return {
                  ...state,
                  user: action.user
              };
          default:
              return state;
      }
  }
  }
})
export type RootState = ReturnType<typeof store.getState>
export type AppDispatch = typeof store.dispatch
export default store;

// const store = configureStore(
//   {
//     reducer: {
//       user: (state = {}, action) => {
//         switch (action.type) {
//           case 'SET_USER':
//             return action.payload;
//           default:
//             return state;
//         }
//       },
//     },
//   }
// );

// export default store;
