<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

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
        $tools = new \Encore\Admin\Tools($model);

        return $content
            ->title($this->title())
            ->breadcrumb(['text'=>'系统管理'],['text'=>$this->title()],['text'=>'新增'])
            ->description($this->description['create'] ?? trans('admin.create'))
            ->view(
                'admin.user.edit',
                [
                    'tools'=>$tools->render(),
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
        $tools = new \Encore\Admin\Tools($userModel);

        return $content
            ->title($this->title())
            ->breadcrumb(['text'=>'系统管理'],['text'=>$this->title()],['text'=>'新增'])
            ->description($this->description['create'] ?? trans('admin.create'))
            ->view(
                'admin.user.create',
                [
                    'tools'=>$tools->renderList(),
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
    public function update(Request $request, $id)
    {
        $userModel = config('admin.database.users_model');
        $user = $userModel::findOrFail($id);
        //头像        
        if ($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $path = $avatar->store('images/'.date('Ymd'), 'admin');
            $user->avatar = $path;
        }
        //密码
        if($request->password && $request->password_confirmation && $request->password == $request->password_confirmation)
        {
            $user->password = Hash::make($request->password);
        }
        $user->username = $request->username;
        $user->name = $request->name;

        DB::beginTransaction();
        try{
            $user->save();
            $user->roles()->sync($request->roles);
            $user->permissions()->sync($request->permissions);
            DB::commit();
        }catch(\Exception $e){
            $e->getMessage();
            DB::rollBack();
        }

        return redirect()->route('admin.auth.users.index', $user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        $userModel = config('admin.database.users_model');
        $user = new $userModel;
        //头像        
        if ($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $path = $avatar->store('images/'.date('Ymd'), 'admin');
            $user->avatar = $path;
        }
        //密码
        if($request->password && $request->password_confirmation && $request->password == $request->password_confirmation)
        {
            $user->password = Hash::make($request->password);
        }else{
            return redirect()->route('admin.auth.users.index', $request);
        }
        $user->username = $request->username;
        $user->name = $request->name;
        $user->remember_token = Str::random(10);

        DB::beginTransaction();
        try{
            $user->save();
            $user->roles()->sync($request->roles);
            $user->permissions()->sync($request->permissions);
            DB::commit();
        }catch(\Exception $e){
            $e->getMessage();
            DB::rollBack();
        }

        return redirect()->route('admin.auth.users.index', $user);
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
        $userModel = config('admin.database.users_model');
        $user = $userModel::findOrFail($id)->delete();
        return redirect()->route('admin.auth.users.index', $user);
    }
}
