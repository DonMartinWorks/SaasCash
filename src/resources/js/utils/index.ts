export function formatDate(date: string): string {
    return new Intl.DateTimeFormat('es-CL', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    }).format(new Date(date))
}

export function formatCurrency(amount: number): string {
    return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(amount)
}
