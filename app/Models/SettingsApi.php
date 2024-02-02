<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SettingsApi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'settings_api';
    protected $connection = 'mysql'; // çoklu db bağlantısı olması durumunda kullanılacak
    protected $guarded = ['id'];

    public function updatedBy(){
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

}
