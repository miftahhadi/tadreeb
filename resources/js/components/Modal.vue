<template>
    <div class="modal fade" 
        :id="id" 
        tabindex="-1" :aria-labelledby="id + 'Label'" aria-hidden="true"
        :data-backdrop="backdrop"
    >
        <div class="modal-dialog" :class="modalClass" role="document">
            <div class="modal-content">
                <div class="dimmer" :class="isLoading">
                    
                    <div class="loader"></div>
                    
                    <div class="dimmer-content">
                        <div class="modal-header">
                            <slot name="header">
                                <h5 class="modal-title">
                                    <slot name="title"></slot>
                                </h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                            </slot>
                        </div>
                        
                        <div class="modal-body">
                            <slot name="body"></slot>
                        </div>
                        
                        <div class="modal-footer">
                            <slot name="footer">
                                <button type="button" class="btn mr-auto" data-bs-dismiss="modal">Close</button>
                            </slot>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    name: 'modal',

    props: {
        id: {
            type: String,
            required: true
        },
        classes: {
            type: Array,
            default: () => []
        },
        loading: {
            type: Boolean,
            default: false
        },
        backdrop: {
            type: [String, Boolean],
            default: false
        }
    },

    computed: {
        modalClass() {
            return this.classes.join(' ');
        },

        isLoading() {
            return (this.loading) ? 'active' : '';
        }
    }
}
</script>