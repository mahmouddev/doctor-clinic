<template>
    <div>
        <div class="alert alert-danger" id="error_alert" v-if="error_message">
            <h6 style="margin: 0; color: #fff; font-size:15px; line-height:1.6em">
                <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                {{ error_message }}
            </h6>
    </div>
    <p  v-if="!requirements_page && !permission_page && !complete_installation_page">
        Welome at Doctor clinic installer , this is easy installer to help you install doctor clinic in few easy steps
    </p>
    <span v-html="page"  v-if="requirements_page || permission_page"></span>
    <div class="loader"  v-if="loader && (requirements_page || permission_page)"></div>
    <div class="buttons">
        <a class="button" @click="permissions()" v-if="requirements_page && permissions_button && !loader">
            Check Permissions
            <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i> 
        </a>
        <a class="button" @click="requirements()" v-if="!requirements_page && !permission_page && !complete_installation_page">
            Start instalation
            <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
        </a>
        <a class="button" @click="completeInstallationPage()" v-if="permission_page && complete_installation_button && !loader">
            Configure Environment
            <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
        </a>
        <a class="button" @click="permissions()" v-if="permission_page && !complete_installation_button && !loader"
            style="background-color: #fd0909;">
            Retry
            <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
        </a>
    </div>
    <div class="tabs tabs-full" v-if="complete_installation_page">
        <div v-if="finished">
            <h6 style="margin: 0; padding: 0; font-size:17px" v-if="finished"> Installation Finished</h6>
            <p><strong><small>Migration &amp; Seed Console Output:</small></strong></p>
            <pre><code>{{ dbOutputLog }}</code></pre>

            <p><strong><small>Application Console Output:</small></strong></p>
            <pre><code>{{ finalMessages }}</code></pre>

            <p><strong><small>Installation Log Entry:</small></strong></p>
            <pre><code>{{ finalStatusMessage }}</code></pre>

            <p><strong><small>Final .env File:</small></strong></p>
            <pre><code>{{ finalEnvFile }}</code></pre>

            <div class="buttons">
                <a :href="login_url" class="button">Click here to exit</a>
            </div>
        </div>
        <div v-if="!finished">
            <input id="tab1" type="radio" name="tabs" class="tab-input" checked />
            <div class="alert alert-danger" id="error_alert" style="background:#6fe373" v-if="connection_exists">
                <h6 style="margin: 0; color: #fff; font-size:15px; line-height:1.6em">
                    Database connection tested successfully
                </h6>
            </div>

            <form class="tabs-wrap">
                <div class="tab" id="tab1content">
                    <input type="hidden" name="_token" value="{{ window.laravel }}">

                    <div class="form-group" :class="{ 'has-error': errors['app_name'] }">
                        <label for="app_name">
                            App Name
                        </label>
                        <input type="text" name="app_name" id="app_name" v-model="app_name" placeholder="App Name" />
                        <span class="error-block" v-if="errors['app_name']">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ errors['app_name'] }}
                        </span>
                    </div>

                    <div class="form-group" :class="{ 'has-error': errors['app_timezone'] }">
                        <label for="app_timezone">
                            App Timezone
                        </label>
                        <select name="app_timezone" id="app_timezone" v-model="app_timezone">
                            <option :value="timezone" v-for="timezone in timezones">{{ timezone }}</option>
                        </select>
                        <span class="error-block" v-if="errors['app_timezone']">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ errors['app_timezone'] }}
                        </span>
                    </div>

                    <div class="form-group " :class="{ 'has-error': errors['database_connection'] }">
                        <label for="database_connection">
                            Database Connection
                        </label>
                        <select name="database_connection" id="database_connection" v-model="database_connection"
                            @change="changeDBConnection()">
                            <option value="1">mysql</option>
                            <option value="2">pgsql</option>
                        </select>
                        <span class="error-block" v-if="errors['database_connection']">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ errors['database_connection'] }}
                        </span>

                    </div>

                    <div class="form-group " :class="{ 'has-error': errors['database_host'] }">
                        <label for="database_hostname">
                            Database Host
                        </label>
                        <input type="text" name="database_hostname" id="database_hostname" v-model="database_host"
                            placeholder="Database Host" @input="valuesChangedAfterTest()" />
                        <span class="error-block" v-if="errors['database_host']">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ errors['database_host'] }}
                        </span>
                    </div>

                    <div class="form-group" :class="{ 'has-error': errors['database_port'] }">
                        <label for="database_port">
                            Database Port
                        </label>
                        <input type="number" name="database_port" id="database_port" v-model="database_port"
                            placeholder="Database Port" @input="valuesChangedAfterTest()" />
                        <span class="error-block" v-if="errors['database_port']">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ errors['database_port'] }}
                        </span>
                    </div>

                    <div class="form-group" :class="{ 'has-error': errors['database_name'] }">
                        <label for="database_name">
                            Database Name
                        </label>
                        <input type="text" name="database_name" id="database_name" v-model="database_name"
                            placeholder="Database Name" @input="valuesChangedAfterTest()" />
                        <span class="error-block" v-if="errors['database_name']">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ errors['database_name'] }}
                        </span>
                    </div>

                    <div class="form-group " :class="{ 'has-error': errors['database_user_name'] }">
                        <label for="database_username">
                            Database User Name
                        </label>
                        <input type="text" name="database_username" id="database_username"
                            v-model="database_user_name" placeholder="Database User Name"
                            @input="valuesChangedAfterTest()" />
                        <span class="error-block" v-if="errors['database_user_name']">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ errors['database_user_name'] }}
                        </span>
                    </div>

                    <div class="form-group" :class="{ 'has-error': errors['database_password'] }">
                        <label for="database_password">
                            Database Password
                        </label>
                        <input type="password" name="database_password" id="database_password"
                            v-model="database_password" placeholder="Database Password"
                            @input="valuesChangedAfterTest()" />
                        <span class="error-block" v-if="errors['database_password']">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ errors['database_password'] }}
                        </span>
                    </div>
                    <div class="loader" v-if="loader"></div>
                    <div class="buttons" v-if="!loader">
                        <button class="button" type="button" style="background-color: #66cd66; font-size:14px"
                            @click="testConnection()" v-if="!connection_exists">
                            Test DB Connection
                            <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
                        </button>
                        <button class="button" type="button" @click="completeInstallation()" v-if="connection_exists">
                            Install
                            <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
    </div>
