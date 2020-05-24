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
        $grid = new Grid(new OperationLog());
        $grid->model()->orderBy('id', 'DESC');
        $grid->column('id', 'ID')->sortable();
        $grid->column('user.name', '用户');
        $grid->column('method', '请求动作')->display(function ($method) {
            $color = Arr::get(OperationLog::$methodColors, $method, 'grey');
            return "<span class=\"badge bg-$color\">$method</span>";
        });
        $grid->column('path','请求路径')->label('info');
        $grid->column('ip')->label('primary');
        $grid->column('input','输入')->display(function ($input) {
            $input = json_decode($input, true);
            $input = Arr::except($input, ['_pjax', '_token', '_method', '_previous_']);
            if (empty($input)) {
                return '<code>{}</code>';
            }
            return '<pre>'.json_encode($input, JSON_PRETTY_PRINT | JSON_HEX_TAG).'</pre>';
        });
        $grid->column('created_at', trans('admin.created_at'));
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableEdit();
            $actions->disableView();
        });
        $grid->disableCreateButton();
        $grid->filter(function (Grid\Filter $filter) {
            $userModel = config('admin.database.users_model');
            $filter->equal('user_id', '用户')->select($userModel::all()->pluck('name', 'id'));
            $filter->equal('method','请求动作')->select(array_combine(OperationLog::$methods, OperationLog::$methods));
            $filter->like('path','请求路径');
            $filter->equal('ip');
        });
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
            return $this->export($lists);
        }
        // return $content
        //     ->title($this->title)
        //     ->breadcrumb(['text'=>$this->title])
        //     ->description($this->description['index'] ?? trans('admin.list'))
        //     ->body($grid);

        $userModel = config('admin.database.users_model');
        return $content
            ->title($this->title)
            ->breadcrumb(['text'=>$this->title])
            ->description($this->description['index'] ?? trans('admin.list'))
            ->view('admin.log.index',
            [
                'grid'=>$grid,
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
        dd($lists);
    }
}
