<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
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
    public function index(Content $content,Request $request)
    {
        $userModel = config('admin.database.users_model');

        $where = function ($query) use ($request) {
            if ($request->get('id')) {
                $query->where('id', $request->get('id'));
            }
            if ($request->get('username')) {
                $query->where('username', 'like', '%'.$request->get('username').'%');
            }
            if ($request->get('name')) {
                $query->where('name',  'like', '%'.$request->get('name').'%');
            }
        };

        $lists = $userModel::where(function ($query) use ($where) {
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
            ->view('admin.user.index',
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

    //导出
    public function export($lists)
    {
        $filename = $this->title().date('Y-m-d').'.csv';

        header("Content-Encoding:UTF-8");
        header("Content-Type:text/csv;charset=UTF-8");
        header('Content-Disposition:attachment; filename=".'.$filename.'"');
        
        $handle = fopen('php://output', 'w');

        $titles = ['ID','用户名','名称','角色','创建时间','更新时间'];
        $records = [];
        foreach($lists as $key => $val)
        {
            $records[] = [$val->id,$val->username,$val->name, implode(',', $val->roles->pluck('name')->toArray() ?: []),$val->created_at,$val->updated_at];
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
