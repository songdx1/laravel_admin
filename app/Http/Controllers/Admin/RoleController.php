<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * {@inheritdoc}
     */
    protected function title()
    {
        return trans('admin.roles');
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
        $grid = new Grid(new Role);
        $grid->column('id', 'ID')->sortable();
        $grid->column('slug', trans('admin.slug'));
        $grid->column('name', trans('admin.name'));
        $grid->column('permissions', trans('admin.permission'))->pluck('name')->label();
        $grid->column('created_at', trans('admin.created_at'));
        $grid->column('updated_at', trans('admin.updated_at'));
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            if ($actions->row->slug == 'administrator') {
                $actions->disableDelete();
            }
        });
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
        $model = Role::findOrFail($id);
        $tools = new \Encore\Admin\Tools($model);

        return $content
            ->title($this->title())
            ->breadcrumb(['text'=>'系统管理'],['text'=>$this->title()],['text'=>'查看'])
            ->description($this->description['show'] ?? trans('admin.show'))
            ->view('admin.role.show',['tools'=>$tools->render(),'model'=>$model]);
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
        $permissionModel = config('admin.database.permissions_model');
        $model = Role::findOrFail($id);
        $form = new Form($model);
        $builder =new \Encore\Admin\Form\Builder($form);
        $tools = new \Encore\Admin\Tools($model);

        return $content
            ->title($this->title())
            ->breadcrumb(['text'=>'系统管理'],['text'=>$this->title()],['text'=>'新增'])
            ->description($this->description['create'] ?? trans('admin.create'))
            ->view(
                'admin.role.edit',
                [
                    'tools'=>$tools->render(),
                    'form'=>$builder,
                    'permissions'=>$permissionModel::all()->pluck('name', 'id'),
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
        $permissionModel = config('admin.database.permissions_model');
        $form = new Form(new Role);
        $builder =new \Encore\Admin\Form\Builder($form);
        $tools = new \Encore\Admin\Tools(new Role);

        return $content
            ->title($this->title())
            ->breadcrumb(['text'=>'系统管理'],['text'=>$this->title()],['text'=>'新增'])
            ->description($this->description['create'] ?? trans('admin.create'))
            ->view(
                'admin.role.create',
                [
                    'tools'=>$tools->renderList(),
                    'form'=>$builder,
                    'permissions'=>$permissionModel::all()->pluck('name', 'id')
                ]
            );
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
        $role = Role::findOrFail($id);
        $role->slug = $request->slug;
        $role->name = $request->name;

        DB::beginTransaction();
        try{
            $role->save();
            $role->permissions()->sync($request->permissions);
            DB::commit();
        }catch(\Exception $e){
            $e->getMessage();
            DB::rollBack();
        }

        return redirect()->route('admin.auth.roles.index', $role);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        $role = new Role;
        $role->slug = $request->slug;
        $role->name = $request->name;

        DB::beginTransaction();
        try{
            $role->save();
            $role->permissions()->sync($request->permissions);
            DB::commit();
        }catch(\Exception $e){
            $e->getMessage();
            DB::rollBack();
        }

        return redirect()->route('admin.auth.roles.index', $role);
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
        $role = Role::findOrFail($id)->delete();
        return redirect()->route('admin.auth.roles.index', $role);
    }
}
