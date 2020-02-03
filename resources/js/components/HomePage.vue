<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-5">
                <form @submit.prevent="save()">
                    <alert-success :form="form">Saved</alert-success>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Home Page</h3>

                            <div class="card-tools">
                                <button class="btn btn-app" type="submit">
                                    <i class="fas fa-save"></i> Save
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-3">


                            <div class="form-group">
                                <div class="form-group">
                                    <label>Page title</label>
                                    <input v-model="form.pageTitle" type="text" name="pageTitle" class="form-control"
                                        :class="{ 'is-invalid': form.errors.has('pageTitle') }">
                                    <has-error :form="form" field="pageTitle"></has-error>
                                </div>
                                <div class="form-group">
                                    <label>Page description</label>
                                    <input v-model="form.pageDescription" type="text" name="pageDescription"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('pageDescription') }">
                                    <has-error :form="form" field="pageDescription"></has-error>
                                </div>
                                <label>Driver slider title</label>
                                <input v-model="form.driverSliderTitle" type="text" name="driverSliderTitle"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('driverSliderTitle') }">
                                <has-error :form="form" field="driverSliderTitle"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Driver slider text</label>
                                <textarea
                                 v-model="form.driverSliderText" name="driverSliderText"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('driverSliderText') }"    
                                rows="3"></textarea>
                                <has-error :form="form" field="driverSliderText"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Main slider background image</label>
                                <input type="file" @change="selectFile" class="form-control">
                            </div>
                            <span v-if="this.form.url !== null"> 
                                <img :src="this.s3Url + this.form.url" alt="" class="img-fluid">
                            </span>

                            <div class="form-group">
                                <label>Main slider title</label>
                                <textarea
                                 v-model="form.mainSliderTitle" name="mainSliderTitle"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('mainSliderTitle') }"    
                                rows="3"></textarea>
                                <has-error :form="form" field="mainSliderTitle"></has-error>
                            </div>
                            

                            <div class="form-group">
                                <label>Work steps sub title</label>
                                <input v-model="form.workStepsSubTitle" type="text" name="workStepsSubTitle"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('workStepsSubTitle') }">
                                <has-error :form="form" field="workStepsSubTitle"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Work steps title</label>
                                <input v-model="form.workStepsTitle" type="text" name="workStepsTitle"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('workStepsTitle') }">
                                <has-error :form="form" field="workStepsTitle"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Work step 1</label>
                                <input v-model="form.workStep1" type="text" name="workStep1"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('workStep1') }">
                                <has-error :form="form" field="workStep1"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Work step 2</label>
                                <input v-model="form.workStep2" type="text" name="workStep2"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('workStep2') }">
                                <has-error :form="form" field="workStep2"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Work step 3</label>
                                <input v-model="form.workStep3" type="text" name="workStep3"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('workStep3') }">
                                <has-error :form="form" field="workStep3"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Work step 4</label>
                                <input v-model="form.workStep4" type="text" name="workStep4"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('workStep4') }">
                                <has-error :form="form" field="workStep4"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Trust box title</label>
                                <input v-model="form.trustBoxTitle" type="text" name="trustBoxTitle"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('trustBoxTitle') }">
                                <has-error :form="form" field="trustBoxTitle"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Statistic title</label>
                                <input v-model="form.statisticTitle" type="text" name="statisticTitle"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('statisticTitle') }">
                                <has-error :form="form" field="statisticTitle"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Statistic number 1</label>
                                <input v-model="form.statisticNumber1" type="text" name="statisticNumber1"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('statisticNumber1') }">
                                <has-error :form="form" field="statisticNumber1"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Statistic number 2</label>
                                <input v-model="form.statisticNumber2" type="text" name="statisticNumber2"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('statisticNumber2') }">
                                <has-error :form="form" field="statisticNumber2"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Statistic number 3</label>
                                <input v-model="form.statisticNumber3" type="text" name="statisticNumber3"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('statisticNumber3') }">
                                <has-error :form="form" field="statisticNumber3"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Statistic number 4</label>
                                <input v-model="form.statisticNumber4" type="text" name="statisticNumber4"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('statisticNumber4') }">
                                <has-error :form="form" field="statisticNumber4"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Statistic number 5</label>
                                <input v-model="form.statisticNumber5" type="text" name="statisticNumber5"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('statisticNumber5') }">
                                <has-error :form="form" field="statisticNumber5"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Statistic Text 1</label>
                                <input v-model="form.statisticText1" type="text" name="statisticText1"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('statisticText1') }">
                                <has-error :form="form" field="statisticText1"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Statistic Text 2</label>
                                <input v-model="form.statisticText2" type="text" name="statisticText2"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('statisticText2') }">
                                <has-error :form="form" field="statisticText2"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Statistic Text 3</label>
                                <input v-model="form.statisticText3" type="text" name="statisticText3"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('statisticText3') }">
                                <has-error :form="form" field="statisticText3"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Statistic Text 4</label>
                                <input v-model="form.statisticText4" type="text" name="statisticText4"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('statisticText4') }">
                                <has-error :form="form" field="statisticText4"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Statistic Text 5</label>
                                <input v-model="form.statisticText5" type="text" name="statisticText5"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('statisticText5') }">
                                <has-error :form="form" field="statisticText5"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Under statistics title</label>
                                <input v-model="form.underStatisticsTitle" type="text" name="underStatisticsTitle"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('underStatisticsTitle') }">
                                <has-error :form="form" field="underStatisticsTitle"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Under statistics text</label>
                                <textarea
                                 v-model="form.underStatisticsText" name="underStatisticsText"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('underStatisticsText') }"    
                                rows="3"></textarea>
                                <has-error :form="form" field="underStatisticsText"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Under statistics video title</label>
                                <input v-model="form.underStatisticsVideoTitle" type="text" name="underStatisticsVideoTitle"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('underStatisticsVideoTitle') }">
                                <has-error :form="form" field="underStatisticsVideoTitle"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Driver banner title</label>
                                <input v-model="form.driverBannerTitle" type="text" name="driverBannerTitle"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('driverBannerTitle') }">
                                <has-error :form="form" field="driverBannerTitle"></has-error>
                            </div>

                            <div class="form-group">
                                <label>Driver banner text</label>
                                <textarea
                                 v-model="form.driverBannerText" name="driverBannerText"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('driverBannerText') }"    
                                rows="3"></textarea>
                                <has-error :form="form" field="driverBannerText"></has-error>
                            </div>

                            <div class="form-group">
                                <label>About title</label>
                                <input v-model="form.aboutTitle" type="text" name="aboutTitle"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('aboutTitle') }">
                                <has-error :form="form" field="aboutTitle"></has-error>
                            </div>

                            <div class="form-group">
                                <label>About text</label>
                                <textarea
                                 v-model="form.aboutText" name="aboutText"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('aboutText') }"    
                                rows="3"></textarea>
                                <has-error :form="form" field="aboutText"></has-error>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </form>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                s3Url: 'https://hellovans-assets.s3.eu-west-2.amazonaws.com/',
                form: new Form({
                    file: null,
                    url:'',
                    page: 'home',
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
                }),
            }
        },
        mounted() {
        },
        created() {
            this.getPage()
            if(window.location.hostname === 'hellovansapi.com') {
                this.s3Url = 'https://hellovans-assets.s3.eu-west-2.amazonaws.com/'
            } 
        },
        methods: {
            selectFile(e) {
                const file = e.target.files[0]
                this.form.file = file
                console.log(file)
            },
            getPage() {
                axios.post('/api/admin/pages', {page: this.form.page})
                    .then(
                        ({
                            data
                        }) => (this.form.fill(data))
                        //
                    )
            },
            save() {
                this.form.post('/api/admin/pages/save', {
                        // Transform form data to FormData
                        transformRequest: [function (data, headers) {
                            return objectToFormData(data)
                        }]
                    })
                    .then(() => {
                        this.getPage()
                    })
                    .catch(() => {

                    })
            },
        }
    }

</script>
