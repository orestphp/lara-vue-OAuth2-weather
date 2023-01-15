import store from './../store';

/**
 * Usage:
 *
 * async mounted() {
 *   const result = await this.$plugins.getUser(1);
 *   console.log(result)
 * }
 *
 * @returns mix
 * @param url
 */
export function getUser(url) {
    axios.get(url)
        .then(result => {
            return result.data;
        })
        .catch(error => {
            console.log(error.response && error.response.data.message || 'Error.');
        });
}
