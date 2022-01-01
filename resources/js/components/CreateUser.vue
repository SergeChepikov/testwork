<template>
    <div>
        <input v-model="name" placeholder="Name">
        <input v-model="email" placeholder="Email">
        <input v-model="password" placeholder="Password" type="password">
        <button v-on:click="createUser">Create</button>
    </div>
</template>

<script>
import {users} from "../api";

export default {
    name: "CreateUser",
    data() {
        return {
            id: null,
            name: "",
            email: "",
            password: ""
        }
    },
    methods: {
        createUser() {
            let data = {name: this.name, email: this.email, password: this.password}
            users.create(data, this.$store.state.token, this.successResponse)
        },
        successResponse() {
            alert("User created")
            this.$router.push("/")
        }
    }
}
</script>

<style scoped>

</style>
