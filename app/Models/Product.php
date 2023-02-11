<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'image',
        'price',
        'quantity',
        'category_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price'     => 'integer',
        'quantity'  => 'integer',
    ];

    /**
     * The rules are defined so that data can be stored
     *
     * @param  bool $required
     * @param  int|null $id
     * @return array<string, mixed>
     */
    public static function rules($required = true, $id = null): array
    {
        return [
            'name'          => !$required ? '' : 'required|' . 'string|max:255' . '|unique:categories' . ($required ? '' : ',name,' . $id),
            'description'   => !$required ? '' : 'required|' . 'string|max:255' . '|unique:categories' . ($required ? '' : ',description,' . $id),
            'image'         => !$required ? '' : 'required|' . 'string|max:255',
            'price'         => !$required ? '' : 'required|' . 'integer|min:1',
            'quantity'      => !$required ? '' : 'required|' . 'integer|min:1',
            'category_id'   => !$required ? '' : 'required|' . 'integer|min:1|exists:categories,id'
        ];
    }
}
