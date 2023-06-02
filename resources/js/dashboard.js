import $ from 'jquery';
window.$ = window.jQuery = $;

import favico from 'favico.js';
import toastr from 'toastr';
import { Fancybox } from "@fancyapps/ui";
import { selectize } from '@selectize/selectize'; 

window.Favico= favico;
window.toastr= toastr;
window.Fancybox= Fancybox;

import * as bootstrap from 'bootstrap';
import '/public/js/main.js';
import '/public/js/main-dashboard.js';

import __ from './lib/translation';
window.__ = __;
window.bootstrap = bootstrap;

import {createApp} from 'vue/dist/vue.esm-bundler.js';
import VueSweetalert2 from 'vue-sweetalert2';
import PatientsFilter from "./components/PatientsFilter.vue";
import PatientForm from "./components/PatientForm.vue";
import PatientPrescriptionForm from "./components/PatientPrescriptionForm.vue";
import PayOrderBtn from "./components/PayOrderBtn.vue";
import EditPrescriptionBtn from "./components/EditPrescriptionBtn.vue";

const app = createApp({
    provide: {
        __
    },
});

app.component('patients-filter', PatientsFilter);
app.component('patient-form', PatientForm);
app.component('patient-prescription-form', PatientPrescriptionForm);
app.component('pay-order-btn', PayOrderBtn);
app.component('edit-prescription-btn', EditPrescriptionBtn);

app.use(VueSweetalert2);
app.mount("#app");

$(document).ready(function() { 
    $(function () {
        $(".selectize").selectize({
            plugins: ["restore_on_backspace", "clear_button"],
            delimiter: " - ",
            persist: false
        });

        $("form:not(.accept-submit)").bind("keypress", function (e) {
            if (e.keyCode == 13) {
                return false;
            }
        });
    });
});