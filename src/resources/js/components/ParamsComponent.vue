<template>
    <div class="row">
        <div class="col-12">
            <div class="card" v-for="(units, typeIndex, tI) in this.available ">
            <form method="post">
                <div class="card-header">
                    <h2>{{ typeIndex }}</h2>
                </div>
                <div class="card-body">
                    <div class="my-3" v-for="(unit, unitIndex) in units">
                        <template  v-if="unit['names'].length">
                            <p><b>{{ unit.title }}:</b></p>
                            <template v-if="! unit.demonstrated">
                                <div class="d-flex flex-wrap">
                                    <div class="form-control w-auto me-2 mb-2" v-for="(name, nameIndex) in unit.names">
                                        <label class="form-label" :for="'type'+tI+'param'+name['id']">
                                            {{ name['title'] }} <small class="text-secondary">/ {{ name['name'] }}</small>
                                            <span class="text-danger" v-if="!! name['expected_at']">*</span>
                                        </label>
                                        <input  v-if="name['value_type'] !== 'bool'"
                                                :class="'form-control '"
                                                :id="'type'+tI+'param'+name['id']"
                                                ref="paramInput"
                                                :name="'param_'+name['id']"
                                                :type="name['value_type']"
                                                :required="!! name['expected_at']"
                                                :min="name['value_type'] === 'number' ? 0: null"
                                                :value="name['values'][0]?.value ??''"
                                                @input="updateDataValues(name['values'][0]?.id ??false,name['values'][0]? name['values'][0]: name['values'], $event.target.value)"
                                                @change="setInputValue(name['values'][0]?.id ??false, name['id'],0,$event.target.value)"
                                        >
                                        <select v-else class="form-select"
                                                :id="'type'+tI+'param'+name['id']"
                                                :name="'param_'+name['id']"
                                                ref="paramInput"
                                                @change="updateDataValues(name['values'][0]?.id ??false,name['values'][0]? name['values'][0]: name['values'], $event.target.value);setInputValue(name['values'][0]?.id ??false, name['id'],0,$event.target.value)"

                                        >
                                            <option v-if="! name['expected_at']" value="">-</option>
                                            <option value="true" :selected="(name['values'][0] && name['values'][0].value ==='true')? true :null">Да</option>
                                            <option value="false" :selected="(name['values'][0] && name['values'][0].value ==='false')? true :null">Нет</option>
                                        </select>
                                    </div>
                                </div>
                                <hr>
                            </template>

                           <template v-else-if="this.inputSets[typeIndex][unit.id]" >
                               <template v-for="(i, setIndex) in this.inputSets[typeIndex][unit.id]">
                                   <div class="d-flex flex-wrap">
                                       <div class="form-control w-auto me-2 mb-2" v-for="(name, nameIndex) of unit.names">
                                           <label class="form-label" :for="'type'+typeIndex+'unit'+(unit.id)+'param'+name['id']+'_'+i">
                                               {{ name['title'] }} <small class="text-secondary">/ {{ name['name'] }}</small>
                                               <span class="text-danger" v-if="!! name['expected_at']">*</span>
                                           </label>
                                           <input v-if="name['value_type'] !== 'bool'" class="form-control"
                                                  :id="'type'+typeIndex+'unit'+(unit.id)+'param'+name['id']+'_'+i"
                                                  :type="name['value_type']"
                                                  :name="'unit_'+unit.id+'param_'+name['id']"
                                                  :value="name['values'][setIndex]?.value ??''"
                                                  :min="name['value_type'] === 'number' ? 0: null"
                                                  :required="!! name['expected_at']"
                                                  @input="updateDataValues(name['values'][setIndex]?.id ??false,name['values'][setIndex]? name['values'][setIndex]: name['values'], $event.target.value)"
                                                  @change="setInputValue(name['values'][setIndex]?.id ??false, name['id'],setIndex,$event.target.value)"
                                           >

                                           <select v-else class="form-select"
                                                   :id="'type'+typeIndex+'unit'+(unit.id)+'param'+name['id']+'_'+i"
                                                   :name="'unit_'+unit.id+'param_'+name['id']"
                                                   @change="updateDataValues(name['values'][setIndex]?.id ??false,name['values'][setIndex]? name['values'][setIndex]: name['values'], $event.target.value);setInputValue(name['values'][setIndex]?.id ??false, name['id'],setIndex,$event.target.value)"
                                           >
                                               <option v-if="! name['expected_at']" value="">-</option>
                                               <option value="true" :selected="(name['values'][setIndex] && name['values'][setIndex].value ==='true')? true :null">Да</option>
                                               <option value="false" :selected="(name['values'][setIndex] && name['values'][setIndex].value ==='false')? true :null">Нет</option>
                                           </select>
                                       </div>
                                       <div class="d-flex flex-column">
                                           <button v-if="setIndex!==0 && setIndex === this.inputSets[typeIndex][unit.id].length -1" title="Удалить" class="btn-close"
                                                   @click.prevent="deleteFromInputSet(typeIndex, unit.id, setIndex, unit.names)">
                                           </button>
                                       </div>

                                   </div>
                               </template>
                               <button title="Добавить еще" class="btn btn-sm btn-outline-primary mb-2"
                                       @click.prevent="pushToInputSet(typeIndex, unit.id)">
                                   +
                               </button>
                           </template>

                        </template>
                    </div>
                </div>
            </form>
            </div>

            <div v-if="this.message" :class="'fixed-bottom alert alert-dismissible fade '+ (!error? 'alert-success show ':  'alert-danger show ')">
                <div :class="{ 'text-success': !error, 'text-danger': error}">{{ message }}</div>
                <div v-for="item in errors" class="text-danger">
                    {{ item }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
</template>

<style>

</style>

<script>
    export default {
        props: ['getUrl', 'postUrl', 'getAvailableUrl'],
        data: function() {
            return {
                paramContents: [],
                loading: false,
                message: '',
                errors: [],
                error: false,
                params: [],
                available: [],
                loadElement: {},
                inputSets: {}
            }
        },

        computed: {

        },

        methods: {
            loadData(){
                axios.get(this.getUrl)
                    .then(response => {
                        this.error = false;
                        let result = response.data;
                        if (result.success) {
                            this.params = result.params;
                        }
                        else {
                            this.message = result.message;
                        }
                    })
                axios.get(this.getAvailableUrl)
                    .then(response => {
                        this.error = false;
                        let result = response.data;
                        if (result.success) {
                            this.available = result.available;
                            // set inputs Sets for demonstrated units
                            for(let type in this.available){
                                this.inputSets[type] = [];
                                for (let uValue of this.available[type]){
                                    let uId = uValue.id;
                                    if (uValue.demonstrated){
                                        this.inputSets[type][uId]=  [];

                                        if (uValue.sets){
                                            if (! uValue.sets.length)
                                                this.inputSets[type][uId].push(0);
                                            for (let set of uValue.sets)
                                            {
                                                this.inputSets[type][uId].push(set);
                                            }
                                        }

                                    }
                                }
                            }
                        }
                        else {
                            this.message = result.message;
                        }
                    })
            },

            // Восстановить переменные.
            reset() {
                this.loading = false;
                this.error = false;
                this.errors = [];
                this.available = [];
                this.inputSets = {};
                this.loadData();
            },

            // Увеличить количество сетов для группы
            pushToInputSet(typeId, unitId){
                let max =  this.inputSets[typeId][unitId][0];
                for (let i = 1; i <  this.inputSets[typeId][unitId].length; ++i) {
                    if ( this.inputSets[typeId][unitId][i] > max) {
                        max =  this.inputSets[typeId][unitId][i];
                    }
                }
                this.inputSets[typeId][unitId].push(max +1);
            },

            // удалить сет инпутов
            deleteFromInputSet(typeId, unitId, index, names){
                if (names.length) {
                    Swal.fire({
                        title: 'Вы уверены?',
                        text: "Значение будет невозможно восстановить!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Да, удалить!',
                        cancelButtonText: "Отмена"
                    }).then((result) => {
                        if (result.value){
                            this.inputSets[typeId][unitId].splice(index,1);
                            for (let name of names) {
                                for (let i=0; i< name.values.length; i++){
                                    if (i === index && this.params[name.values[i].id])
                                        this.deleteParam(this.params[name.values[i].id])
                                }
                            }

                        }
                    });
                }
                else
                    this.inputSets[typeId][unitId].splice(index,1);
            },
            updateDataValues(paramId, availableElement, newValue){
                if (paramId){
                    this.params[paramId].value = newValue;
                    availableElement.value = newValue;
                }
            },
            // отправить параметр
            setInputValue(paramId, nameId, setId, newValue){
                this.loadElement = event.target;
                this.loadElement.classList.add('border-warning');
                this.loadElement.setAttribute('disabled','');
              // существующий
              if (paramId) {
                  this.params[paramId].valueChanged = newValue;
                  this.changeValue(this.params[paramId])
              }
              // новый
              else {
                  this.sendSingleParam(nameId,setId, newValue);
              }
            },

            // Меняем значение.
            changeValue (param) {
                param.valueInput = false;
                this.loading = true;
                this.message = "";
                this.loadElement = event.target;
                this.loadElement.classList.add('border-warning');
                this.loadElement.setAttribute('disabled','');
                let formData = new FormData();
                formData.append('changed', param.valueChanged);
                axios
                    .post(param.valueUrl, formData)
                    .then(response => {
                        let result = response.data;
                        if (result.success) {
                            this.params = result.params;
                            this.available = result.available;
                            this.message = 'Изменено';
                        }
                        else {
                            this.message = result.message;
                        }
                    })
                    .finally(() => {
                        //this.loadData();
                        this.loading = false;
                        this.loadElement.classList.remove('border-warning');
                        this.loadElement.removeAttribute('disabled')
                    });
            },

            // Удаление .
            deleteParam (param) {

                        this.loading = true;
                        this.message = "";
                        axios
                            .delete(param.delete)
                            .then(response => {
                                this.error = false;
                                let result = response.data;
                                if (result.success) {
                                    this.params = result.params;
                                    this.available = result.available;
                                    this.message = 'Удалено';
                                }
                                else {
                                    this.message = result.message;
                                }
                            })
            },

            // Отправка по одному параметру.
            sendSingleParam(nameId, setId, value) {
                this.message = "";
                let formData = new FormData();
                formData.append('staff_param_name_id', nameId);
                formData.append('set_id', setId);
                formData.append("value", value);
                this.loadElement = event.target;
                this.loadElement.classList.add('border-warning');
                this.loadElement.setAttribute('disabled','');
                axios
                    .post(this.postUrl, formData, {
                        responseType: 'json'
                    })
                    .then(response => {
                        let result = response.data;
                        if (result.success) {
                            //this.loadData();
                            this.params[result.param['id']]= result.param;
                            this.params = result.params;
                            this.available = result.available;
                            this.message = 'Внесено';

                        }
                        else {
                            this.message = result.message;
                        }
                        this.loadElement.classList.remove('border-warning');
                        this.loadElement.removeAttribute('disabled')

                    })
                    .catch(error => {
                        let data = error.response.data;
                        console.log(data)
                        this.loadData();
                        if (data.errors.length) {
                            this.errors.push(data.errors);
                        }
                    })

            },
        },

        created(){
            this.loadData();
        }
    }
</script>
