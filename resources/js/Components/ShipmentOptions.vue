<script setup>
import { ref, watch } from 'vue'
import axios from 'axios'

const props = defineProps(['shipmentProducts'])
const product = ref()
const productCombination = ref()
const formError = ref('')
const formLoading = ref(false)

watch(product, (oldVal, newVal) => {
    formError.value = ''
    if(oldVal !== undefined && newVal !== undefined) {
        if(oldVal.id !== newVal.id) {
            productCombination.value = null
        }
    }
})

const onSubmit = () => {
    var submit = false;
    formLoading.value = true
    if(product.value == undefined) {
        formError.value = 'Geen verzend product geselecteerd!'
        formLoading.value = false
        return
    } else {
        submit = true
    }
    if(productCombination.value == undefined) {
        formError.value = 'Geen verzend product optie geselecteerd!'
        formLoading.value = false
        return
    } else {
        submit = true
    }
    if(submit) {
        axios.post('/labels/generate-shipment', {
            product: product.value,
            productCombination: productCombination.value
        }).then((response) => {
            console.log(response)
            if(response.data.product_id) {
                formError.value = response.data.product_id.isValidProductId
            }
            if(response.data.weight) {
                formError.value = response.data.weight.isPossibleWithProduct
            }
            if(response.data.product_id && response.data.weight) {
                formError.value = response.data.product_id.isValidProductId + ', ' + response.data.weight.isPossibleWithProduct
            }
            const link = document.createElement('a');
            link.href = response.data.file;
            link.setAttribute('download', response.data.fileName); //or any other extension
            document.body.appendChild(link);
            link.click();
            formLoading.value = false
        }).catch((error) => {
            console.log(error)
        })
    }

}

</script>

<template>
    <VCard>
        <VCardTitle>Genereer label en pakbon</VCardTitle>
        <VCardText>
            <VRow>
                <VCol cols="6">
                    <VSelect
                        v-model="product"
                        :items="props.shipmentProducts.data"
                        item-value="id"
                        item-title="name"
                        label="Verzender"
                        return-object
                        chips
                    >
                        <template v-slot:item="{ props, item }">
                            <v-list-item v-bind="props" lines="three">
                                <template v-slot:subtitle>
                                    <span v-html="item.raw.specifications"></span>
                                </template>
                            </v-list-item>
                        </template>
                    </VSelect>
                </VCol>
                <VCol cols="6" v-if="product != null">
                    <VSelect
                        v-model="productCombination"
                        :items="product.combinations"
                        item-value="id"
                        item-title="name"
                        label="Verzender opties"
                        return-object
                        chips
                    />
                </VCol>
            </VRow>
            <VAlert
                v-if="formError !== ''"
                density="compact"
                :text="formError"
                title="Fout bij aanvraag"
                type="error"
            />
        </VCardText>
        <VCardText style="justify-content: space-between; display: flex;">
            <span>&nbsp;</span>
            <VBtn color="secondary" @click="onSubmit" :loading="formLoading">Genereer</VBtn>
        </VCardText>
    </VCard>
</template>
