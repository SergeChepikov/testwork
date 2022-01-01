export const users = {
    index(token, success = console.log, error = console.log) {
        axios.get("/api/users", {
            headers: {Authorization: "Bearer " + token}
        }).then(success).catch(error)
    },
    delete(id, token, success = console.log, error = console.log) {
        axios.delete("/api/users/" + id, {
            headers: {Authorization: "Bearer " + token}
        }).then(success).catch(error)
    },
    create(data, token, success = console.log, error = console.log) {
        axios.post("/api/users/", data, {
            headers: {Authorization: "Bearer " + token}
        }).then(success).catch(error)
    },
    update(id, data, token, success = console.log, error = console.log) {
        axios.put("/api/users/" + id, data, {
            headers: {Authorization: "Bearer " + token}
        }).then(success).catch(error)
    },
    get(id, token, success = console.log, error = console.log) {
        axios.get("/api/users/" + id, {
            headers: {Authorization: "Bearer " + token}
        }).then(success).catch(error)
    }
}
