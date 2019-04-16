<?php
namespace App\Entities;

use App\Services\ClientService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Debit
 * @package App\Entities
 * @property int $id
 * @property int $client_id
 * @property int $clientObject
 * @property string $reason
 * @property float $value
 * @property Carbon $date;
 */
class Debit extends Model {

    use SoftDeletes;

    protected $table = "debit";
    protected $guarded = [];
    protected $appends = ['client', 'date_formatted'];
    protected $dates = ['date'];

    public function getClientAttribute(){
        if(!$this->clientObject){
            $this->clientObject = app(ClientService::class)->findClient($this->client_id);
        }
        return $this->clientObject;
    }

    public function getDateFormattedAttribute(){
        return $this->date->format("d/m/Y");
    }

}