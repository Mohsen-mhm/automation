<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    public const CONTACT_US_INDEX = 'contact-us-index';

    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'phone',
    ];
}
