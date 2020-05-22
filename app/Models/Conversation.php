<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $table = 'conversations';

    protected $fillable = [
        'owner_id',
        'peer_id',
    ];

    public function scopeByOwnerAndPeer(Builder $builder, int $owner_id, int $peer_id): Builder
    {
        return $builder->where('owner_id', $owner_id)->where('peer_id', $peer_id);
    }

    public function scopeByOwner(Builder $builder, int $owner_id): Builder
    {
        return $builder->where('owner_id', $owner_id);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
