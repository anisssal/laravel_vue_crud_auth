import axios from "axios";

const devInstance = createInstance("http://localhost:8000");
const productionInstance = createInstance("");

function createInstance(baseURL) {
    return axios.create({
        baseURL,
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('id_token')}`
        },
    });
}

export default devInstance;