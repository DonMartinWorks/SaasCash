import { create } from 'zustand'
import { Budget } from '@/types/budget'
import { Category } from '@/types/category'

type ExpenseModalStore = {
    open: boolean,
    budget: Budget | null,
    categories: Category[],
    openCreateModal: () => void
    closeModal: () => void,
    setBudget: (budget: Budget) => void
    setCategories: (categories: Category[]) => void
}

export const useExpenseModalStore = create<ExpenseModalStore>((set) => ({
    open: false,
    budget: null,
    categories: [],
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
    },
    setCategories: (categories: Category) => {
        set({
            categories
        })
    }
}));
