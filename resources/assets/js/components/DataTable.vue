<template>
    <div class="row">
        
        <div class="col-sm-12">
            <a href="#" 
                class="btn white black-text" 
                v-if="response.allow.creation"
                @click.prevent="creating.active = !creating.active"
            >{{ creating.active ? 'Cancel' : 'New Record' }}</a>    
        </div>
        <div class="col-sm-12" v-if="creating.active">
          <div class="panel panel-default">
            <div class="panel-body">
                <span class="">New Record</span>
                <form class="row" @submit.prevent="store">
                    <div class="form-group col-sm-4" v-for="column in response.updatable">
                        <template v-if="response.form['input-types'][column] === 'date' ">
                            <label :for="column">{{column}}</label>
                            <input type="date" :id="column" class="form-control" v-model="creating.form[column]">
                            <p class="help-block" v-if="creating.errors[column]">{{ creating.errors[column][0] }}</p>
                        </template>
                        <template v-if="response.form['input-types'][column] === 'text' ">
                            <label :for="column">{{column}}</label>
                            
                            <input type="text" :id="column" v-model="creating.form[column]" class="form-control">
                            <p class="help-block" v-if="creating.errors[column]">{{ creating.errors[column][0] }}</p>
                        </template>
                        <template v-if="response.form['input-types'][column] === 'email' ">
                            <label :for="column">{{column}}</label>

                            <input type="email" :id="column" v-model="creating.form[column]" class="form-control">

                            <p class="help-block" v-if="creating.errors[column]">{{ creating.errors[column][0] }}</p>
                        </template>

                    </div>
                    <div class="input-field col-sm-12">
                        <button type="submit" class="btn white black-text">Save</button> </div>
                </form>
            </div>
          </div>
        </div>
        <div class="input-field col-sm-4 form-group">
            <input id="filter" type="text" class="validate form-control" v-model="quickSearchQuery">
            <label>Quick search current results</label>
        </div>
        <div class="input-field col-sm-2 form-group pull-right">
            <input type="text" value="50" class="validate form-control" v-model="limit">
            <label>Display records</label>
        </div>
        <div class="col-sm-12">
            <table class="table">
                <thead>
                    <tr>
                    <th v-for="column in response.displayable">
                        <span class="sortable" @click="sortBy(column)">{{ column }}</span>

                        <div 
                            class="arrow"
                            v-if="sort.key === column"
                            :class="{'arrow--asc': sort.order === 'asc', 'arrow--desc': sort.order === 'desc'}"
                        ></div>
                    </th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="record in filteredRecords">
                    <td v-for="columnValue, column in record">
                        <template v-if="editing.id === record.id && isUpdatable(column)">
                            <div class="input-field form-group" :class="{ 'has-error' : editing.errors[column] }">
                                <input type="text" :id="column" class="validate form-control" v-model="editing.form[column]">
                                <span class="help-block" v-if="editing.errors[column]">
                                    <strong>{{ editing.errors[column][0]}}</strong>
                                </span>
                            </div>
                        </template>
                        <template v-else>
                            {{ columnValue }}
                        </template>
                    </td>
                    <td>
                        <a href="#" @click.prevent="edit(record)" v-if="editing.id !== record.id">Edit</a>
                        
                        <template v-if="editing.id === record.id">
                            <a href="#" @click.prevent="update">Save</a>
                            <a href="#" @click.prevent="editing.id = null">Cancel</a>
                        </template>
                    </td>
                    <td>
                        <a href="#" @click.prevent="destroy(record.id)" v-if="response.allow.deletion">Delete</a>
                    </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
</template>

<script>
    import Vue from 'vue'
    import vSelect from 'vue-select'
    Vue.component('v-select', vSelect)
    import queryString from 'query-string'

    export default {
        props: ['endpoint'],
        data () {
            return {
                response: {
                    displayable: [],
                    records: [],
                    allow: {},
                    form: {}
                },
                sort: {
                    key: 'tour_id',
                    order: 'asc'
                },
                limit: 50,
                quickSearchQuery: '',
                editing: {
                    id: null,
                    form: {},
                    errors: []
                },
                search: {
                    value: '',
                    operator: 'equals',
                    column: 'id'
                },
                creating: {
                    active: false,
                    form: {},
                    errors: []
                }
            }
        },
        computed: {
            filteredRecords () {
                let data = this.response.records;

                data = data.filter((row) =>{
                    return Object.keys(row).some((key) => {
                        return String(row[key]).toLowerCase().indexOf(this.quickSearchQuery.toLowerCase()) > -1
                    })
                })

                if (this.sort.key) {
                    data = _.orderBy(data, (i) => {
                        let value = i[this.sort.key];

                        value = new Date(value);

                        if (!isNaN(value.getTime())) {
                            return value
                        }

                        if (!isNaN(parseFloat(value))) {
                            return parseFloat(value)
                        }
                            
                        console.log(value);


                        return String(i[this.sort.key]).toLowerCase()
                    }, this.sort.order)
                }

                return data
            }
        },
        methods: {
            getRecords () {
                console.log(this.getQueryParameters())
                return axios.get(`${this.endpoint}?${this.getQueryParameters()}`).then((response) => {
                    this.response = response.data.data
                })
            },
            getQueryParameters () {
                return queryString.stringify({
                    limit: this.limit
                })
            },
            sortBy (column) {
                this.sort.key = column
                this.sort.order = this.sort.order === 'asc' ? 'desc' : 'asc'
                console.log(this.sort)
            },
            edit (record) {
                console.log(record)
                this.editing.errors = []
                this.editing.id = record.id
                this.editing.form = _.pick(record, this.response.updatable)
            },
            isUpdatable (column) {
                return this.response.updatable.includes(column)
            },
            update () {
                axios.patch(`${this.endpoint}/${this.editing.id}`, this.editing.form).then((response) => {
                    this.getRecords().then(() => {
                        this.editing.id = null
                        this.editing.form = {}
                    })
                }).catch((error) => {
                    this.editing.errors = error.response.data.errors
                })
            },
            store () {
                axios.post(`${this.endpoint}`, this.creating.form).then((response) => {
                    this.getRecords().then(() => {
                        this.creating.active = false
                        this.creating.form = {}
                        this.creating.errors = []
                    })
                }).catch((error) => {
                    console.log(error.response.data.errors);
                    this.creating.errors = error.response.data.errors
                })
            },
            destroy (record) {
                if (!window.confirm('Are you sure you want to delete the record ?')) {
                    return;
                }
                axios.delete(`${this.endpoint}/${record}`).then((response) => {
                    this.getRecords()
                })
            }
        },
        watch: {
            limit: function () {
                this.getRecords()
            }
        },
        mounted() {
            this.getRecords()
            console.log(this.endpoint);
        },
    }
</script>

<style lang="scss">
    .sortable {
        cursor: pointer;
    }

    .arrow {
        display: inline-block;
        vertical-align: middle;
        width: 0;
        height: 0;
        margin-left: 5px;
        opacity: .6;

        &--asc {
            border-left: 4px solid transparent;
            border-right: 4px solid transparent;
            border-bottom: 4px solid #222;
        }

        &--desc {
            border-left: 4px solid transparent;
            border-right: 4px solid transparent;
            border-top: 4px solid #222;
        }
    }
</style>