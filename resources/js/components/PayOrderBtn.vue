<template>
  <a href="" @click.prevent="openModel()">
    <span class="btn  btn-outline-success btn-sm font-1 mx-1">
      <span :class="icon"></span> {{  __('Pay') }}
    </span>
  </a>

  <Teleport to="body">
    <Modal :show="showModal" @close="closeModal()">
      <template #title>{{ __('Pay invoice') }}</template>
      <template #body>
        <form @submit.prevent="submit" @keydown="formData.onKeydown($event)">

          <div class="modal-body">
            <div class="col-12 col-lg-12 pt-3">
              <AlertError :form="formData" :message="__('There was a problem submitting the form.')" />
            </div>
            <div class="col-12 col-lg-12 p-12">
              <div class="col-12 pt-2">
                <div class="col-12">
                  {{ __('Required amount') }}
                </div>
                <div class="col-12 pt-3">
                  <input  v-model="formData.total"  class="form-control">
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-12 p-12">
              <div class="col-12 pt-2">
                <div class="col-12">
                  {{ __('Recieved') }}
                </div>
                <div class="col-12 pt-3">
                  <input v-model="formData.total_recieved" class="form-control" 
                  @keyup="calculateChange($event)"
                  @keypress="isNumber($event)">
                </div>
                <HasError :form="formData" field="total_recieved" />
              </div>
            </div>
            <div class="col-12 col-lg-12 p-12">
              <div class="col-12 pt-2">
                <div class="col-12">
                  {{ __('Change') }}
                </div>
                <div class="col-12 pt-3">
                  <input readOnly v-model="formData.change" class="form-control">
                </div>
                <HasError :form="formData" field="change" />
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary" :disabled="formData.busy">{{ __('Save') }}</button>
          </div>
        </form>
      </template>

    </Modal>
  </Teleport>
</template>
    
<script>
/"allowJs": true/

import Modal from './Modal.vue';
import Form from 'vform'
import {
  HasError,
  AlertError,
} from 'vform/src/components/bootstrap5'

export default {
  inject: ['__'],
  name: 'PayOrderBtn',
  props: {
    csrf: String,
    action: String,
    icon: String,
    appointment:Number,
    patient:Number
  },
  components: {
    Modal, HasError, AlertError
  },
  data() {
    return {
      showModal: false,
      formData: new Form({
        total_recieved: 0.00,
        change: 0.00,
        total:0.00,
        appointment_id: this.appointment,
        patient_id: this.patient
      })
    }
  },
  methods: {
    payOrder() {

    },
    openModel() {
      this.showModal = true
    },
    closeModal() {
      this.formData.total_recieved = 0.00;
      this.formData.total = 0.00;
      this.formData.change = 0.00;
      this.showModal = false
    },
    async submit() {

      const response = await this.formData.post(this.action, {
        headers: {
          'X-CSRF-TOKEN': this.csrf
        }
      });

      if(response.data.status == true){

        this.closeModal();

      this.$swal.fire({
                position: 'center',
                icon: 'success',
                title: __('Your work has been saved'),
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            }).then((result) => {
                 window.location.reload();
            });
      }else{
       this.formData.errors.set('test');
      }
      

    },
    calculateChange(event) {
      if(event.target.value === ""){
        this.formData.change = 0.00;
        return;
      }

      this.formData.change = (this.changeToFlotNumber(event.target.value) - this.changeToFlotNumber(this.formData.total)).toFixed(2);
    },
    changeToFlotNumber(value) {
      return Number(value);

    },
    isNumber: function(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                evt.preventDefault();;
            } else {
                return true;
            }
        },
  }

}
</script>