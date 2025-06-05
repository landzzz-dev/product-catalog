import './bootstrap';
import { createApp } from 'vue';
import Index from '../js/components/pages/Product.vue';
import vuetify from './vuetify';

const app = createApp(Index)
app.use(vuetify)
app.mount('#app')
