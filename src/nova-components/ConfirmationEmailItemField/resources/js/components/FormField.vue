<template>
    <DefaultField :field="field" :errors="errors" :show-help-text="showHelpText">
        <template #field>
            <div class="flex flex-col">
                <VueMultiselect
                    v-model="value"
                    :options="options"
                    :searchable="false"
                    :close-on-select="true"
                    :show-labels="false"
                    placeholder="Pick a value"
                    @open="getOptions"
                ></VueMultiselect>
            </div>
        </template>
    </DefaultField>
</template>

<script>
import {FormField, HandlesValidationErrors} from 'laravel-nova';
import VueMultiselect from 'vue-multiselect';

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field'],

    components: {
        VueMultiselect,
    },

    data () {
        return {
            value: '',
            options: []
        }
    },

    methods: {
        /*
         * Set the initial, internal value for the field.
         */
        setInitialValue() {
            this.value = this.field.value || '';
        },

        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill(formData) {
            this.fillIfVisible(formData, this.fieldAttribute, this.value || '')
        },

        getOptions() {
            let fieldType = this.field.fieldTypeEmail;
            let options = [];

            this.$parent.$children.forEach(field => {
                if (field.field.attribute === 'fields') {
                    field.selected.forEach(function(selected){
                        if (parseInt(selected.field_type) === fieldType) {
                            options.push(selected.field_name);
                        }
                    });
                }
            });

            return this.options = options;
        }
    },
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>