</template>


<script>
/"allowJs": true/

import axios  from "axios";
export default {
    name: 'Installer',
    props: {        
    },
    data() {
        return {
            errors: [],
            login_url: window.installer.login_url,
            error_message: '',
            name: null,
            loader: false,
            permissions_page: false,
            permissions_button: false,
            complete_installation_button: false,
            requirements_page: false,
            complete_installation_page: false,
            page: '',
            app_name: 'Doctor Clinic',
            app_timezone: null,
            database_connection: 1,
            database_host: 'localhost',
            database_port: '3306',
            database_name: 'clinic',
            database_user_name: 'homestead',
            database_password: 'secret',
            connection_exists: false,
            finished: false,
            finalEnvFile: null,
            finalStatusMessage: null,
            finalMessages: null,
            dbOutputLog: null,
            is_sub_directory: window.installer.is_sub_directory,
            timezones: window.installer.timezones,
            host: window.installer.host
        }
    },

    methods: {
        requirements() {
            this.loader = true;
            axios.get(window.installer.requirements_url).then(res => {
                this.loader = false;
                this.page = res.data.html;
                this.requirements_page = true;
                if (res.data.status) this.permissions_button = true;
            }).catch(err => {
                this.loader = false;
                this.error_message = 'Something Went Wrong'
            });
        },

        permissions() {
            this.loader = true;
            axios.get(window.installer.permissions_url).then(res => {
                this.requirements_page = false;
                this.permission_page = true;
                this.page = res.data.html;
                this.loader = false;
                if (res.data.status) this.complete_installation_button = true;
            }).catch(err => {
                this.loader = false;
                this.error_message = 'Something Went Wrong'
            });
        },

        testConnection() {
            let res = this.validator('test_db');
            if (res) {
                this.loader = true;
                const tdata = {
                    database_connection: this.database_connection == 1 ? 'mysql' : (this.database_connection == 2 ? 'pgsql' : 'null'),
                    database_hostname: this.database_host,
                    database_port: this.database_port,
                    database_name: this.database_name,
                    database_user_name: this.database_user_name,
                    database_password: this.database_password
                }
                axios.post(window.installer.test_connection_url, tdata).then(res => {
                    if (res.data && res.data.status_code && res.data.status_code == 200) {
                        this.connection_exists = true;
                    }
                    else if (res.data && res.data.status_code && res.data.status_code == 422 && res.data.errors) {
                        this.errors['database_connection'] = res.data.errors['database_connection'][0];
                    }
                    else {
                        this.error_message = 'Could not connect to the database';
                    }
                    this.loader = false;
                })
                    .catch(err => {
                        this.loader = false;
                        this.error_message = 'Could not connect to the database';

                    })

            }
        },

        completeInstallation() {
            let res = this.validator('test_db', true);
            if (res) {
                this.loader = true;
                const sdata = {
                    app_name: this.app_name,
                    app_timezone: this.app_timezone,
                    database_connection: this.database_connection == 1 ? 'mysql' : (this.database_connection == 2 ? 'pgsql' : 'null'),
                    database_hostname: this.database_host,
                    database_port: this.database_port,
                    database_name: this.database_name,
                    database_username: this.database_user_name,
                    database_password: this.database_password,
                }
                axios.post(window.installer.complete_installation_url, sdata).then(res => {
                        if (
                            res.data 
                            && res.data.status_code 
                            && res.data.status_code == 422 
                            && res.data.errors) {
                                console.log('422');
                                if (res.data.errors['app_name']) this.errors['app_name'] = res.data.errors['app_name'][0];
                                if (res.data.errors['app_timezone']) this.errors['app_timezone'] = res.data.errors['app_timezone'][0];
                                if (res.data.errors['database_connection']) this.errors['database_connection'] = res.data.errors['database_connection'][0];
                                if (res.data.errors['database_hostname']) this.errors['database_host'] = res.data.errors['database_hostname'][0];
                                if (res.data.errors['database_port']) this.errors['database_port'] = res.data.errors['database_port'][0];
                                if (res.data.errors['database_name']) this.errors['database_name'] = res.data.errors['database_name'][0];
                                if (res.data.errors['database_username']) this.errors['database_user_name'] = res.data.errors['database_username'][0];
                                if (res.data.errors['database_password']) this.errors['database_password'] = res.data.errors['database_password'][0];
                        }
                        else if (
                            res.data 
                            && res.data.status_code 
                            && res.data.status_code == 500
                            ) {
                                console.log('500');

                            this.error_message = res.data.errors;
                        }
                        else if (
                            res.data 
                            && res.data.status_code 
                            && res.data.status_code == 200
                        ) {
                            console.log('200');

                            this.dbOutputLog = res.data.dbOutputLog;
                            this.finalMessages = res.data.final.finalMessages;
                            this.finalStatusMessage = res.data.final.finalStatusMessage;
                            this.finalEnvFile = res.data.final.finalEnvFile;
                            this.finished = true;
                        } else {
                            this.error_message = 'Something went wrong';
                        }
                        this.loader = false;

                    })
                    .catch(err => {
                        this.error_message = 'Something went wrong'
                        this.loader = false;
                    })

            }
        },
        valuesChangedAfterTest() {
            this.connection_exists = false;
        },

        changeDBConnection() {
            this.connection_exists = false;
            if (this.database_connection == 1) {
                if (this.database_port == '5432') this.database_port = '3306';
                if (this.database_user_name == 'postgres') this.database_user_name = 'root';
            } else if (this.database_connection == 2) {
                if (this.database_port == '3306') this.database_port = 5432;
                if (this.database_user_name == 'root') this.database_user_name = 'postgres';
            }
        },

        completeInstallationPage() {
            this.permission_page = false;
            this.complete_installation_page = true;
        },
        validator(page, final = false) {
            this.error_message = null;
            this.errors = [];
            let error = false;
            if (page == 'test_db') {
                if (!this.database_connection) {
                    this.errors['database_connection'] = 'Database Connection required.';
                    error = true;
                }
                if (!this.database_host) {
                    this.errors['database_host'] = 'Database Host  required.';
                    error = true;
                }
                if (!this.database_port) {
                    this.errors['database_port'] = 'Database Port required.';
                    error = true;
                }
                if (!this.database_name) {
                    this.errors['database_name'] = 'Database Name required.';
                    error = true;
                }
                if (!this.database_user_name) {
                    this.errors['database_user_name'] = 'Database User Name required.';
                    error = true;
                }
                if (final)
                    if (!this.app_name) {
                        this.errors['app_name'] = 'App Name required.';
                        error = true;
                    }
                if (!this.app_timezone) {
                    this.errors['app_timezone'] = 'App Timezone required.';
                    error = true;
                }

            }

            if (error) return false;
            return true;
        }
    },
}
</script>