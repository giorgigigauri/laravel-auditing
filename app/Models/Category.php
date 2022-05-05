<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Redactors\LeftRedactor;

class Category extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name',
        'slug',
        'status',
    ];

    protected $auditInclude = [
        'name',
        'slug',
        'status',
    ];

    protected $attributeModifiers = [
        'slug' => LeftRedactor::class,
        //'slug' => Base64Encoder::class,
    ];
}
