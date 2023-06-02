<template>
    <div class="row pb-3">
        <div class="col-lg-8">
            <div class="row pt-2 mt-2">
                <div class=" col-lg-12 p-2  mb-2">
                    <div class="">
                        {{ __('Date of visit') }}
                    </div>
                    <div class="pt-1 position-relative">
                        <select
                            v-model="patientData.appointment_id"
                            :class="[{ 'is-invalid' : checkInvalidKey('appointment_id') }, 'form-control', 'px-4']"  
                            name="appointment_id">
                            <option value="">{{ __('Plese select.....') }}</option>
                            <option v-for="appointment in patientData.appointments" 
                                :value="appointment.id">
                                {{ reformDate(appointment.appointment_id) }}
                            </option>
                        </select>
                        <span class="invalid-feedback position-absolute">
                            <strong>{{ checkInvalidKey('appointment_id') && errors.appointment_id[0] ? errors.appointment_id[0] : '' }}</strong>
                        </span>
                    </div>
                </div>
                <div class=" col-lg-12 p-2  mb-2">
                    <div class="">
                        {{ __('Prescription details') }}
                    </div>
                    <div class=" pt-1 position-relative">
                        <textarea
                            name="prescription"
                            autocomplete="off"
                            rows="8"
                            :class="[{ 'is-invalid' : checkInvalidKey('prescription') }, 'form-control', 'px-4']"
                            v-model="patientData.prescription"></textarea>
                        <span class="invalid-feedback position-absolute">
                            <strong>{{ checkInvalidKey('prescription') && errors.prescription[0] ? errors.prescription[0] : '' }}</strong>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class=" col-lg-4"> 
            <div class="row pt-2">
                <div class="col-lg-12 p-2 mb-2">
                    <div class="">
                        {{ __('Phone') }}
                    </div>
                    <div class="pt-1 position-relative">
                        <span class="position-absolute top-30 px-2">
                            <i class="fas fa-search"></i>
                        </span>
                        <patients-filter
                            :old-phone='patientOldData.phone'
                            @result="setPatientData"
                            ></patients-filter>
                        <span class="invalid-feedback position-absolute">
                        </span>
                    </div>
                </div>
                <div class="col-lg-12 p-2 mb-2">
                    <div class="">
                        {{ __('Name') }}
                    </div>
                    <div class="pt-1 position-relative">
                        <span class="position-absolute top-30 px-2">
                            <i class="fas fa-user"></i>
                        </span>
                        <input 
                            autocomplete="off"
                            type="text" 
                            name="name"  
                            minlength="3" 
                            maxlength="190" 
                            readonly
                            :class="[{ 'is-invalid' : checkInvalidKey('name') }, 'form-control', 'px-4']"
                            v-model="patientData.name">
                        <span class="invalid-feedback position-absolute">
                            <strong>{{ checkInvalidKey('name') && errors.name[0] ? errors.name[0] : '' }}</strong>
                        </span>
                    </div>
                </div>
                <div class="col-lg-12 p-2 mb-2">
                    <div class="">
                        {{ __('Date of birth') }}
                    </div>
                    <div class="pt-1 position-relative">
                        <input 
                            type="date" 
                            v-model="dobInCorrectFormat"
                            name="dob" 
                            readonly
                            :class="[{ 'is-invalid' : checkInvalidKey('dob') }, 'form-control', 'px-4']">
                        <span class="invalid-feedback position-absolute">
                            <strong>{{ checkInvalidKey('dob') && errors.dob[0] ? errors.dob[0] : '' }}</strong>
                        </span>
                    </div>
                </div>
                <div class="col-lg-12 p-2 mb-2">
                    <div class="">
                        {{ __('Gendar') }}
                    </div>
                    <div class=" pt-1 position-relative">
                        <span class="position-absolute top-30 px-2">
                            <i class="fas fa-file-medical-alt"></i>
                        </span>

                        <input 
                            type="text" 
                            v-model="patientData.gendar"
                            name="gendar" 
                            readonly
                            :class="[{ 'is-invalid' : checkInvalidKey('gendar') }, 'form-control', 'px-4']">
                        <span class="invalid-feedback position-absolute">
                            <strong>{{ checkInvalidKey('gendar') && errors.gendar[0] ? errors.gendar[0] : '' }}</strong>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
      
<script>

import moment from 'moment';

/"allowJs": true/
export default {
    inject: ['__'],
    name: 'PatientPrescriptionForm',
    props: {
        patientOldData : Object,
        errors:  Object,
    },
    data() {
        return {
            patientData:{},
        };
    },

    methods: {
        checkInvalidKey(key){
            return this.errors.hasOwnProperty(key);
        },
        setPatientData(patientData){
            //this.patientData = patientData;
            this.patientData = Object.assign(this.patientData , patientData) ;
        },
        reformDate(date){
            return moment(date).format('Y-MM-DD')
        },

    },
    watch: {
    },
    created() {
        if(this.patientOldData){
            Object.assign(this.patientData , this.patientOldData);
        }
    },
    destroyed() {
    },
    computed: {
      dobInCorrectFormat: {
        get() {            
            return this.patientData.dob ? 
                moment(this.patientData.dob, 'Y-MM-DD', true).isValid() 
                    ? this.patientData.dob 
                    : moment(this.patientData.dob).format('Y-MM-DD')
                :'';
            
        },
        set(newValue) {
        this.patientData.dob = newValue 
                                ? moment(newValue, 'Y-MM-DD', true).isValid() 
                                    ?  newValue 
                                    :  moment(newValue).format('Y-MM-DD')
                                : '';
      }

      }
    },
    provide() {
        return {
            patientOldData: this.patientOldData,
            errors: this.errors,
        }
    }
}
</script>