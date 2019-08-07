/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('calendar-events', require('./components/Calendar/CalendarEvents.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    mounted: function() {
    	let that = this
        axios.interceptors.response.use(
        	response => response,
        	that.handleErrors
    	)
    },
    methods: {
        handleSuccess: function(message) {
            $.notify({
                offset: 30,
                message: message+' ',
                showClose: true
            }, {
                type: 'success',
            })
        },
        handleErrors: function(response) {
        	response = response.response;
            if (response && response.status) {
                let message = ''
                switch (response.status) {
                    case 401:
                        message = 'You are not authorized to make this request.'
                        alert('Your session has expired. Logging out.')
                        window.location.href = '/login'
                        break
                    case 403:
                        message = 'You do not have enough permissions to make this request.'
                        if (response.data && response.data.error) {
                            message = response.data.error
                        }
                        break
                    case 404:
                        message = 'Requested resource not found.'
                        break
                    case 422:
                        let keys = Object.keys(response.data.errors);
                        if (keys.length == 1) {
                        	keys = keys.pop()
                        	message = response.data.errors[keys]
                        } else {
                        	message = "<ul class='list m-0'>"
	                        for (let index in response.data.errors) {
	                            message += "<li class='list-item pl-0 pr-0'><div class='list-body'>" + response.data.errors[index] + "</div></li>"
	                        }
	                        message += "</ul>"
	                    }
                        break
                    case 500:
                        message = 'Oops! We are having some problems right now, please try again later.'
                        break
                }
                $.notify({
                    offset: 30,
                    title: 'Error: ',
                    message: message,
                    showClose: true,
                }, {
                    type: 'danger',
                })
            }
        },
    }
});
