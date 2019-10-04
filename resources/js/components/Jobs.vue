<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Jobs</h3>

                        <div class="card-tools">
                            <a class="btn btn-app" @click.prevent="newJobModal">
                                <i class="fas fa-plus-square"></i> New Job
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Driver</th>
                                    <th>Driver Email</th>
                                    <th>Driver Phone</th>
                                    <th>Customer</th>
                                    <th>Customer Email</th>
                                    <th>Customer Phone</th>
                                    <th>Status</th>
                                    <th>Created Date</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="job in jobs" :key="job.id">
                                    <td>{{job.id}}</td>
                                    <td>{{job.driver.name}}</td>
                                    <td>{{job.driver.email}}</td>
                                    <td>{{job.driver.phone}}</td>
                                    <td>{{job.customer.name}}</td> 
                                    <td>{{job.customer.email}}</td>
                                    <td>{{job.customer.phone}}</td>
                                    <td class="text-capitalize">{{job.status}}</td>
                                    <td>{{job.created_at}}</td>
                                    <td>
                                        <a href="#" @click.prevent="editJobModal(job)">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>

        <!-- .modal -->
        <div class="modal fade" id="jobModal" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">

                <div class="modal-content">
                    <form @submit.prevent="editmode ? editJob() : newJob()">
                        <div class="modal-header">
                            <h4 class="modal-title"> {{editmode ? 'Edit' : 'New'}} Job</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                <label>Driver Email</label>
                                <input v-model="form.driver.email" type="email" name="driverEmail" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('driverEmail') }">
                                <has-error :form="form" field="driverEmail"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Customer Email</label>
                                <input v-model="form.customer.email" type="email" name="customerEmail" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('customerEmail') }">
                                <has-error :form="form" field="customerEmail"></has-error>
                            </div>

                           <!--  <div class="form-group">
                                <label>Collection Address</label>
                                <input v-model="form.collection.address" type="text" name="collectionAddress" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('collectionAddress') }">
                                <has-error :form="form" field="collectionAddress"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Delivery Address</label>
                                <input v-model="form.delivery.address" type="text" name="deliveryAddress" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('deliveryAddress') }">
                                <has-error :form="form" field="deliveryAddress"></has-error>
                            </div> -->


                            
                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
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
                editmode: false,
                jobs: {},
                form: new Form({
                    id: '',
                    driver: {
                        id: '',
                        name: '',
                        email: '',
                        phone: ''
                    },
                    customer: {
                        id: '',
                        name: '',
                        email: '',
                        phone: ''
                    },
                    job_metas: [{}],
                    status: 'booked',
                })
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created() {
            this.getJobs()
        },
        methods: {
            newJobModal() {
                this.editmode =false
                this.form.clear()
                this.form.reset()
                $('#jobModal').modal('show')
            },
            editJobModal(job) {
                this.editmode =true
                this.form.clear()
                $('#jobModal').modal('show')
                this.form.fill(job)
            },
            getJobs(){
                axios.get('/api/admin/job')
                .then(
                    ({ data }) => (this.jobs= data.data),
                    
                )
                
            },
            newJob() {
                this.form.post('/api/admin/job')
                .then(() => {
                    this.getJobs()
                })
                .catch(() => {

                })
            },
            editJob() {
                this.form.put('/api/admin/job/'+this.form.id)
                .then(() => {
                    this.getJobs()
                })
                .catch(() => {

                })
            }
        }
    }

</script>
