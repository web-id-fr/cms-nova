<template>
    <DefaultField :field="field" :errors="errors">
        <template #field>
            <div class="flex flex-col">
                <VueMultiselect
                    v-model="selected"
                    :options="field.items"
                    title="Search a template"
                    label="title"
                    :custom-label="customLabel"
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
            currentLocale: null,
        }
    },

    mounted() {
        this.currentLocale = document.querySelector('#select-language-translatable').value;
        Nova.$on('change-language', (lang) => {
            this.currentLocale = lang;
        });
    },

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

        customLabel({title}) {
            return this.selectFirstTitle(title);
        },

        selectFirstTitle(title) {
            if (!title[this.currentLocale]) {
                if (title[this.currentLocale + 1]) {
                    return title[this.currentLocale + 1];
                } else if (title[this.currentLocale - 1]) {
                    return title[this.currentLocale - 1];
                } else {
                    return title[Object.keys(title)[0]];
                }
            } else {
                return title[this.currentLocale];
            }
        }
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
