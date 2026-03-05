<script setup>
    import { reactive } from 'vue'
    import Item from './Item.vue'
    const modals = reactive([]);
    
    const open = (data) => {
        const item = {
            type: data.type,
            title: data.title,
            message: data.message,
            icon: data.icon,
            iconColor: data.iconColor,
            component: data.component,
            rawData:data,
            callback: {}
        }
        item.callback.promise = new Promise((resolve, reject) => {
            Object.assign(item.callback, { resolve, reject })
        })
        
        const key = modals.push(item)

        item.callback.promise.then(response => {
            // console.log('paso 2')
            modals.splice(key - 1, 1)
        })
        item.callback.promise.catch(error => {
            // console.log('paso 3')
            modals.splice(key - 1, 1)
        })
        // close is alias for resolve
        item.callback.close = item.callback.resolve
        
        item.overlayClick = () => {
            item.callback.reject('Close on overlay click')
        }

        // si presiona la tecla escape
        item.keydown = (event) => {
            if (event.key === 'Escape') {
                item.callback.reject('Close on escape key')
            }
        }
        window.addEventListener('keydown', item.keydown)

        return item.callback
    }
    const closeAll = () => {
        modals.splice(0, modals.length)
    }
    window.modals = modals
    window.awesomeModal = {}
    window.awesomeModal.open = open
    window.awesomeModal.closeAll = closeAll
    window.awesomeModal.loading = () => {
        return open({
            type: 'loading',
            title: 'Cargando',
            message: 'Espere un momento',
            icon: '<i class="fas fa-spinner fa-pulse"></i>',
            iconColor: 'var(--blue)',
        })
    }
    window.awesomeModal.error = (title, message) => {
        return open({
            type: 'loading',
            title: title,
            message: message,
            icon: '<i class="fas fa-exclamation-triangle"></i>',
            iconColor: 'var(--red)',
        })
    }

</script>

<template>
    <Item v-for="(item, key) in modals" :data="item" :key="key"></Item>
</template>

<style lang="scss" scoped>

</style>