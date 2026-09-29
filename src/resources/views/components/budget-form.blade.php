<div class="space-y-4 mb-8">
    <div class="flex flex-col gap-2">
        <label class="font-bold text-2xl" for="name">Nombre</label>

        <input required id="name" type="text" name="name"
            placeholder="Nombre del Presupuesto. Ej. Boda, Casa, Graduación, Semana"
            value="{{ old('name', $budget->name ?? '') }}"
            class="form-input-2 @error('name') border-red-500 @enderror" />

        <x-input-error :messages="$errors->get('name')" />
    </div>

    <div class="flex flex-col gap-2">
        <label class="font-bold text-2xl" for="amount">Cantidad</label>

        <input required id="amount" type="number" min="0" step="0.01" name="amount"
            placeholder="Cantidad de Presupuesto" value="{{ old('amount', $budget->amount ?? '') }}"
            class="form-input-2 @error('amount') border-red-500 @enderror" />

        <x-input-error :messages="$errors->get('amount')" />
    </div>

    <div class="flex flex-col gap-2">
        <div class="flex gap-2 items-center">
            <label class="font-bold text-2xl" for="type">Tipo de Presupuesto</label>
            <div class="relative inline-block group">
                <button type="button"
                    class="w-5 h-5 flex items-center justify-center rounded-full bg-neutral-900 text-neutral-300 text-sm font-bold">
                    i
                </button>
                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-80
                rounded-lg bg-neutral-700 text-white px-3 py-2
                opacity-0 invisible
                group-hover:opacity-100 group-hover:visible
                group-focus-within:opacity-100 group-focus-within:visible
                transition-all duration-200 space-y-3">
                    <p><span class="font-bold">Presupuesto General</span> te permite almacenar gastos con categorías,
                        ideal para presupuestos semanales o mensuales.</p>
                    <p><span class="font-bold">Proyecto</span> te permite almacenar gastos relacionados como una
                        graduación, boda o remodelación.</p>
                </div>
            </div>
        </div>

        <select required name="type" id="type" class="form-input-2 @error('type') border-red-500 @enderror">
            <option value="" {{ old('type', $budget->type ?? '') == '' ? 'selected' : '' }} disabled>Tipo de Presupuesto</option>
            <option value="general" {{ old('type', $budget->type ?? '') == 'general' ? 'selected' : '' }}>
                General - Con Categorías
            </option>
            <option value="goal" {{ old('type', $budget->type ?? '') == 'goal' ? 'selected' : '' }}>
                Proyecto
            </option>
        </select>

        <x-input-error :messages="$errors->get('type')" />
    </div>
</div>
