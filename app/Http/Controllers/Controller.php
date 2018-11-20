<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

   
    public function Test(){
        return session()->all();
    }

    public function delTest(){
        session()->flush();
        return session()->all();
    }

    public function list(Request $request){
        
        if (session()->has('ToDoList')) 
        {
            $items=session('ToDoList');
            return view('List',['items'=>$items]);
        } else {
            return view('List',['items'=>[]]);
        }
    }

    public function addGroup(){
        return view('addGroup');
    }
  
    public function addGroupPOST(Request $req){
        if (empty($req->group)){
            return redirect('/addGroup');
        }  else{
            if (session()->has('ToDoList')) 
            {
                $old_array = session('ToDoList');
                $old_array[$req->group]=[];
                $setSession=['ToDoList'=> $old_array];
                session($setSession);
                return redirect('/list');
            } else {
                $setSession=['ToDoList'=> [$req->group=>[]]];
                session($setSession);
                return redirect('/list');
            }
        }
    }

    public function addList(Request $req){
        if (empty($req->text) || empty($req->select)){
            return redirect('/list');
        }  else{
            if (session()->has('ToDoList')) 
            {
                $old_array = session('ToDoList');
                $old_array[$req->select][]=$req->text;
                $setSession=['ToDoList'=> $old_array];
                session($setSession);
                
                return redirect('/list');
            } else {
                return redirect('/list');
            }
        }
        
    }
    public function del($group,$list){
            if (session()->has('ToDoList')) 
            {
                $old_array = session('ToDoList');
                if (empty( $old_array[$group]) || empty( $old_array[$group][$list]) ) {
                    return redirect('/list');
                } else {
                    unset($old_array[$group][$list]);
                    $setSession=['ToDoList'=> $old_array];
                    session($setSession);
                    return redirect('/list');
                }
            } else {
                return redirect('/list');
            }
        }

    public function delGroup($group){
            if (session()->has('ToDoList')) 
            {
                $old_array = session('ToDoList');
                unset($old_array[$group]);
                $setSession=['ToDoList'=> $old_array];
                session($setSession);
                return redirect('/list');
            } else {
                return redirect('/list');
            }
        }
    
    public function editGroup($group){
        if (session()->has('ToDoList')) 
        {   
            $old_array = session('ToDoList');
                
            if (empty( $old_array[$group])) {
                return redirect('/list');
            } else {
                return view('editGroup',['group'=>$group]);
            }
        } else {
            return redirect('/list');
        }
            
    }

    public function editGroupPOST(Request $req){
        // dd($req->all());
        if (empty($req->group)){
            return redirect('/list');
        }  else{
             if (session()->has('ToDoList')) 
            {   
                $old_array = session('ToDoList');
                if (empty( $old_array[$req->group])) {
                    return redirect('/list');
                } else {
                    $group_array = $old_array[$req->group];
                
                    foreach ($group_array as $key => $value) {
                        $group_array[$key]=$req->$key;
                    }
                    $old_array[$req->group]=$group_array;
                    $setSession=['ToDoList'=> $old_array];
                    session($setSession);
                    return redirect('/list');
                }
            } else {
                return redirect('/list');
            }
        }

    }

 

    public function sortGroup($group){
        if (session()->has('ToDoList')) 
        {
            $old_array = session('ToDoList');
            if (empty( $old_array[$group])) {
                return redirect('/list');
            } else {
                $group_array = $old_array[$group];
                if (session()->has('sorted')) {
                    if (session()->get('sorted')===true) {
                        arsort($group_array);
                        session(['sorted'=>false]);
                    } else{
                        natcasesort($group_array);
                        session(['sorted'=>true]);
                    }
                } else{
                    natcasesort($group_array);
                    session(['sorted'=>true]);
                }
                $old_array[$group]=$group_array;
                $setSession=['ToDoList'=> $old_array];
                session($setSession);
                return redirect('/view/'.$group);
            }
        } else {
            return redirect('/list');
        }
    }

    public function viewGroup(Request $request,$group){

        if (session()->has('ToDoList')) 
        {   
            $items = session('ToDoList');
            if (empty( $items[$group])) {
                return redirect('/list');
            } else {
                if(count($items[$group])>=10){
                        // Get current page form url e.x. &page=1
                        $currentPage = LengthAwarePaginator::resolveCurrentPage();
                
                        // Create a new Laravel collection from the array data
                        $itemCollection = collect($items[$group]);
                
                        // Define how many items we want to be visible in each page
                        $perPage = 10;
                
                        // Slice the collection to get the items to display in current page
                        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
                
                        // Create our paginator and pass it to the view
                        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
                
                        // set url path for generted links
                        $paginatedItems->setPath($request->url());
                        $items[$group]=$paginatedItems;
                }
                return view('task',['items'=>[$group=>$items[$group]]]);
            }
        } else {
            return redirect('/list');
        }
    }


}
