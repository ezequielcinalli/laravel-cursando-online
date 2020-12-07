<template>
    <div>
        <h1>Filtrar por</h1>
        <form method="GET" @submit.prevent="checkFilter($event)">
            <select @change="changeSelect($event)" name="filter" id="selectFilter" class="custom-select mb-3">
                <option value="no-filter">Sin filtro</option>
                <option value="name">Nombre</option>
                <option value="duration">Duracion</option>
                <option value="price">Precio</option>
            </select>
            <input v-if="inputText===true" id="inputName" type="text" name="name" placeholder="Busqueda..." class="w-100 mb-3">
            <template v-if="inputNumber===true">
                Min<input id="inputMin" type="number" name="min" value="0" class="w-100 mb-3">
                Max<input id="inputMax" type="number" name="max" value="0" class="w-100 mb-3">
            </template>

            <button type="submit" class="btn btn-primary btn-block">Filtrar</button>
        </form>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                inputText:false,
                inputNumber:false,
            }
        },
        methods:{
            changeSelect(e){
                const valueSelect = e.target.value
                switch(valueSelect){
                    case 'no-filter':
                        this.inputText=false;
                        this.inputNumber=false;
                        break;
                    case 'name':
                        this.inputText=true;
                        this.inputNumber=false;
                        break;
                    case 'price': case 'duration':
                        this.inputText=false;
                        this.inputNumber=true;
                        break;
                }
            },
            checkFilter(e){ 
                let url = 'api/courses?';
                if(this.inputText){
                    const name = document.querySelector("#inputName");
                    if(name.value == '') 
                        return false;
                    url+='filter=name&name='+name.value;
                }
                if(this.inputNumber){
                    const min = document.querySelector("#inputMin");
                    const max = document.querySelector("#inputMax");
                    const filter = document.querySelector("#selectFilter").value;
                    if(isNaN(min.value) && isNaN(max.value)){
                        return false;
                    }
                    if(min.value<=0 && max.value<=0){
                        return false;
                    }
                    if(!isNaN(min.value) && min.value>0 && !isNaN(max.value) && max.value>0){
                        url+='filter='+filter+'&min='+min.value+'&max='+max.value;
                    }
                    else if(!isNaN(min.value) && min.value>0){
                        url+='filter='+filter+'&min='+min.value;
                    }
                    else if(!isNaN(max.value) && max.value>0){
                        url+='filter='+filter+'&max='+max.value;
                    }
                }
                axios.get(url).then(res =>{
                    this.$emit('filter', res.data);
                });
            }
        }
    }
</script>

