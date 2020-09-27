<template>
    <div class="container">
        <h1>Busqueda de Usuarios</h1>
        <div class="form-group">
            <label for="exampleInputEmail1"><strong>Parametro de busqueda (Busque sin parametro para traer todos)</strong></label>
            <input type="text" v-model="param.param" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="email o nombre, apellido">
            <br>
            <button type="button" v-on:click="search" class="btn btn-success">Buscar o recargar</button>
        </div>
        <div class="row">
            <div class="col-md-6">
                <table class="table">
                <thead class="thead-dark">
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">Documento</th>
                    <th scope="col">Email</th>
                    <th scope="col">Telefono</th>
                    <th scope="col">Cargo</th>
                    <th scope="col">Pais</th>
                    <th scope="col">Departamento</th>
                    <th scope="col">Ciudad</th>
                    <th scope="col">Usuario</th>
                    <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(user, index) of users">
                        <th scope="row">{{index + 1}}</th>
                        <td>{{user.first_name}}</td>
                        <td>{{user.last_name}}</td>
                        <td>{{user.document}}</td>
                        <td>{{user.email}}</td>
                        <td>{{user.phone_number}}</td>
                        <td>{{user.job_title}}</td>
                        <td>{{user.country}}</td>
                        <td>{{user.state}}</td>
                        <td>{{user.city}}</td>
                        <td>{{user.username}}</td>
                        <td>
                            <button type="button"  v-on:click="remove(user.id)" class="btn btn-danger">Eliminar</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            </div>
            
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            axios.get("http://localhost/UserDirectory/public/users/index").then((result) => {
                console.log(result.data);
                this.users = result.data;
            })
            
        },
        data: function () {
            return {
                users: null,
                param: {},
            }
        },
        methods: {
            search: function(){
                axios.post("http://localhost/UserDirectory/public/users/search", this.param).then((result) => {
                    console.log('asdf');
                    console.log(result);
                    this.users = result.data.users; 
                })
            },
            remove: function(id){
                console.log(id)
                axios.get("http://localhost/UserDirectory/public/users/destroy/" + id).then((result) => {
                    let myToast = this.$toasted.show("Bienvenido!");
                    myToast.text("Usuario eliminado!!!").goAway(2000);
                    this.search();
                })
            }
        }

    }
</script>
