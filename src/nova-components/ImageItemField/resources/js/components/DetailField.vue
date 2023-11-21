<template>
    <PanelItem :field="field">
    </PanelItem>
</template>

<script>
export default {
    props: ['resource', 'resourceName', 'resourceId', 'field'],
}
</script>
