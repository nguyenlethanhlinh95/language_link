<?php

namespace App\Services;


use App\Model\Payment;

/**
 * Class PaymentService
 * @package App\Services
 */
class PaymentService
{
    /**
     * Get list user Payment with pagination
     * @return mixed
     */
    public function getAllPaymentWithPagination()
    {
        $pagination = config('constant.pagination');
        return Payment::with('employee')->paginate($pagination);
    }

    /**
     * Find by id
     * @return mixed
     */
    public function findById($id)
    {
        return Payment::query()->findOrFail($id);
    }

    /**
     * @param $params
     * @return bool
     */
    public function store($params)
    {
        $params['employee_id'] = getUserLogin()['employee_id'];
        $date = date('Y-m-d h:m:s', strtotime($params['payment_created_day']));
        $params['payment_created_day'] = $date;
        $payment = Payment::query()->create($params);
        if (!is_null($payment))
            return true;
        return false;
    }

    /**
     * @param $params
     * @param $id
     * @return bool
     */
    public function update($params, $id)
    {
        try {
            $params['employee_id'] = getUserLogin()['employee_id'];
            $date = date('Y-m-d h:m:s', strtotime($params['payment_created_day']));
            $params['payment_created_day'] = $date;
            $payment = Payment::query()->findOrFail($id);
            $payment->payment_title = $params['payment_title'];
            $payment->payment_content = $params['payment_content'];
            $payment->payment_amount = $params['payment_amount'];
            $payment->payment_created_day = $params['payment_created_day'];
            $payment->payment_note = $params['payment_note'];
            $payment->employee_id = $params['employee_id'];
            $payment->save();
            return true;
        } catch (\Exception $exception)
        {
            return false;
        }

    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        try {
            $payment = Payment::query()->findOrFail($id)->delete();
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }
}