<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CaptureOrderRequest;
use App\Http\Requests\CreateOrderRequest;
use App\Models\Order;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class OrdersController extends Controller
{
    /**
     * PayPal API provider object.
     *
     * @var
     */
    public PayPalClient $provider;

    public function __construct()
    {
        $this->provider = new PayPalClient;
        $this->provider = \PayPal::setProvider();
        $this->provider->getAccessToken();
    }

    /**
     * Create a new order.
     *
     * @param  CreateOrderRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateOrderRequest $request)
    {
        $data = json_decode('{
            "intent": "CAPTURE",
            "purchase_units": [
              {
                "amount": {
                  "currency_code": "USD",
                  "value": "70.00"
                }
              }
            ]
        }', true);

        try {
            $order = $this->provider->createOrder($data);

            if (isset($order['status']) && $order['status'] == 'CREATED') {
                Order::create([
                    'payment_order_id' => $order['id'],
                    'total' => 70.00
                ]);

                return $this->success('Order Created', [
                    'id' => $order['id']
                ]);
            }

            return $this->error('Unable to create order.');
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * Capture an order.
     *
     * @param  CaptureOrderRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function capture(CaptureOrderRequest $request)
    {
        $order = $this->provider->capturePaymentOrder($request->orderId);

        if (isset($order['status']) && $order['status'] == 'COMPLETED') {
            Order::where('payment_order_id', $request->orderId)->update([
                'status' => Order::STATUS_PAID
            ]);

            return $this->success('Order captured.', [
                'orderId' => $request->orderId
            ]);
        }

        return $this->error('Order can\'t be captured.');
    }
}
