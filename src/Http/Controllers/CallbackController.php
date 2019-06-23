<?php

namespace Tumainimosha\TigopesaPush\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use Tumainimosha\TigopesaPush\Events\TigopesaCallbackReceived;
use Tumainimosha\TigopesaPush\Models\TigopesaPushTransaction as Transaction;
use Tumainimosha\TigopesaPush\TigopesaPush;

class CallbackController extends Controller
{
    public function __invoke(Request $request)
    {
        $reference = $request->input('ReferenceID');

        try {
            /** @var Transaction $transaction */
            $transaction = Transaction::query()
                ->where('reference', $reference)
                ->firstOrFail();

            $transaction->update([
                'callback_received_at' => Carbon::now(),
                'callback_status' => $request->input('Status'),
                'callback_description' => $request->input('Description'),
                'tigopesa_transaction_id' => $request->input('MFSTransactionID'),
            ]);

            // Success response
            $response = [
                'ResponseCode' => 'BILLER-30-0000-S',
                'ResponseStatus' => true,
                'ResponseDescription' => 'Callback successful',
                'ReferenceID' => $reference,
            ];

            // Dispatch callback received event
            event(new TigopesaCallbackReceived($transaction));

        } catch (ModelNotFoundException $e) {
            logger("Callback Error! Transaction with reference $reference not found!");

            // Error Response
            $response = [
                'ResponseCode' => 'BILLER-18-3020-E',
                'ResponseStatus' => false,
                'ResponseDescription' => 'Callback failed! Transaction not found.',
                'ReferenceID' => $reference,
            ];
        }

        return Response::json($response);
    }
}
