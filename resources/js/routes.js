export default [
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default },
    { path: '/developer', component: require('./components/Developer.vue').default },
    { path: '/users', component: require('./components/Users.vue').default },
    { path: '/products', component: require('./components/pages/Product.vue').default },
    { path: '/tags', component: require('./components/pages/Tag.vue').default },
    { path: '/categories', component: require('./components/pages/Category.vue').default },
    { path: '*', component: require('./components/NotFound.vue').default }
];
