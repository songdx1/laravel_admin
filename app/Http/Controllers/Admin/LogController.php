<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use App\Models\OperationLog;
use Encore\Admin\Grid;
use Illuminate\Support\Arr;
use Encore\Admin\Layout\Content;

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
    public function index(Content $content)
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

        return $content
            ->title($this->title)
            ->breadcrumb(['text'=>$this->title])
            ->description($this->description['index'] ?? trans('admin.list'))
            ->body($grid);
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
}
