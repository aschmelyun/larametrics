@extends('larametrics::common.default')
@section('content')
<div class="row row-cards" id="larametricsRequests">
    <div class="col-12">
        <div class="btn-list" style="margin-bottom: 0.75rem;">
            <a href="#" :class="{'btn': true, 'btn-secondary': true, 'disabled': typeof requestsPaginated[page - 1] == 'undefined'}" @click.prevent="page = (page - 1)">Prev</a>
            <a href="#" v-for="n in pageNumbers" v-text="n + 1" :class="{'btn': true, 'disabled': page === (n), 'btn-primary': page === (n), 'btn-secondary': page !== (n)}" @click.prevent="page = (n)"></a>
            <a href="#" :class="{'btn': true, 'btn-secondary': true, 'disabled': typeof requestsPaginated[page + 1] == 'undefined'}" @click.prevent="page = (page + 1)">Next</a>
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">All Requests</h3>
            </div>
            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Method</th>
                            <th>Date</th>
                            <th>URI</th>
                            <th>IP Address</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(request, index) in requestsPaginated[page]">
                            <td><i :class="getRequestClass(request)"></i></td>
                            <td v-text="request.method"></td>
                            <td v-text="request.created_at"></td>
                            <td><strong v-text="request.uri"></strong></td>
                            <td v-text="request.ip"></td>
                            <td><a :href="requestsRoute + '/' + request.id" class="btn btn-secondary btn-sm">View Details</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="btn-list">
            <a href="#" :class="{'btn': true, 'btn-secondary': true, 'disabled': typeof requestsPaginated[page - 1] == 'undefined'}" @click.prevent="page = (page - 1)">Prev</a>
            <a href="#" v-for="n in pageNumbers" v-text="n + 1" :class="{'btn': true, 'disabled': page === (n), 'btn-primary': page === (n), 'btn-secondary': page !== (n)}" @click.prevent="page = (n)"></a>
            <a href="#" :class="{'btn': true, 'btn-secondary': true, 'disabled': typeof requestsPaginated[page + 1] == 'undefined'}" @click.prevent="page = (page + 1)">Next</a>
        </div>
    </div>
</div>
@php $requestsRoute = route('larametrics::requests.index'); @endphp
<script>
    var app = new Vue({
        el: '#larametricsRequests',
        data: {
            requests: {!! json_encode($requests) !!},
            requestsRoute: "{{ $requestsRoute }}",
            page: 0,
            maxPerPage: 20
        },
        methods: {
            getRequestClass: function(request) {
                let textClass = 'fe-circle text-info';

                if(request.method === 'POST' || request.method === 'PUT' || request.method === 'OPTIONS') {
                    textClass = 'fe-disc text-warning';
                }

                if(request.method === 'DELETE') {
                    textClass = 'fe-minus-circle text-danger';
                }

                return 'fe ' + textClass;
            }
        },
        computed: {
            requestsPaginated: function() {
                let groups = [];
                for(let i=0; i<this.requests.length; i+=this.maxPerPage) {
                    groups.push(this.requests.slice(i, i + this.maxPerPage));
                }

                return groups;
            },
            pageNumbers: function() {
                let pageNumbers = [];
                if(this.requestsPaginated.length < 10) {
                    for (i = 0; i < this.requestsPaginated.length; i++) { 
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