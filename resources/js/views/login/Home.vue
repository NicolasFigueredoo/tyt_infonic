<template>
    <div class="login">
        <form class="login__form" v-if="step === 'credentials'" @submit.prevent="login">
            <div class="login__header">
                <img :src="pathAsset('/images/logoProd.png')" alt="TyT">
                <h1>Iniciar sesión</h1>
            </div>
            <InputText
                label="Nombre de Usuario / Correo electrónico"
                placeholder=""
                v-model="form.username"
                :error="errors.username"
                class="mb-15"
            />
            <InputPassword
                label="Contraseña"
                placeholder=""
                v-model="form.password"
                :error="errors.password"
                class="mb-15"
            />
            <div class="login__footer">
                <button class="btn btn--black" type="submit">
                    <i class="fas fa-sign-in-alt"></i>
                    Iniciar sesión
                </button>
            </div>
        </form>

        <form class="login__form" v-else @submit.prevent="verifyCode">
            <div class="login__header">
                <img :src="pathAsset('/images/logoProd.png')" alt="TyT">
                <h1>Ingresá el código</h1>
            </div>
            <p style="text-align:center; margin-bottom: 20px;">
                Te enviamos un código de acceso a tu correo. Ingresalo para continuar.
            </p>
            <InputText
                label="Código"
                placeholder=""
                v-model="form.code"
                :error="errors.code"
                class="mb-15"
            />
            <div class="login__footer">
                <button class="btn btn--black" type="submit">
                    <i class="fas fa-sign-in-alt"></i>
                    Verificar código
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
    import { reactive, ref } from 'vue'
    import { useRoute, useRouter } from 'vue-router'

    const route = useRoute()
    const router = useRouter()

    const step = ref('credentials')

    const form = reactive({
        username: '',
        password: '',
        code: '',
    })
    const errors = reactive({
        username: [],
        password: [],
        code: [],
    })

    const login = () => {
        let modal = awesomeModal.loading()
        var form_data = new FormData();

        form_data.append("username", form.username);
        form_data.append("password", form.password);
        httpRequest({
            url: window.public_path + '/adm/login',
            method: 'POST',
            data: form_data,
            errors: errors,
        })
        .then((data) => {
            modal.close()
            if (data && data.data && data.data.two_factor) {
                step.value = 'code'
                return
            }
            window.verifyAuth().then(result => {
                if (result) {
                    router.push('/adm')
                }
            })
        })
        .catch((response) => {
            modal.close()
            if (response.status == 401) {
                errors.username.push('Usuario o contraseña incorrectos')
                return false
            }
        })
    }

    const verifyCode = () => {
        let modal = awesomeModal.loading()
        var form_data = new FormData();

        form_data.append("username", form.username);
        form_data.append("code", form.code);
        httpRequest({
            url: window.public_path + '/adm/login/verify-code',
            method: 'POST',
            data: form_data,
            errors: errors,
        })
        .then((data) => {
            window.verifyAuth().then(result => {
                if (result) {
                    modal.close()
                    router.push('/adm')
                }
            })
        })
        .catch((response) => {
            modal.close()
            if (response.status == 401) {
                errors.code.push('Código inválido o vencido')
                return false
            }
        })
    }

</script>
<style lang="scss" scoped>
    .login {
        background-color: #ecf0f1;
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        &__form {
            padding: 44px 24px;
            box-sizing: border-box;
            background: #FFFFFF;
            max-width: 440px;
            width: 100%;
        }
        &__header {
            text-align: center;
            img {
                margin-bottom: 37px;
            }
            h1 {
                font-weight: 600;
                font-size: 30px;
                line-height: 32px;
                color: #000000;
                margin: 0 0 32px 0;
            }
        }
        &__footer {
            text-align: center;
        }
    }
</style>
