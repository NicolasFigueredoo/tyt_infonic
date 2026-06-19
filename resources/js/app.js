import { createApp, reactive, ref, watch } from 'vue'
import App from './App.vue'
import router from './router'
import SectionHeader from './components/SectionHeader.vue'
import Main from './components/Layouts/Main.vue'
import Dropdown from './components/Dropdown/index.vue'
import Paginator from './components/Paginator/index.vue'
import { InputsRegister } from './components/Inputs/index.js'

window.public_path = document.head.querySelector('meta[name="public-path"]')
if (window.public_path) {
    window.public_path = window.public_path.content.replace(/\/$/, '')
} else {
    window.public_path = ''
}

window.httpRequest = ({
    url,
    method = 'GET',
    data,
    errors
}) => {
    if (errors && Object.prototype.toString.call(errors) === '[object Object]') {
        Object.keys(errors).forEach(key => {
            errors[key].splice(0, errors[key].length)
        })
    }
    return new Promise((resolve, reject) => {
        fetch(url, {
            method: method,
            body: data,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            },
        })
        .then((response) => {
            const bodyData = response.json()
            if (response.ok) {
                resolve(bodyData)
            }
            if (response.status == 401) {
                console.log('acceso denegado')
                router.push('/adm/login')
                reject(response)
            }
            if (response.status == 405) {
                bodyData.then((data) => {
                    awesomeModal.error('Error', `
                        <p>Ha ocurrido un error 405: Metodo no permitido.</p>
                        <p>${data.message}</p>
                    `)
                    reject(data)
                })
            }
            if (response.status == 422) {
                bodyData.then((data) => {
                    if (errors && Object.prototype.toString.call(errors) === '[object Object]') {
                        Object.assign(errors, data.errors)
                    } else {
                        awesomeModal.error('Tiene errores en el formulario', `
                            ${Object.keys(data.errors).map((key) => {
                                return data.errors[key].map((error) => {
                                    return `<div class="mb-2">${error}</div>`
                                }).join('')
                            }).join('')}
                        `)
                    }
                    reject(data)
                })
            }
            if (response.status == 500) {
                bodyData.then((data) => {
                    reject(data)
                    awesomeModal.error('Error', `
                        <p>Ha ocurrido un error inesperado.</p>
                        <p>${data.message || JSON.stringify(data)}</p>
                    `)
                })
            }
            reject(response)
        })
    })
}

window.pathAsset = (path) => {
    return `${window.public_path}/${path}`
}
window.toggle = ( value, trueValue, falseValue ) => {
    if (value === trueValue) {
        return falseValue
    }
    return trueValue
}
window.$globalState = reactive({
    auth: {
        user: {},
        status: 'error',
    },
    render: false
})

$globalState.sidebar = {
    position: {
        value: 'side-bar__wrapper--absolute',
        toggle() {
            this.value = toggle(this.value, 'side-bar__wrapper--relative', 'side-bar__wrapper--absolute')
            localStorage.setItem('sidebar-position', this.value)
        }
    },
    place: {
        value: 'side-bar__wrapper--left',
        toggle() {
            this.value = toggle(this.value, 'side-bar__wrapper--left', 'side-bar__wrapper--right')
            localStorage.setItem('sidebar-place', this.value)
        }
    },
    show: {
        value: 'side-bar__wrapper--hide',
        toggle() {
            this.value = toggle(this.value, 'side-bar__wrapper--show', 'side-bar__wrapper--hide')
            localStorage.setItem('sidebar-show', this.value)
        }
    }
}
$globalState.sidebar.position.value = localStorage.getItem('sidebar-position') || $globalState.sidebar.position.value
$globalState.sidebar.place.value    = localStorage.getItem('sidebar-place')    || $globalState.sidebar.place.value
$globalState.sidebar.show.value     = localStorage.getItem('sidebar-show')     || $globalState.sidebar.show.value


const app = createApp(App)
window.appInstance = app

const logout = () => {
    let modal = awesomeModal.loading()
    httpRequest({
        url: window.public_path + '/adm/logout',
        method: 'GET'
    })
    .then((data) => {
        modal.close()
        window.$globalState.auth.status = 'error'
        window.$globalState.auth.user = {}
        window.$globalState.render = false
        setTimeout(() => {
            window.$globalState.render = true
            router.push('/adm/login')
        }, 50)
    })
    .catch((error) => {
        modal.close()
    })
}
window.logout = logout

app.provide('$globalState', window.$globalState)

