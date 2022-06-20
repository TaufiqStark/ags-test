<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Choose extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public static function generate($chars, $count = 15)
    {
        $choose = Choose::create([
            'A' => $chars[0],
            'B' => $chars[1],
            'C' => $chars[2],
            'D' => $chars[3],
            'E' => $chars[4],
        ]);
        $all_chars = [];
        for ($i=0; $i < $count; $i++) { 
            $char = substr(str_shuffle($chars), 1);
            $all_chars[] = [
                'choose_id' => $choose->id,
                'chars' => $char
            ];
        }
        if(Char::upsert($all_chars, 'unique'))
        
        return $choose->load('char')->char;
    }
    public function get_chars()
    {
        return $this->only(str_split('ABCDE'));
    }

    public function char()
    {
        return $this->hasMany(Char::class);
    }
}
