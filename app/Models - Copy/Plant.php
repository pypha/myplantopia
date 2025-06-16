<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    protected $fillable = ['name', 'category', 'light', 'watering', 'temperature', 'humidity', 'planting_guide', 'locations', 'image_url'];

    protected $casts = [
        'locations' => 'array',
    ];
}