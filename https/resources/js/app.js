
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


/**
 * console function
 */
window.events = new Vue()
window.noty = function (notification) {
    window.events.$emit('notification', notification)
}

window.handleError = function (error) {
    if(error.response.status == 422){
        window.notry({
            message: 'You had validation errors. Please try again.',
            type: 'danger'
        })
    }

    window.noty({
        message: 'Something went wrong. Please refresh the page',
        type: 'danger'
    })
}

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('vue-login', require('./components/Login.vue'));
Vue.component('vue-lessons', require('./components/Lesson.vue'));
Vue.component('vue-noty', require('./components/Noty.vue'));

const app = new Vue({
    el: '#app'
});
