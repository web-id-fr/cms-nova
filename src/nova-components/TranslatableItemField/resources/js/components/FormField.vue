<template>
    <FieldWrapper>
        <div class="px-6 md:px-8 mt-2 md:mt-0 w-full md:w-1/5 md:py-5 bloc-title">
            <slot>
                <FormLabel :label-for="field.name">
                    <LanguageIcon class="h-6 w-6 text-blue-500"/>
                    - {{ field.name }}
                    <span v-if="field.required" class="text-red-500 text-sm">*</span>
                </FormLabel>
            </slot>
        </div>
        <div class="px-8 py-6" :class="computedWidth">
            <textarea
                ref="field"
                :id="field.name"
                class="mt-4 w-full form-control form-input form-input-bordered py-3 min-h-textarea"
                :class="errorClasses"
                :placeholder="extraAttributes.placeholder || field.name"
                v-model="value[currentLocale]"
                v-if="!field.singleLine && !field.trix"
            ></textarea>

            <div v-if="!field.singleField && field.trix" @keydown.stop class="mt-4">
                <trix
                    ref="field"
                    name="trixman"
                    :value="value[currentLocale]"
                    placeholder=""
                    @change="handleChange"
                />
                <button class="p-2 text-xs flex items-center" v-if="field.showRefresh" @click.prevent="refresh">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="11" height="11" class="fill-current align-middle"><path d="M6 18.7V21a1 1 0 0 1-2 0v-5a1 1 0 0 1 1-1h5a1 1 0 1 1 0 2H7.1A7 7 0 0 0 19 12a1 1 0 1 1 2 0 9 9 0 0 1-15 6.7zM18 5.3V3a1 1 0 0 1 2 0v5a1 1 0 0 1-1 1h-5a1 1 0 0 1 0-2h2.9A7 7 0 0 0 5 12a1 1 0 1 1-2 0 9 9 0 0 1 15-6.7z"></path></svg>
                    <span class="pl-1">{{ __('Refresh') }}</span>
                </button>
            </div>

            <input
                ref="field"
                type="text"
                :id="field.name"
                class="mt-4 w-full form-control form-input form-input-bordered"
                :class="errorClasses"
                :placeholder="extraAttributes.placeholder || field.name"
                v-model="value[currentLocale]"
                v-if="field.singleLine"
            />

            <div v-if="hasError" class="help-text error-text mt-2 text-danger">
                {{ firstError }}
            </div>
            <HelpText class="help-text mt-2" v-if="field.helpText">
                {{ field.helpText }}
            </HelpText>
        </div>
    </FieldWrapper>
</template>

<script>
import Trix from '../Trix'
import { FormField, HandlesValidationErrors } from 'laravel-nova'
import { LanguageIcon } from '@heroicons/vue/24/solid'

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field'],

    components: {
        LanguageIcon,
        Trix,
    },

    data() {
        return {
            locales: Object.keys(this.field.locales),
            currentLocale: null,
            extraAttributes: {}
        }
    },

    mounted() {
        this.currentLocale = document.querySelector('#select-language-translatable').value;
        this.extraAttributes = this.field.extraAttributes || {};
        Nova.$on('change-language', (lang) => {
            this.changeTab(lang);
        });
    },

    methods: {
        stopDefaultActions(e) {
            e.preventDefault();
            e.stopPropagation();
        },

        setInitialValue() {
            if (_.isEmpty(this.field.value)) {
                this.value = this.field.defaultValues || {};
            } else {
                this.value = this.field.value;
            }
        },

        fill(formData) {
            Object.keys(this.value).forEach(locale => {
                formData.append(this.field.attribute + '[' + locale + ']', this.value[locale] || '')
            })
        },

        handleChange(value) {
            this.value[this.currentLocale] = value
        },

        changeTab(locale) {
            this.currentLocale = locale
            this.$nextTick(() => {
                if (this.field.trix) {
                    this.$refs.field.update()
                }
            })
        },

        refresh(e) {
            this.stopDefaultActions(e);

            let _data = [];

            for (let i = 0; i < tinyMCE.editors.length; i++) {
                if (tinyMCE.editors[i].getContent()){
                    _data.push({
                        el: tinyMCE.editors[i],
                        settings: tinyMCE.editors[i].settings,
                    });
                }
            }

            for (let i = 0; i < _data.length; i++) {
                _data[i].el.remove();

                tinyMCE.init(
                    _data[i].settings
                );
            }
        }
    },

    computed: {
        computedWidth() {
            return {
                'w-1/2': !this.field.trix,
                'w-4/5': this.field.trix
            }
        }
    }
}
</script>

<style>
    .bloc-title {
        padding-bottom: 2rem;
        padding-top: 2rem;
    }
</style>
