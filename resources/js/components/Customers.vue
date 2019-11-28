<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Customers</h3>

                        <div class="card-tools">
                            <a class="btn btn-app" @click.prevent="newUserModal">
                                <i class="fas fa-user-plus"></i> New User
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Join Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in users" :key="user.id">
                                    <td>{{user.id}}</td>
                                    <td>{{user.name}}</td>
                                    <td>{{user.email}}</td>
                                    <td>{{user.phone}}</td>
                                    <td class="text-capitalize">{{user.role}}</td>
                                    <td class="text-capitalize">{{user.status}}</td>
                                    <td>{{user.created_at}}</td>
                                    <td>
                                        <a href="#" @click.prevent="editUserModal(user)">
                                            <i class="fas fa-user-edit"></i>
                                        </a>
                                        |
                                        <a href="#" @click.prevent="sendEmailModal(user)">
                                            <i class="fas fa-envelope"></i>
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
        <div class="modal fade" id="senEmailModal" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form @submit.prevent="sendEmail">
                        <div class="modal-header">
                            <h4 class="modal-title">Send Email to {{emailForm.name}} | {{emailForm.email}}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Sender Email</label>
                                <input v-model="emailForm.senderEmail" type="email" name="senderEmail" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('senderEmail') }">
                                <has-error :form="emailForm" field="senderEmail"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Subject</label>
                                <input v-model="emailForm.subject" type="text" name="subject" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('subject') }">
                                <has-error :form="emailForm" field="subject"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Message</label>
                                <textarea v-model="emailForm.message" type="textarea" name="message" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('message') }" rows="3"></textarea>
                                <has-error :form="emailForm" field="message"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Signature</label>
                                <textarea v-model="emailForm.signature" type="textarea" name="signature" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('signature') }" rows="3"></textarea>
                                <has-error :form="emailForm" field="signature"></has-error>
                            </div>
                            
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Send</button>
                            </div>
                            <alert-success :form="emailForm">Done</alert-success>
                        </div>
                    </form>
                </div>
            </div>
        </div> 
        <div class="modal fade" id="userModal" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">

                <div class="modal-content">
                    <form @submit.prevent="editMode ? editUser() : newUser()">
                        <div class="modal-header">
                            <h4 class="modal-title"> {{editMode ? 'Edit' : 'New'}} User</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="level" v-model="form.level">    
                            <div class="form-group">
                                <label>Name</label>
                                <input v-model="form.name" type="text" name="name" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input v-model="form.email" type="email" name="email" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('email') }">
                                <has-error :form="form" field="email"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Password</label>
                                <input v-model="form.password" type="password" name="password" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('password') }">
                                <has-error :form="form" field="password"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Phone</label>
                                <input v-model="form.phone" type="text" name="phone" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('phone') }">
                                <has-error :form="form" field="phone"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Role</label>
                                <select class="form-control" v-model="form.role" name="role"
                                    :class="{ 'is-invalid': form.errors.has('role') }">
                                    <option value="customer">Customer</option>
                                    <option value="driver">Driver</option>
                                </select>
                                <has-error :form="form" field="role"></has-error>
                            </div>

                            <input v-if="!editMode" type="hidden" name="status" v-model="form.status">

                            <div class="form-group" v-if="editMode">
                                <label>Status</label>
                                <select class="form-control" v-model="form.status" name="status"
                                    :class="{ 'is-invalid': form.errors.has('status') }">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                                <has-error :form="form" field="status"></has-error>
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
                senderEmail: 'info@hellovans.com',
                signature: 'Hello Vans Team',
                users: {},
                form: new Form({
                    id: '',
                    name: '',
                    password: '',
                    email: '',
                    phone: '',
                    status: 'active',
                    role: 'customer',
                    level: 'none'
                }),
                emailForm: new Form({
                    id: '',
                    name: '',
                    email: '',
                    message: '',
                    subject: '',
                    senderEmail: 'info@hellovans.com',
                    signature:''
                }),
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created() {
            this.getUsers()
        },
        methods: {
            sendEmailModal(user) {
                this.form.clear()
                this.form.reset()
                $('#senEmailModal').modal('show')
                this.emailForm.fill(user)
                this.emailForm.senderEmail = this.senderEmail;
                this.emailForm.signature = this.signature;
            },
            sendEmail( ){
                this.emailForm.post('/api/admin/email/send')
                .then(() => {
                    
                })
                .catch(() => {

                })
            },

            newUserModal() {
                this.editMode =false
                this.form.clear()
                this.form.reset()
                $('#userModal').modal('show')
            },
            editUserModal(user) {
                this.editMode =true
                this.form.clear()
                $('#userModal').modal('show')
                this.form.fill(user)
            },
            getUsers(){
                axios.get('/api/admin/user')
                .then(
                    ({ data }) => (this.users= data)
                )
                
            },
            newUser() {
                this.form.post('/api/admin/user')
                .then(() => {
                    this.getUsers()
                })
                .catch(() => {

                })
            },
            editUser() {
                this.form.put('/api/admin/user/'+this.form.id)
                .then(() => {
                    this.getUsers()
                })
                .catch(() => {

                })
            }
        }
    }

</script>
