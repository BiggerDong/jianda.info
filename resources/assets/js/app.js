
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-default/index.css';

window.Vue = require('vue');
Vue.use(ElementUI)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));
Vue.component('question-follow-button', require('./components/QuestionFollowButton.vue'));
Vue.component('question-follow-button-s', require('./components/QuestionFollowButtonS.vue'));
Vue.component('vote-comment', require('./components/VoteComment.vue'));
Vue.component('warning-button',require('./components/WarningButton.vue'))
Vue.component('topic-follow-button',require('./components/TopicFollowButton.vue'))
Vue.component('user-follow-button',require('./components/UserFollowButton.vue'))
Vue.component('avatar',require('./components/Avatar.vue'))

const app = new Vue({
    el: '#app'
});
