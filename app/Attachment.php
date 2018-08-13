<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = [        
        'reference_type',
        'reference_id',
        'link',
        'name',
        'file_type',
        'file_size', 
        'file_icon',
        'file_id'            
    ];

    public $timestamps = false; 
}
