<template>
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
                <select
                v-model="patientData.gendar"
                :class="[{ 'is-invalid' : checkInvalidKey('gendar') }, 'form-control', 'px-4']"  
                name="gendar">
                    <option value="">{{ __('Plese select.....') }}</option>
                    <option value="male">
                        {{ __('Male') }}</option>
                    <option value="female">
                        {{ __('Female') }}</option>
                </select>
                <span class="invalid-feedback position-absolute">
                    <strong>{{ checkInvalidKey('gendar') && errors.gendar[0] ? errors.gendar[0] : '' }}</strong>
                </span>
            </div>
        </div>
    </div>
</template>
      
<script>

import moment from 'moment';

/"allowJs": true/
export default {
    inject: ['__'],
    name: 'PatientForm',
    props: {
        patientOldData : Object,
        errors:  Object,
    },
    data() {
        return {
            patientData:{}
        };
    },

    methods: {
        checkInvalidKey(key){
            return this.errors.hasOwnProperty(key);
        },
        setPatientData(patientData){
            this.patientData = Object.assign(this.patientData , patientData) ;
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