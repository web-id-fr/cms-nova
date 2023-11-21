<template>
    <multiselect v-model="selected"/>
    <div class="flex container">
        <div class="flex flex-col mt-3 block m-auto w-1/2 justify-content-center my-page-container">
            <div class="flex header-my-page">
                <div class="text-lg mb-3">
                    {{ __("My page") }}
                </div>

                <div class="pt-1 flex justify-end">
                    <button type="button"
                            class="shadow relative bg-primary-500 hover:bg-primary-400 text-white dark:text-gray-900 cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 inline-flex items-center justify-center h-9 px-3 shadow relative bg-primary-500 hover:bg-primary-400 text-white dark:text-gray-900"
                            @click="getAllFieldsValue">
                        <span class="">
                            {{ __("Preview in :locale", {locale: this.currentLang}) }}
                        </span>
                    </button>
                </div>
            </div>

            <div class="mt-6">
                <draggable v-model="selected" ghost-class="ghost">
                    <template #item="{ element }">
                        <div :key="element.id"
                             class="relative flex mb-2 pb-1"
                        >
                            <div class="z-10 border-t border-l border-b border-60 h-auto pin-l pin-t rounded-l self-start w-8">
                                <div>
                                    <button v-tooltip.click="__('Move up')"
                                            class="group-control btn border-t border-r border-40 w-8 h-8 bloc has-tooltip"
                                            type="button"
                                            @click.prevent="moveUp(element)">
                                        <svg fill="none" height="14" stroke="grey" viewBox="0 0 20 20" width="14"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5 15l7-7 7 7" stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2"/>
                                        </svg>
                                    </button>
                                    <button v-tooltip.click="__('Move down')"
                                            class="group-control btn border-t border-r border-40 w-8 h-8 block has-tooltip"
                                            type="button"
                                            @click.prevent="moveDown(element)">
                                        <svg fill="none" height="14" stroke="grey" viewBox="0 0 20 20" width="14"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2"/>
                                        </svg>
                                    </button>
                                    <button v-tooltip.click="__('Detach')"
                                            class="group-control btn border-t border-r border-40 w-8 h-8 block has-tooltip"
                                            @click.prevent="selectComponents(element)">
                                        <svg aria-labelledby="delete" class="fill-current" height="14" role="presentation"
                                             viewBox="0 0 20 20" width="14" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M6 4V2a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2h5a1 1 0 0 1 0 2h-1v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6H1a1 1 0 1 1 0-2h5zM4 6v12h12V6H4zm8-2V2H8v2h4zM8 8a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0V9a1 1 0 0 1 1-1zm4 0a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0V9a1 1 0 0 1 1-1z"
                                                fill="grey"
                                                fill-rule="nonzero"></path>
                                        </svg>
                                    </button>
                                    <button v-if="element.component_nova" v-tooltip.click="__('Edit')"
                                            class="group-control btn border-t border-r border-40 w-8 h-8 block has-tooltip"
                                            target="_blank"
                                            @click.prevent="openEditPage(element)">
                                        <svg aria-labelledby="edit" class="fill-current" height="14" role="presentation"
                                             viewBox="0 0 20 20" width="14" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M4.3 10.3l10-10a1 1 0 0 1 1.4 0l4 4a1 1 0 0 1 0 1.4l-10 10a1 1 0 0 1-.7.3H5a1 1 0 0 1-1-1v-4a1 1 0 0 1 .3-.7zM6 14h2.59l9-9L15 2.41l-9 9V14zm10-2a1 1 0 0 1 2 0v6a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4c0-1.1.9-2 2-2h6a1 1 0 1 1 0 2H2v14h14v-6z"
                                                fill="grey"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="min-h-full w-full border-60 border rounded-r-lg">
                                <div v-if="element.status === 2" class="flex m-3 text-sm">
                                    <div class="border-60 w-full border rounded p-3 text-center bg-red warning-status">
                                        <svg class="mx-1 align-middle" fill="#842029" height="24" viewBox="0 0 24 24"
                                             width="24" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/>
                                        </svg>
                                        {{ __('Attention this component is in draft mode and will not appear on your page') }}
                                    </div>
                                </div>
                                <div  class="flex m-3 text-sm">
                                    <div class="w-full p-3 text-center information-status">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                            <path d="M256 512c141.4 0 256-114.6 256-256S397.4 0 256 0S0 114.6 0 256S114.6 512 256 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-144c-17.7 0-32-14.3-32-32s14.3-32 32-32s32 14.3 32 32s-14.3 32-32 32z"/>
                                        </svg>
                                        {{ __('Component name') }} : {{ __(element.component_name) }}
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="flex-auto self-center text-name text-center py-2 m-2">
                                        <p class="break-words">{{ __('Name') }} : {{ element.name }}</p>
                                    </div>
                                    <img :src="element.component_image" class="component-image-preview">
                                </div>
                            </div>
                        </div>
                    </template>
                </draggable>
            </div>
        </div>
        <div class="flex flex-col mt-3 block m-auto w-1/2">
            <div class="relative w-1/2 max-w-xs mt-3 mx-3" v-if="activeComponentItem">
                <button class="btn btn-default btn-primary inline-flex items-center" v-on:click="hideComponentItems">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="pr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                    </svg>
                    {{ __('Back') }}
                </button>
            </div>

            <div class="relative h-9 w-full md:w-1/3 md:flex-shrink-0 mb-6 mb-6" searchable="true" v-if="!activeComponentItem">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="20"
                     height="24" class="inline-block absolute ml-2 text-gray-400" role="presentation" style="top: 4px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input
                    class="appearance-none rounded-full h-8 pl-10 w-full bg-gray-100 dark:bg-gray-900 dark:focus:bg-gray-800 focus:bg-white focus:outline-none focus:ring focus:ring-primary-200 dark:focus:ring-gray-600"
                    :placeholder="__('Search')"
                    type="search"
                    spellcheck="false"
                    aria-label="__('Search')"
                    v-model="search"
                    v-on:input="searchItems"
                    ref="search-components"
                >
            </div>

            <div class="flex flex-wrap component-container-select">
                <div @click="showComponentItems(component, name)"
                     v-for="(component, name, index) in filteredFiles"
                     ref="card"
                     class="w-1/3 card card-component relative flex flex-wrap border border-lg border-50 cursor-pointer m-2"
                     v-if="!activeComponentItem"
                >
                    <div class="image-component">
                        <img :src="componentInfos[name]['image']" class="image-component" :alt="name">
                    </div>
                    <div class="w-full text-center text-xs border-t border-30 bg-50 flex p-1 items-center justify-center absolute text-name">
                        {{ __(name) }}
                    </div>
                </div>

                <ComponentItem
                    ref="componentItem"
                    :componentItem="componentItem"
                    :active="activeComponentItem"
                    v-on:selectComponent="selectComponents"
                    v-on:refreshData="refreshData"
                    :selected="selected"
                    :name="componentName"
                    :novaPath="novaUrl"
                    :componentInfos="componentInfos"
                />
            </div>
        </div>
    </div>
