import './bootstrap';
import { createApp } from 'vue';
import App from '../js/components/App.vue'
import vuetify from './vuetify';
import router from './router';

const app = createApp(App)
app.use(vuetify)
app.use(router)
app.mount('#app')
