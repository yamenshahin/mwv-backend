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
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Join Date</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>183</td>
                                    <td>John Doe</td>
                                    <td>john@doe</td>
                                    <td>123456789</td>
                                    <td>Driver</td>
                                    <td><span class="tag tag-success">Active</span></td>
                                    <td>11-7-2014</td>
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
                            <label>Phone</label>
                            <input v-model="form.phone" type="text" name="phone" class="form-control"
                                :class="{ 'is-invalid': form.errors.has('phone') }">
                            <has-error :form="form" field="phone"></has-error>
                        </div>

                        <div class="form-group">
                            <label>Role</label>
                            <select class="form-control" v-model="form.role" name="role" :class="{ 'is-invalid': form.errors.has('role') }">
                                <option value="customer">Customer</option>
                                <option value="driver">Driver</option>
                            </select>
                            <has-error :form="form" field="role"></has-error>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
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
                form: new Form({
                    username: '',
                    password: '',
                    email: '',
                    phone: '',
                    role: 'customer'
                })
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }

</script>
