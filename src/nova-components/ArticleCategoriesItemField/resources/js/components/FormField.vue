<template>
    <DefaultField :field="field" :errors="errors">
        <template #field>
            <div class="flex flex-col">
                <div class="flex flex-col">
                    <VueMultiselect
                        v-model="selected"
                        :options="field.items"
                        title="Search an item field"
                        label="name"
                        :custom-label="customLabel"
                        track-by="id"
                        :multiple="true"
                        :close-on-select="false"
                        :clear-on-select="false"
                        :taggable="true"
                        :max="field.limit"
                    ></VueMultiselect>
                </div>
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

    computed: {},

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

        customLabel({name}) {
            return this.selectFirstTitle(name);
        },

        selectFirstTitle(name) {
            if (!name[this.currentLocale]) {
                if (name[this.currentLocale + 1]) {
                    return name[this.currentLocale + 1];
                } else if (name[this.currentLocale - 1]) {
                    return name[this.currentLocale - 1];
                } else {
                    return name[Object.keys(name)[0]];
                }
            } else {
                return name[this.currentLocale];
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
