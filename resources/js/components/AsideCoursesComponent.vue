<template>
    <div>
        <h1>Filtrar por</h1>
        <form @submit.prevent="filtrar()">
            <select name="filtro" class="custom-select mb-3">
                <option value="no-filter">Sin filtro</option>
                <option value="name">Nombre</option>
                <option value="duration">Duracion</option>
                <option value="price">Precio</option>
            </select>
            <input v-if="true" type="text" name="name" placeholder="Busqueda..." class="w-100 mb-3">
            <button type="submit" class="btn btn-primary btn-block">Filtrar</button>
        </form>
    </div>
</template>

<script>
    export default {
        methods:{
            filtrar(){
                console.log("entro al filtro");
            }
        }
    }
</script>

