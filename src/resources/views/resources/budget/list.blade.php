<div>
    <div class="mt-8 flow-root">
        <div class="overflow-x-auto ring-1 ring-neutral-300 rounded-lg border border-neutral-300 shadow-xl">
            <div class="inline-block min-w-full align-middle">
                <table class="relative min-w-full">
                    <thead>
                        <tr>
                            <th scope="col">
                                <span class="sr-only">Presupuestos</span>
                            </th>
                            <th scope="col">
                                <span class="sr-only">Acciones</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-300">
                        @forelse($budgets as $budget)
                        <tr class="flex items-center justify-between bg-white hover:bg-neutral-100 transition-colors">
                            <td class="pt-10 pb-5 px-10 relative">
                                <p class="absolute top-0 left-0 inline-block px-3 py-1 rounded-br-2xl text-sm font-medium w-40 text-white
                                    {{ $budget->isGeneral() ? 'bg-purple-950' : 'bg-orange-500' }}">
                                    {{ $budget->isGeneral() ? 'General' : 'Proyecto' }}
                                </p>
                                <a class="text-2xl font-bold text-neutral-500 block">
                                    {{ $budget->name }}
                                </a>
                                <p class="text-lg text-neutral-500">
                                    &#x24;{{ $budget->amount }}
                                </p>
                            </td>
                            <td class="py-6 px-10 flex justify-end gap-3">
                                <x-budget-dropdown :budget="$budget" />

                                <x-confirm-delete :id="'delete-dialog-'.$budget->id"
                                    :title="'Eliminar presupuesto: '.$budget->name"
                                    :message="'Esta acción es irreversible, vas a eliminar: '.$budget->name.' con el valor de $'.$budget->amount"
                                    :action="route('budgets.destroy', $budget)" />
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center py-10">
                                <p class="text-xl text-neutral-600">
                                    No Hay Presupuestos.
                                    <a href="{{ route('budgets.create') }}"
                                        class="text-amber-500 font-semibold hover:underline">
                                        Comienza creando uno
                                    </a>
                                </p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
