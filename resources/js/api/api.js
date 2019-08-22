import axios from 'axios'

export function getAuthUser() {
    return axios.get(process.env.MIX_API_URL + '/users/auth').then(response => response.data);
}
