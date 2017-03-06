<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/5
 * Time: 21:29
 */

namespace App\Http\Controllers\Backend;


use App\Service\Pc\IndustryService;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

class IndustryController extends BaseController
{

    protected $subViewPath = "industry";

    public function index(Request $request)
    {
        $name = trim($request -> input("name"));
        $pageSize = $request -> input("pageSize");
        $builder = (new IndustryService()) -> orderBy("created_at", "desc");

        if($name != "")
            $builder = $builder -> where("name", "like", "%$name%");
        $resultSet = $builder -> paginate($pageSize) -> toArray();

        $pageHtml = $this -> getPagination($resultSet, $request -> getPathInfo(), ['name' => $name]) ;

        return $this -> _sendViewResponse("index", array_merge($resultSet, ['name' => $name, 'pageHtml' => $pageHtml]));
    }

    public function create(Request $request)
    {
        if($request -> ajax()) {
            $repo = new IndustryService();
            $repo -> fill($request -> all()) -> save();
            return $this -> _sendJsonResponse("添加成功", ['insertId' => $repo -> getAttribute("id")]);
        }
        return $this -> _sendViewResponse("new");
    }


    public function update(Request $request, $id)
    {
        $repo = (new IndustryService()) -> find($id);
        if($request -> ajax())
        {
            $newName = $request -> input("name");
            $repo -> setAttribute("name", $newName) -> save();

            return $this -> _sendJsonResponse("修改成功", ['id' => $id]);
        }
        return $this -> _sendViewResponse("update", $repo);
    }

    public function delete(Request $request, $id)
    {
        if($request -> ajax()){
            $repo = (new IndustryService()) -> find($id);
            if($repo) {
                $repo -> delete();
                return $this -> _sendJsonResponse("删除成功", ['id' => $id]);
            }
            return $this -> _sendJsonResponse("对象不存在", null, false);
        }
        throw new MethodNotAllowedException("仅支持ajax请求");
    }
}