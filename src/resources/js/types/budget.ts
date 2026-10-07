import { Expense } from "./expense";

type BudgetType = 'general' | 'goal';

export type Budget = {
    id: number,
    name: string,
    amount: string,
    type: BudgetType,
    expenses: Expense[]
    created_at: string,
    updated_at: string
}
