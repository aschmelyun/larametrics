@extends('larametrics::common.default')
@section('content')
<div class="row row-cards" id="larametricsLogs">
    <div class="col-12">
        <div class="btn-list" style="margin-bottom:0.75rem">
            <a href="#" :class="{'btn': true, 'btn-secondary': true, 'disabled': typeof logsPaginated[page - 1] == 'undefined'}" @click.prevent="page = (page - 1)">Prev</a>
            <a href="#" v-for="n in pageNumbers" v-text="n + 1" :class="{'btn': true, 'disabled': page === (n), 'btn-primary': page === (n), 'btn-secondary': page !== (n)}" @click.prevent="page = (n)"></a>
            <a href="#" :class="{'btn': true, 'btn-secondary': true, 'disabled': typeof logsPaginated[page + 1] == 'undefined'}" @click.prevent="page = (page + 1)">Next</a>
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">All Logs</h3>
            </div>
            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Log Level</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="log in logsPaginated[page]">
                            <td><i :class="getLogClass(log)"></i></td>
                            <td v-text="log.level.charAt(0).toUpperCase() + log.level.slice(1)"></td>
                            <td v-text="log.created_at"></td>
                            <td><strong v-text="log.message.substring(0, 96) + '...'"></strong></td>
                            <td><a :href="logsRoute + '/' + log.id" class="btn btn-secondary btn-sm">View Details</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="btn-list">
            <a href="#" :class="{'btn': true, 'btn-secondary': true, 'disabled': typeof logsPaginated[page - 1] == 'undefined'}" @click.prevent="page = (page - 1)">Prev</a>
            <a href="#" v-for="n in pageNumbers" v-text="n + 1" :class="{'btn': true, 'disabled': page === (n), 'btn-primary': page === (n), 'btn-secondary': page !== (n)}" @click.prevent="page = (n)"></a>
            <a href="#" :class="{'btn': true, 'btn-secondary': true, 'disabled': typeof logsPaginated[page + 1] == 'undefined'}" @click.prevent="page = (page + 1)">Next</a>
        </div>
    </div>
</div>
@php $logsRoute = route('larametrics::logs.index'); @endphp
<script>
    var app = new Vue({
        el: '#larametricsLogs',
        data: {
            logs: {!! json_encode($logs) !!},
            logsRoute: "{{ $logsRoute }}",
            page: 0,
            maxPerPage: 20
        },
        methods: {
            getLogClass: function(log) {
                let textClass = 'fe-alert-circle text-info';

                if(log.level === 'warning' || log.level === 'failed') {
                    textClass = 'fe-alert-circle text-warning';
                }

                if(log.level === 'error' || log.level === 'critical' || log.level === 'alert' || log.level === 'emergency') {
                    textClass = 'fe-alert-triangle text-danger';
                }

                return 'fe ' + textClass;
            }
        },
        computed: {
            logsPaginated: function() {
                let groups = [];
                for(let i=0; i<this.logs.length; i+=this.maxPerPage) {
                    groups.push(this.logs.slice(i, i + this.maxPerPage));
                }

                return groups;
            },
            pageNumbers: function() {
                let pageNumbers = [];
                if(this.logsPaginated.length < 10) {
                    for (i = 0; i < this.logsPaginated.length; i++) { 
                        pageNumbers.push(i);
                    }

                    return pageNumbers;
                }

                if(this.page >= 10) {
                    for(i = this.page - 9; i < this.page + 1; i++) {
                        pageNumbers.push(i);
                    }
                } else {
                    for(i = 0; i < 10; i++) {
                        pageNumbers.push(i);
                    }
                }

                return pageNumbers;
            }
        }
    });
</script>
@endsection