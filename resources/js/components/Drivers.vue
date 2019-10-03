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
                    <!-- Using the VdtnetTable component -->
                    <vdtnet-table ref="table" :fields="fields" :opts="options" :select-checkbox="1" :details="details"
                        @edit="doAlertEdit" @delete="doAlertDelete" @reloaded="doAfterReload"
                        @table-creating="doCreating" @table-created="doCreated">
                        <template slot="HEAD__details_control">
                            <b>Show Details</b>
                        </template>
                        <template slot="address2" slot-scope="ctx">
                            <span>{{ ctx.data.city }}, {{ ctx.comp.formatCode(ctx.data.zipcode) }}</span>
                        </template>
                    </vdtnet-table>
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
                options: {
                    ajax: {
                        url: 'https://jsonplaceholder.typicode.com/users',
                        dataSrc: (json) => {
                            return json
                        }
                    },
                    buttons: ['copy', 'csv', 'print'],
                    /*eslint-disable */
                    dom: "Btr<'row vdtnet-footer'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'pl>>",
                    /*eslint-enable */
                    responsive: false,
                    processing: true,
                    searching: true,
                    searchDelay: 1500,
                    destroy: true,
                    ordering: true,
                    lengthChange: true,
                    serverSide: true,
                    fixedHeader: true,
                    saveState: true
                },
                fields: {
                    id: {
                        label: 'ID',
                        sortable: true
                    },
                    actions: {
                        isLocal: true,
                        label: 'Actions',
                        defaultContent: '<a href="javascript:void(0);" data-action="edit" class="btn btn-primary btn-sm"><i class="mdi mdi-square-edit-outline"></i> Edit</a>' +
                            '<span data-action="delete" class="btn btn-danger btn-sm"><i class="mdi mdi-delete"></i> Delete</span>'
                    },
                    name: {
                        label: 'Name',
                        sortable: true,
                        searchable: true,
                        defaultOrder: 'desc'
                    },
                    username: {
                        label: 'Username',
                        sortable: false,
                        searchable: true
                    },
                    email: {
                        label: 'Email'
                    },
                    address1: {
                        label: 'Address1',
                        data: 'address',
                        template: '{{ data.street }}, {{ data.suite }}'
                    },
                    address2: {
                        label: 'Address2',
                        data: 'address'
                    },
                    phone: {
                        label: 'Phone'
                    },
                    website: {
                        label: 'Website',
                        render: (data) => {
                            return `https://${ data }`
                        }
                    }
                },
                quickSearch: '',
                details: {
                    template: 'I\'m a child for {{ data.id }} yall'
                },
                drivers: {},
                form: new Form({
                    username: '',
                    password: '',
                    email: '',
                    phone: '',
                    role: 'driver',
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
            doLoadTable(cb) {
                $.getJSON('https://jsonplaceholder.typicode.com/users', function (data) {
                    cb(data)
                })
            },
            doAlertEdit(data) {
                window.alert(`row edit click for item ID: ${data.id}`)
            },
            doAlertDelete(data, row, tr, target) {
                window.alert(`deleting item ID: ${data.id}`)
                // row.remove() doesn't work when serverside is enabled
                // so we fake it with dom remove
                tr.remove()
                const table = this.$refs.table
                setTimeout(() => {
                    // simulate extra long running ajax
                    table.reload()
                }, 1500)
            },
            doAfterReload(data, table) {
                window.alert('data reloaded')
            },
            doCreating(comp, el) {
                console.log('creating')
            },
            doCreated(comp) {
                console.log('created')
            },
            doSearch() {
                this.$refs.table.search(this.quickSearch)
            },
            doExport(type) {
                const parms = this.$refs.table.getServerParams()
                parms.export = type
                window.alert('GET /api/v1/export?' + jQuery.param(parms))
            },
            formatCode(zipcode) {
                return zipcode.split('-')[0]
            },
            getDrivers() {
                axios.get('/api/admin/user')
                    .then(
                        ({
                            data
                        }) => (
                            this.drivers = data.filter(function (driver) {
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
