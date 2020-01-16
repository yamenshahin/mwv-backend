<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">UK Landing Pages</h3>

                        <div class="card-tools">
                            <a class="btn btn-app" @click.prevent="newPageModal">
                                <i class="fas fa-plus-square"></i> New Page
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Slug</th>
                                    <th>View</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="page in pages" :key="page.id">
                                    <td>{{page.id}}</td>
                                    <td>{{page.slug}}</td>
                                    <td>
                                        <a href="#" @click.prevent="editPageModal(page)">
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
        <div class="modal fade" id="pageModal" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">

                <div class="modal-content">
                    <form @submit.prevent="editMode ? editPage() : newPage()">

                        <div class="modal-header">
                            <h4 class="modal-title"> {{editMode ? 'Edit' : 'New'}} Page</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Page title</label>
                                <input v-model="form.meta.pageTitle" type="text" name="pageTitle" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('pageTitle') }">
                                <has-error :form="form" field="pageTitle"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Page description</label>
                                <input v-model="form.meta.pageDescription" type="text" name="pageDescription"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('pageDescription') }">
                                <has-error :form="form" field="pageDescription"></has-error>
                            </div>
                            <span v-if="editMode">
                                <input type="hidden" name="id" v-model="form.id">
                            </span>
                            <input type="hidden" name="category" v-model="form.category">
                            <div class="form-group">
                                <label>URL Slug</label>
                                <input v-model="form.slug" type="text" name="slug" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('slug') }">
                                <has-error :form="form" field="slug"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Driver slider title</label>
                                <input v-model="form.meta.driverSliderTitle" type="text" name="driverSliderTitle"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('driverSliderTitle') }">
                                <has-error :form="form" field="driverSliderTitle"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Driver slider text</label>
                                <textarea v-model="form.meta.driverSliderText" name="driverSliderText"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('driverSliderText') }"
                                    rows="3"></textarea>
                                <has-error :form="form" field="driverSliderText"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Main slider title</label>
                                <textarea v-model="form.meta.mainSliderTitle" name="mainSliderTitle"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('mainSliderTitle') }"
                                    rows="3"></textarea>
                                <has-error :form="form" field="mainSliderTitle"></has-error>
                            </div>


                            <div class="form-group">
                                <label>Work steps sub title</label>
                                <input v-model="form.meta.workStepsSubTitle" type="text" name="workStepsSubTitle"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('workStepsSubTitle') }">
                                <has-error :form="form" field="workStepsSubTitle"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Work steps title</label>
                                <input v-model="form.meta.workStepsTitle" type="text" name="workStepsTitle"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('workStepsTitle') }">
                                <has-error :form="form" field="workStepsTitle"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Work step 1</label>
                                <input v-model="form.meta.workStep1" type="text" name="workStep1" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('workStep1') }">
                                <has-error :form="form" field="workStep1"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Work step 2</label>
                                <input v-model="form.meta.workStep2" type="text" name="workStep2" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('workStep2') }">
                                <has-error :form="form" field="workStep2"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Work step 3</label>
                                <input v-model="form.meta.workStep3" type="text" name="workStep3" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('workStep3') }">
                                <has-error :form="form" field="workStep3"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Work step 4</label>
                                <input v-model="form.meta.workStep4" type="text" name="workStep4" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('workStep4') }">
                                <has-error :form="form" field="workStep4"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Trust box title</label>
                                <input v-model="form.meta.trustBoxTitle" type="text" name="trustBoxTitle"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('trustBoxTitle') }">
                                <has-error :form="form" field="trustBoxTitle"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Statistic title</label>
                                <input v-model="form.meta.statisticTitle" type="text" name="statisticTitle"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('statisticTitle') }">
                                <has-error :form="form" field="statisticTitle"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Statistic number 1</label>
                                <input v-model="form.meta.statisticNumber1" type="text" name="statisticNumber1"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('statisticNumber1') }">
                                <has-error :form="form" field="statisticNumber1"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Statistic number 2</label>
                                <input v-model="form.meta.statisticNumber2" type="text" name="statisticNumber2"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('statisticNumber2') }">
                                <has-error :form="form" field="statisticNumber2"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Statistic number 3</label>
                                <input v-model="form.meta.statisticNumber3" type="text" name="statisticNumber3"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('statisticNumber3') }">
                                <has-error :form="form" field="statisticNumber3"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Statistic number 4</label>
                                <input v-model="form.meta.statisticNumber4" type="text" name="statisticNumber4"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('statisticNumber4') }">
                                <has-error :form="form" field="statisticNumber4"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Statistic number 5</label>
                                <input v-model="form.meta.statisticNumber5" type="text" name="statisticNumber5"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('statisticNumber5') }">
                                <has-error :form="form" field="statisticNumber5"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Statistic Text 1</label>
                                <input v-model="form.meta.statisticText1" type="text" name="statisticText1"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('statisticText1') }">
                                <has-error :form="form" field="statisticText1"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Statistic Text 2</label>
                                <input v-model="form.meta.statisticText2" type="text" name="statisticText2"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('statisticText2') }">
                                <has-error :form="form" field="statisticText2"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Statistic Text 3</label>
                                <input v-model="form.meta.statisticText3" type="text" name="statisticText3"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('statisticText3') }">
                                <has-error :form="form" field="statisticText3"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Statistic Text 4</label>
                                <input v-model="form.meta.statisticText4" type="text" name="statisticText4"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('statisticText4') }">
                                <has-error :form="form" field="statisticText4"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Statistic Text 5</label>
                                <input v-model="form.meta.statisticText5" type="text" name="statisticText5"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('statisticText5') }">
                                <has-error :form="form" field="statisticText5"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Under statistics title</label>
                                <input v-model="form.meta.underStatisticsTitle" type="text" name="underStatisticsTitle"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('underStatisticsTitle') }">
                                <has-error :form="form" field="underStatisticsTitle"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Under statistics text</label>
                                <textarea v-model="form.meta.underStatisticsText" name="underStatisticsText"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('underStatisticsText') }"
                                    rows="3"></textarea>
                                <has-error :form="form" field="underStatisticsText"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Under statistics video title</label>
                                <input v-model="form.meta.underStatisticsVideoTitle" type="text" name="underStatisticsVideoTitle"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('underStatisticsVideoTitle') }">
                                <has-error :form="form" field="underStatisticsVideoTitle"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Driver banner title</label>
                                <input v-model="form.meta.driverBannerTitle" type="text" name="driverBannerTitle"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('driverBannerTitle') }">
                                <has-error :form="form" field="driverBannerTitle"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Driver banner text</label>
                                <textarea v-model="form.meta.driverBannerText" name="driverBannerText"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('driverBannerText') }"
                                    rows="3"></textarea>
                                <has-error :form="form" field="driverBannerText"></has-error>
                            </div>

                            <div class="form-group">
                                <label>About title</label>
                                <input v-model="form.meta.aboutTitle" type="text" name="aboutTitle" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('aboutTitle') }">
                                <has-error :form="form" field="aboutTitle"></has-error>
                            </div>

                            <div class="form-group">
                                <label>About text</label>
                                <textarea v-model="form.meta.aboutText" name="aboutText" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('aboutText') }" rows="3"></textarea>
                                <has-error :form="form" field="aboutText"></has-error>
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
                pages: {},
                category: 'uk',
                form: new Form({
                    id: '',
                    category: 'uk',
                    slug: '',
                    meta: {
                        pageTitle: '',
                        pageDescription: '',
                        driverSliderTitle: '',
                        driverSliderText: '',
                        mainSliderTitle: '',
                        workStepsSubTitle: '',
                        workStepsTitle: '',
                        workStep1: '',
                        workStep2: '',
                        workStep3: '',
                        workStep4: '',
                        trustBoxTitle: '',
                        statisticTitle: '',
                        statisticNumber1: '',
                        statisticNumber2: '',
                        statisticNumber3: '',
                        statisticNumber4: '',
                        statisticNumber5: '',
                        statisticText1: '',
                        statisticText2: '',
                        statisticText3: '',
                        statisticText4: '',
                        statisticText5: '',
                        underStatisticsTitle: '',
                        underStatisticsText: '',
                        underStatisticsVideoTitle: '',
                        driverBannerTitle: '',
                        driverBannerText: '',
                        aboutTitle: '',
                        aboutText: '',
                    }
                }),
            }
        },
        mounted() {},
        created() {
            this.getPages()
        },
        methods: {
            getPages() {
                axios.post('/api/admin/dynamic-pages', {
                        category: this.category
                    })
                    .then(
                        ({
                            data
                        }) => (this.pages = data.data)
                    )
            },
            newPageModal() {
                this.editMode = false
                this.form.clear()
                this.form.reset()
                $('#pageModal').modal('show')
            },
            editPageModal(page) {
                this.editMode = true
                this.form.clear()
                $('#pageModal').modal('show')
                this.form.fill(page)
            },
            newPage() {
                this.form.post('/api/admin/dynamic-pages/save')
                    .then(() => {
                        this.getPages()
                    })
                    .catch(() => {

                    })
            },
            editPage() {
                this.form.post('/api/admin/dynamic-pages/save')
                    .then(() => {
                        this.getPages()
                    })
                    .catch(() => {

                    })
            },

        }
    }

</script>
