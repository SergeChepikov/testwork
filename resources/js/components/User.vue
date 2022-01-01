<template>
    <div>
        <input v-model="name" placeholder="Name">
        <input v-model="email" placeholder="Email">
        <button v-on:click="saveUser">Save</button>
    </div>
</template>

<script>
import {users} from "../api";

export default {
    name: "User",
    data() {
        return {
            id: null,
            name: "",
            email: "",
        }
    },
    mounted() {
        this.clearData()
        if (this.$route.params.id) {
            users.get(this.$route.params.id, this.$store.state.token, this.setData)
        }
    },
    methods: {
        clearData() {
            this.id = null
            this.name = this.email = null
        },
        setData(response) {
            this.id = this.$route.params.id
            this.name = response.data.name
            this.email = response.data.email
        },
        saveUser() {
            let data = {name: this.name, email: this.email}
            users.update(this.$route.params.id, data, this.$store.state.token, this.afterSaveAction)
        },
        afterSaveAction() {
            alert("User updated")
            this.$router.push("/")
        }
    }
}
</script>

<style scoped>

</style>
