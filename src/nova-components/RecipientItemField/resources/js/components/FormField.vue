<template>
    <DefaultField :field="field" :errors="errors">
        <template #field>
            <div class="flex flex-col">
                <VueMultiselect
                    v-model="selected"
                    :options="field.items"
                    title="Search a template"
                    label="name"
                    :custom-label="name"
                    track-by="id"
                    :multiple="true"
                    :close-on-select="false"
                    :clear-on-select="false"
                    :taggable="true"
                ></VueMultiselect>
            </div>
        </template>
    </DefaultField>
</template>

<script>
import {FormField, HandlesValidationErrors} from 'laravel-nova';
import VueMultiselect from 'vue-multiselect'
import {map} from 'lodash';

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field'],

    components: {
        VueMultiselect,
    },

    data() {
        return {
            selected: [],
        }
    },

    computed: {},

    methods: {

        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill(formData) {
            this.fillIfVisible(formData, this.fieldAttribute, this.value || '')
        },

        /*
        * Set the initial, internal value for the field.
        */
        setInitialValue() {
            this.value = this.field.value || '';
            this.selected = this.value || [];
        },

        /**
         * Update the field's internal value.
         */
        handleChange(value) {
            this.value = value;
        },
    },

    watch: {
        selected: function (val) {
            let ids = map(val, (item) => {
                return {
                    id: item.id,
                };
            });
            this.handleChange(JSON.stringify(ids));
        }
    }
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>
