import VueRouter from 'vue-router';

const routes = [
    {
      path: '/',
      component: require('./components/LoginComponent.vue').default,
      props: true
    },
    {
      path: '/home',
      component: require('./components/pages/ContactForm.vue').default,
      props: true
    },
  ];

const routerRender = routes.length !== 0 ?
    new VueRouter({routes}) :
    null;

export default routerRender;
