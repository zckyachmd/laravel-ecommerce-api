<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
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
            'description'   => !$required ? '' : 'required|' . 'string|max:255' . '|unique:categories' . ($required ? '' : ',description,' . $id)
        ];
    }
}
