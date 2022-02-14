import Vue from 'vue';
import App from './App.vue';
import router from './router';
import { upperFirst, camelCase } from 'lodash';
import './filters';

Vue.config.productionTip = false;
const requireComponent = require.context(
    './components',
    true,
    /[A-Z]\w+\.(vue|js)$/
);

requireComponent.keys().forEach((fileName) => {
    const componentConfig = requireComponent(fileName);
    const componentName = upperFirst(
        camelCase(
            fileName
                .split('/')
                .pop()
                ?.replace(/\.\w+$/, '')
        )
    );

    Vue.component(componentName, componentConfig.default || componentConfig);
});

new Vue({
    router,
    render: (h) => h(App),
}).$mount('#app');
