<template>
    <div class="container">
        <template v-if="formulario == 0">
            <button type="button" class="btn btn-primary btn-sm" @click="formularioEmp()">Agregar empleado</button>
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
                        <td v-text="emp.id"></td>
                        <td v-text="emp.codigo"></td>
                        <td v-text="emp.nombre"></td>
                        <td v-text="emp.apellido_paterno"></td>
                        <td v-text="emp.apellido_materno"></td>
                        <td v-text="emp.correo"></td>
                        <td v-text="emp.tipo_contrato"></td>
                    </tr>
                </tbody>
            </table>
         </template>
         <template v-else>
               <div class="form-group">
                    <label for="exampleInputEmail1">Codigo</label>
                    <input type="text" class="form-control" v-model="codigo">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Nombre</label>
                    <input type="text" class="form-control" v-model="nombre" >
                </div>
                 <div class="form-group">
                    <label for="exampleInputPassword1">Apellido paterno</label>
                    <input type="text" class="form-control" v-model="apellido_p">
                </div>
                 <div class="form-group">
                    <label for="exampleInputPassword1">Apellido materno</label>
                    <input type="text" class="form-control" v-model="apellido_m">
                </div>
                 <div class="form-group">
                    <label for="exampleInputPassword1">Correo</label>
                    <input type="text" class="form-control" v-model="correo">
                </div>
                 <div class="form-group">
                    <label for="exampleInputPassword1">Tipo contrado</label>
                    <input type="text" class="form-control" v-model="tipo">
                </div>
                <button type="button" class="btn btn-success btn-sm" @click="guardarInfo()">Guardar</button>
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
                tipo:''
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
                    'tipo':me.tipo
                }).then(function (response){
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
            }
        },
        mounted(){
            this.listarEmpleado();
        }
       
    }
</script>
