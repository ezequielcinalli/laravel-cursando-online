<template>
    <div class="container mt-5">
        <h1>Detalle del curso</h1>
        <div class="card-body d-flex">
            <div class="mx-auto d-flex">
                <img v-if="course.image" v-bind:src="course.image" alt="image" height="200" width="200">
                <img v-else src="images/system/without_image.jpg" alt="image" height="200" width="200">
                <div class="ml-5">
                    <h4><span class="badge badge-primary">{{getCategoryName(course.id_category)}}</span></h4>
                    <h3 class="card-title">{{course.name}}</h3>
                    <h4>Precio: ${{course.price}}</h4>
                    <h4>Duración en meses: {{course.duration}} </h4>
                    <p class="card-text">{{course.description}}</p>
                    <a href="cursos" class="btn btn-primary btn-block">Volver</a> 
                </div>
            </div>
        </div>

        <div class="card-header mb-3">
            <p class="h3">Comentarios</p>
        </div>
        <div v-for="comment in comments" :key="comment.id">
            <span class="text-warning" v-html="calculateTextStars(comment.score)"></span><small> ({{comment.score}} estrella{{comment.score > 1 ? 's': ''}})</small>
            <p>{{comment.content}}</p>
            <small class="text-muted mr-2">Autor: {{comment.email}} - Fecha: {{comment.date}}</small>
            <button v-if="admin" @click="deleteComment(comment)" class="btn btn-danger inline">Borrar comentario</button>
            <hr>
        </div>
        <div v-if="login">
            <div class="card-header">
                <p class="h3">Dejar un comentario</p>
            </div>
            <div class="card-body">
                <form @submit.prevent="addComment">
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="content">Contenido</label>
                        <input v-model="comment.content" type="text" name="content" class="form-control" required>
                    </div>
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="puntuacion">Puntuacion</label>
                        <select v-model="comment.score" class="custom-select" name="puntuacion" id="puntuacion">
                            <option :value="1" selected>1 estrella &#9733;</option>
                            <option :value="2">2 estrellas &#9733; &#9733;</option>
                            <option :value="3">3 estrellas &#9733; &#9733; &#9733;</option>
                            <option :value="4">4 estrellas &#9733; &#9733; &#9733; &#9733;</option>
                            <option :value="5">5 estrellas &#9733; &#9733; &#9733; &#9733; &#9733;</option>
                        </select>
                        <button type="submit" class="btn btn-success w-25">Comentar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['course', 'login', 'admin'],
        data(){
            return{
                comment: {content: '', score: 3},
                categories: [],
                comments : [],
            }
        },
        created(){
            console.log("LOGIN: "+this.login);
            console.log("ADMIN: "+this.admin);
            axios.get('api/categories').then(res =>{
                this.categories = res.data;
            });
            axios.get('api/courses').then(res =>{
                this.courses = res.data;
            });
             axios.get(`api/comments/${this.course.id}`).then(res =>{
                this.comments = res.data;
            });
        },
        methods:{
            getCategoryName(id){
                if(this.categories.length > 0)
                    return this.categories.find(category => category.id === id).name;
                return "Categoria";
            },
            calculateTextStars(quantityStars){
                let textStars = "";
                for (let i = 1; i <= quantityStars; i++) {
                    textStars += " &#9733;";
                }
                for (let i = 1; i <= 5 - quantityStars; i++) {
                    textStars += " &#9734;";
                }
                return textStars;
            },
            addComment(){
                const comment = {
                    content: this.comment.content,
                    score: this.comment.score,
                    id_course: this.course.id,
                }
                axios.post('api/comments', comment)
                    .then(res=>{
                        console.log(res.data);
                        this.comments.push(res.data);
                    })
                    .catch(error=>{
                        console.log(error.response);
                    });
            },
            updateComment(){
                console.log("TODO: update");
            },
            deleteComment(comment){
                axios.delete(`api/comments/${comment.id}`).then(res =>{
                    const index = this.comments.indexOf(comment);
                    this.comments.splice(index, 1);
                });
            }
        },
    }
</script>