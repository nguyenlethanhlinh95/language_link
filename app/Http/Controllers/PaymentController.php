<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * @var PaymentService
     */
    protected $paymentService;

    /**
     * PaymentController constructor.
     * @param PaymentService $paymentService
     */
    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $payments = $this->paymentService->getAllPaymentWithPagination();
        $data = [
            'payments' => $payments
        ];
        //dd($data);
        return view('payment.index', $data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('payment.create');
    }

    /**
     * @param PaymentRequest $request
     *
     * return Mix
     */
    public function store(PaymentRequest $request)
    {
        try {
            $params = $request->all();
            $params['payment_amount'] = changeVND($params['payment_amount']);
            $status = $this->paymentService->store($params);
            if ($status) {
                return redirect()->route('payment.index')
                    ->with('suc', 'Thêm mới phiếu chi thành công !');
            }
            return back()->with('err','Không thể thêm mới!');
        } catch (\Exception $exception)
        {
            dd($exception->getMessage());
            abort(404);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        try {
            $payment = $this->paymentService->findById($id);
        } catch (\Exception $exception)
        {
            abort(404);
        }
        $data = [
            'payment' => $payment
        ];
        return view('payment.edit', $data);
    }

    /**
     * @param PaymentRequest $request
     * @return mixed
     */
    public function update(PaymentRequest $request, $id)
    {
        try {
            $params = $request->all();
            $status = $this->paymentService->update($params,$id);
            if ($status) {
                return redirect()->route('payment.index')
                    ->with('suc', 'Cập nhật phiếu chi thành công !');
            }
            return back()->with('err','Không thể cập nhật!');
        } catch (\Exception $exception)
        {
            abort(404);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        try {
            $payment = $this->paymentService->findById($id);
        } catch (\Exception $exception)
        {
            abort(404);
        }
        $data = [
            'payment' => $payment
        ];
        return view('payment.show', $data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        try {
            $status = $this->paymentService->delete($id);
            if ($status) {
                return redirect()->route('payment.index')
                    ->with('suc', 'Xóa phiếu chi thành công !');
            }
            return back()->with('err','Không thể xóa!');
        } catch (\Exception $exception)
        {
            abort(404);
        }
    }
}
