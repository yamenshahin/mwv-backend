<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Jobs</h3>

                        <!-- New Job Disabled -->
                        <!-- <div class="card-tools">
                            <a class="btn btn-app" @click.prevent="newJobModal">
                                <i class="fas fa-plus-square"></i> New Job
                            </a>
                        </div> -->
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
                                    <th>View</th>
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
                                    <td>{{job.created_at | isoDateToString}}</td>
                                    <!-- Edit Job Disabled -->
                                    <!-- <td>
                                        <a href="#" @click.prevent="editJobModal(job)">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td> -->
                                    <td>
                                        <a href="#" @click.prevent="viewJobModal(job)">
                                            <i class="fas fa-eye"></i>
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
                    <form @submit.prevent="viewJob()">
                        <div class="modal-header">
                            <h4 class="modal-title">Job</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                <h4><b>ID:</b> {{form.id}} | <b>Status:</b> {{form.status}}</h4>
                                <hr>
                                <span v-if="form.feedback.id !== 0">
                                    <h5><b>Feedback</b></h5>
                                    <p><b>Stars:</b> {{form.feedback.stars}}</p>
                                    <p><b>Comment:</b> {{form.feedback.comment}}</p>
                                    <p><b>Status:</b> {{form.feedback.status | unCamelCase}}</p>
                                    <a href="" @click.prevent="editFeedbackModal()">Edit feedback</a>
                                </span>
                                <span v-else>
                                    <h5><b>Feedback</b></h5>
                                    <p><b>No feedback yet</b></p>
                                    <span v-if="form.status === 'booked'">
                                        <a href="" @click.prevent="newFeedbackModal()">Give feedback</a>
                                    </span>
                                </span>
                                <hr>
                                <h5><b>Driver:</b></h5>
                                <p><b>Driver name:</b> {{form.driver.name}}</p>
                                <p><b>Driver Email:</b> {{form.driver.email}}</p>
                                <p><b>Driver phone:</b> {{form.driver.phone}}</p>
                                <hr>
                                <h5><b>Customer:</b></h5>
                                <p><b>Customer name:</b> {{form.customer.name}}</p>
                                <p><b>Customer Email:</b> {{form.customer.email}}</p>
                                <p><b>Customer phone:</b> {{form.customer.phone}}</p>
                                <hr>
                                <h4><b>Addresses:</b></h4>
                                <hr>
                                <span v-for="job_meta in form.job_metas" :key="job_meta.key">
                                    <span v-if="job_meta.key === 'collection' || job_meta.key === 'delivery'">
                                        <h5><b>{{job_meta.key | unCamelCase}}:</b></h5>
                                        <p v-for="(value, key) in job_meta.value" :key="key">
                                            <span v-if="key === 'stairs'">
                                                <b>{{key | unCamelCase}}:</b> {{value | stairs}}
                                            </span>
                                            <span v-else>
                                                <b>{{key | unCamelCase}}:</b> {{value}}
                                            </span>
                                        </p>
                                        <hr>
                                    </span>
                                    <span v-else-if="job_meta.key === 'waypoints' && job_meta.value.length > 0">
                                        <h5><b>{{job_meta.key | unCamelCase}}:</b></h5>
                                        <hr>
                                        <span v-for="waypoint in job_meta.value" :key="waypoint.index">
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
                                <span v-for="job_meta in form.job_metas" :key="job_meta.key">
                                    <span v-if="job_meta.key === 'vanSize'">
                                        <p><b>{{job_meta.key | unCamelCase}}:</b> {{job_meta.value | vanSize}}</p>
                                        <hr>
                                    </span>
                                    <span v-else-if="job_meta.key === 'helpersRequired'">
                                        <p><b>{{job_meta.key | unCamelCase}}:</b> {{job_meta.value | helpersRequired}}</p>
                                        <hr>
                                    </span>
                                    <span v-else-if="job_meta.key === 'movingDate'">
                                        <p><b>{{job_meta.key | unCamelCase}}:</b> {{job_meta.value | isoDateToString}}</p>
                                        <hr>
                                    </span>
                                    <span v-else-if="job_meta.key === 'totalTime'">
                                        <p><b>{{job_meta.key | unCamelCase}}:</b> {{job_meta.value | timeInFloatToSec | timeInHoursMinutes}}</p>
                                        <hr>
                                    </span>
                                    <span v-else-if="job_meta.key === 'total'">
                                        <p><b>{{job_meta.key | unCamelCase}}:</b> {{job_meta.value | currency}}</p>
                                        <hr>
                                    </span>
                                    <span v-else-if="job_meta.key === 'fee'">
                                        <p><b>{{job_meta.key | unCamelCase}}:</b> {{job_meta.value | percentage}}</p>
                                        <hr>
                                    </span>
                                    <span v-else-if="job_meta.key === 'paymentMethod'">
                                        <p><b>{{job_meta.key | unCamelCase}}:</b> {{job_meta.value | unCamelCase}}</p>
                                        <hr>
                                    </span>
                                    <span v-else-if="job_meta.key === 'additionalTimePrice'">
                                        <p><b>{{job_meta.key | unCamelCase}}:</b> {{job_meta.value | currency}} per half hour </p>
                                        <hr>
                                    </span>
                                </span>
                            </div>                            
                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <!-- Save Job Disabled -->
                            <!-- <button type="submit" class="btn btn-primary">Save changes</button> -->
                        </div>
                        <alert-success :form="form">Done</alert-success>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <!-- .modal -->
        <div class="modal fade" id="feedbackModal" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">

                <div class="modal-content">
                    <form @submit.prevent="editMode ? editFeedback() : newFeedback()">
                        <div class="modal-header">
                            <h4 class="modal-title"> {{editMode ? 'Edit' : 'New'}} Feedback</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                <label>Stars</label>
                                <input v-model="form.feedback.stars" type="number" min="1" max="5" step="1" name="feedback.stars" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('feedback.stars') }">
                                <has-error :form="form" field="feedback.stars"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Comment</label>
                                <textarea v-model="form.feedback.comment" type="textarea" name="feedback.comment" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('feedback.comment') }" rows="3"></textarea>
                                <has-error :form="form" field="feedback.comment"></has-error>
                            </div>

                            <input v-if="!editMode" type="hidden" name="feedback.status" v-model="form.feedback.status">

                            <div class="form-group" v-if="editMode">
                                <label>Status</label>
                                <select class="form-control" v-model="form.feedback.status" name="feedback.status"
                                    :class="{ 'is-invalid': form.errors.has('feedback.status') }">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                                <has-error :form="form" field="feedback.status"></has-error>
                            </div>
                        </div>

                        <footer class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </footer>
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
                jobs: {},
                bookedJobsNoFeedback: {},
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
                    feedback: {
                        'comment' : '',
                        'stars': '5',
                        'status': '',
                    }
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
            viewJobModal(job) {
                this.form.clear()
                this.form.reset()
                $('#jobModal').modal('show')
                this.form.fill(job)
            },
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
            },


            newFeedbackModal() {
                this.editMode =false
                
                $('#feedbackModal').modal('show')
            },
            editFeedbackModal() {
                this.editMode =true
                
                $('#feedbackModal').modal('show')
            },

            newFeedback() {                
                this.form.post('/api/admin/feedback-jobs')
                .then(() => {
                    this.getJobs()
                    $('#jobModal').modal('hide')
                })
                .catch(() => {

                })
            },
            editFeedback() {
                this.form.post('/api/admin/feedback-jobs')
                .then(() => {
                    this.getJobs()
                    $('#jobModal').modal('hide')
                })
                .catch(() => {

                })
            }
        }
    }

</script>
