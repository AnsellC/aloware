import { Component, Vue } from 'vue-property-decorator';
import config from '../config.json';
@Component
export default class BaseClass extends Vue {
    loading = false;
    config = config;
}
