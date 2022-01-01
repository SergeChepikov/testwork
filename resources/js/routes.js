import Home from "./components/UserList";
import Login from "./components/Login";
import CreateUser from "./components/CreateUser";
import User from "./components/User";
import NotFound from "./components/NotFound";

export default [
    {path: '/', components: {default: Home, unAuth: Login}},
    {path: '/user/new', component: CreateUser},
    {path: '/user/:id', component: User},
    {path: '*', component: NotFound}
]
