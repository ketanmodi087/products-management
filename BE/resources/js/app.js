import { createApp } from 'vue/dist/vue.esm-bundler.js';
import ProductTable from './components/ProductTable.vue';

const app = createApp({});
app.component('product-table', ProductTable);
app.mount("#app");
