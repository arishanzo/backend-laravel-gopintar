<?php

namespace App\Http\Controllers\Pembayaran;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\CoreApi;

class PaymentController extends Controller
{
    //

    public function __construct()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        //  \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
        config::$isProduction = false;

        Config::$isSanitized = true;

        Config::$is3ds = true;
    }

      public function charge(Request $request)
    {
        $method = $request->method;
        $amount = $request->total;
        $bank   = $request->bank;

        $params = [
            "transaction_details" => [
                "order_id" => uniqid(),
                "gross_amount" => $amount
            ],
            "item_details" => [
                [
                    "id" => uniqid('id-'),
                    "price" => $amount,
                    "quantity" => 1,
                    "name" => "Pembayaran Paket"
                ]
            ],
            "customer_details" => [
                "first_name" => $request->user()->nama_user,
                "email" => $request->user()->email,
            ],
        ];

        switch ($method) {
            case "bank_transfer":
                $params["payment_type"] = "bank_transfer";
                $params["bank_transfer"] = ["bank" => $bank];
                break;

            case "qris":
                $params["payment_type"] = "qris";
                break;

            case "gopay":
                $params["payment_type"] = "gopay";
                $params["gopay"] = [
                    "enable_callback" => true,
                    "callback_url" => "myapp://callback"
                ];
                break;

            case "shopeepay":
                $params["payment_type"] = "shopeepay";
                break;

            case "credit_card":
                $params["payment_type"] = "credit_card";
                $params["credit_card"] = ["secure" => true];
                break;

            case "cstore_indomaret":
                $params["payment_type"] = "cstore";
                $params["cstore"] = [
                    "store" => "indomaret",
                    "message" => "Pembayaran belanja di toko Indomaret"
                ];
                break;

            case "cstore_alfamart":
                $params["payment_type"] = "cstore";
                $params["cstore"] = [
                    "store" => "alfamart",
                    "message" => "Pembayaran belanja di toko Alfamart"
                ];
                break;
        }

        $charge = CoreApi::charge($params);

            // simpan ke DB
        $pembayaran = new Pembayaran();
        $pembayaran->iduser = $request->user()->iduser;
        $pembayaran->order_id = $charge->order_id;
        $pembayaran->transaction_id = $charge->transaction_id;
        $pembayaran->namapaket = $request->namapaket ?? 'Paket Berlangganan';
        $pembayaran->jumlahpembayaran = $charge->gross_amount;
        $pembayaran->statuspembayaran = $charge->transaction_status;
        $pembayaran->metodepembayaran = $charge->payment_type;
        $pembayaran->tglberakhirpembayaran = now()->addDays(1);

        // simpan detail sesuai metode
        if ($charge->payment_type === "bank_transfer" && isset($charge->va_numbers)) {
            $pembayaran->va_number = $charge->va_numbers[0]->va_number;
            $pembayaran->bank = $charge->va_numbers[0]->bank;
        }
        if ($charge->payment_type === "qris" && isset($charge->actions)) {
            $pembayaran->qris_url = $charge->actions[0]->url;
        }
        if ($charge->payment_type === "cstore") {
            $pembayaran->payment_code = $charge->payment_code;
        }
        if ($charge->payment_type === "credit_card" && isset($charge->redirect_url)) {
            $pembayaran->redirect_url = $charge->redirect_url;
        }
        if (($charge->payment_type === "gopay" || $charge->payment_type === "shopeepay") && isset($charge->actions)) {
            $pembayaran->redirect_url = $charge->actions[0]->url;
        }

        $pembayaran->save();

        return response()->json($pembayaran);
    }

     public function notification(Request $request)
    {
        $notif = $request->all();

        $order = Pembayaran::where('transaction_id', $notif['transaction_id'])->first();
        if ($order) {
            $order->update([
                'status'   => $notif['transaction_status'],
                'response' => $notif,
            ]);
        }

        return response()->json(['success' => true]);
    }


  public function getTransaction($iduser)
{
    $trx = Pembayaran::where('iduser', $iduser)->first();
    return response()->json($trx);
}
}
