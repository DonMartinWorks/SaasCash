/// <reference types="vite/client" />
import { createInertiaApp } from '@inertiajs/react'

const appName = import.meta.env.VITE_APP_NAME || 'CashTrackr'

createInertiaApp({
    title: title => `${title} - ${appName}`,
    pages: {
        path: './Pages',
        extension: '.tsx',
    },
});
