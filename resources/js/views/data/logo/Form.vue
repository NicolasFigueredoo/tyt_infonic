
<template>
    <h3>Logo:</h3>
    <div class="grid-3 gap-15">
        <InputFileImage
                    label="Image"
                    placeholder=""
                    v-model="form.image"
                    :error="errors.image"
                    class="col-1"
        />

        <img v-bind:src="form.imageSrc" class="col-3" style="max-width: 100%;" onerror="this.onerror=null;">
        
    </div>
</template>

<script setup>
    import { reactive, ref } from "@vue/reactivity";

    const props = defineProps({
        form: {
            type: Object,
            required: true,
        },
        errors: {
            type: Object,
            required: true,
        },
    })
</script>

<style lang="scss" scoped>
</style>