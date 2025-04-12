<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'start_time', 'end_time', 'user_id']; // Define the fillable attributes for mass assignment

    public function user(): BelongsTo // Define the relationship with the User model
    {
        return $this->belongsTo(User::class); // Assuming the foreign key in the events table is user_id that belongs to the users table
    }

    public function attendees(): HasMany // Define the relationship with the Attendee model
    {
        return $this->hasMany(Attendee::class); // Assuming the foreign key in the attendees table is event_id that belongs to the events table
    }
}
