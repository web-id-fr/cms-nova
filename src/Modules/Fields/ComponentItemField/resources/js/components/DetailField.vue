<template>
    <PanelItem :field="field">
        <template #value>
            <div class="w-2/3 shadow-md p-3 my-2 flex justify-between"
                 v-for="(item, name, index) in field.value"
                 :key="item.id"
            >
                <div class="container-global-preview">
                    <div class="header-preview-component">
                        <div class="number-component">
                            #{{ name }}
                        </div>
                        <div  class="flex m-3 text-sm">
                            <div class="w-full p-3 text-center information-status">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                    <path d="M256 512c141.4 0 256-114.6 256-256S397.4 0 256 0S0 114.6 0 256S114.6 512 256 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-144c-17.7 0-32-14.3-32-32s14.3-32 32-32s32 14.3 32 32s-14.3 32-32 32z"/>
                                </svg>
                                {{ __('Component name') }} : {{ __(item.component_name) }}
                            </div>
                        </div>
                    </div>
                    <div class="preview-component-value">
                        <div class="flex-auto self-center text-center py-2 m-2">
                            <p class="break-words">{{ item.name }}</p>
                        </div>
                        <div class="flex-auto self-center">
                            <img class="m-auto block image-preview-component" :src="item.component_image">
                        </div>
                        <div class="flex-auto self-center text-center py-2 m-2">
                            <a v-tooltip.click="__('Edit')" target="_blank" :href="item.component_nova + '/' + item.id + '/edit'"
                               class="inline-flex cursor-pointer text-70 hover:text-primary mr-3 has-tooltip">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" aria-labelledby="edit" role="presentation" class="fill-current">
                                    <path d="M4.3 10.3l10-10a1 1 0 0 1 1.4 0l4 4a1 1 0 0 1 0 1.4l-10 10a1 1 0 0 1-.7.3H5a1 1 0 0 1-1-1v-4a1 1 0 0 1 .3-.7zM6 14h2.59l9-9L15 2.41l-9 9V14zm10-2a1 1 0 0 1 2 0v6a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4c0-1.1.9-2 2-2h6a1 1 0 1 1 0 2H2v14h14v-6z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </PanelItem>
</template>

<script>
export default {
    props: ['resource', 'resourceName', 'resourceId', 'field'],
}
</script>

<style>
.image-preview-component {
    width: 200px;
}
.preview-component-value {
    display: flex;
    padding: 15px;
    align-items: center;
}
.container-global-preview {
    width: 100%;
    border: 1px solid;
}
.container-global-preview .information-status {
    border: none;
}
.number-component {
    border-right: 1px solid;
    width: 80px;
    text-align: center;
}
.header-preview-component {
    display: flex;
    border-bottom: 1px solid;
    align-items: center;
}
</style>
