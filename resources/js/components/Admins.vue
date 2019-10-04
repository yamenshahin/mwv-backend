<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Admins</h3>

                        <div class="card-tools">
                            <a class="btn btn-app" @click.prevent="newUserModal">
                                <i class="fas fa-user-plus"></i> New Admin
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
                                    <th>Edit</th>
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
        <div class="modal fade" id="userModal" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">

                <div class="modal-content">
                    <form @submit.prevent="editmode ? editUser() : newUser()">
                        <div class="modal-header">
                            <h4 class="modal-title"> {{editmode ? 'Edit' : 'New'}} Admin</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">

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
                                    <option value="admin">Admin</option>
                                </select>
                                <has-error :form="form" field="role"></has-error>
                            </div>

                            <input v-if="!editmode" type="hidden" name="status" v-model="form.status">

                            <div class="form-group" v-if="editmode">
                                <label>Status</label>
                                <select class="form-control" v-model="form.status" name="role"
                                    :class="{ 'is-invalid': form.errors.has('status') }">
                                    <option value="active">Active</option>
                                    <option value="unactive">Unactive</option>
                                    <option value="banned">Banned</option>
                                </select>
                                <has-error :form="form" field="role"></has-error>
                            </div>
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
                users: {},
                form: new Form({
                    id: '',
                    name: '',
                    password: '',
                    email: '',
                    phone: '',
                    status: 'active',
                    role: 'admin'
                })
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created() {
            this.getUsers()
        },
        methods: {
            newUserModal() {
                this.editmode =false
                this.form.clear()
                this.form.reset()
                $('#userModal').modal('show')
            },
            editUserModal(user) {
                this.editmode =true
                this.form.clear()
                $('#userModal').modal('show')
                this.form.fill(user)
            },
            getUsers(){
                axios.get('/api/admin/admin')
                .then(
                    ({ data }) => (this.users= data)
                )
                
            },
            newUser() {
                this.form.post('/api/admin/admin')
                .then(() => {
                    this.getUsers()
                })
                .catch(() => {

                })
            },
            editUser() {
                this.form.put('/api/admin/admin/'+this.form.id)
                .then(() => {
                    this.getUsers()
                })
                .catch(() => {

                })
            }
        }
    }

</script>
