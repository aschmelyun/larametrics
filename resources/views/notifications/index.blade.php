@extends('larametrics::common.default')
@section('content')
<div class="row row-cards" id="larametricsNotifications">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">All Active Notifications</h3>
            </div>
            <div class="card-body">
                <div v-for="(notification, index) in notifications" :class="{'row': true, 'mt-4': index > 0}">
                    <div class="col-sm-4">
                        <div class="input-group">
                            <span class="input-group-prepend" id="action-addon">
                                <span class="input-group-text"><strong>When</strong></span>
                            </span>
                            <select name="action" id="action" class="form-control custom-select" v-model="notification.action" aria-label="When" aria-describedby="action-addon">
                                <option value="model_created">A model is created</option>
                                <option value="model_updated">A model is updated</option>
                                <option value="model_deleted">A model is deleted</option>
                                <option value="logged_error">An error is logged</option>
                                <option value="logged_notice">A notice is logged</option>
                                <option value="logged_debug">A debug message is logged</option>
                                <option value="request_route">A route is requested</option>
                                <option value="execution_time">A route's execution time</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group" v-if="notification.action.includes('model_')">
                            <span class="input-group-prepend" id="filter-addon">
                                <span class="input-group-text"><strong>and the model is</strong></span>
                            </span>
                            <select name="filter" id="filter" class="form-control custom-select" v-model="notification.filter" aria-label="and the model is" aria-describedby="filter-addon">
                                <option value="*">Any Model</option>
                                @foreach(config('larametrics.modelsWatched') as $model)
                                    <option value="{{ $model }}">{{ $model }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group" v-if="notification.action.includes('logged_')">
                            <span class="input-group-prepend" id="filter-addon">
                                <span class="input-group-text"><strong>and the message contains</strong></span>
                            </span>
                            <input type="text" name="filter" id="filter" class="form-control" v-model="notification.filter" aria-label="and the message contains" aria-describedby="filter-addon">
                        </div>
                        <div class="input-group" v-if="notification.action.includes('request_')">
                            <span class="input-group-prepend" id="filter-addon">
                                <span class="input-group-text"><strong>and the route contains</strong></span>
                            </span>
                            <input type="text" name="filter" id="filter" class="form-control" v-model="notification.filter" aria-label="and the route contains" aria-describedby="filter-addon">
                        </div>
                        <div class="input-group" v-if="notification.action.includes('execution_')">
                            <span class="input-group-prepend" id="filter-addon">
                                <span class="input-group-text"><strong>is longer than (ms)</strong></span>
                            </span>
                            <input type="number" name="filter" id="filter" class="form-control" v-model="notification.filter" aria-label="and the route contains" aria-describedby="filter-addon">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <span class="input-group-prepend" id="notify_by-addon">
                                <span class="input-group-text"><strong>notify me by</strong></span>
                            </span>
                            <select name="notify_by" id="notify_by" class="form-control custom-select" v-model="notification.notify_by" aria-label="notify me by" aria-describedby="notify_by-addon">
                                <option value="email">Email</option>
                                <option value="slack">Slack</option>
                                <option value="email_slack">Email + Slack</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <a href="#" class="btn btn-danger" @click.prevent="removeNotification(index)">
                            <i class="fe fe-trash"></i>
                        </a>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-sm-11"></div>
                    <div class="col-sm-1">
                        <a href="#" class="btn btn-secondary" @click.prevent="addNotification">
                            <i class="fe fe-plus-circle"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <form action="{{ route('larametrics::notifications.update') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="notifications" id="notifications" :value="JSON.stringify(notifications)">
                    <button type="submit" class="btn btn-primary">Save Notifications</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    var app = new Vue({
        el: '#larametricsNotifications',
        data: {
            notifications: {!! json_encode($notifications) !!}
        },
        methods: {
            addNotification: function() {
                this.notifications.push({
                    action: "model_deleted",
                    filter: "*",
                    notify_by: "email"
                });
            },
            removeNotification: function(index) {
                this.notifications.splice(index, 1);
            }
        },
        computed: {

        }
    });
</script>
@endsection