<template>
    <div class="autocomplete">
        <input type="text" 
        :class="[{ 'is-invalid' : checkInvalidKey('phone') }, 'form-control', 'px-4']"
        @input="onChange" 
        v-model="phone" 
        name="phone" 
        autocomplete="off"
        @keyup.down="onArrowDown" 
        @keyup.up="onArrowUp"
        @keyup.enter="onEnter"
        @keypress="onlyNumbers"/>
        <span class="invalid-feedback position-absolute">
                    <strong>{{ checkInvalidKey('phone') && errors.phone[0] ? errors.phone[0] : '' }}</strong>
                </span>
        <ul id="autocomplete-results" 
            v-show="isOpen" 
            class="autocomplete-results position-absolute">
            <li class="loading" v-if="isLoading">
                Loading results...
            </li>
            <li v-else v-for="(result, i) in results" 
                :key="i" 
                @click="setResult(result)"
                class="autocomplete-result"
                :class="{ 'is-active': i === arrowCounter }"
                >
                {{ result.phone }}
            </li>
        </ul>

        <input type="hidden" name="patient_id"  v-model="patient_id">

    </div>
</template>
      
<script>
import axios from 'axios';

/"allowJs": true/
export default {
    inject: ['__' , 'patientOldData', 'errors'],
    name: 'PatientsFilter',
    props: {
        patientId: {
            type: Number,
            required: false,
            default: 0
        },
        oldPhone: {
            type: String,
            required: false,
            default: ""
        }
    },
    data() {
        return {
            isOpen: false,
            results: [],
            phone: "",
            patient_id:"",
            isLoading: false,
            arrowCounter: 0
        };
    },

    methods: {
        onChange() {
            this.$emit("result", {});
            // Let's search our flat array
            this.filterResults();
            this.isOpen = true;
            
        },
        async filterResults() {
            // first uncapitalize all the things

            const res = await axios.post(`/admin/patients/search`, {
                q: this.phone,
            });

            this.results = res.data.patients;
    
        },
        setResult(result) {
            // Let's warn the parent that a change was made
            this.$emit("result", result);

            this.phone = result.phone;
            this.patient_id = result.id;
            this.isOpen = false;
        },
        onArrowDown(evt) {
            this.$emit("result", {});
            if (this.arrowCounter < this.results.length) {
                this.arrowCounter = this.arrowCounter + 1;
            }
        },
        onArrowUp() {
            this.$emit("result", {});
            if (this.arrowCounter > 0) {
                this.arrowCounter = this.arrowCounter - 1;
            }
        },
        onEnter() {
            if(this.results && this.arrowCounter >= 0 ){
                this.$emit("result", this.results[this.arrowCounter]);
                this.phone = this.results[this.arrowCounter].phone;
                this.patient_id = this.results[this.arrowCounter].id;
                this.isOpen = false;
                this.arrowCounter = -1;
            }else{
                this.patient_id = 0;
                this.$emit("result", {});
                this.isOpen = false;
                this.arrowCounter = -1;
            }
        },
        handleClickOutside(evt) {
            if (!this.$el.contains(evt.target)) {
                this.isOpen = false;
                this.arrowCounter = -1;
            }
        },
        checkInvalidKey(key){
            return this.$parent.checkInvalidKey(key);
        },
        onlyNumbers(event) {      
            let keyCode = event.keyCode ? event.keyCode : event.which;
            if (keyCode < 48 || keyCode > 57) {
                // 46 is dot
                event.preventDefault();
            }
        }
    },
    watch: {
        results(newValue){
            if(!newValue.length){
                this.isOpen = false;
            }
        }
    },
    async mounted() {
        document.addEventListener("click", this.handleClickOutside);
        
        if(this.oldPhone){
            this.phone = this.oldPhone;
            await this.filterResults();
            if(this.results.length){
                this.setResult(this.results[0]);
            }
        }
    },
    created(){
    },
    destroyed() {
        document.removeEventListener("click", this.handleClickOutside);
    }
}
</script>