import axios from 'axios'

let prefix = process.env.MIX_API_URL

export function getAuthUser() {
    return axios.get(prefix + '/users/auth').then(response => response.data);
}
export function logout() {
    return axios.get('/logout').then(response => response.data);
}
export function saveProfile(data) {
    return axios.post(prefix + '/users/save/profile', data).then(response => response.data);
}
export function saveUserEdit(data, id) {
    return axios.post(prefix + `/users/save/edit/${id}`, data).then(response => response.data);
}
export function getUsers() {
    return axios.get(prefix + '/users').then(response => response.data);
}
export function activateUser(id) {
    return axios.get(prefix + `/users/activate/${id}`).then(response => response.data);
}
export function deactivateUser(id) {
    return axios.get(prefix + `/users/deactivate/${id}`).then(response => response.data);
}
export function getDepartments() {
    return axios.get(prefix + '/departments').then(response => response.data);
}
export function getDirectorates() {
    return axios.get(prefix + '/directorates').then(response => response.data);
}
export function getDesignations() {
    return axios.get(prefix + '/designations').then(response => response.data);
}
export function getContracts() {
    return axios.get(prefix + '/contracts').then(response => response.data);
}
export function getRoles() {
    return axios.get(prefix + '/roles').then(response => response.data);
}
export function getProjects() {
    return axios.get(prefix + '/projects').then(response => response.data);
}
export function getLeaveTypes() {
    return axios.get(prefix + '/admin/leavetypes').then(response => response.data);
}
export function getAssets() {
    return axios.get(prefix + '/admin/assets').then(response => response.data);
}
export function getVendors() {
    return axios.get(prefix + '/admin/vendors').then(response => response.data);
}
export function addUser(data) {
    return axios.post(prefix + '/users/add', data).then(response => response.data);
}
export function attachRole(data) {
    return axios.post(prefix + '/users/attach/role', data).then(response => response.data);
}
export function detachRole(data) {
    return axios.post(prefix + '/users/detach/role', data).then(response => response.data);
}
export function attachProject(data) {
    return axios.post(prefix + '/users/attach/project', data).then(response => response.data);
}
export function detachProject(data) {
    return axios.post(prefix + '/users/detach/project', data).then(response => response.data);
}
export function countUsers() {
    return axios.get(prefix + '/users/count').then(response => response.data);
}
export function saveContract(data) {
    return axios.post(prefix + '/admin/contracts', data).then(response => response.data);
}
export function saveDesignation(data) {
    return axios.post(prefix + '/designations', data).then(response => response.data);
}
export function saveLeaveType(data) {
    return axios.post(prefix + '/admin/leavetypes', data).then(response => response.data);
}
export function saveVendor(data) {
    return axios.post(prefix + '/admin/vendors', data).then(response => response.data);
}
export function saveDp(data, id) {
    return axios.post(prefix + `/users/save/dp/${id}`, data).then(response => response.data);
}
export function addRequest(data) {
    return axios.post(prefix + '/requests', data, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    }).then(response => response.data);
}
export function saveRequest(data, id) {
    return axios.post(prefix + `/requests/update/${id}`, data, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    }).then(response => response.data);
}
export function getMyRequests() {
    return axios.get(prefix + '/requests/mine').then(response => response.data);
}
export function downloadFile(id) {
    return axios.get(prefix + `/download/file/${id}`).then(response => response.data);
}
export function getProjectRequests() {
    return axios.get(prefix + '/requests/accountant').then(response => response.data);
}
export function getLevel1Requests() {
    return axios.get(prefix + '/requests/firstlevel').then(response => response.data);
}
export function getFMRequests() {
    return axios.get(prefix + '/requests/fmrequests').then(response => response.data);
}
export function getDirectorRequests() {
    return axios.get(prefix + '/requests/directorreqeuests').then(response => response.data);
}
export function getEDRequests() {
    return axios.get(prefix + '/requests/edrequests').then(response => response.data);
}
export function giveAccountantApproval(req) {
    return axios.post(prefix + '/requests/accountant', {
        request_id: req,
        field: 'accountant_approval'
    }).then(response => response.data);
}
export function giveLevel1Approval(req) {
    return axios.post(prefix + '/requests/firstlevel', {
        request_id: req,
        field: 'level_one_approval'
    }).then(response => response.data);
}
export function givefMApproval(req) {
    return axios.post(prefix + '/requests/fmrequests', {
        request_id: req,
        field: 'finance_approval'
    }).then(response => response.data);
}
export function giveEDApproval(req) {
    return axios.post(prefix + '/requests/edrequests', {
        request_id: req,
        field: 'level_three_approval'
    }).then(response => response.data);
}
export function giveDirectorApproval(req) {
    return axios.post(prefix + '/requests/directorreqeuests', {
        request_id: req,
        field: 'level_two_approval'
    }).then(response => response.data);
}
export function declineRequest(data) {
    return axios.post(prefix + '/requests/decline', {
        request_id: data.request_id,
        field: data.field,
        comments: data.comments,
    }).then(response => response.data);
}
export function askForLeave(data) {
    return axios.post(prefix + '/leaves', data).then(response => response.data)
}
export function cancelLeave(id) {
    return axios.get(prefix + `/leaves/cancel/${id}`).then(response => response.data)
}
export function approveLeave(id) {
    return axios.get(prefix + `/leaves/approve/${id}`).then(response => response.data)
}
export function getMyLeaves() {
    return axios.get(prefix + '/leaves/mine').then(response => response.data)
}
export function getPendingLeaves() {
    return axios.get(prefix + '/leaves/pending').then(response => response.data)
}
export function declineLeave(data) {
    return axios.post(prefix + `/leaves/decline/${data.id}`, {
        reason: data.reason
    }).then(response => response.data)
}

export function toggleButton(field) {
    return axios.post(prefix + '/settings/toggle', {
        field: field
    }).then(response => response.data)
}

export function getSettings() {
    return axios.get(prefix + '/settings').then(response => response.data)
}
export function getSystemSettings() {
    return axios.get(prefix + '/settings/system').then(response => response.data)
}
export function getLeaveStats() {
    return axios.get(prefix + '/reports/leaves').then(response => response.data)
}
export function setHoliday(data) {
    return axios.post(prefix + '/leaves/holidays', data).then(response => response.data)
}


export function makeReq(data) {
    return axios.post(prefix + '/programs', data).then(response => response.data)
}
export function saveTSoW(data) {
    return axios.post(prefix + '/programs/savetsow', data).then(response => response.data)
}
export function saveVhr(data) {
    return axios.post(prefix + '/programs/savevhr', data).then(response => response.data)
}
export function saveBudget(data) {
    return axios.post(prefix + '/programs/savebudget', data).then(response => response.data)
}
export function updateRequestThatDocIsCompleted(data) {
    return axios.post(prefix + '/programs/changedoccompletionstatus', data).then(response => response.data)
}
export function saveAttachments(data) {
    return axios.post(prefix + '/programs/save/attachments', data).then(response => response.data)
}
export function sendToken(data) {
    return axios.post(prefix + '/requests/send/token', data).then(response => response.data)
}
export function checkAndInvalidateToken(data) {
    return axios.post(prefix + '/requests/check/token', data).then(response => response.data)
}
