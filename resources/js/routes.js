// import Home from './components/Home.vue';
// import About from './components/About.vue';

export default {
    mode: 'history',
    routes: [
        {
            name: 'welcome',
            path: '/',
            component: () => import('./components/Welcome.vue')
        },
        {
            name: 'home',
            path: '/home',
            component: () => import('./components/Home/AppHome.vue')
        },
        {
            name: 'login',
            path: '/login',
            component: () => import('./components/Login/Login.vue')
        },
        {
            name: 'logout',
            path: '/logout',
            component: () => import('./components/Login/Login.vue')
        },
        {
            name: 'register_account',
            path: '/register-account',
            component: () => import('./components/Login/RegisterAccount.vue')
        },
        {
            name: 'about',
            path: '/about',
            component: () => import('./components/About.vue')
        },
        {
            name: 'lesson',
            path: '/lesson',
            component: () => import('./components/Lesson/List.vue')
        },
        {
            name: 'lesson_detail',
            path: '/lesson/detail-:id',
            component: () => import('./components/Lesson/Detail.vue')
        },
        {
            name: 'news',
            path: '/news',
            component: () => import('./components/News/List.vue')
        },
        {
            name: 'news_content',
            path: '/news-content',
            component: () => import('./components/News/Detail.vue')
        },
        {
            name: 'admin',
            path: '/admin',
            component: () => import('./components/Admin/Index.vue')
        },
        {
            name: 'manage_lesson_edit',
            path: '/admin/lesson/edit-:id',
            component: () => import('./components/Admin/Lesson/Edit.vue')
        },
        {
            name: 'manage_lesson_add',
            path: '/admin/lesson/edit',
            component: () => import('./components/Admin/Lesson/Edit.vue')
        },
        {
            name: 'manage_lesson_list',
            path: '/admin/lesson',
            component: () => import('./components/Admin/Lesson/List.vue')
        }
    ]
}