<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Encore\Admin\Grid;
use Encore\Admin\Show;
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
    public function index(Content $content)
    {
        $grid = new Grid(new Permission);
        $grid->column('id', 'ID')->sortable();
        $grid->column('slug', trans('admin.slug'));
        $grid->column('name', trans('admin.name'));
        $grid->column('http_path', trans('admin.route'))->display(function ($path) {
            return collect(explode("\n", $path))->map(function ($path) {
                $method = $this->http_method ?: ['ANY'];
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
                return "<div style='margin-bottom: 5px;'>$method<code>$path</code></div>";
            })->implode('');
        });
        $grid->column('created_at', trans('admin.created_at'));
        $grid->column('updated_at', trans('admin.updated_at'));
        $grid->disableBatchActions();

        return $content
            ->title($this->title())
            ->breadcrumb(['text'=>'系统管理'],['text'=>$this->title()])
            ->description($this->description['index'] ?? trans('admin.list'))
            ->body($grid);
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
        
        $tools = new \Encore\Admin\Tools($model);

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
        $tools = new \Encore\Admin\Tools($model);

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
        $tools = new \Encore\Admin\Tools(new Permission);

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
}
