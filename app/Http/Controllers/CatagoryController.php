<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CatagoryController extends Controller
{
    public function getAllCatagorys()
    {
        $start = microtime(true);

        $categories = DB::select('select id,name,parent_id from categories');
        $categories = collect($categories)->map(function($x){ return (array) $x; })->toArray();

        $childs = array();
        foreach($categories as &$item){
            $childs[$item['parent_id']][] = &$item;
            unset($item);
        }
        foreach($categories as &$item){
            if (isset($childs[$item['id']])){
                $item['childs'] = $childs[$item['id']];
            }else{
                $item['childs'] = [];
            }
        }
        return $childs[0];
        // $time = microtime(true) - $start;
        //return [$childs[0],$time];
    }
    
    public function getCatagoryById($id)
    {
        $categories = DB::select('select id,name,parent_id from categories');
        $categories = collect($categories)->map(function($x){ return (array) $x; })->toArray();

        $childs = array();
        foreach($categories as &$item){
            $childs[$item['parent_id']][] = &$item;
            unset($item);
        }
        foreach($categories as &$item){
            if (isset($childs[$item['id']])){
                    $item['childs'] = $childs[$item['id']];
            }
        }
        return $childs[$id];
    }

    public function getRecursiveCatagoryById($id)
    {

        $categories = DB::select('select id,name,parent_id from categories');
        $categories = collect($categories)->map(function($x){ return (array) $x; })->toArray();

        $childs = array();
        foreach($categories as &$item){
            $childs[$item['id']][] = &$item;
            unset($item);
        }
        foreach($categories as &$item){
            if (isset($childs[$item['parent_id']])){
                $item['parent'] = $childs[$item['parent_id']];
            }else{
                $item['parent'] = [];
            }
        }
        return $childs[$id];
    }
}
