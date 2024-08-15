<script setup>
const props = defineProps(['shipmentProducts'])
import AppLayout from '@/Layouts/AppLayout.vue';
import ShipmentOptions from '@/Components/ShipmentOptions.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <ShipmentOptions :shipment-products="props.shipmentProducts" />
    </AppLayout>
</template>
