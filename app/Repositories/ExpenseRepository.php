<?php

namespace App\Repositories;

use App\Models\Expense;
use Carbon\Carbon;

class ExpenseRepository
{
    public function createExpense($worker, $collectionId, $expenseData)
    {
        $expense = new Expense();
        $expense->date = $expenseData['date'];
        $expense->amount = $expenseData['amount'];
        $expense->glosa = $expenseData['glosa'] ?? '';
        $expense->blocked = $expenseData['blocked'];
        $expense->created_by_id = $worker->id;
        $expense->collection_id = $collectionId;
        $expense->created_at_device = Carbon::createFromTimestamp($expenseData['created_at_device']);
        $expense->updated_at_device = Carbon::createFromTimestamp($expenseData['updated_at_device']);
        $expense->save();

        return $expense;
    }

    public function deleteExpense(Expense $expense)
    {
        $expense->delete();
    }

    public function updateExpense(Expense $expense, $expenseData)
    {
    }
}
