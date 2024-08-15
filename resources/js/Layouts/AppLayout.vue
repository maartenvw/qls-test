<script setup>
import { ref, watch } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { useDisplay } from 'vuetify';


defineProps({
    title: String,
});

const { mobile } = useDisplay()
const drawer = ref(true);

const showingNavigationDropdown = ref(false)

const switchToTeam = (team) => {
    router.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    router.post(route('logout'))
};

watch(mobile, () => {
    if(mobile.value) {
        drawer.value = false
    }
})
</script>

<template>
    <VApp>
        <VNavigationDrawer v-model="drawer">
            <VList>
                <VListItem class="logo" title="QLS" base-color="primary"></VListItem>
                <VDivider></VDivider>
                <VListItem title="Navigation drawer"></VListItem>
            </VList>
        </VNavigationDrawer>
        <VAppBar elevation="2">
            <template v-slot:prepend>
                <VAppBarNavIcon variant="text" @click.stop="drawer = !drawer"></VAppBarNavIcon>
            </template>
        </VAppBar>
        <VMain>
            <VContainer>
                <slot />
            </VContainer>
        </VMain>
    </VApp>
</template>

<style>
.logo .v-list-item-title {
    font-weight: 900;
    font-size: 32px;
}
</style>
