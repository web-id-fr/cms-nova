<template>
    <fwb-modal v-if="show" @close="closeModal" class="modal">
        <template #header>
            <div class="flex items-center text-lg">
                {{ __("Menu items") }}
            </div>
        </template>
        <template #body>
            <div class="w-full flex flex-wrap">
                <div class="flex items-center w-full max-w-xs h-12 relative">
                    <div class="flex-1 relative">
                        <div class="relative z-10">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="20" height="24" class="inline-block absolute ml-2 text-gray-400" role="presentation" style="top: 4px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <input ref="search-components" v-on:input="searchItems" v-model="search" type="search" :placeholder="this.__('Search')" class="appearance-none rounded-full h-8 pl-10 w-full bg-gray-100 dark:bg-gray-900 dark:focus:bg-gray-800 focus:bg-white focus:outline-none focus:ring focus:ring-primary-200 dark:focus:ring-gray-600" role="search" aria-label="Rechercher" aria-expanded="false" spellcheck="false">
                        </div>
                    </div>
                </div>
            </div>

            <ComponentItem
                ref="componentItem"
                :menuItems="filteredFiles"
                v-on:selectMenuItem="selectMenuItem"
                :selected="selected"
            />
        </template>
    </fwb-modal>
</template>

<script>
    import ComponentItem from "./ComponentItem";
    import {FwbButton, FwbModal} from 'flowbite-vue'

    export default {
        props: {
            show: {
                type: Boolean,
                default: false,
                required: true,
            },
            menus: {
                type: Object,
                required: true,
            },
            search: {
                type: String,
                required: false,
                default: '',
            },
            selected: {
                type: Array,
                default: () => [],
                required: false,
            },
        },

        data() {
            return {
                search: '',
                activeComponentItem: false,
                currentLocale: null,
            }
        },

        mounted() {
            this.currentLocale = document.querySelector('#select-language-translatable').value;
            Nova.$on('change-language', (lang) => {
                this.currentLocale = lang;
            });
        },

        components: {
            FwbButton,
            FwbModal,
            ComponentItem: ComponentItem,
        },

        updated() {
            if (this.$refs['search-components']) {
                this.$refs['search-components'].focus();
            }
        },

        methods: {
            closeModal() {
                this.$emit('closeModal');
            },

            selectMenuItem(menuItem) {
                this.$emit('selectMenuItems', menuItem);
            },

            searchItems: _.debounce(function (e) {
                this.search = e.target.value;
            }, 300),
        },

        computed: {
            filteredFiles() {
                let filtered = {};

                if (this.search) {
                    for (const [key, menu] of Object.entries(this.menus)) {
                        if (menu.title && menu.title[this.currentLocale]) {
                            let title = menu.title[this.currentLocale];
                            if (title.toLowerCase().includes(this.search.toLowerCase())) {
                                filtered[key] = menu;
                            }
                        }
                    }
                    return filtered;
                }

                return this.menus;
            }
        },
    };
</script>

<style>
    .modal div.bg-gray-900.bg-opacity-50.fixed.inset-0.z-40 {
        z-index: 40;
        background: rgba(148,163,184,0.8);
    }
</style>

