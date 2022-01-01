<template>
    <div>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            <tr v-for="user in users" :key="user.id">
                <td>{{ user.id }}</td>
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td><router-link :to="'/user/' + user.id">I</router-link></td>
                <td><a class="clickable" v-on:click="deleteUser(user.id)">X</a></td>
            </tr>
        </table>
    </div>
</template>

<script>
import {users} from "../api";

export default {
    name: "UserList",
    data: () => {
        return {
            users: []
        }
    },
    mounted() {
        this.updateList()
    },
    methods: {
        updateList() {
            users.index(this.$store.state.token, response => this.users = response.data)
        },
        deleteUser(id) {
            if (confirm("Вы действительно хотите удалить пользователя?")) {
                users.delete(id, this.$store.state.token, this.updateList)
            }
        }
    }
}
</script>
