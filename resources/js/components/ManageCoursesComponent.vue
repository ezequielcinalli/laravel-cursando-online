<template>
<div class="container">
    <h1 class="text-center mt-3">Administrar cursos</h1>

    <form v-if="!editing" @submit.prevent="addCourse" enctype="multipart/form-data">
    <h2>Agregar curso</h2>
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" name="name" v-model="course.name">
        </div>
        <div class="form-group">
            <label for="description">Descripcion</label>
            <input type="text" class="form-control" name="description" v-model="course.description">
        </div>
        <div class="form-group">
            <label for="price">Precio</label>
            <input type="number" class="form-control" name="price" v-model="course.price">
        </div>
        <div class="form-group">
            <label for="duration">Duracion</label>
            <input type="number" class="form-control" name="duration" v-model="course.duration">
        </div>
        <div class="form-group">
            <label for="id_category">Categoria</label>
            <select class="form-control" name="id_category" v-model="course.id_category">
                <option v-for="category in categories" :key="category.id" :value="category.id">
                   {{category.name}}
                </option> 
            </select>
        </div>
         <div class="form-group">
            <label for="image">Imagen</label>
            <input @change="setImage" id="image" type="file" class="ml-3" name="image" accept="image/*">
        </div>
        <img v-if="course.image" :src="course.image" alt="imagen" height="200" class="mb-3">
        <button type="submit" class="btn btn-success btn-block mb-2">Agregar</button>
        <div v-if="error" class="alert alert-danger">Ya existe un curso con ese nombre!</div>
    </form>

    <form v-else @submit.prevent="updateCourse">
    <h2>Editar curso</h2>
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" name="name" v-model="course.name">
        </div>
        <div class="form-group">
            <label for="description">Descripcion</label>
            <input type="text" class="form-control" name="description" v-model="course.description">
        </div>
        <div class="form-group">
            <label for="price">Precio</label>
            <input type="number" class="form-control" name="price" v-model="course.price">
        </div>
        <div class="form-group">
            <label for="duration">Duracion</label>
            <input type="number" class="form-control" name="duration" v-model="course.duration">
        </div>
        <div class="form-group">
            <label for="id_category">Categoria</label>
            <select class="form-control" name="id_category" v-model="course.id_category">
                <option v-for="category in categories" :key="category.id" :value="category.id">
                   {{category.name}}
                </option> 
            </select>
        </div>
         <div class="form-group">
            <label for="image">Imagen</label>
            <input @change="setImage" id="imageUpdate" type="file" class="ml-3" name="image" accept="image/*">
        </div>
        <img v-if="course.image" :src="course.image" alt="imagen" height="200" class="mb-3">
        <a @click="cancelUpdate" class="btn btn-danger btn-block mb-2">Cancelar</a>
        <button type="submit" class="btn btn-primary btn-block mb-2">Guardar</button>
        <div v-if="error" class="alert alert-danger">Ya existe un curso con ese nombre!</div>
    </form>

    <table class="table table-striped table-hover mt-5">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Imagen</th>
                <th scope="col">Id</th>
                <th scope="col">Nombre</th>
                <th scope="col">Descripcion</th>
                <th scope="col">Precio</th>
                <th scope="col">Duracion</th>
                <th scope="col">Categoria</th>
                <th scope="col">Editar</th>
                <th scope="col">Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="course in courses" :key="course.id">
                <td class="align-middle">
                    <img v-bind:src="course.image" alt="image" width="128">
                </td>
                <td class="align-middle">{{course.id}}</td>
                <td class="align-middle">{{course.name}}</td>
                <td class="align-middle">{{course.description}}</td>
                <td class="align-middle">{{course.price}}</td>
                <td class="align-middle">{{course.duration}}</td>
                <td class="align-middle">{{course.id_category}} - {{categoryName(course.id_category)}}</td>
                <td>
                    <button @click="showUpdate(course)" class="btn">
                        <img src="images/system/editar.png" alt="edit" />
                    </button>
                </td> 
                <td>
                    <button @click="deleteCourse(course)" class="btn">
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
                courses : [],
                categories : [],
                course: {name: '', description: '', price: 0, duration: 0, id_category: 0, image:''},
                error: false,
            }
        },
        created(){
            axios.get('api/categories').then(res =>{
                this.categories = res.data;
                if(this.categories.length > 0){
                    this.course.id_category = this.categories[0].id;
                }
            });
            axios.get('api/courses').then(res =>{
                this.courses = res.data;
            });
        },
        methods:{
            categoryName(id){
                return this.categories.find(category => category.id === id).name;
            },
            setImage(e){
                this.course.image = URL.createObjectURL(e.target.files[0]);
            },
            checkValues(){
                if(this.course.name == '' || this.course.description == ''){
                    alert("Los campos no pueden estar vacios!");
                    return false;
                }
                if(isNaN(this.course.price == '') || isNaN(this.course.duration == '')){
                    alert("Los campos precio y duracion deben ser numericos!");
                    return false;
                }
                return true;
            },
            addCourse(){
                if(this.checkValues()){
                    const img = document.querySelector("#image").files[0];
                    const course = new FormData();
                    course.append('name', this.course.name);
                    course.append('description', this.course.description);
                    course.append('price', this.course.price);
                    course.append('duration', this.course.duration);
                    course.append('id_category', this.course.id_category);
                    course.append('image', img);
                    axios.post('api/courses', course)
                        .then(res =>{
                            this.error=false;
                            this.courses.push(res.data);
                            this.course.name = '';
                            this.course.description = '';
                            this.course.price = 0;
                            this.course.duration = 0;
                            this.course.id_category = 0;
                        })
                        .catch(error =>{
                            this.error=true;
                            console.log("ERROR:" + error.response.data.message);
                            console.log(error.response);
                        });
                }
            },
            cancelUpdate(){
                this.editing = false;
                this.error = false;
                this.course = {name: '', description: '', price: 0, duration: 0, id_category: 0};
            },
            showUpdate(course){
                this.editing = true;
                this.course.name = course.name;
                this.course.description = course.description;
                this.course.price = course.price;
                this.course.duration = course.duration;
                this.course.id_category = course.id_category;
                this.course.image = course.image;
                this.course.id = course.id;
            },
            updateCourse(){
                if(this.checkValues()){
                    const img = document.querySelector("#imageUpdate").files[0];
                    const courseToUpdate = new FormData();
                    courseToUpdate.append('name', this.course.name);
                    courseToUpdate.append('description', this.course.description);
                    courseToUpdate.append('price', this.course.price);
                    courseToUpdate.append('duration', this.course.duration);
                    courseToUpdate.append('id_category', this.course.id_category);
                    courseToUpdate.append("_method", "put");
                    courseToUpdate.append('image', img);

                    axios.post(`api/courses/${this.course.id}`, courseToUpdate).then(res => {
                        const index = this.courses.findIndex(cat => cat.id === this.course.id);
                        this.courses.splice(index, 1, res.data);
                        this.editing = false;
                        this.course = {name: '', description: '', price: 0, duration: 0, id_category: 0};
                    })
                    .catch(error =>{
                        console.log(error.response.data);
                        console.log(error);
                    });
                }
            },
            deleteCourse(course){
                const confirmation = confirm("Eliminar el curso?");
                if(confirmation){
                    axios.delete(`api/courses/${course.id}`).then(res =>{
                        const index = this.courses.indexOf(course);
                        this.courses.splice(index,1);
                    })
                    .catch(error=>{
                        console.log(error.response.data);
                        console.log(error);
                    });
                }
            }
        }
    }
</script>
