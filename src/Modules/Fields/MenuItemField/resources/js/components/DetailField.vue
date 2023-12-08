<template>
    <PanelItem :field="field">
        <template #value>
            <detail-tree
                class="col-8"
                v-model="field.value"
                :value="field.value"
            />
        </template>
    </PanelItem>
</template>

<script>
import DetailTree from "./detail-tree";

export default {
    components: {DetailTree},
    props: ['index', 'resource', 'resourceName', 'resourceId', 'field'],

    computed: {
        value() {
            return this.field.value
        }
    },
}
</script>

<style scoped>
span {
    padding: 1rem;
}
</style>
