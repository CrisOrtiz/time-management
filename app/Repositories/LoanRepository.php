<?php

namespace App\Repositories;

use App\Models\Loan;
use App\Models\Client;
use App\Models\LoanAbono;
use App\Models\LoanInstallment;
use App\Models\LoanPayment;
use Carbon\Carbon;

class LoanRepository
{
    public function createAbono($worker, $collectionId, $abonoData)
    {
        $abono = new LoanAbono();
        $abono->date = $abonoData['date'];
        $abono->amount = $abonoData['amount'];
        $abono->blocked = $abonoData['blocked'];
        $abono->loan_id = $abonoData['loan_id'];
        $abono->client_id = $abonoData['client_id'];
        $abono->created_by = $worker->id;
        $abono->collection_id = $collectionId;
        $abono->created_at_device = Carbon::createFromTimestamp($abonoData['created_at_device']);
        $abono->updated_at_device = Carbon::createFromTimestamp($abonoData['updated_at_device']);
        $abono->save();

        return $abono;
    }

    public function createInstallment($worker, $collectionId, $installmentData)
    {
        $installment = new LoanInstallment();
        $installment->id = $installmentData['id'];
        $installment->date = $installmentData['date'];
        $installment->amount = $installmentData['amount'];
        $installment->status = $installmentData['status'];
        $installment->loan_id = $installmentData['loan_id'];
        $installment->client_id = $installmentData['client_id'];
        $installment->collection_id = $collectionId;
        $installment->created_by_id = $worker->id;
        $installment->created_at_device = Carbon::createFromTimestamp($installmentData['created_at_device']);
        $installment->save();
    }

    public function createLoan($worker, $collectionId, $loanData)
    {
        $collection = $worker->collections()->find($collectionId);
        if (!$collection) {
            return;
        }

        $loan = new Loan();
        $loan->id = $loanData['id'];
        $loan->date = $loanData['date'];
        $loan->end_date = $loanData['end_date'];
        $loan->amount = $loanData['amount'];
        $loan->interest = $loanData['interest'];
        $loan->debt = $loanData['debt'];
        $loan->installment_number = $loanData['installment_number'];
        $loan->fee = $loanData['fee'];
        $loan->paid = $loanData['paid'];
        $loan->status = $loanData['status'];
        $loan->blocked = $loanData['blocked'];
        $loan->glosa = $loanData['glosa'] ?? '';
        $loan->type = $loanData['type'];
        $loan->installment_dates = $loanData['installment_dates'];
        $loan->client_id = $loanData['client_id'];
        $loan->created_by = $worker->id;
        $loan->created_at_device = Carbon::createFromTimestamp($loanData['created_at_device']);
        $loan->collection_id = $collectionId;
        $loan->save();

        return $loan;
    }

    public function deleteAbono(LoanAbono $abono)
    {
        $abono->delete();
    }

    public function deleteInstallment(LoanInstallment $installment)
    {
        $installment->delete();
    }

    public function deletePayment(LoanPayment $payment)
    {
        $payment->delete();
    }

    public function updateLoan(Loan $loan, $loanData)
    {
        $loan->paid = $loanData['paid'];
        $loan->debt = $loanData['debt'];
        $loan->save();

        return $loan;
    }

    public function createPayment($worker, $collectionId, $paymentData)
    {
        $collection = $worker->collections()->find($collectionId);
        if (!$collection) {
            return;
        }

        $payment = new LoanPayment();
        $payment->id = $paymentData['id'];
        $payment->date = $paymentData['date'];
        $payment->amount = $paymentData['amount'];
        $payment->type = $paymentData['type'];
        $payment->blocked = $paymentData['blocked'];
        $payment->loan_installment_id = $paymentData['loan_installment_id'];
        $payment->client_id = $paymentData['client_id'];
        $payment->loan_id = $paymentData['loan_id'];
        $payment->created_by = $worker->id;
        $payment->created_at_device = Carbon::createFromTimestamp($paymentData['created_at_device']);
        $payment->collection_id = $collectionId;
        $payment->save();

        return $payment;
    }

    public function updateInstallment(LoanInstallment $installment, $installmentData)
    {
        $installment->status = $installmentData['status'];
        $installment->save();

        return $installment;
    }

    public function updateAbono(LoanAbono $abono, $abonoData)
    {
//        $abonoData->status = $installmentData['status'];
        $abono->save();
        return $abono;
    }
}
