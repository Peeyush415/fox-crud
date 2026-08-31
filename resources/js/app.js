import { createApp } from 'vue';
import axios from 'axios';
import App from './components/App.vue';

// axios.defaults.baseURL = 'http://localhost:8000/api/';
axios.defaults.withCredentials = true;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

createApp(App).mount('#app');
