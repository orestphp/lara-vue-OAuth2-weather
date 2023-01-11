/**
 * Usage:
 *
 * async mounted() {
 *   const result = await this.$plugins.getWeather();
 *   console.log(result)
 * }
 *
 * @param id
 * @returns {Promise<unknown>}
 */
export function getWeather() {
    return new Promise((resolve, reject) => {
        axios.get('/url')
            .then(result => {
                commit('setUser', result.data);
                resolve();
            })
            .catch(error => {
                reject(error.response && error.response.data.message || 'Error.');
            });
    });
}
