import axios from 'axios'

let prefix = process.env.MIX_API_URL

export function getAuthUser() {
    return axios.get(prefix + '/users/auth').then(response => response.data);
}
export function logout(){
    return axios.get('/logout').then(response => response.data);
}
export function saveProfile(data){
    return axios.post(prefix + '/users/save/profile', data).then(response => response.data);
}
