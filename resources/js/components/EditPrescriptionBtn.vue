<template>
  <a href="" @click.prevent="openModel()">
    <span class="btn  btn-outline-primary btn-sm font-1 mx-1">
      <span :class="icon"></span> {{  __('Prescription') }}
    </span>
  </a>

  <Teleport to="body">
    <Modal :show="showModal" @close="closeModal()">
      <template #title>{{ __('Prescription') }}</template>
      <template #body>
        <form @submit.prevent="submit" @keydown="formData.onKeydown($event)">

          <div class="modal-body">
            <div class="col-12 col-lg-12 pt-3">
              <AlertError :form="formData" :message="__('There was a problem submitting the form.')" />
            </div>
            <div class="col-12 col-lg-12 p-12">
              <div class="col-12 pt-2">
                <div class="col-12">
                  {{ __('Prescription details') }}
                </div>
                <div class="col-12 pt-3">
                  <textarea rows="10" v-model="formData.prescription"  class="form-control"></textarea>
                </div>
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
  name: 'EditPrescriptionBtn',
  props: {
    csrf: String,
    action: String,
    icon: String,
    appointment:Number
  },
  components: {
    Modal, HasError, AlertError
  },
  data() {
    return {
      showModal: false,
      formData: new Form({
        prescription: "",
        appointment_id: this.appointment,
        requestType: 'ajax'
      })
    }
  },
  methods: {
    openModel() {
      this.showModal = true
    },
    closeModal() {
      this.formData.prescription = "";
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
  }

}
</script>