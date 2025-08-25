<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

          /**
     * fillable
     *
     * @var array
     */
    protected $table = 'pembayaran';
     protected $primaryKey = 'idpembayaran';
       public $incrementing = true; // jika auto increment
    protected $keyType = 'int'; // tipe primary key

     public function User_Login()
     {
         return $this->belongsTo(UserLogin::class, 'iduser'); // Relasi Many-to-One
     }
 


    protected $fillable = [
        'iduser',
        'order_id',
        'transaction_id',
        'namapaket',
        'metodepembayaran',
        'jumlahpembayaran',
        'statuspembayaran',
        'tglberakhirpembayaran',
        'va_number',
        'bank',
        'qris_url',
        'payment_code',
        'redirect_url',
    ];

      protected $casts = [
        'response' => 'array',
    ];
}
