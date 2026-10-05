import { create } from 'zustand'
import { Budget } from '@/types/budget'

type ExpenseModalStore = {
    open: boolean,
    budget: Budget | null,
    openCreateModal: () => void
    closeModal: () => void,
    setBudget: (budget: Budget) => void
}

export const useExpenseModalStore = create<ExpenseModalStore>((set) => ({
    open: false,
    budget: null,
    openCreateModal: () => {
        set({
            open: true
        })
    },
    closeModal: () => {
        set({
            open: false
        })
    },
    setBudget: (budget: Budget) => {
        set({
            budget
        })
    }
}));
