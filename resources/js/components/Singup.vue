<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                    <form>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nombre</label>
                            <input type="text" v-model="user.first_name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Apellido</label>
                            <input type="text" v-model="user.last_name" class="form-control" id="exampleInputPassword1" >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="email" v-model="user.email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">documento</label>
                            <input type="number" v-model="user.document" class="form-control" id="exampleInputPassword1" >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Telefono</label>
                            <input type="text" v-model="user.phone_number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Cargo</label>
                            <input type="text" v-model="user.job_title" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Pais</label>
                            <input type="text" v-model="user.country" class="form-control" id="exampleInputPassword1" >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Departamento</label>
                            <input type="text" v-model="user.state" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Ciudad</label>
                            <input type="text" v-model="user.city" class="form-control" id="exampleInputPassword1" >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Username</label>
                            <input type="text" v-model="user.username" class="form-control" id="exampleInputPassword1" >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" v-model="user.pass" class="form-control" id="exampleInputPassword1" >
                        </div>
                        <button type="button" v-on:click="singup" class="btn btn-primary">Registrarse</button>
                     </form>
                    
                </div>
                
            
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component .')
        },
        data: function () {
            return {
                prueba: 0,
                user: {},
            }
        },
        methods: {
            singup: function(){
                console.log(this.credentials)
                axios.post("http://localhost/UserDirectory/public/users/create", this.user).then((result) => {
                    console.log(result);
                    let myToast = this.$toasted.show("Bienvenido!");
                    myToast.text("Usuario Creado!").goAway(2000);
                });

            }
        }

    }
</script>
