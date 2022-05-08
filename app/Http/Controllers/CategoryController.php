<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function view(Request $request): View{

        if($request->isMethod("post")) $this->edit($request);

        $tree = DB::table('kategorie')->first();
        return view("main", ["list" =>$tree]);
    }

    public function add(Request $request){
        if ($request->isMethod('put')) {
            $id_rodzic = $request->input('id_rodzic')=='null' ? null : $request->input('id_rodzic');
            $id_prev = $request->input('id_prev')=='null' ? NULL : $request->input('id_prev');

            return DB::table('kategorie')->insertGetId([
                "nazwa" => $request->input('nazwa'),
                "id_rodzic" => $id_rodzic,
                "id_prev" => $id_prev
            ]);
        }
    }

    private function edit(Request $request){
        if ($request->isMethod('post')) {
            $db = DB::table('kategorie');
            $id = (int) $request->input('id');
            $nazwa = $request->input('nazwa');
            $id_rodzic = (int) $request->input('id_rodzic');
            $id_prev = (int) $request->input('id_prev');
            $id_next = (int) $request->input('id_next');
            $id_n = (int) $request->input('id_n');
            $id_r = (int) $request->input('id_r');

            if(!empty($nazwa)) $db->where("id", $id)->update(["nazwa" => $nazwa]);
            if(!empty($id_prev)) $this->updateNextElement($id, $id_prev);
            if(!empty($id_next)) $this->updateNextElement($id_next, $id);
            if(!empty($id_rodzic)) $db->where("id", $id)->update(["id_rodzic" => $id_rodzic]);
            if(!empty($id_rodzic) && !empty($id_next)) $this->updateNextElement($id_next, $id_rodzic);
            if(!empty($id_n) && !empty($id_next) && empty($id_r)) $this->updateNextElement($id_n, $id_next);
            if(!empty($id_n) && !empty($id_next) && !empty($id_r)) $this->updateNextElement($id_n, $id_r);
        }
    }

    private function updateNextElement(int $id,int $id_prev){
        if($id_prev>0) DB::table('kategorie')->where("id", $id)->update(["id_prev" => $id_prev]);
        else DB::table('kategorie')->where("id", $id)->update(["id_prev" => null]);
    }

    public function remove(Request $request){
        if ($request->isMethod('delete')) {
            $this->removeElemnt($request->input('id'));
        }
    }

    private function removeElemnt(int $id){
        $element = DB::table('kategorie')->find($id);
        $elementNext = DB::table('kategorie')->where("id_prev", "=", $id)->first();

        if(!empty($elementNext)) DB::table('kategorie')->where("id", "=", $elementNext->id )->update(["id_prev" =>  $element->id_prev]);

        $this->removeChildren($id);

        DB::table('kategorie')->where("id", "=", $id )->delete();
    }

    private function removeChildren(int $id){
            $list =  DB::table('kategorie')->where("id_rodzic", "=", $id )->get();

            if(count($list)>0){
                foreach($list as $e){
                    $this->removeElemnt((int) $e->id);
                }
            }
    }

    public function viewChildren(Request $request){
        if ($request->isMethod('post')) {
            $id = $request->input('id');

            $list = DB::table('kategorie')->where("id_rodzic", "=", $id)->get();

            $newList = [];
            foreach ($list as $e){
                if($e->id_prev== null){
                    $newList[] = $e;
                    $li = $e;
                }
            }
            for($i = 0; $i<count($list); $i++){
                if($li->id==($list[$i]->id_prev)){
                    $newList[] = $list[$i];
                    $li = $list[$i];
                    $i=-1;
                }
            }

            return $newList;
        }
    }
}
