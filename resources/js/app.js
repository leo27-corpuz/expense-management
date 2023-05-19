import './bootstrap';
import {createApp} from 'vue'
import App from './App.vue'
import router from './router'
import NProgress from 'nprogress'

const app = createApp(App);
app.use(router)
NProgress.configure({
    easing: 'ease',
    showSpinner: false,
    startOnLoad: false
});
app.mount('#app');