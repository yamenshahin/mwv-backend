<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Feedback for Jobs</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Job ID</th>
                                    <th>Driver Name</th>
                                    <th>Customer Name</th>
                                    <th>Stars</th>
                                    <th>Commnet</th>
                                    <th>Status</th>
                                    <th>Created Date</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="feedbackJob in feedbackJobs" :key="feedbackJob.id">
                                    <td>{{feedbackJob.id}}</td>
                                    <td>{{feedbackJob.owner_id}}</td>
                                    <td>{{feedbackJob.driver.name}}</td>
                                    <td>{{feedbackJob.customer.name}}</td>
                                    <td>{{feedbackJob.stars}}</td>
                                    <td>{{feedbackJob.commnet}}</td>
                                    <td class="text-capitalize">{{feedbackJob.status}}</td>
                                    <td>{{feedbackJob.created_at | isoDateToString}}</td>
                                    <td>
                                        <a href="#" @click.prevent="editFeedbakJobModal(feedbackJob)">
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
        
        <div class="modal fade" id="feedbackJobModal" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">

                <div class="modal-content">
                    <form @submit.prevent="editMode ? editFeedbakJob() : newFeedbakJob()">
                        <div class="modal-header">
                            <h4 class="modal-title"> {{editMode ? 'Edit' : 'New'}} Feedbak</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                <label>Job ID</label>
                                <input v-model="form.owner_id" type="text" name="owner_id" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('owner_id') }">
                                <has-error :form="form" field="owner_id"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Stars</label>
                                <input v-model="form.stars" type="number" min="1" max="5" step="1" name="stars" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('stars') }">
                                <has-error :form="form" field="stars"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Comment</label>
                                <textarea v-model="form.comment" type="textarea" name="comment" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('comment') }" rows="3"></textarea>
                                <has-error :form="form" field="comment"></has-error>
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
                feedbackJobs: {},
                form: new Form({
                    id: '',
                    owner_id: '',
                    customer: {
                        name: ''
                    },
                    driver: {
                        name: ''
                    },
                    stars: '',
                    comment: '',
                    type: '',
                    created_at: '',
                    status: ''
                }),
                jobsWithNoFeedback: []
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created() {
            this.getFeedbakJobs()
        },
        methods: {
            newFeedbakJobModal() {
                this.editMode =false
                this.form.clear()
                this.form.reset()
                $('#feedbackJobModal').modal('show')
            },
            editFeedbakJobModal(feedbackJob) {
                this.editMode =true
                this.form.clear()
                $('#feedbackJobModal').modal('show')
                this.form.fill(feedbackJob)
            },
            getFeedbakJobs(){
                axios.get('/api/admin/jobs-no-feedback')
                .then(
                    ({ data }) => (this.jobsWithNoFeedback= data.data)
                )
                
            },
            newFeedbakJob() {
                this.form.post('/api/admin/feedback-jobs')
                .then(() => {
                    this.getFeedbakJobs()
                })
                .catch(() => {

                })
            },
            editFeedbakJob() {
                this.form.put('/api/admin/feedback-jobs/'+this.form.id)
                .then(() => {
                    this.getFeedbakJobs()
                })
                .catch(() => {

                })
            }
        }
    }

</script>
