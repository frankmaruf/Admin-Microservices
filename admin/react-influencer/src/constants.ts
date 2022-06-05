const dev = {
    BASE_URL: 'http://localhost:8070/api/influencer',
    CHECKOUT_URL: 'http://localhost:3002',
}

const prod = {
    BASE_URL: '',
    CHECKOUT_URL: ''
}

export default {
    ...(process.env.NODE_ENV === 'development' ? dev : prod)
};