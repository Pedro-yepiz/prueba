<template>
    <div class="container">
        <template v-if="formulario == 0">
            <button type="button" class="btn btn-primary btn-sm" @click="formularioEmp()">Agregar empleado</button>
            <hr>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Opciones</th>
                        <th scope="col">id</th>
                        <th scope="col">Codigo</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido paterno</th>
                        <th scope="col">Apellido materno</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Tipo contrato</th>
                        <th scope="col">estatus</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="emp in arrayEmp" :key="emp.id">
                        <td>
                            <button @click="verDetalle(emp)" type="button" class="btn btn-secondary btn-sm">Detalles</button>
                            <button @click="editEmp(emp)" type="button" class="btn btn-secondary btn-sm">Editar</button>
                            <button v-if="emp.activo" @click="desactivarEmp(emp.id)"   type="button"  class="btn btn-danger btn-sm"> Desactivar</button>
                            <button v-else @click="activarEmp(emp.id)"   type="button"  class="btn btn-success btn-sm"> Activar</button>
                            <button @click="eliminaEmp(emp.id)" type="button" class="btn btn-warning btn-sm">Eliminar</button>
                        </td>
                        <td v-text="emp.id"></td>
                        <td v-text="emp.codigo"></td>
                        <td v-text="emp.nombre"></td>
                        <td v-text="emp.apellido_paterno"></td>
                        <td v-text="emp.apellido_materno"></td>
                        <td v-text="emp.correo"></td>
                        <td v-text="emp.tipo_contrato"></td>
                        <td>
                            <span v-if="emp.activo" class="badge badge-success">Activo</span>
                            <span v-else class="badge badge-danger">Inactivo</span>
                        </td>
                    </tr>
                </tbody>
            </table>
         </template>
         <template v-else-if="formulario == 2">
             <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{nombre}} {{apellido_p}}  {{apellido_m}}</h5>
                    <p class="card-text">Codigo: <strong>{{codigo}}</strong></p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Correo electronico:  <strong>{{correo}}</strong></li>
                    <li class="list-group-item">Tipo de contrato: <strong>{{tipo}}</strong> </li>
                </ul>
                <div class="card-body">
                   <button type="button" class="btn btn-danger btn-sm" @click="regresaTbla()">Regresar</button>
                </div>
              </div>
         </template>
         <template v-else>
            <form @submit.prevent="guardarInfo">            
               <div class="form-group">
                    <label for="exampleInputEmail1">Codigo</label>
                    <input type="text" class="form-control" v-model="codigo" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Nombre</label>
                    <input type="text" class="form-control" v-model="nombre" required>
                </div>
                 <div class="form-group">
                    <label for="exampleInputPassword1">Apellido paterno</label>
                    <input type="text" class="form-control" v-model="apellido_p" required>
                </div>
                 <div class="form-group">
                    <label for="exampleInputPassword1">Apellido materno</label>
                    <input type="text" class="form-control" v-model="apellido_m" required>
                </div>
                 <div class="form-group">
                    <label for="exampleInputPassword1">Correo</label>
                    <input type="email" class="form-control" v-model="correo" required>
                </div>
                 <div class="form-group">
                    <label for="exampleInputPassword1">Tipo contrado</label>
                    <input type="text" class="form-control" v-model="tipo" required>
                </div>
                 <button type="submit" class="btn btn-success btn-sm" >Enviar</button>
                 <button type="button" class="btn btn-danger btn-sm" @click="regresaTbla()">Regresar</button>
              </form>
         </template>
    </div>
</template>
<script>
    export default {
        data(){
            return{
                arrayEmp:[],
                formulario:0,
                codigo:'',
                nombre:'',
                apellido_p:'',
                apellido_m:'',
                correo:'',
                tipo:'',
                idactualida:0
            }
        },
        methods:{
            listarEmpleado(){
                let me = this;
                axios.get('/empleado').then(response =>{
                    me.arrayEmp = response.data.empleados
                }).catch(error => {
                    console.log(error);
                });
            },
            formularioEmp(){
                let me = this;
                me.formulario = 1
            },
            guardarInfo(){
                let me = this;
                axios.post('/empleado/store',{
                    'codigo':me.codigo,
                    'nombre':me.nombre,
                    'apellidop':me.apellido_p,
                    'apellidom':me.apellido_m,
                    'correo':me.correo,
                    'tipo':me.tipo,
                    'id': me.idactualida,
                }).then(function (response){
                    me.idactualida = 0;
                    me.codigo = '';
                    me.nombre = '';
                    me.apellido_p = '';
                    me.apellido_m = '';
                    me.correo = '';
                    me.tipo = '';
                    me.formulario = 0;
                    me.listarEmpleado();                    
                }).catch(function(response){
                    console.log(error);
                });
            },
            regresaTbla(){
                let me = this;
                me.formulario = 0;
            },
            desactivarEmp(id){
               let me = this;
                axios.put('/empleado/desactivar',{
                     'id': id
                }).then(function (response) {
                    me.listarEmpleado();
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            activarEmp(id){
               let me = this;
                axios.put('/empleado/activar',{
                        'id': id
                }).then(function (response) {
                    me.listarEmpleado();
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            editEmp(data = []){
                let me = this;
                me.formulario = 1;
                me.idactualida = data['id'];
                me.codigo = data['codigo'];
                me.nombre = data['nombre'];
                me.apellido_p = data['apellido_paterno'];
                me.apellido_m = data['apellido_materno'];
                me.correo = data['correo'];
                me.tipo = data['tipo_contrato'];
            },
            verDetalle(data = []){
                let me = this;
                me.formulario = 2;
                me.codigo = data['codigo'];
                me.nombre = data['nombre'];
                me.apellido_p = data['apellido_paterno'];
                me.apellido_m = data['apellido_materno'];
                me.correo = data['correo'];
                me.tipo = data['tipo_contrato'];
            },
            eliminaEmp(id){
              let me = this;
                axios.put('/empleado/elimina',{
                        'id': id
                }).then(function (response) {
                    me.listarEmpleado();
                }).catch(function (error) {
                    console.log(error);
                }); 
            }
        },
        mounted(){
            this.listarEmpleado();
        }
       
    }
</script>