window.verifyAuth = async () => {
    return new Promise((resolve, reject) => {
        httpRequest({
            url: window.public_path + '/adm/check-auth',
            method: 'GET'
        })
        .then((data) => {
            if (data.status == 'error') {
                window.$globalState.auth.status = 'error'
                window.$globalState.render = true
                awesomeModal.closeAll()
                router.push('/adm/login')
                resolve(false)
                return
            }
            Object.assign(window.$globalState.auth.user, data.user)
            window.$globalState.auth.status = 'success'
            window.$globalState.render = true
            resolve(true)
        })
        .catch((error) => {})
    })
}
window.verifyAuth()

app.mixin({
    methods: {
        pathAsset(path) {
            path = path.replace(/^\//, '')
            return `${window.public_path}/${path}`
        },
        logout() {
            return window.logout()
        }
    }
})

window.toCurrency = (numero, decimales = 2) => {
    let separadorDecimal = document.head.querySelector('meta[name="decimal-separator"]')
    if (separadorDecimal) {
        separadorDecimal = separadorDecimal.content
    } else {
        separadorDecimal = ",";
    }
    let separadorMiles = document.head.querySelector('meta[name="thousands-separator"]')
    if (separadorMiles) {
        separadorMiles = separadorMiles.content
    } else {
        separadorMiles = ".";
    }
    let partes, array;

    if ( !isFinite(numero) || isNaN(numero = parseFloat(numero)) ) {
        return "";
    }

    if ( !isNaN(parseInt(decimales)) ) {
        if (decimales >= 0) {
            numero = numero.toFixed(decimales);
        } else {
            numero = (
                Math.round(numero / Math.pow(10, Math.abs(decimales))) * Math.pow(10, Math.abs(decimales))
            ).toFixed();
        }
    } else {
        numero = numero.toString();
    }

    partes = numero.split(".", 2);
    array = partes[0].split("");
    for (var i=array.length-3; i>0 && array[i-1]!=="-"; i-=3) {
        array.splice(i, 0, separadorMiles);
    }
    numero = array.join("");

    if (partes.length>1) {
        numero += separadorDecimal + partes[1];
    }

    return numero;
}
app.config.globalProperties.$filters = {
    toCurrency(numero, decimales = 2) {
        return window.toCurrency(numero, decimales)
    }
}
app.use(router)

app.component('SectionHeader', SectionHeader)
app.component('Dropdown', Dropdown)
app.component('Main', Main)
app.component('Paginator', Paginator)
InputsRegister(app)

app.mount('#app')

window.dataPaginator = ({
    urlBase,
    filtersKeys
}) => {
    const trash = ref(false)
    const paginator = reactive({})
    const endpoint = reactive({
        dataUrl: urlBase,
        lastUrl: null,
    })
    const filters = reactive({})
    const appliedFilters = reactive({})

    filtersKeys.forEach((key) => {
        filters[key] = ''
        appliedFilters[key] = ''
    })

    const applyFilters = () => {
        appliedFilters.code = filters.code
        appliedFilters.name = filters.name
        appliedFilters.description = filters.description
        appliedFilters.oculto = filters.oculto
        syncData(endpoint.dataUrl)
    }

    const clearFilters = () => {
        for (const key in filters) {
            filters[key] = ''
        }
        for (const key in appliedFilters) {
            appliedFilters[key] = ''
        }
        syncData(endpoint.dataUrl)
    }

    const eliminarImg = () => {
        console.log(this);
    }

    const syncData = (url) => {
        let modal = awesomeModal.loading()
        if ( !endpoint.lastUrl ) {
            endpoint.lastUrl = endpoint.dataUrl
        }
        if (!url) {
            url = endpoint.lastUrl
        } else {
            endpoint.lastUrl = url
        }
        const form_data = new FormData()
        for (const [key, value] of Object.entries(appliedFilters)) {
            if (value) {
                form_data.append('filters[' + key + ']', value)
            }
        }
        if (trash.value) {
            form_data.append('trash', 1)
        }
        httpRequest({
            url: url,
            method: 'POST',
            data: form_data,
        })
        .then((data) => {
            Object.assign(paginator, data)
            modal.close()
        })
        .catch((error) => {
            modal.close()
        })
    }

    watch(trash, () => {
        syncData(endpoint.dataUrl)
    })

    return {
        trash,
        paginator,
        endpoint,
        filters,
        applyFilters,
        clearFilters,
        syncData
    }
}