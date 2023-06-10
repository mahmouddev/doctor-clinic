
import __ from './lib/translation';
window.__ = __;

import {createApp} from 'vue/dist/vue.esm-bundler.js';
import Installer from "./installer/Installer.vue";

const app = createApp({
    provide: {
        __
    },
});

app.component('installer', Installer);
app.mount("#installer");