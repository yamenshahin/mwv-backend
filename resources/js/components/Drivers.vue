<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Drivers</h3>

                        <div class="card-tools">
                            <a class="btn btn-app" data-toggle="modal" data-target="#new-driver-modal">
                                <i class="fas fa-user-plus"></i> New Driver
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
                                <tr v-for="driver in drivers" :key="driver.id">
                                    <td>{{driver.id}}</td>
                                    <td>{{driver.name}}</td>
                                    <td>{{driver.email}}</td>
                                    <td>{{driver.phone}}</td>
                                    <td class="text-capitalize">{{driver.role}}</td>
                                    <td class="text-capitalize">{{driver.status}}</td>
                                    <td>{{driver.created_at}}</td>
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
        <div class="modal fade" id="new-driver-modal" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">

                <div class="modal-content">
                    <form @submit.prevent="createDriver">
                        <div class="modal-header">
                            <h4 class="modal-title">New Driver</h4>
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
                drivers: {},
                form: new Form({
                    username: '',
                    password: '',
                    email: '',
                    phone: '',
                    status: 'active',
                    role: 'driver',
                    csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                })
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created() {
            this.getDrivers()
        },
        methods: {
            getDrivers(){
                axios.get('/api/admin/user')
                .then(
                    ({ data }) => (
                        this.drivers= data.filter(function(driver) {
                            return driver.role == 'driver'
                        })
                    )
                )
                
            },
            createDriver() {
                this.form.post('/api/admin/user')
            }
        }
    }

</script>