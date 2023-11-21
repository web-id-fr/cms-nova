<template>
    <div>
        <heading class="mb-6">{{ __('Components') }}</heading>

        <card class="flex items-stretch flex-wrap p-8" style="min-height: 300px">
            <div class="w-full flex flex-wrap">
                <div class="relative h-9 w-full md:w-1/3 md:flex-shrink-0 mb-6 mb-6" searchable="true">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="20" height="24" class="inline-block absolute ml-2 text-gray-400" role="presentation" style="top: 4px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
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
                        autofocus>
                </div>
            </div>
            <div class="component-container w-1/3 py-4 px-8" v-for="component in filteredFiles" :key="component.title">
                <a :href="component.nova" class="no-underline dim text-primary font-bold">
                    <div class="min-h-full flex flex-col text-center">
                        <div class="m-4">
                            <h3>{{ __(component.title) }}</h3>
                        </div>
                        <div class="h-64">
                            <img :src="component.image">
                        </div>
                    </div>
                </a>
            </div>
        </card>
    </div>
</template>

<script>
export default {
    mounted() {
        this.getComponents();
        this.$refs['search-components'].focus();
    },

    data: () => ({
        components: [],
        search: '',
    }),

    methods: {
        getComponents() {
            Nova.request().get('/ajax/component').then((response) => {
                this.components = response.data;
            })
        },

        searchItems: _.debounce(function (e) {
            this.search = e.target.value;
        }, 300),
    },

    computed: {
        filteredFiles() {
            let filtered = {};

            if (this.search) {
                for (const [key, value] of Object.entries(this.components)) {
                    let title = this.__(value['title']);
                    if (title.toLowerCase().includes(this.search.toLowerCase())) {
                        filtered[key] = value;
                    }
                }

                return filtered;
            }

            return this.components;
        }
    },
}
</script>

<style>
.component-container {
    width: 33.333333%;;
}
</style>
