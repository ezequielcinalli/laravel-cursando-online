<template>
<div class="container">
    <h1 class="text-center mt-3">Administrar categorias</h1>

    <form v-if="!editing" @submit.prevent="addCategory">
    <h2>Agregar categoria</h2>
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" name="name" v-model="category.name">
        </div>
        <div class="form-group">
            <label for="description">Descripcion</label>
            <input type="text" class="form-control" name="description" v-model="category.description">
        </div>
        <button type="submit" class="btn btn-success btn-block mb-5">Agregar</button>
    </form>

    <form v-else @submit.prevent="updateCategory">
    <h2>Editar categoria</h2>
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" name="name" v-model="category.name">
        </div>
        <div class="form-group">
            <label for="description">Descripcion</label>
            <input type="text" class="form-control" name="description" v-model="category.description">
        </div>
        <a @click="cancelUpdate" class="btn btn-danger btn-block mb-2">Cancelar</a>
        <button type="submit" class="btn btn-primary btn-block mb-5">Guardar</button>
    </form>

    <table class="table table-striped table-hover">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Nombre</th>
                <th scope="col">Descripcion</th>
                <th scope="col">Editar</th>
                <th scope="col">Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="category in categories" :key="category.id">
                <td class="align-middle">{{category.id}}</td>
                <td class="align-middle">{{category.name}}</td>
                <td class="align-middle">{{category.description}}</td>
                <td>
                    <button @click="showUpdate(category)" class="btn">
                        <img src="images/system/editar.png" alt="edit" />
                    </button>
                </td> 
                <td>
                    <button @click="deleteCategory(category)" class="btn">
                        <img src="images/system/eliminar.png" alt="delete" />
                    </button>
                </td> 
            </tr>
        </tbody>
    </table>
</div>         
</template>

<script>
    export default {
        data(){
            return{
                editing : false,
                categories : [],
                category: {name: '', description: ''}
            }
        },
        created(){
            axios.get('api/categories').then(res =>{
                this.categories = res.data;
            });
        },
        methods:{
            checkValues(){
                if(this.category.name == '' || this.category.description == ''){
                    alert("Los campos no pueden estar vacios!");
                    return false;
                }
                return true;
            },
            addCategory(){
                // if(this.checkValues()){
                    const category = {
                        name : this.category.name,
                        description : this.category.description
                    };
                    axios.post('api/categories', category)
                        .then(res =>{
                            this.categories.push(res.data);
                        })
                        .catch(error =>{
                            console.log("ERROR:" + error.response.data.message);
                        });
                    this.category.name= '';
                    this.category.description= '';
                // }
            },
            cancelUpdate(){
                this.editing = false;
                this.category = {name: '', description: ''};
            },
            showUpdate(category){
                this.editing = true;
                this.category.name = category.name;
                this.category.description = category.description;
                this.category.id = category.id;
            },
            updateCategory(){
                if(this.checkValues()){
                    const categoryToUpdate = {
                        name : this.category.name,
                        description : this.category.description
                    };
                    axios.put(`api/categories/${this.category.id}`, categoryToUpdate).then(res => {
                        const index = this.categories.findIndex(cat => cat.id === this.category.id);
                        this.categories.splice(index, 1, res.data);
                        this.editing = false;
                        this.category = {name: '', description: ''};
                    });
                }
            },
            deleteCategory(category){
                const confirmation = confirm("Eliminar la categoria?");
                if(confirmation){
                    axios.delete(`api/categories/${category.id}`).then(res =>{
                        const index = this.categories.indexOf(category);
                        this.categories.splice(index,1);
                    });
                }
            }
        }
    }
</script>
