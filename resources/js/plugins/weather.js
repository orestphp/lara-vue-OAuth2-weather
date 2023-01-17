/**
 * Usage:
 *
 * async mounted() {
 *   const result = await this.$plugins.getWeather();
 *   console.log(result)
 * }
 *
 * @param lat
 * @param lon
 * @param token
 * @returns {Promise<unknown>}
 */
export function getWeather(lat, lon, token) {
    // TODO: if "localhost" & location discarded: get country`s capital lat & long
    let clientLang = navigator.language || navigator.userLanguage;

    // get Weather
    return new Promise((resolve, reject) => {
        axios.get(`${process.env.MIX_API_URL}/getweather?lat=${lat}&lon=${lon}&token=${token}`)
            .then(result => {
                // return JSON.stringify(result.data);
                resolve(result.data);
            })
            .catch(error => {
                console.log(error.response && error.response.data.message || 'Error.');
            });
    });
}

