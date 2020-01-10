<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Quotes</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th>Customer Email</th>
                                    <th>Customer Phone</th>
                                    <th>Created Date</th>
                                    <th>View</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="quote in quotes.data" :key="quote.id">
                                    <td>{{quote.id}}</td>
                                    <td>{{quote.customer.name}}</td> 
                                    <td>{{quote.customer.email}}</td>
                                    <td>{{quote.customer.phone}}</td>
                                    <td>{{quote.created_at | isoDateToString}}</td>
                                    <td>
                                        <a href="#" @click.prevent="viewQuoteModal(quote)">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="quotes" @pagination-change-page="getResults">

                        </pagination>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>

        <!-- .modal -->
        <div class="modal fade" id="quoteModal" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">

                <div class="modal-content">
                    <form @submit.prevent="viewQuote()">
                        <div class="modal-header">
                            <h4 class="modal-title">Quote</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                <h4><b>ID:</b> {{form.id}} | <b>Status:</b> {{form.status}}</h4>
                                <hr>
                                <h5><b>Customer:</b></h5>
                                <p><b>Customer name:</b> {{form.customer.name}}</p>
                                <p><b>Customer Email:</b> {{form.customer.email}}</p>
                                <p><b>Customer phone:</b> {{form.customer.phone}}</p>
                                <hr>
                                <h4><b>Addresses:</b></h4>
                                <hr>
                                <span v-for="quote_meta in form.quote_metas" :key="quote_meta.key">
                                    <span v-if="quote_meta.key === 'collection' || quote_meta.key === 'delivery'">
                                        <h5><b>{{quote_meta.key | unCamelCase}}:</b></h5>
                                        <p v-for="(value, key) in quote_meta.value" :key="key">
                                            <span v-if="key === 'stairs'">
                                                <b>{{key | unCamelCase}}:</b> {{value | stairs}}
                                            </span>
                                            <span v-else>
                                                <b>{{key | unCamelCase}}:</b> {{value}}
                                            </span>
                                        </p>
                                        <hr>
                                    </span>
                                    <span v-else-if="quote_meta.key === 'waypoints' && quote_meta.value.length > 0">
                                        <h5><b>{{quote_meta.key | unCamelCase}}:</b></h5>
                                        <hr>
                                        <span v-for="waypoint in quote_meta.value" :key="waypoint.index">
                                            <p v-for="(value, key) in waypoint" :key="key">
                                               <span v-if="key === 'stairs'">
                                                    <b>{{key | unCamelCase}}:</b> {{value | stairs}}
                                                </span>
                                                <span v-else>
                                                    <b>{{key | unCamelCase}}:</b> {{value}}
                                                </span>
                                            </p>
                                            <hr />
                                        </span>
                                    </span>
                                </span>
                                <h4><b>Others info:</b></h4>
                                <hr />    
                                <span v-for="quote_meta in form.quote_metas" :key="quote_meta.key">
                                    <span v-if="quote_meta.key === 'vanSize'">
                                        <p><b>{{quote_meta.key | unCamelCase}}:</b> {{quote_meta.value | vanSize}}</p>
                                        <hr>
                                    </span>
                                    <span v-else-if="quote_meta.key === 'helpersRequired'">
                                        <p><b>{{quote_meta.key | unCamelCase}}:</b> {{quote_meta.value | helpersRequired}}</p>
                                        <hr>
                                    </span>
                                    <span v-else-if="quote_meta.key === 'movingDate'">
                                        <p><b>{{quote_meta.key | unCamelCase}}:</b> {{quote_meta.value | isoDateToString}}</p>
                                        <hr>
                                    </span>
                                    <span v-else-if="quote_meta.key === 'totalTime'">
                                        <p><b>{{quote_meta.key | unCamelCase}}:</b> {{quote_meta.value | timeInFloatToSec | timeInHoursMinutes}}</p>
                                        <hr>
                                    </span>
                                    <span v-else-if="quote_meta.key === 'estimatedTotalTime'">
                                        <p><b>{{quote_meta.key | unCamelCase}}:</b> {{quote_meta.value | timeInHoursMinutes}}</p>
                                        <hr>
                                    </span>
                                </span>
                            </div>                            
                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <!-- Save Quote Disabled -->
                            <!-- <button type="submit" class="btn btn-primary">Save changes</button> -->
                        </div>
                        <alert-success :form="form">Done</alert-success>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                editMode: false,
                quotes: {},
                form: new Form({
                    id: '',
                    customer: {
                        name: '',
                        email: '',
                        phone: ''
                    },
                    quote_metas: [{}],
                })
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created() {
            this.getQuotes()
        },
        methods: {
            // Our method to GET results from a Laravel endpoint
            getResults(page = 1) {
                axios.get('/api/admin/quote?page=' + page)
                    .then(response => {
                        this.quotes= response.data;
                    });
            },

            viewQuoteModal(quote) {
                this.form.clear()
                this.form.reset()
                $('#quoteModal').modal('show')
                this.form.fill(quote)
            },
 
            getQuotes(){
                axios.get('/api/admin/quote')
                .then(
                    ({ data }) => (this.quotes= data),
                    
                )
                
            }
            
        }
    }

</script>
