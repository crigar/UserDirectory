<template>
    <div class="container">
        <div class="flex-center position-ref full-height" v-if="!isLoged">
            <div class="top-right links">
                <button v-on:click="loginActive = true;singup = false" class="btn btn-success">Login</button>
                <button v-on:click="singup = true;loginActive = false;" class="btn btn-info">Registrarse</button>
            </div>
        </div>
        <div class="flex-center position-ref full-height" v-if="isLoged">
            <div class="top-right links">
                <button v-on:click="load" class="btn btn-primary">Cargar Usuarios</button>
                <button v-on:click="removeAll" class="btn btn-warning">Eliminar todos los Usuarios</button>
                <button v-on:click="logout" class="btn btn-secondary">Logout</button>
            </div>
        </div>
        
        <div class="row justify-content-center" v-if="!isLoged && loginActive">
            <div class="col-md-8">
                    <form>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nombre de usuario (username)</label>
                            <input type="text" v-model="credentials.username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" v-model="credentials.pass" class="form-control" id="exampleInputPassword1" placeholder="">
                        </div>
                        
                        <button type="button" v-on:click="login" class="btn btn-primary">Log in</button>
                     </form>
                    
                </div>
            
                
            
        </div>
        
        <div class="row justify-content-center" v-if="isLoged">
            <br><br>
            <h3>Puede oprimir el boton Cargar Usuarios si desea agregar los usuarios del 
                siguiente <a href="http://www.mocky.io/v2/5d9f39263000005d005246ae?mocky-delay=10s" target="_blank">Enlace</a>
                a la base de datos
            </h3>
            <users></users>
        </div>

        <div class="row justify-content-center" v-if="!isLoged && singup">
            <singup></singup>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component .')
            if (localStorage.getItem('token')) {
                this.isLoged = true;
            }
        },
        data: function () {
            return {
                prueba: 0,
                credentials: {},
                isLoged: false,
                singup: false,
                loginActive: true
            }
        },
        methods: {
            login: function(){
                
                
                axios.post("http://localhost/UserDirectory/public/users/login", this.credentials).then((result) => {
                    console.log(result);
                    console.log(result.data.success);
                    if (result.data.success == true) {
                        localStorage.setItem('token', result.data.token);
                        this.isLoged = true;
                        let myToast = this.$toasted.show("Bienvenido!");
                        myToast.text("Bienvenido!!!").goAway(2000);
                    }else{
                        let myToast = this.$toasted.show("Bienvenido!");
                        myToast.text("Usuario incorrecto!!!").goAway(2000);
                    }
                    
                    //localStorage.getItem('YourItem')
                });

            },
            logout: function(){
                var token = {
                    token: localStorage.getItem('token')
                }
                axios.post("http://localhost/UserDirectory/public/users/logout", token).then((result) => {
                    console.log(result);
                    if (result.data.success == true) {
                        localStorage.removeItem('token')
                        this.isLoged = false;
                        let myToast = this.$toasted.show("Bienvenido!");
                        myToast.text("Sesion Cerrada!").goAway(2000);
                    }
                });
            },
            load: function(){
                axios.get("http://www.mocky.io/v2/5d9f39263000005d005246ae?mocky-delay=10s").then((result) => {
                    for (const user of result.data.objects) {
                        axios.get("http://localhost/UserDirectory/public/users/document/" +user.document ).then((result) => {
                            console.log("asdf")
                            console.log(result);
                            if (result.data.success == false) {
                                axios.post("http://localhost/UserDirectory/public/users/create", user).then((result) => {
                                    let myToast = this.$toasted.show("Bienvenido!");
                                    myToast.text("Usuario Creado!, documento: " + user.document).goAway(2000);
                                });
                            }else{
                                let myToast = this.$toasted.show("Bienvenido!");
                                myToast.text("El usuario con documento "+user.document+ " ya existe!"  ).goAway(2000);
                            }
                        })
                        
                    }
                    
                });
            },
            removeAll: function(){
                axios.get("http://localhost/UserDirectory/public/users/remove-users").then((result) => {
                    let myToast = this.$toasted.show("Bienvenido!");
                    myToast.text("Usuarios eliminados correctamente ").goAway(2000);
                    
                });
            }
        }

    }
</script>

<style  scoped>
     html, body {
        background-color: #fff;
        color: #636b6f;
        font-family: 'Nunito', sans-serif;
        font-weight: 200;
        height: 10vh;
        margin: 0;
    }

    .full-height {
        height: 10vh;
    }

    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
    }

    .position-ref {
        position: relative;
    }

    .top-right {
        position: absolute;
        right: 10px;
        top: 18px;
    }

    .content {
        text-align: center;
    }

    .title {
        font-size: 84px;
    }

    .links > a {
        color: #636b6f;
        padding: 0 25px;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: .1rem;
        text-decoration: none;
        text-transform: uppercase;
    }

    .m-b-md {
        margin-bottom: 30px;
    }
</style>
