<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Encore\Admin\Layout\Content;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * {@inheritdoc}
     */
    protected function title()
    {
        return trans('admin.permissions');
    }

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
            if ($request->get('slug')) {
                $query->where('slug', 'like', '%'.$request->get('slug').'%');
            }
            if ($request->get('name')) {
                $query->where('name', 'like', '%'.$request->get('name').'%');
            }
        };

        $lists = Permission::where(function ($query) use ($where) {
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
        
        return $content
            ->title($this->title())
            ->breadcrumb(['text'=>$this->title()])
            ->description($this->description['index'] ?? trans('admin.list'))
            ->view('admin.permission.index',
            [
                'lists'=>$lists,
            ]);
    }

    /**
     * Show interface.
     *
     * @param mixed   $id
     * @param Content $content
     *
     * @return Content
     */
    public function show($id, Content $content)
    {
        $model = Permission::findOrFail($id);

        $method = $model->http_method ?: ['ANY'];
        $path = $model->http_path;
        if (Str::contains($path, ':')) {
            list($method, $path) = explode(':', $path);
            $method = explode(',', $method);
        }
        $method = collect($method)->map(function ($name) {
            return strtoupper($name);
        })->map(function ($name) {
            return "<span class='label label-primary'>{$name}</span>";
        })->implode('&nbsp;');
        if (!empty(config('admin.route.prefix'))) {
            $path = '/'.trim(config('admin.route.prefix'), '/').$path;
        }
        $model->routes = "<div style='margin-bottom: 5px;'>$method<code>$path</code></div>";
        
        $tools = new \App\Libraries\Tools($model);

        return $content
            ->title($this->title())
            ->breadcrumb(['text'=>'系统管理'],['text'=>$this->title()],['text'=>'查看'])
            ->description($this->description['show'] ?? trans('admin.show'))
            ->view('admin.permission.show',['tools'=>$tools->render(),'model'=>$model]);
    }

    /**
     * Edit interface.
     *
     * @param mixed   $id
     * @param Content $content
     *
     * @return Content
     */
    public function edit($id, Content $content)
    {
        $model = Permission::findOrFail($id);
        $tools = new \App\Libraries\Tools($model);

        return $content
            ->title($this->title())
            ->breadcrumb(['text'=>'系统管理'],['text'=>$this->title()],['text'=>'新增'])
            ->description($this->description['create'] ?? trans('admin.create'))
            ->view(
                'admin.permission.edit',
                [
                    'tools'=>$tools->render(),
                    'methods'=>$this->getHttpMethodsOptions(),
                    'model'=>$model,
                ]
            );
    }

    /**
     * Create interface.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function create(Content $content)
    {
        $tools = new \App\Libraries\Tools(new Permission);

        return $content
            ->title($this->title())
            ->breadcrumb(['text'=>'系统管理'],['text'=>$this->title()],['text'=>'新增'])
            ->description($this->description['create'] ?? trans('admin.create'))
            ->view(
                'admin.permission.create',
                [
                    'tools'=>$tools->renderList(),
                    'methods'=>$this->getHttpMethodsOptions(),
                ]
            );
    }

    /**
     * Get options of HTTP methods select field.
     *
     * @return array
     */
    protected function getHttpMethodsOptions()
    {
        $model = config('admin.database.permissions_model');

        return array_combine($model::$httpMethods, $model::$httpMethods);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $Permission = Permission::findOrFail($id);
        $Permission->slug = $request->slug;
        $Permission->name = $request->name;
        $Permission->http_method = $request->http_method ? implode(",",$request->http_method):''; 
        $Permission->http_path = $request->http_path;       
        $Permission->save();

        return redirect()->route('admin.auth.permissions.index', $Permission);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        $Permission = new Permission;
        $Permission->slug = $request->slug;
        $Permission->name = $request->name;
        $Permission->http_method = $request->http_method ? implode(",",$request->http_method):'';
        $Permission->http_path = $request->http_path;       
        $Permission->save();

        return redirect()->route('admin.auth.permissions.index', $Permission);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id)->delete();
        return redirect()->route('admin.auth.permissions.index', $permission);
    }

    //导出
    public function export($lists)
    {
        $filename = $this->title().date('Y-m-d').'.csv';

        header("Content-Encoding:UTF-8");
        header("Content-Type:text/csv;charset=UTF-8");
        header('Content-Disposition:attachment; filename=".'.$filename.'"');
        
        $handle = fopen('php://output', 'w');

        $titles = ['ID','标识','名称','请求动作','请求路径','创建时间','更新时间'];
        $records = [];
        foreach($lists as $key => $val)
        {
            $records[] = [$val->id,$val->slug,$val->name, implode(',', $val->http_method ?: ['ANY']),$val->http_path,$val->created_at,$val->updated_at];
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
