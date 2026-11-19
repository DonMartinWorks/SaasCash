import '@inertiajs/core';

export interface SharedProps {
    flash: {
        success?: string;
        error?: string;
        warning?: string;
        info?: string;
        status?: string;
    },
    user: {
        user: {
            id: number
            name: string
            email: string
        },
        subscribed: boolean,
        plan: string | null
    }
}

declare module '@inertiajs/core' {
    export interface InertiaConfig {
        sharedPageProps: SharedProps;
    }
}
