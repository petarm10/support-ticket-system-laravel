<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class SupportTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'priority',
        'status',
        'user_id',
        'agent_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function assignAgent(User $agent): void
    {
        $this->agent_id = $agent->id;
        $this->status = 'assigned';
        $this->save();
    }
    
    public function reassignAgent(User $agent): void
    {
        $this->agent_id = $agent->id;
        $this->save();
    }
}
