<script>
import Editor from '@tinymce/tinymce-vue';

let useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;

export default {
    name: 'trix-vue',
    props: ['name', 'value', 'placeholder'],
    components: {
        'editor': Editor
    },
    data() {
        return {
            content: null,
            init: false,
            config: {
                relative_urls: false,
                remove_script_host: false,
                entity_encoding: "raw",
                encoding: "UTF-8",
                menubar: false,
                plugins: "code preview link lists media table image emoticons charmap visualblocks",
                toolbar: "code | undo redo | blocks | bold italic strikethrough underline forecolor backcolor | link image media | alignleft aligncenter alignright alignjustify | table | bullist numlist outdent indent blockquote | charmap emoticons | removeformat",
                toolbar_sticky: true,
                automatic_uploads: true,
                file_picker_types: 'image file media',
                media_live_embeds: true,
                image_advtab: true,
                skin: useDarkMode ? 'oxide-dark' : 'oxide',
                content_css: useDarkMode ? 'dark' : 'default',
            }
        }
    },

    mounted: () => {
        this.content = this.value;
    },

    methods: {
        update() {
            this.content = this.value == undefined ? '' : this.value;
        },

        onChange() {
            this.$emit('change', this.content)
        },
    },

    watch: {
        'value': function (newValue) {
            if (!this.init) {
                this.content = this.value;
                this.init = true;
            }
        },
        'content': function(newValue) {
            this.$emit('change', this.content);
        }
    }
}
</script>

<template>
    <editor v-model="content"
            ref="theEditor"
            @change="onChange"
            api-key="qw068v96pacv2vfc9nc69wnpkc3h3jzdsz643l6ioup1icd7"
            :init="config"
    ></editor>
</template>
