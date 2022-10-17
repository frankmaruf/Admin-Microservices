const dev = {
    BASE_URL: 'http://localhost:8003/api',
    USERS_URL: "http://localhost:8001/api",
    CHECKOUT_URL: 'http:localhost:3002',
}

const prod = {
    BASE_URL: '',
    CHECKOUT_URL: '',
    USERS_URL: '',
}

export default {
    ...(process.env.NODE_ENV === 'development' ? dev : prod)
};