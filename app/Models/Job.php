<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    protected $table = 'jobs';
    public $timestamps = true;

    use SoftDeletes;

    protected $fillable = array('policy_number', 'claim_number', 'notes', 'date_of_loss', 'type_of_loss', 'status', 'state', 'street', 'city', 'zip', 'company', 'customer_id', 'client_id', 'work_type_id', 'insurance_id');
    protected $visible = array('id', 'policy_number', 'claim_number', 'notes', 'date_of_loss', 'type_of_loss', 'status', 'state', 'street', 'city', 'zip', 'company', 'customer_id', 'client_id', 'work_type_id', 'insurance_id');


    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function workType(): BelongsTo
    {
        return $this->belongsTo(WorkType::class);
    }

    public function insurance(): BelongsTo
    {
        return $this->belongsTo(Insurance::class);
    }

    public function calendar(): HasOne
    {
        return $this->hasOne(Calendar::class);
    }

    public function document(): HasOne
    {
        return $this->hasOne(Document::class);
    }
}
