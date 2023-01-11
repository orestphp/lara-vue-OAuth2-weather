import * as userClient from "./plugins/user";
import * as weatherClient from "./plugins/weather";

export default {
    install(Vue) {
        Vue.prototype.$plugins = {
            ...userClient,
            ...weatherClient
        };
    }
};
