/* eslint-disable @next/next/no-sync-scripts */
import Head from 'next/head'
import React, { PropsWithChildren } from 'react'

const Wrapper = (props: PropsWithChildren<any>) => {
  return (
    <>
    <Head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossOrigin="anonymous"/>
    {/* <script src="https://js.stripe.com/v3/"></script> */}
    </Head>
    <div className="container">
    {props.children}
    </div>
    </>
  )
}

export default Wrapper