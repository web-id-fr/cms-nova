<template>
    <div class="flex relative">
        <Icon class="icon-language" type="language"  />
        <select id="select-language-translatable" class="block form-control form-select form-select-bordered" onchange="Nova.$emit('change-language', this.value);">
            <option v-for="(value,key) in langs" :value="key">{{value}}</option>
        </select>
        <svg class="flex-shrink-0 pointer-events-none form-select-arrow" xmlns="http://www.w3.org/2000/svg" width="10" height="6" viewBox="0 0 10 6">
            <path class="fill-current" d="M8.292893.292893c.390525-.390524 1.023689-.390524 1.414214 0 .390524.390525.390524 1.023689 0 1.414214l-4 4c-.390525.390524-1.023689.390524-1.414214 0l-4-4c-.390524-.390525-.390524-1.023689 0-1.414214.390525-.390524 1.023689-.390524 1.414214 0L5 3.585786 8.292893.292893z"></path>
        </svg>
    </div>
</template>

<script>
    export default {
        name: "LanguageSwitcher",
    }
</script>

<style>
.icon-language {
    margin : 5px
}
</style>
