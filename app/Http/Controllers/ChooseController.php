<?php

namespace App\Http\Controllers;

use App\Models\Char;
use App\Models\Choose;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChooseController extends Controller
{
    public function index()
    {
        return view('index');
    }
    public function generate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'chars' => 'min:5|max:5|required',
            'count' => 'max:255|numeric|nullable'
        ]);
        if($validator->fails()){
            return back()->with('error', $validator->errors()->all());
        }
        $valid = $validator->validated();
        $chars = $valid['chars'];
        if(Char::is_repeat_char($chars)) return back()->withInput()->with('error', 'Huruf/Karakter tidak boleh ada yang sama.');
        $result = Choose::generate($chars, $valid['count'] ?? 15);
        return back()->with([
            'all_chars' => $result,
            'full_chars' => $chars
        ]);
    }
    public function correction(Request $request, Choose $choose)
    {
        $chars = $choose->load('char')->char->find($request->chars_id);
        foreach($choose->get_chars() as $k => $c){
            if(!str_contains($chars->chars, $c)){
                $correct = $k;
            }
        }
        return response()->json([
            'choosed' => $request->choose,
            'correct' => $correct ?? 0
        ], 200);
    }
}
