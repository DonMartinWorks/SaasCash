import '@inertiajs/core';

export interface SharedProps {
    flash: {
        success?: string;
        error?: string;
        warning?: string;
        info?: string;
        status?: string;
    };
}

declare module '@inertiajs/core' {
    export interface InertiaConfig {
        sharedPageProps: SharedProps;
    }
}
