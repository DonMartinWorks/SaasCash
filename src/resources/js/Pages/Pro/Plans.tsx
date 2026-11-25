import PricingTable from '@/Components/PricingTable'
import { Head, usePage } from '@inertiajs/react'

type Props = {
    prices: {
        monthly: number;
        yearly: number;
    }
}

export default function Plans() {
    const { prices } = usePage().props

    return (
        <>
            <Head title="Planes" />

            <main className="mt-5">
                <PricingTable prices={prices} />
            </main>
        </>
    )
}
