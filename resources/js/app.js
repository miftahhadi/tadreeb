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

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.component('item-baru-form', require('./components/admin/general/ItemBaruForm.vue').default);

Vue.component('item-index', require('./components/admin/item-index/ItemIndex.vue').default);
Vue.component('item-list', require('./components/admin/item-index/ItemList.vue').default);
Vue.component('item-action', require('./components/admin/item-index/ItemAction.vue').default);
Vue.component('item-delete-modal', require('./components/admin/item-index/ItemDeleteModal.vue').default);
Vue.component('item-assign', require('./components/admin/item-index/ItemAssign.vue').default);

Vue.component('pagination', require('laravel-vue-pagination'));

Vue.component('kelas-index', require('./components/admin/kelas/KelasIndex.vue').default);
Vue.component('kelas-item-tab', require('./components/admin/kelas/KelasItemTab.vue').default);
Vue.component('kelas-assign-modal', require('./components/admin/kelas/KelasAssignModal.vue').default);

Vue.component('import-user', require('./components/admin/user/ImportUser.vue').default);

Vue.component('exam-doing-page', require('./components/front/ujian/ExamDoingPage.vue').default);
Vue.component('exam-number-button', require('./components/front/ujian/ExamNumberButton.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
