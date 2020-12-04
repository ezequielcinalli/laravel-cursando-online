<template>
    <div class="container-fluid row">
        <div class="col-md-6 col-lg-3">
            <aside-courses-component></aside-courses-component>
        </div>
        <div class="col-md-6 col-lg-9">
            <h1>Cursos</h1>
            <div class="card mt-4" v-for="course in courses" :key="course.id">
                <div class="card-body d-flex">
                    <img v-bind:src="course.image" alt="image">
                    <div class="ml-5">
                        <h4><span class="badge badge-primary">{{course.id_category}}</span></h4>
                        <h3 class="card-title">{{course.name}}</h3>
                        <h3 class="card-title">{{course.image}}</h3>
                        <h4>Precio: ${{course.price}}</h4>
                        <h4>Duración en meses: {{course.duration}} </h4>
                        <p class="card-text">{{course.description}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                courses : [],
            }
        },
        created(){
            axios.get('api/courses').then(res =>{
                this.courses = res.data;
            });
        }
    }
</script>