require('./bootstrap');

window.Vue = require('vue');

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('courses-component', require('./components/CoursesComponent.vue').default);
Vue.component('aside-courses-component', require('./components/AsideCoursesComponent.vue').default);
Vue.component('manage-users-component', require('./components/ManageUsersComponent.vue').default);
Vue.component('manage-categories-component', require('./components/ManageCategoriesComponent.vue').default);
Vue.component('manage-courses-component', require('./components/ManageCoursesComponent.vue').default);

const app = new Vue({
    el: '#app',
});