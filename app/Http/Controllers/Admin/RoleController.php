<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
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
    public function index(Content $content,Request $request)
    {
        $where = function ($query) use ($request) {
            if ($request->get('id')) {
                $query->where('id', $request->get('id'));
            }
            if ($request->get('slug')) {
                $query->where('slug', $request->get('slug'));
            }
            if ($request->get('name')) {
                $query->where('name', $request->get('name'));
            }
        };

        $lists = Role::where(function ($query) use ($where) {
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
            ->view('admin.role.index',
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
        $tools = new \Encore\Admin\Tools($model);

        return $content
            ->title($this->title())
            ->breadcrumb(['text'=>'系统管理'],['text'=>$this->title()],['text'=>'新增'])
            ->description($this->description['create'] ?? trans('admin.create'))
            ->view(
                'admin.role.edit',
                [
                    'tools'=>$tools->render(),
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
        $tools = new \Encore\Admin\Tools(new Role);

        return $content
            ->title($this->title())
            ->breadcrumb(['text'=>'系统管理'],['text'=>$this->title()],['text'=>'新增'])
            ->description($this->description['create'] ?? trans('admin.create'))
            ->view(
                'admin.role.create',
                [
                    'tools'=>$tools->renderList(),
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

    //导出
    public function export($lists)
    {
        $filename = $this->title().date('Y-m-d').'.csv';

        header("Content-Encoding:UTF-8");
        header("Content-Type:text/csv;charset=UTF-8");
        header('Content-Disposition:attachment; filename=".'.$filename.'"');
        
        $handle = fopen('php://output', 'w');

        $titles = ['ID','标识','名称','权限','创建时间','更新时间'];
        $records = [];
        foreach($lists as $key => $val)
        {
            $records[] = [$val->id,$val->slug,$val->name, implode(',', $val->permissions->pluck('name')->toArray() ?: []),$val->created_at,$val->updated_at];
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
