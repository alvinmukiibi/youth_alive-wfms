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
export function saveUserEdit(data, id){
    return axios.post(prefix + `/users/save/edit/${id}`, data).then(response => response.data);
}
export function getUsers(){
    return axios.get(prefix + '/users').then(response => response.data);
}
export function activateUser(id){
    return axios.get(prefix + `/users/activate/${id}`).then(response => response.data);
}
export function deactivateUser(id){
    return axios.get(prefix + `/users/deactivate/${id}`).then(response => response.data);
}
export function getDepartments(){
    return axios.get(prefix + '/departments').then(response => response.data);
}
export function getDesignations(){
    return axios.get(prefix + '/designations').then(response => response.data);
}
export function getContracts(){
    return axios.get(prefix + '/contracts').then(response => response.data);
}
export function addUser(data){
    return axios.post(prefix + '/users/add', data).then(response => response.data);
}
