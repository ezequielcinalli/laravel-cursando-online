<template>
    <table class="table table-striped table-hover">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Email</th>
                <th scope="col">Nombre</th>
                <th scope="col">Administrador</th>
                <th scope="col">Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="user in users" :key="user.id">
                <td class="align-middle">{{user.email}}</td>
                <td class="align-middle">{{user.name}}</td>
                <td>
                    <button @click="unsetAdmin(user)" v-if="user.admin" class="btn btn-success">SI</button>
                    <button @click="setAdmin(user)" v-else class="btn btn-danger">NO</button>
                </td>
                <td>
                    <button @click="deleteUser(user)" class="btn">
                        <img src="images/system/eliminar.png" alt="eliminar" />
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
       
       
</template>

<script>
    export default {
        data(){
            return{
                users : [],
            }
        },
        created(){
            axios.get('api/users').then(res =>{
                this.users = res.data;
            });
        },
        methods:{
            setAdmin(user){
                axios.put(`api/users/setAdmin/${user.id}`).then(res =>{
                    user.admin = 1;
                    console.log(res);
                    console.log(res.data);
                });
            },
            unsetAdmin(user){
                axios.put(`api/users/unsetAdmin/${user.id}`).then(res =>{
                    user.admin = 0;
                });
            },
            deleteUser(user){
                const confirmation = confirm("Eliminar el usuario?");
                if(confirmation){
                    axios.delete(`api/users/${user.id}`).then(res =>{
                        const index = this.users.indexOf(user);
                        this.users.splice(index,1);
                    });
                }
            }
        }
    }
</script>
