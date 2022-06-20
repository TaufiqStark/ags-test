<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Char extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    
    public static function is_repeat_char($str){
        $arr_str = [];
        for ($i=0; $i < strlen($str); $i++) { 
            if (!array_key_exists($str[$i], $arr_str)) {
                $arr_str[$str[$i]] = 0;
            }else{
                $arr_str[$str[$i]] += 1;
            }
        }
        foreach ($arr_str as $value) {
            if($value) return $state = true;
        }
        return $state ?? false;
    }
    public function choose()
    {
        return $this->belongsTo(Choose::class);
    }
}
