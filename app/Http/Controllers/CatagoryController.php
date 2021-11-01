<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CatagoryController extends Controller
{
    public function getAllCatagorys()
    {
        $start = microtime(true);
        $roster = array();
        $catagorys = DB::select('select * from catagory where parent_id = ?',[0]);
        foreach ($catagorys as $catagory) {
            $childs = DB::select('select * from catagory where parent_id = ?', [$catagory->id]);
            if (count($childs) > 0) {
                foreach ($childs as $child) {
                    $subchilds = DB::select('select * from catagory where parent_id = ?', [$child->id]);
                    if (count($subchilds) > 0) {
                        foreach ($subchilds as $subchild) {
                            $roster[$catagory->name][$child->name][$subchild->id] = $subchild->name;
                        }
                    }else{
                        $roster[$catagory->name][$child->name] = [];
                    }
                }
            }
        }
        return $roster;
        $time = microtime(true) - $start; //Used for Efficiency measurement
        //return [$roster,$time];
    }
    
    public function getCatagoryById($id)
    {
        $catagorys = DB::select('select * from catagory where id = ?',[$id]);
        foreach ($catagorys as $catagory) {
            $childs = DB::select('select * from catagory where parent_id = ?', [$catagory->id]);
            if (count($childs) > 0) {
                foreach ($childs as $child) {
                    $subchilds = DB::select('select * from catagory where parent_id = ?', [$child->id]);
                    if (count($subchilds) > 0) {
                        foreach ($subchilds as $subchild) {
                            $roster[$catagory->name][$child->name][$subchild->id] = $subchild->name;
                        }
                    }else{
                        $roster[$catagory->name][$child->name] = [];
                    }
                }
            }
        }
        return $roster;
    }
    public function getRecursiveCatagoryById($id)
    {
        $subchilds = DB::select('select * from catagory where id = ?',[$id]);
        foreach ($subchilds as $subchild) {
            $childs = DB::select('select * from catagory where id = ?', [$subchild->parent_id]);
            if (count($childs) > 0) {
                foreach ($childs as $child) {
                    $catagorys = DB::select('select * from catagory where id = ?', [$child->parent_id]);
                    if (count($catagorys) > 0) {
                        foreach ($catagorys as $catagory) {
                            $roster[$subchild->name][$child->name][$catagory->name] = [];
                        }
                    }else{
                        $roster[$child->name][$catagory->name] = [];
                    }
                }
            }
        }
        return $roster;
    }
}
