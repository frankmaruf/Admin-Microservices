const dev = {
    BASE_URL: 'http://localhost:8070/api',
    CHECKOUT_URL: 'http://localhost:3002',
    USERS_URL: "http://localhost:8001/api",
}

const prod = {
    BASE_URL: '',
    CHECKOUT_URL: '',
    USERS_URL: '',
}

export default {
    ...(process.env.NODE_ENV === 'development' ? dev : prod)
};