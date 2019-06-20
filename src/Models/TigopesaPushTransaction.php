<?php

namespace Tumainimosha\TigopesaPush\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TigopesaPushTransaction
 * @package Tumainimosha\TigopesaPush\Models
 *
 * @property string reference
*  @property string customer_msisdn
*  @property string biller_msisdn
*  @property integer amount
*  @property Carbon callback_received_at
*  @property boolean callback_status
*  @property string callback_description
*  @property string tigopesa_transaction_id
 */
class TigopesaPushTransaction extends Model
{
    protected $fillable = [
        'reference',
        'customer_msisdn',
        'biller_msisdn',
        'amount',
        'callback_received_at',
        'callback_status',
        'callback_description',
        'tigopesa_transaction_id',
    ];

    protected $casts = [
        'reference' => 'string',
        'customer_msisdn' => 'string',
        'biller_msisdn' => 'string',
        'amount' => 'double',
        'callback_received_at' => 'datetime',
        'callback_status' => 'boolean',
        'callback_description' => 'string',
        'tigopesa_transaction_id' => 'string',
    ];
}
