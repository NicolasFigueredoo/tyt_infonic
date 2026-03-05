import InputText          from './InputText.vue'
import InputEmail          from './InputEmail.vue'
import InputNumber          from './InputNumber.vue'
import InputFile          from './InputFile.vue'
import InputFileImage          from './InputFileImage.vue'
import InputFileImageMultiple          from './InputFileImageMultiple.vue'
import InputPassword      from './InputPassword.vue'
import InputSelect        from './InputSelect.vue'
import InputCheckbox      from './InputCheckbox.vue'
import SelectAutocomplete from './SelectAutocomplete.vue'
import InputFake from './InputFake.vue'
import InputTextarea from './InputTextarea.vue'
import InputErrors from './InputErrors.vue'

export const InputsRegister = (app) => {
    app.component('InputText', InputText)
    app.component('InputEmail', InputEmail)
    app.component('InputNumber', InputNumber)
    app.component('InputFile', InputFile)
    app.component('InputFileImage', InputFileImage)
    app.component('InputFileImageMultiple', InputFileImageMultiple)
    app.component('InputPassword', InputPassword)
    app.component('InputSelect', InputSelect)
    app.component('InputCheckbox', InputCheckbox)
    app.component('SelectAutocomplete', SelectAutocomplete)
    app.component('InputFake', InputFake)
    app.component('InputTextarea', InputTextarea)
    app.component('InputErrors', InputErrors)
}