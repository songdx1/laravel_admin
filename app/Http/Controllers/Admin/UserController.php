<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Layout\Content;

class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    protected function title()
    {
        return trans('admin.administrator');
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
        $userModel = config('admin.database.users_model');

        $grid = new Grid(new $userModel());
        $grid->column('id', 'ID')->sortable();
        $grid->column('username', trans('admin.username'));
        $grid->column('name', trans('admin.name'));
        $grid->column('roles', trans('admin.roles'))->pluck('name')->label();
        $grid->column('created_at', trans('admin.created_at'));
        $grid->column('updated_at', trans('admin.updated_at'));
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            if ($actions->getKey() == 1) {
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
        $userModel = config('admin.database.users_model');
        $model = $userModel::findOrFail($id);
        $tools = new \Encore\Admin\Tools($model);

        return $content
            ->title($this->title())
            ->breadcrumb(['text'=>'系统管理'],['text'=>$this->title()],['text'=>'查看'])
            ->description($this->description['show'] ?? trans('admin.show'))
            ->view('admin.user.show',['tools'=>$tools->render(),'model'=>$model]);
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
        $userModel = config('admin.database.users_model');        
        $permissionModel = config('admin.database.permissions_model');
        $roleModel = config('admin.database.roles_model');
        $model = $userModel::findOrFail($id);
        $form = new Form($model);
        $builder =new \Encore\Admin\Form\Builder($form);
        $tools = new \Encore\Admin\Tools($model);
        $image = new \Encore\Admin\Form\File('avatar',['头像'],$model);

        return $content
            ->title($this->title())
            ->breadcrumb(['text'=>'系统管理'],['text'=>$this->title()],['text'=>'新增'])
            ->description($this->description['create'] ?? trans('admin.create'))
            ->view(
                'admin.user.edit',
                [
                    'tools'=>$tools->render(),
                    'form'=>$builder,
                    'image'=>$image->render()->getData(),
                    'roles'=>$roleModel::all()->pluck('name', 'id'),
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
        $userModel = config('admin.database.users_model');
        $permissionModel = config('admin.database.permissions_model');
        $roleModel = config('admin.database.roles_model');
        $form = new Form(new $userModel());
        $builder =new \Encore\Admin\Form\Builder($form);
        $tools = new \Encore\Admin\Tools($userModel);
        $image = new \Encore\Admin\Form\Field\File('avatar',['头像']);
        return $content
            ->title($this->title())
            ->breadcrumb(['text'=>'系统管理'],['text'=>$this->title()],['text'=>'新增'])
            ->description($this->description['create'] ?? trans('admin.create'))
            ->view(
                'admin.user.create',
                [
                    'renderList'=>$tools->renderList(),
                    'form'=>$builder,
                    'image'=>$image->render()->getData(),
                    'roles'=>$roleModel::all()->pluck('name', 'id'),
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
    public function update($id)
    {
        return $this->form()->update($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return mixed
     */
    public function store()
    {
        return $this->form()->store();
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
        return $this->form()->destroy($id);
    }
}
