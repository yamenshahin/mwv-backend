<template>
    <div class="container-fluid">
        <div class="row ">
            <div class="col">
                <div class="card mt-3">
                    <div class="card-header">
                        <h4> <i class="fas fa-chart-pie mr-1"></i>Statistics And charts Component</h4>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <!-- users -->
                            <div class="col-12 col-lg-6">
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <i class="fas fa-user mr-1"></i> Users
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Type</th>
                                                    <th style="width: 40px">Number</th>
                                                    <th style="width: 40px">%</th>
                                                    <th style="width: 100px">%</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Users (All)</td>
                                                    <td><span class="badge bg-success">{{user.userAll}}</span></td>
                                                    <td><span class="badge bg-success">100%</span></td>
                                                    <td>
                                                        <div class="progress progress-xs">
                                                            <div class="progress-bar progress-bar-danger"
                                                                v-bind:style="{ width: user.userAll/user.userAll*100 + '%' }">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Customers (without counting drivers)</td>
                                                    <td><span class="badge bg-success">{{user.customer}}</span></td>
                                                    <td><span
                                                            class="badge bg-success">{{user.customer/user.userAll*100 | intToFloatString | percentage}}</span>
                                                    </td>
                                                    <td>
                                                        <div class="progress progress-xs">
                                                            <div class="progress-bar progress-bar-danger"
                                                                v-bind:style="{ width: user.customer/user.userAll*100 + '%' }">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Drivers</td>
                                                    <td><span class="badge bg-success">{{user.driver}}</span></td>
                                                    <td><span
                                                            class="badge bg-success">{{user.driver/user.userAll*100 | intToFloatString | percentage}}</span>
                                                    </td>
                                                    <td>
                                                        <div class="progress progress-xs">
                                                            <div class="progress-bar progress-bar-danger"
                                                                v-bind:style="{ width: user.driver/user.userAll*100 + '%' }">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Jobs -->
                            <div class="col-12 col-lg-6">
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <i class="fas fa-truck-loading mr-1"></i> Jobs
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Type</th>
                                                    <th style="width: 40px">Number</th>
                                                    <th style="width: 40px">%</th>
                                                    <th style="width: 100px">%</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Jobs (All)</td>
                                                    <td><span class="badge bg-success">{{job.jobAll}}</span></td>
                                                    <td><span class="badge bg-success">100%</span></td>
                                                    <td>
                                                        <div class="progress progress-xs">
                                                            <div class="progress-bar progress-bar-danger"
                                                                v-bind:style="{ width: job.jobAll/job.jobAll*100 + '%' }">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Booked</td>
                                                    <td><span class="badge bg-success">{{job.booked}}</span></td>
                                                    <td><span
                                                            class="badge bg-success">{{job.booked/job.jobAll*100 | intToFloatString | percentage}}</span>
                                                    </td>
                                                    <td>
                                                        <div class="progress progress-xs">
                                                            <div class="progress-bar progress-bar-danger"
                                                                v-bind:style="{ width: job.booked/job.jobAll*100 + '%' }">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Not Booked</td>
                                                    <td><span class="badge bg-success">{{job.unbooked}}</span></td>
                                                    <td><span
                                                            class="badge bg-success">{{job.unbooked/job.jobAll*100 | intToFloatString | percentage}}</span>
                                                    </td>
                                                    <td>
                                                        <div class="progress progress-xs">
                                                            <div class="progress-bar progress-bar-danger"
                                                                v-bind:style="{ width: job.unbooked/job.jobAll*100 + '%' }">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                user: {
                    userAll: 0,
                    customer: 0,
                    driver: 0,
                },
                job: {
                    jobAll: 0,
                    booked: 0,
                    unbooked: 0,
                },
            }
        },
        mounted() {},
        created() {
            this.getUserStatistics()
            this.getJobStatistics()
        },
        methods: {
            getUserStatistics() {
                axios.post('/api/admin/statistic', {
                        type: 'user'
                    })
                    .then(
                        ({
                            data
                        }) => (this.user = data)
                        //
                    )
            },
            getJobStatistics() {
                axios.post('/api/admin/statistic', {
                        type: 'job'
                    })
                    .then(
                        ({
                            data
                        }) => (this.job = data)
                        //
                    )
            }
        }
    }

</script>
