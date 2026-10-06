import React from 'react'

export default function InputError({ children }: { children: React.ReactNode }) {
    return (
        // La clase es la misma 'input-error' de styles.css
        <p className="text-xs font-semibold text-red-600 mt-1">
            {children}
        </p>
    )
}