</template>

<script>
import {FormField, HandlesValidationErrors} from 'laravel-nova'
import Multiselect from 'vue-multiselect';
import draggable from 'vuedraggable'
import {map} from 'lodash';
import { useLocalization } from 'laravel-nova'

const { __ } = useLocalization()

import ComponentItem from "./modules/ComponentItem";

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field'],

    components: {
        Multiselect,
        draggable,
        ComponentItem: ComponentItem,
    },

    data() {
        return {
            search: '',
            selected: [],
            options: [],
            novaUrl: '',
            activeModal: false,
            fields: {},
            fieldsComponent: {},
            currentLocale: null,
            currentLang: null,
            activeComponentItem: false,
            componentItem: {},
            componentName: '',
            componentInfos: {},
        }
    },

    updated() {
        if (this.$refs['search-components']) {
            this.$refs['search-components'].focus();
        }
    },

    mounted() {
        this.currentLocale = document.querySelector('#select-language-translatable').value;
        this.currentLang = document.querySelector('#select-language-translatable option[value="' + this.currentLocale + '"]').text;
        Nova.$on('change-language', (lang) => {
            this.currentLocale = lang;
            this.currentLang = document.querySelector('#select-language-translatable option[value="' + lang + '"]').text;
        });
    },

    methods: {
        showComponentItems(componentItem, componentName) {
            this.activeComponentItem = true;
            this.componentItem = componentItem;
            this.componentName = componentName;
        },

        fill(formData) {
            formData.append(this.field.attribute, this.value || '');
        },

        setInitialValue() {
            this.value = this.field.value || '';
            this.selected = this.value || [];
            this.options = this.field.items || [];
            this.novaUrl = this.field.nova || [];
            this.componentInfos = this.field.componentInfos || [];
        },

        handleChange(value) {
            this.value = value;
        },

        stopDefaultActions(e) {
            e.preventDefault();
            e.stopPropagation();
        },

        moveUp(component) {
            let findIndex = _.findIndex(this.selected, component);

            if (findIndex <= 0) return;

            this.selected.splice(findIndex - 1, 0, this.selected.splice(findIndex, 1)[0]);
        },

        moveDown(component) {
            let findIndex = _.findIndex(this.selected, component);

            if (findIndex < 0 || findIndex >= this.selected.length - 1) return;

            this.selected.splice(findIndex + 1, 0, this.selected.splice(findIndex, 1)[0]);
        },

        openEditPage(component) {
            window.open(component.component_nova + "/" + component.id + "/edit", "_blank");
        },

        selectComponents(component) {
            const findIndex = _.findIndex(this.selected, component);

            if (findIndex >= 0) {
                this.selected.splice(findIndex, 1);
                Nova.error(__('The component has been removed from the list'));
                return;
            }

            if (this.selected.indexOf(component) === -1) {
                this.selected.push(component);
                Nova.success(__('The component has been added to the list'));
            }
        },

        searchItems: _.debounce(function (e) {
            this.search = e.target.value;
        }, 300),

        hideComponentItems() {
            this.componentItem = {};
            this.activeComponentItem = false;
        },

        getAllFieldsValue() {
            this.$parent.$children.forEach(component => {
                if (component.field !== undefined &&
                    (component.field.attribute !== "" || component.field.attribute !== this.field.attribute)
                ) {
                    if (typeof component.field.value === 'object' && component.field.value !== null) {
                        this.fields[component.field.attribute] = component.field.value[this.currentLocale];
                    } else {
                        this.fields[component.field.attribute] = component.field.value;
                    }
                }
                if (component.field.attribute === 'components') {
                    this.fields[component.field.attribute] = component.selected;
                }
            });

            this.fields['lang'] = this.currentLocale;

            Nova.request().post('/nova-vendor/component-item-field/store-preview-data',
                this.fields
            ).then(({data}) => {
                window.open("/preview/" + data.token, '_blank');
                this.$toasted.show(
                    this.__('The preview has been correctly created.'),
                    {type: 'success'}
                )
            }).catch(() => {
                this.$toasted.show(
                    this.__('An unexpected error occurred during the creation of the preview.'),
                    {type: 'error'}
                )
            });
        },

        refreshData(name) {
            Nova.request().get('/nova-vendor/component-item-field/child-component-data')
                .then(({data}) => {
                    this.options = data.items
                    this.componentItem = data.items[name]
                    this.$forceUpdate();
                    Nova.success(__('The list of child component is updated'))
                });
        },
    },

    computed: {
        filteredFiles() {
            let filtered = {};

            if (this.search) {
                for (const [key, value] of Object.entries(this.options)) {
                    let title = this.__(key);
                    if (title.toLowerCase().includes(this.search.toLowerCase())) {
                        filtered[key] = value;
                    }
                }

                return filtered;
            }

            return this.options;
        },
    },

    watch: {
        selected: {
            handler: function(val) {
                console.log(val)
                let ids = map(val, (item) => {
                    return {
                        id: item.id,
                        component_type: item.component_type,
                        component_nova: item.component_nova,
                        component_image: item.component_image,
                        component_name: item.component_name
                    };
                });
                console.log(ids)
                this.handleChange(JSON.stringify(ids));
            },
            deep: true
        }
    }
}
</script>

<style>
.card-component {
    margin: 5px;
    width: 45%;
}

.image-component {
    max-width: 100%;
    height: auto;
    object-fit: contain;
    min-height: 8rem;
    border-radius: 0.375rem;
}

.text-name {
    border-bottom-right-radius: 0.375rem;
    border-bottom-left-radius: 0.375rem;
    bottom: 0;
}

.my-page-container {
    margin: 15px;
}

.container {
    border: none;
}

.header-my-page {
    justify-content: space-between;
}
.warning-status,
.information-status {
    display: flex;
    align-items: center;
}
.information-status {
    border-bottom: 1px solid;
}
.warning-status svg {
    margin-right: 5px;
}
.bg-red {
    background-color: #f8d7da;
    border-color: #f5c2c7;
    color: #842029;
}
.information-status svg {
    margin-right: 5px;
    fill: rgba(var(--colors-primary-500));
}
.component-image-preview {
    height: auto;
    width: 180px;
}
.text-name {
    align-self: center;
}
.card-component .text-name {
    background-color: rgba(var(--colors-primary-500));
    color: rgba(var(--colors-gray-900));
    font-weight: 700;
}
svg {
    display: initial;
}
</style>
