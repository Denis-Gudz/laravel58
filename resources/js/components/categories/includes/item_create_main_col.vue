<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <v-dialog :value="value" @input="$emit('input')">
            <form @submit.prevent="submitHandler">
                <v-card>
                <div class="card">
                <div class="card-body">
                    <div class="card-title"></div>
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#maindata"
                               role="tab">Основные данные</a>
                        </li>
                    </ul>
                    <br>
                    <div class="tab-content">
                        <div class="tab-pane active" id="maindata" role="tabpanel">
                            <div class="form-group">
                                <label for="title">Заголовок</label>
                                <input name="title" v-model="title"
                                       id="title"
                                       type="text"
                                       class="form-control"
                                       minlength="3"
                                       required>
                            </div>
                            <div class="form-group">
                                <label for="slug">Идентификатор</label>
                                <input name="slug" v-model="slug"
                                       id="slug"
                                       type="text"
                                       class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="parent_id">Родитель</label>
                                <select name="parent_id" v-model="parent_id"
                                        id="parent_id"
                                        class="form-control"
                                        required>
                                        <option disabled value=null>Выберете катигорию</option>
                                        <option v-for="$categoryOption in categoryList" v-bind:value="$categoryOption.id">
                                            {{ $categoryOption.id_title }}
                                        </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="description">Описание</label>
                                <textarea name="description"
                                          id="description"
                                          rows="3"
                                          class="form-control"
                                          v-model="description">
                                </textarea>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
                    </v-card>
            </form>
            </v-dialog>
        </div>
    </div>
</template>

<script>
    export default {
        name: "item_create_main",
        props: ['value'],
        data(){
            return{
                title: null,
                slug: null,
                parent_id: null,
                description: null,
                loading: false,
                categoryList: null,
            }
        },
        beforeUpdate(){
            this.loading = this.$attrs.loading;
            this.fetchData();
            this.$attrs.loading = false;
        },
        methods:{
            fetchData() {

                if(this.loading) {
                    this.title = null;
                    this.slug = null;
                    this.parent_id = null;
                    this.description = null;

                    axios.get('/categories/all/api')
                        .then((response) => {
                            this.categoryList = response.data;
                        })
                        .catch(() => {
                            console.log('handle server error from here');
                        });
                    this.loading = false;
                }
            },
            submitHandler(){
                axios.post('/category/store/api', {
                        title:       this.title,
                        slug:        this.slug,
                        parent_id:   this.parent_id,
                        description: this.description,
                    })
                    .then((response) => {
                        alert(response.data['success']);
                        this.$emit('input');
                    })
                    .catch((e) => {
                        alert(e, response.data['msg']);
                    });

            }
        }
    }
</script>
