<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Customers</h3>

                        <div class="card-tools">
                            <a class="btn btn-app" data-toggle="modal" data-target="#new-user-modal">
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
                                        <a href="#">
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
        <div class="modal fade" id="new-user-modal" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">

                <div class="modal-content">
                    <form @submit.prevent="createUser">
                        <div class="modal-header">
                            <h4 class="modal-title">New User</h4>
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
                                    <option value="customer">Customer</option>
                                    <option value="driver">Driver</option>
                                </select>
                                <has-error :form="form" field="role"></has-error>
                            </div>

                            <input type="hidden" name="status" :value="status">
                            <input type="hidden" name="_token" :value="csrf">
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
                users: {},
                form: new Form({
                    username: '',
                    password: '',
                    email: '',
                    phone: '',
                    status: 'active',
                    role: 'customer',
                    csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
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
            getUsers(){
                axios.get('/api/admin/user')
                .then(
                    ({ data }) => (this.users= data)
                )
                
            },
            createUser() {
                this.form.post('/api/admin/user')
            }
        }
    }

</script>
