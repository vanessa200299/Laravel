<style>
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
</style>
<template>
<div  class="table-wrapper">
    <button v-show="!formNew && !formEdit" @click="formNew=true">Nuevo</button>
    <table class="fl-table" v-show="!formNew && !formEdit">
        <thead>
            <tr>
                <td>#</td>
                <td>name</td>
                <td>status</td>
                <td>Options</td>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(service,index) in services" :key="index">
                <td>{{index+1}}</td>
                <td>{{service.name}}</td>
                <td>{{service.status}}</td>
                <td>
                    <button class="button" @click="showFormEdit(index)"> editar</button>
                    <button class="button" @click="deleteService(service.id)">borrar</button>
                </td>
            </tr>
        </tbody>
    </table>
    <div v-show="formNew">
        <form action="" v-on:submit.prevent="nuevoServicio()">
            <div>
                <label for="name">Nombre</label>
                <input type="text" name="name" id="name" v-model="name" required>
            </div>
            <div>
                <select name="status" id="status" v-model="status" required>
                    <option value="1">Activo</option>
                    <option value="0">Desactivado</option>
                </select>
            </div>
            <div>
                <button @click="formNew=false">Cancelar</button>
                <button type="submit">Guardar</button>
            </div>
        </form>
    </div>

    <div v-show="formEdit">
        <form action="" v-on:submit.prevent="actualizarServicio()">
            <div>
                <label for="name">Nombre</label>
                <input type="text" name="name" id="name" v-model="name" required>
            </div>
            <div>
                <select name="status" id="status" v-model="status" required>
                    <option value="1">Activo</option>
                    <option value="0">Desactivado</option>
                </select>
            </div>
            <div>
                <button @click="formEdit=false">Cancelar</button>
                <button type="submit">Guardar</button>
            </div>
        </form>
    </div>
</div>
</template>

<script>
export default {
    props: ['services_prop', 'user_prop'],
    data() {
        return {
            services: this.services_prop ? this.services_prop : [],
            name: '',
            status: 1,
            id: null,
            formNew: false,
            formEdit: false
        }
    },
    methods: {
        deleteService(id){
            let self = this;
            let data = {
                'id': id
            }

            axios.post("/deleteService", data)
                .then(function (response) {
                    self.services = response.data.services;
                    self.name = '';
                    self.status = null;
                    self.formNew = false;
                    self.formEdit = false;
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
        },
        showFormEdit(index) {
            let service = this.services[index];
            this.id = service.id;
            this.name = service.name;
            this.status = service.status;
            this.formEdit = true;
        },
        nuevoServicio() {
            let self = this;
            let data = {
                'name': this.name,
                'status': this.status,
                'user_id': this.user_prop.id
            }

            axios.post("/addService", data)
                .then(function (response) {
                    self.services = response.data.services;
                    self.name = '';
                    self.status = null;
                    self.formNew = false;
                    self.formEdit = false;
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
        },
        actualizarServicio() {
            let self = this;
            let data = {
                'id': this.id,
                'name': this.name,
                'status': this.status,
                'user_id': this.user_prop.id
            }

            axios.post("/updateService", data)
                .then(function (response) {
                    self.id = null;
                    self.services = response.data.services;
                    self.name = '';
                    self.status = null;
                    self.formNew = false;
                    self.formEdit = false;
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
