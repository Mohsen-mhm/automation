<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    public const ABOUT_US_INDEX = 'about-us-index';
    public const ABOUT_US_EDIT = 'about-us-edit';

    protected $fillable = [
        'title',
        'description',
        'image',
    ];
}
