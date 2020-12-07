<template>
    <div class="container-fluid row">
        <div class="col-md-4 col-lg-3">
            <filter-courses-component v-on:filter="updateCourses"></filter-courses-component>
        </div>
        <div class="col-md-8 col-lg-9 d-flex flex-wrap">
            <h1 class="w-100 text-center mt-3">Cursos</h1>
            <div class="card mt-4 widthCourse" v-for="course in courses" :key="course.id">
                <div class="card-body d-flex">
                    <img v-if="course.image" v-bind:src="course.image" alt="image" height="200" width="200">
                    <img v-else src="images/system/without_image.jpg" alt="image" height="200" width="200">
                    <div class="ml-5">
                        <h4><span class="badge badge-primary">{{getCategoryName(course.id_category)}}</span></h4>
                        <h3 class="card-title">{{course.name}}</h3>
                        <h4>Precio: ${{course.price}}</h4>
                        <h4>Duración en meses: {{course.duration}} </h4>
                        <p class="card-text">{{course.description}}</p>
                        <a :href="'cursos/' + course.id" class="btn btn-primary">Mas info</a>
                    </div>
                </div>
            </div>
            <div v-if="!courses.length">
                <h1>No hay cursos disponibles con el criterio de busqueda seleccionado!</h1>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                courses : [],
                categories : [],
            }
        },
        created(){
            axios.get('api/categories').then(res =>{
                this.categories = res.data;
            });
            axios.get('api/courses').then(res =>{
                this.courses = res.data;
            });
        },
        methods:{
            getCategoryName(id){
                return this.categories.find(category => category.id === id).name;
            },
            updateCourses(coursesFilter){
                this.courses = coursesFilter;
            }
        },
    }
</script>

<style scoped>
    .widthCourse{
        width:100%;
    }

    @media screen and (min-width: 1300px){
        .widthCourse{
            width:50%;
        }   
    }
</style>