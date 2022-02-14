import Vue from 'vue';
import moment from 'moment';
Vue.filter('dateFromNow', (value: string) => {
    if (!value) {
        return '';
    }

    value = value.toString();
    return moment(value).fromNow();
});
