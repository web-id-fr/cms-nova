<template>
    <div>
        <h1 class="mb-6 title">{{ __('Configuration') }}</h1>

        <card class="flex px-8" style="min-height: 300px">
            <form autocomplete="off" style="width: 100%;">
                <select-menu
                    :menus="menus"
                    @updateSelectedMenu="updateSelectedMenu($event, zone)"
                    v-for="zone in zones"
                    :value="menusZones[zone.menuID]"
                    :key="zone.menuID"
                    :label="zone.label">

                </select-menu>
            </form>
        </card>
    </div>
</template>

<script>
import SelectMenu from './SelectMenu';
import { useLocalization } from 'laravel-nova'

const { __ } = useLocalization()

export default {
    mounted() {
        this.getMenusZones();
    },

    components: {
        'select-menu': SelectMenu
    },

    data: () => ({
        menus: [],
        zones: [],
        menusZones: {},
    }),

    methods: {
        getMenus() {
            Nova.request().get('/ajax/menu').then((response) => {
                this.menus = response.data;

                _.forIn(this.menus, (item) => {
                    _.forIn(item.zones, (zone) => {
                        this.menusZones[zone] = item.id;
                    });
                });

            }).catch((error) => {
                console.log(error.response);
                Nova.error(__('An error occured while attempting to get available menus.'));
            });
        },

        getMenusZones() {
            Nova.request().get('/ajax/menu-configuration').then((response) => {
                let zones = response.data;

                _.forIn(zones, (item) => {
                    if (typeof this.menusZones[item.menuID] == "undefined") {
                        this.menusZones[item.menuID] = null;
                    }
                });

                this.zones = zones;
            }).catch((error) => {
                console.log(error.response);
                Nova.error(__('An error occured while attempting to get menus zones.'));
            }).finally(() => {
                // Une fois qu'on a récupéré les zones, on récupère les menus
                this.getMenus();
            });
        },

        updateSelectedMenu(menuID, newSelection) {
            this.updateMenu('/ajax/menu-zone', {
                menuID: menuID,
                zoneID: newSelection.menuID,
                label: newSelection.label
            });
        },

        updateMenu(url, data) {
            Nova.request().post(url, {
                menu_id: data.menuID,
                zone_id: data.zoneID
            }).then((response) => {
                Nova.success(response.data.message, __('The menu was successfully updated.'));
            }).catch((error) => {
                console.log(error.response);
                Nova.error(__('An unexpected error occured.'));
            });
        },

        isInvalidData(data) {
            return data === null || (Array.isArray(data) && data.length === 0);
        },
    },
}
</script>

<style>
.title {
    font-size: 1.5rem;
}
</style>
