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
export function getRoles(){
    return axios.get(prefix + '/roles').then(response => response.data);
}
export function getProjects(){
    return axios.get(prefix + '/projects').then(response => response.data);
}
export function getLeaveTypes(){
    return axios.get(prefix + '/admin/leavetypes').then(response => response.data);
}
export function getAssets(){
    return axios.get(prefix + '/admin/assets').then(response => response.data);
}
export function getVendors(){
    return axios.get(prefix + '/admin/vendors').then(response => response.data);
}
export function addUser(data){
    return axios.post(prefix + '/users/add', data).then(response => response.data);
}
export function attachRole(data){
    return axios.post(prefix + '/users/attach/role', data).then(response => response.data);
}
export function detachRole(data){
    return axios.post(prefix + '/users/detach/role', data).then(response => response.data);
}
export function attachProject(data){
    return axios.post(prefix + '/users/attach/project', data).then(response => response.data);
}
export function detachProject(data){
    return axios.post(prefix + '/users/detach/project', data).then(response => response.data);
}
export function countUsers(){
    return axios.get(prefix + '/users/count').then(response => response.data);
}
export function saveContract(data){
    return axios.post(prefix + '/admin/contracts', data).then(response => response.data);
}
export function saveDesignation(data){
    return axios.post(prefix + '/designations', data).then(response => response.data);
}
export function saveLeaveType(data){
    return axios.post(prefix + '/admin/leavetypes', data).then(response => response.data);
}
export function saveVendor(data){
    return axios.post(prefix + '/admin/vendors', data).then(response => response.data);
}
export function saveDp(data, id){
    return axios.post(prefix + `/users/save/dp/${id}`, data).then(response => response.data);
}
