<style>

   .login-user{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
    width: 400px;
   }
   .user{
    display: flex;
    -ms-flex-align: center;
    align-items: center;
    /*padding: .375rem .75rem;*/
    margin-bottom: 0;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    text-align: center;
    white-space: nowrap;
    background-color: #e9ecef;
    border: 1px solid #ced4da;
    border-radius: .25rem;
   }
   input{
    opacity: .5;
}
input:focus{
    opacity: 1;
}

.form-control{
        display: block;
    width: 100%;
    height: calc(1.5em + .75rem + 2px);
    padding: .375rem .75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}
   .icon-user{
        padding: 7px 7px;
        background-color: #ced4da;
   }

   /*REGISTRO UP*/
   .registro-up {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  z-index: 1;
  width: 436px;
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 3px 25px rgba(0, 0, 0, 0.2);
  overflow: hidden;
  display: flex;
}
.registro-modal{
    width: 100%;
    padding: 0px 13px;
}


.input-block {
	margin-bottom: 20px;
}

.input-block label {
	font-size: 14px;
  color: #040404;
}

.input-block input {
	display: block;
	width: 100%;
	margin-top: 8px;
	padding-right: 15px;
	padding-left: 15px;
	font-size: 16px;
	line-height: 40px;
	color: #3b4465;
  background: #eef9fe;
  border: 1px solid #cddbef;
  border-radius: 2px;
}

</style>
<template>
<div>
   <div>
       <ul>
           <li v-for="(message,index) in messages" :key="index">{{message}}</li>
       </ul>
   </div>
    <div class="login-user">
        <h2>Login user</h2>
        <form action="" v-show="formLogin" v-on:submit.prevent="login()">
            <div>
                <div class="user" style="margin-bottom: 1rem!important;"> 
                    <div class="icon-user">
                       <img src="icons/user.svg" alt="" >
                    </div>
                     <input class="form-control" type="text" name="email" id="email" placeholder="Correo-Electronico" v-model.trim="email" required>
                </div>
            </div>
            <div>
                <div class="user" style="margin-bottom: 1rem!important;">
                    <div class="icon-user" style="width:41px;">
                       <img src="icons/contrasena.svg" alt="" >
                    </div>
                    <input  class="form-control" type="password" name="pass" id="pass" placeholder="Contraseña" v-model.trim="password" required>
                </div>
            </div>
            <button class="button" type="submit">Entrar</button>
        </form>
        <button class="button" @click="switchForm()" v-show="formLogin">Registro</button>
    </div>
    <div class="registro-up">
        <form class="registro-modal" v-show="!formLogin" v-on:submit.prevent="nuevoUsuario()">
             <h2>REGISTRO DE USUARIO</h2>
            <div class="input-block">
                <label for="reg_name">Nombre</label>
                <input type="text" name="reg_name" id="reg_name" v-model.trim="name" required>
            </div>
            <div class="input-block">
                <label for="reg_mail">Correo</label>
                <input type="email" name="reg_mail" id="reg_mail" v-model.trim="email" required>
            </div>
            <div class="input-block">
                <label for="reg_pass">Contraseña</label>
                <input type="password" name="reg_pass" id="reg_pass" v-model.trim="password" required>
            </div>
            <div class="input-block">
                <label for="age">Edad</label>
                <input type="number" name="age" id="age" v-model.trim="age" required>
            </div>
            <div class="input-block">
                <label for="gender">Genero</label>
                <select name="gender" id="gender" v-model="gender">
                    <option value="M">Mujer</option>
                    <option value="H">Hombre</option>
                </select>
            </div>

            <button class="button" @click="switchForm()">Cancelar</button>
            <button class="button" type="submit">Registro</button>
        </form>
    </div>
</div>
</template>

<script>
export default {
    props: ['messages_prop'],
    data() {
        return {
            formLogin: true,
            name: '',
            email: '',
            password: '',
            age: null,
            gender: '',
            messages: this.messages_prop ? this.messages_prop : []
        }
    },
    methods: {
        switchForm() {
            this.formLogin = !this.formLogin;
        },
        nuevoUsuario() {
            let data = {
                'name': this.name,
                'email': this.email,
                'password': this.password,
                'age': this.age,
                'gender': this.gender
            };

            axios.post("/registrar", data)
                .then(function (response) {
                    this.password = '';
                    this.name = '';
                    this.formLogin = true;
                    alert(response.data.message);

                }).catch((e) => {
                    var res = e.response;
                    if (res) {
                        if (res.status == 422) {
                            var errors = Object.values(res.data);
                            errors.forEach(item => {
                                alert(item);
                            });
                        }
                    }
                });
        },
        login() {
            let data = {
                'email': this.email,
                'password': this.password
            }

            axios.post("/login", data)
                .then(function (response) {
                    window.location.href = "/redirect";
                }).catch((e) => {
                    var res = e.response;
                    if (res.status == 422) {
                        var errors = Object.values(res.data);
                        errors.forEach(item => {
                            alert(item);
                        });
                    }
                });
        }
    }
}
</script>


