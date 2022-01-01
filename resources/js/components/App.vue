<template>
    <div class="container">
        <div class="navbar">
            <router-link to="/" class="navbar-item navbar-item__brand">App</router-link>
            <router-link v-if="isLoggedIn" to="/user/new" class="navbar-item">Create new user</router-link>
            <a v-if="isLoggedIn" v-on:click="logout" class="navbar-item navbar-item__right navbar-item__clicked">Logout</a>
        </div>
        <router-view v-if="isLoggedIn"></router-view>
        <router-view name="unAuth" v-if="!isLoggedIn"></router-view>
    </div>
</template>

<script>
export default {
    name: "App",
    components: {},
    methods: {
        logout() {
            this.$store.commit('clearToken')
        }
    },
    computed: {
        isLoggedIn() {
            return this.$store.state.token !== ""
        }
    }
}
</script>

<style scoped>
.container {
    width: 100%;
    margin: 0;
}

.navbar {
    height: 60px;
    background-color: #3b3f41;
    color: white;
    width: 100%;
}

.navbar-item {
    line-height: 60px;
    margin: 0 15px;
}

.navbar-item__brand {
    font-size: 25px;
}

.navbar-item__right {
    float: right;
}

.navbar-item__clicked {
    cursor: pointer;
}
</style>
