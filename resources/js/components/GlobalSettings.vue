<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Global settings</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Key</th>
                                    <th>Value</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="meta in metas" :key="meta.id">
                                    <td>{{meta.id}}</td>
                                    <td>{{meta.key | unCamelCase}}</td>
                                    <td>{{meta.value}}</td>
                                    <td>
                                        <a href="#" @click.prevent="editMetaModal(meta)">
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
        <div class="modal fade" id="metaModal" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">

                <div class="modal-content">
                    <form @submit.prevent="editmode ? editMeta() : newMeta()">
                        <div class="modal-header">
                            <h4 class="modal-title"> {{editmode ? 'Edit' : 'New'}} Meta</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <input v-model="form.key" type="hidden" name="key">
                                

                            <div class="form-group">
                                <label>Value</label>
                                <input v-model="form.value" type="text" name="value" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('value') }">
                                <has-error :form="form" field="value"></has-error>
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
                metas: {},
                form: new Form({
                    id: '',
                    key: '',
                    value: '',
                })
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created() {
            this.getMetas()
        },
        methods: {
            newMetaModal() {
                this.editmode =false
                this.form.clear()
                this.form.reset()
                $('#metaModal').modal('show')
            },
            editMetaModal(meta) {
                this.editmode =true
                this.form.clear()
                $('#metaModal').modal('show')
                this.form.fill(meta)
            },
            getMetas(){
                axios.get('/api/admin/meta')
                .then(
                    ({ data }) => (this.metas= data)
                )
                
            },
            newMeta() {
                this.form.post('/api/admin/meta')
                .then(() => {
                    this.getMetas()
                })
                .catch(() => {

                })
            },
            editMeta() {
                this.form.put('/api/admin/meta/'+this.form.key)
                .then(() => {
                    this.getMetas()
                })
                .catch(() => {

                })
            }
        }
    }

</script>
