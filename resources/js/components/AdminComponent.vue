<style>
    *{
    box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
}
.button {
    margin: 11px;
    border: 1px solid transparent;
    background: #16559a;
    color: rgb(250, 245, 245);
    padding: 8px 12px;
    font-size: 0.875em;
    font-weight: bold;
    position: relative;
    transition: background-color 0.5s;
    text-align: center;
    cursor: pointer;
}
body{
    font-family: Helvetica;
    -webkit-font-smoothing: antialiased;
}
h2{
    text-align: center;
    font-size: 18px;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: rgb(10, 10, 10);
    padding: 30px 0;
}

/* Table Styles */

.table-wrapper{
    margin: 10px 70px 70px;
    box-shadow: 0px 35px 50px rgba( 0, 0, 0, 0.2 );
}

.fl-table {
    border-radius: 5px;
    font-size: 12px;
    font-weight: normal;
    border: none;
    border-collapse: collapse;
    width: 100%;
    max-width: 100%;
    white-space: nowrap;
    background-color: white;
}

.fl-table td, .fl-table th {
    text-align: center;
    padding: 8px;
}

.fl-table td {
    border-right: 1px solid #f8f8f8;
    font-size: 12px;
}

.fl-table thead th {
    color: #ffffff;
    background: #4FC3A1;
}


.fl-table thead th:nth-child(odd) {
    color: #ffffff;
    background: #324960;
}

.fl-table tr:nth-child(even) {
    background: #F8F8F8;
}

/* Responsive */

@media (max-width: 767px) {
    .fl-table {
        display: block;
        width: 100%;
    }
    .table-wrapper:before{
        content: "Scroll horizontally >";
        display: block;
        text-align: right;
        font-size: 11px;
        color: white;
        padding: 0 0 10px;
    }
    .fl-table thead, .fl-table tbody, .fl-table thead th {
        display: block;
    }
    .fl-table thead th:last-child{
        border-bottom: none;
    }
    .fl-table thead {
        float: left;
    }
    .fl-table tbody {
        width: auto;
        position: relative;
        overflow-x: auto;
    }
    .fl-table td, .fl-table th {
        padding: 20px .625em .625em .625em;
        height: 60px;
        vertical-align: middle;
        box-sizing: border-box;
        overflow-x: hidden;
        overflow-y: auto;
        width: 120px;
        font-size: 13px;
        text-overflow: ellipsis;
    }
    .fl-table thead th {
        text-align: left;
        border-bottom: 1px solid #f7f7f9;
    }
    .fl-table tbody tr {
        display: table-cell;
    }
    .fl-table tbody tr:nth-child(odd) {
        background: none;
    }
    .fl-table tr:nth-child(even) {
        background: transparent;
    }
    .fl-table tr td:nth-child(odd) {
        background: #F8F8F8;
        border-right: 1px solid #E6E4E4;
    }
    .fl-table tr td:nth-child(even) {
        border-right: 1px solid #E6E4E4;
    }
    .fl-table tbody td {
        display: block;
        text-align: center;
    }
}
    thead{
        background-color: #c1c4c7;
    }
</style>
<template>
<div>
    <h2>Administrador</h2>
    <div class="table-wrapper" v-show="!showServices">
        <table class="fl-table">
            <thead>
                <tr>
                    <td>Nombre</td>
                    <td>Correo</td>
                    <td>Edad</td>
                    <td>Genero</td>
                    <td>Estatus</td>
                    <td>Opciones</td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(user, index) in users" :key="index">
                    <td>{{user.name}}</td>
                    <td>{{user.email}}</td>
                    <td>{{user.age}}</td>
                    <td>{{user.gender == 'H'? 'Hombre':'Mujer'}}</td>
                    <td>{{user.status ==1 ?'Activo':'Inactivo'}}</td>
                    <td>
                        <button class="button" @click="mostrarServicios(index)">Servicios</button>
                        <button class="button" @click="switchStatusUser(index)">{{user.status ==1 ?'Desactivar':'Activar'}}</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="table-wrapper" v-show="showServices">
        <table class="fl-table" v-if="services.length">
            <thead>
                <tr>
                    <td>name</td>
                    <td>status</td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(service, index) in services" :key="index">
                    <td>{{service.name}}</td>
                    <td>{{service.name ? 'Activo':'Inactivo'}}</td>
                </tr>
            </tbody>
        </table>
        <div v-else>
            <p>No hay Servicios asociados</p>
        </div>
        <button class="button" @click="showServices=false">Ver tabla</button>
    </div>
</div>
</template>

<script>
export default {
    props: ['users_prop'],
    data() {
        return {
            users: this.users_prop ? this.users_prop : [],
            showServices: false,
            services:[]
        }
    },
    methods: {
        mostrarServicios(index){
            this.services = this.users[index].services ? this.users[index].services:[];
            this.showServices = true;
        },
        switchStatusUser(index) {
            let user = this.users[index];
            let self = this;

            let data = {
                'status': !user.status,
                'id': user.id
            }

            this.users[index].status = !user.status

            let aux = this.users
            axios.post("/switchUser", data)
                .then(function (response) {
                    self.users = [];
                    self.users = aux;
                    alert(response.data.message);
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
