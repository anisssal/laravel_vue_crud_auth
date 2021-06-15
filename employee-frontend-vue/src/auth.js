
export default {
    async check(context) {
        let token = localStorage.getItem('id_token');
        if (token !== null) {
            context.axios.get(
                'api/user', {
                    headers : {"Authorization" : "Bearer "+token}
                }
            ).then(response => {
                context.auth.authenticated = true
                context.auth.profile = response.data.data
                context.axios.defaults.headers = {
                    'Authorization': `Bearer ${token}`
                }
            }).catch((error)=>{
                console.log(error)
            })
        }
    },

}