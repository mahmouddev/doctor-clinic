<script setup>
defineProps({
    show: Boolean
});
</script>


<template>
    <transition name="fade" appear>
        <div class="modal-overlay" v-if="show" @click="show = false , $emit('close')"></div>
    </transition>
    <Transition name="pop" appear>
        <div v-if="show" role="dialog" class="modal-container">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <slot name="title"></slot>
                        </h5>
                        <button type="button" class="btn-close"  @click="show = false , $emit('close')"></button>
                    </div>
                        <slot name="body"></slot>
                    
                </div>
            </div>
        </div>
    </Transition>
</template>

<style scoped>

</style>