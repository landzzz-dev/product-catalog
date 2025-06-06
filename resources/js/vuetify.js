// import this after install `@mdi/font` package
import '@mdi/font/css/materialdesignicons.css'

import 'vuetify/styles'
import { createVuetify } from 'vuetify'

const vuetify = createVuetify({
    defaults: {
        VBtn: {
            class: 'text-none'
        },
        VTextField: {
            density: 'compact',
            variant: 'outlined',
            clearable: true,
        },
        VAutocomplete: {
            density: 'compact',
            variant: 'outlined',
        },
        VSelect: {
            density: 'compact',
            variant: 'outlined',
        },
    },
    icons: {
        defaultSet: 'mdi',
    },
});

export default vuetify;
