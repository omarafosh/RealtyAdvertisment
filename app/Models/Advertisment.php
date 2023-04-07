<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Advertisment extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $table = 'advertisment';
    protected $fillable = [
        "id",
        "user_id",
        "type",
        "salary",
        "rooms",
        "bath_room",
        "area",
        "evaluation",
        "state",
        "duration",
        "location",
        "description",
        "advertisment_type",
    ];
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('advertisment');
        $this->addMediaCollection('profile');
    }
}
