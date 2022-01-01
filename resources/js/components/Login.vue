<template>
    <div class="form-block form-block__center">
        <form>
            <input v-model="email" class="input" placeholder="Email"/>
            <span class="error">&nbsp;{{ emailErrors.join(', ') }}</span>
            <input v-model="password" class="input" placeholder="Password" type="password"/>
            <span class="error">&nbsp;{{ passwordErrors.join(', ') }}</span>
            <button class="button" v-on:click="login">Login</button>
            <span class="error">&nbsp;{{ errorMessage }}</span>
        </form>
    </div>
</template>

<script>
export default {
    name: "Login",
    data: () => {
        return {
            email: "",
            password: "",
            emailErrors: [],
            passwordErrors: [],
            errorMessage: ""
        }
    },
    methods: {
        login() {
            this.clearErrors()
            axios
                .post('/api/login', { email: this.email, password: this.password })
                .then(response => this.processApiResponse(response))
                .catch(error => this.processApiError(error))
        },
        clearErrors() {
            this.emailErrors = this.passwordErrors = []
            this.errorMessage = ""
        },
        processApiResponse(response) {
            if (response.data.token) {
                this.$store.commit('setToken', response.data.token)
            } else {
                console.log(response)
            }
        },
        processApiError(error) {
            console.log(error)
            if (error.response.data.errors) {
                this.emailErrors = error.response.data.errors.email ?? []
                this.passwordErrors = error.response.data.errors.password ?? []
            } else if (error.response.data.message) {
                this.errorMessage = error.response.data.message
            } else {
                alert("Error: try again")
            }
        }
    }
}
</script>

<style scoped>
    .form-block {
        width: 500px;
        background-color: #b2bac4;
        height: 275px;
        padding: 15px;
        border-radius: 15px;
    }

    .form-block__center {
        margin: 25px auto;
    }

    .input {
        width: 100%;
        height: 50px;
        margin: 15px 0 0;
        text-align: center;
        border-radius: 15px;
        font-size: 25px;
    }

    .input:focus {
        outline: none;
    }

    .button {
        width: 250px;
        margin: 5px 110px;
        height: 50px;
        cursor: pointer;
        border-radius: 15px;
        font-size: 20px;
        color: #252525;
    }

    .error {
        color: red;
        font-size: 15px;
    }
</style>
