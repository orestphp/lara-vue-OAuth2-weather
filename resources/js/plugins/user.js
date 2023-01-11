import store from './../store';

/**
 * Usage:
 *
 * async mounted() {
 *   const result = await this.$plugins.getUser(1);
 *   console.log(result)
 * }
 *
 * @param id
 * @returns {Promise<unknown>}
 */
export function getUser(id) {
    return new Promise((resolve, reject) => {
        axios.get(`${store.app.apiUrl}/user/${id}`)
            .then(result => {
                store.commit('setUser', result.data);
                resolve();
            })
            .catch(error => {
                reject(error.response && error.response.data.message || 'Error.');
            });
    });
}
