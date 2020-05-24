<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use App\Models\OperationLog;
use Encore\Admin\Grid;
use Encore\Admin\Paginator;
use Illuminate\Support\Arr;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * {@inheritdoc}
     */
    protected $title = '操作日志';

    /**
     * Index interface.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function index(Content $content,Request $request)
    {        
        $where = function ($query) use ($request) {
            if ($request->get('id')) {
                $query->where('id', $request->get('id'));
            }
            if ($request->get('user_id')) {
                $query->where('user_id', $request->get('user_id'));
            }
            if ($request->get('method')) {
                $query->where('method', $request->get('method'));
            }
            if ($request->get('path')) {
                $query->where('path', 'like', $request->get('path'));
            }
            if ($request->get('ip')) {
                $query->where('ip', $request->get('ip'));
            }

        };

        $lists = OperationLog::where(function ($query) use ($where) {
                return $query->where($where);      
            })
            ->when($request->get('_export_') != 'all', function ($query) use ($request) {
                return $query->paginate($request->get('per_page'));
            });

        if($request->get('_export_')){
            if($request->get('_export_') == 'all'){
                return $this->export($lists->get());
            }else{
                return $this->export($lists);
            }
        }

        $userModel = config('admin.database.users_model');
        return $content
            ->title($this->title)
            ->breadcrumb(['text'=>$this->title])
            ->description($this->description['index'] ?? trans('admin.list'))
            ->view('admin.log.index',
            [
                'lists'=>$lists,
                'methodColors'=>OperationLog::$methodColors,
                'users'=>$userModel::all()->pluck('name', 'id'),
                'methods'=>array_combine(OperationLog::$methods, OperationLog::$methods),
            ]);
    }

    /**
     * @param mixed $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $ids = explode(',', $id);

        if (OperationLog::destroy(array_filter($ids))) {
            $data = [
                'status'  => true,
                'message' => trans('admin.delete_succeeded'),
            ];
        } else {
            $data = [
                'status'  => false,
                'message' => trans('admin.delete_failed'),
            ];
        }

        return response()->json($data);
    }

    public function export($lists)
    {
        $filename = $this->title.date('Y-m-d').'.csv';

        header("Content-Encoding:UTF-8");
        header("Content-Type:text/csv;charset=UTF-8");
        header('Content-Disposition:attachment; filename=".'.$filename.'"');
        
        $handle = fopen('php://output', 'w');

        $titles = ['ID','用户','请求动作','请求路径','Ip','输入','创建时间'];
        $records = [];
        foreach($lists as $key => $val)
        {
            $records[] = [$val->id,$val->user->name,$val->method,$val->path,$val->ip,$val->input,$val->created_at];
        }
        // Add CSV headers
        fputcsv($handle, $titles);            

        foreach ($records as $record) {
            fputcsv($handle, $record);
        }            

        // Close the output stream
        fclose($handle);            

        exit;
    }
}
