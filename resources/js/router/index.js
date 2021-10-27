import {createRouter, createWebHistory} from 'vue-router'
import RegisterComponent from '../components/register-component'
import AuthorizeComponent from '../components/authorize-component'
import TableComponent from '../components/table-component'
import MyRoomsComponent from '../components/myrooms-component'
import newRoom from '../components/newRoom-component'
import NewTaskComponent from '../components/newTask-component'
import Home from "../views/Home";
import store from '../store/index'


const routes = [
    {
        path: '/my-rooms/:id',
        name: 'rooms',
        component: MyRoomsComponent,
        meta: {requiresAuth: true}
    },
    {
        path: '/create-room',
        name: 'new-room',
        component: newRoom,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/my-rooms/room/:id/',
        name: 'room',
        component: TableComponent,
        meta: {requiresAuth: true},
        children: [
            {
                path: 'new-task',
                name: 'new-task',
                component:NewTaskComponent,
                props:true,
                meta: {
                    requiresAuth: true
                }
            }
        ]
    },
    {
        path: '/auth',
        name: 'auth',
        component: AuthorizeComponent,
        meta: {unAuth: true}
    },
    {
        path: '/registration',
        name: 'registration',
        component: RegisterComponent,
        meta: {unAuth: true}
    },
    {
        path: '/',
        name: 'Home',
        component: Home,

    },
]

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes
})


router.beforeEach((to, from, next) => {

    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!store.getters.setUser) next('/')
        else next()
    } else if (to.matched.some(record => record.meta.unAuth)) {
        if (store.getters.setUser) next('/')
        else next()
    }
    next()
})


export default router
