<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Tasks;
use App\Lists;

use DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function Test(){
      /*
      return response()->json(Lists::find(9)->getTasks);
      return response()->json(Tasks::find(10)->getLists);
      return response()->json(Tasks::with('getLists')->get());
      return response()->json(Lists::with('getTasks')->get());
      return response()->json(Lists::pluck('name'));
      */
        // $list = Lists::where('name', 'hgj')->firstOrFail();
        // return response()->json($list->getTasks()->where('name', '123')->delete());
        // return session()->all();
    }

    public function delTest(){
        session()->flush();
        return session()->all();
    }

    public function list(Request $request){
        $data = Lists::pluck('name');
        return view('List',['items'=>$data]);
    }

    public function addGroup(){
        return view('addGroup');
    }

    public function addGroupPOST(Request $req){
          $this->validate($req, [
            'group' => 'required|alpha_num',
          ]);

          $list = new Lists;
          $list->name = $req->group;
          $list->save();
          return redirect('/list');

    }

    public function addList(Request $req){

            $this->validate($req, [
              'text' => 'required|alpha_num',
              'select' => 'required',
            ]);

            $task = new Tasks(['name' => $req->text]);
            $list = Lists::where('name', $req->select)->firstOrFail();
            $list->getTasks()->save($task);

            /**
            * Метод 2
            */
            /*
            $task = new Tasks;
            $task->lists_id =Lists::where('name', $req->select)->value('id');
            $task->name = $req->text;
            $task->save();
            */

            return redirect('/list');

    }
    public function del($group,$name){
            $list = Lists::where('name', $group)->firstOrFail();
            $delete = $list->getTasks()->where('name', $name)->delete();
            return redirect('/list');
        }

    public function delGroup($group){
            $deletedRows = Lists::where('name', $group)->first();
            $deletedRows->getTasks()->delete();
            $deletedRows->delete();
            return redirect('/list');
        }

    public function editGroup($group){
        $data = Lists::where('name',$group)->with('getTasks')->firstOrFail();
        return view('editGroup',['data'=>$data]);
    }

    public function editGroupPOST(Request $req){
          DB::beginTransaction();
              foreach ($req->except('_token') as $key => $value) {
                  $task = Tasks::lockForUpdate()->find($key);
                  $task->name = $value;
                  $task->save();
              }
          DB::commit();
          return redirect('/list');
    }



    public function sortGroup($group){
          session()->has('sorted')?session(['sorted'=>!session('sorted')]):session(['sorted'=>true]);
          return redirect()->back();
    }

    public function viewGroup($group){

        DB::beginTransaction();
          $lists= Lists::where('name',$group)->firstOrFail();
          if (session()->has('sorted')){
              session('sorted') ?
              $task = Tasks::where('lists_id', $lists->id)->orderBy('name', 'desc')->paginate(10) :
              $task = Tasks::where('lists_id', $lists->id)->orderBy('name', 'asc')->paginate(10);
          } else{
              $task = Tasks::where('lists_id', $lists->id)->paginate(10);
          }
        DB::commit();
        return view('task',['items'=>$task,'name'=>$lists->name]);
    }


}
