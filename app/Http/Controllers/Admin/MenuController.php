<?php

namespace App\Http\Controllers\Admin;

use Encore\Admin\Form;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Tree;
use Encore\Admin\Widgets\Box;
use Illuminate\Routing\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{

    /**
     * Index interface.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->title(trans('admin.menu'))
            ->breadcrumb(['text'=>'系统管理'],['text'=>trans('admin.menu')])
            ->description(trans('admin.list'))
            ->row(function (Row $row) {
                $row->column(6, $this->treeView()->render());
                $row->column(6, $this->createView());
            });
    }

    /**
     * Redirect to edit page.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        return redirect()->route('admin.auth.menu.edit', ['menu' => $id]);
    }

    /**
     * @return \Encore\Admin\Tree
     */
    protected function treeView()
    {
        $menuModel = config('admin.database.menu_model');

        $tree = new Tree(new $menuModel());

        $tree->disableCreate();

        $tree->branch(function ($branch) {
            $payload = "<i class='fa {$branch['icon']}'></i>&nbsp;<strong>{$branch['title']}</strong>";

            if (!isset($branch['children'])) {
                if (url()->isValidUrl($branch['uri'])) {
                    $uri = $branch['uri'];
                } else {
                    $uri = admin_url($branch['uri']);
                }

                $payload .= "&nbsp;&nbsp;&nbsp;<a href=\"$uri\" class=\"dd-nodrag\">$uri</a>";
            }

            return $payload;
        });

        return $tree;
    }

    protected function createView()
    {
        $roleModel = config('admin.database.roles_model');
        $tools = new \Encore\Admin\Tools(new Menu);
        return view(
            'admin.menu.create',
            [
                'tools'=>$tools->renderList(),
                'menuOptions'=>Menu::selectOptions(),
                'roles'=>$roleModel::all()->pluck('name', 'id'),
            ]
        );
    }

    /**
     * Edit interface.
     *
     * @param string  $id
     * @param Content $content
     *
     * @return Content
     */
    public function edit($id, Content $content)
    {
        $roleModel = config('admin.database.roles_model');
        $permissionModel = config('admin.database.permissions_model');
        $model = Menu::findOrFail($id);
        $tools = new \Encore\Admin\Tools($model);

        return $content
            ->title('菜单')
            ->breadcrumb(['text'=>'系统管理'],['text'=>'菜单'],['text'=>'新增'])
            ->description($this->description['create'] ?? trans('admin.create'))
            ->view(
                'admin.menu.edit',
                [
                    'tools'=>$tools->render(),
                    'menuOptions'=>Menu::selectOptions(),
                    'roles'=>$roleModel::all()->pluck('name', 'id')->toArray(),
                    'model'=>$model,
                ]
            );
    }

    /**
     * Help message for icon field.
     *
     * @return string
     */
    protected function iconHelp()
    {
        return 'For more icons please see <a href="http://fontawesome.io/icons/" target="_blank">http://fontawesome.io/icons/</a>';
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
        $menu = Menu::findOrFail($id);
        $menu->parent_id = $request->parent_id;
        $menu->title = $request->title;
        $menu->icon = $request->icon;
        $menu->uri = $request->uri;

        DB::beginTransaction();
        try{
            $menu->save();
            $menu->permissions()->sync($request->permissions);
            DB::commit();
        }catch(\Exception $e){
            $e->getMessage();
            DB::rollBack();
        }

        return redirect()->route('admin.auth.menu.index', $menu);
        return $this->form()->update($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        $menu = new Menu;
        $menu->parent_id = $request->parent_id;
        $menu->title = $request->title;
        $menu->icon = $request->icon;
        $menu->uri = $request->uri;

        DB::beginTransaction();
        try{
            $menu->save();
            $menu->roles()->sync($request->roles);
            DB::commit();
        }catch(\Exception $e){
            $e->getMessage();
            DB::rollBack();
        }

        return redirect()->route('admin.auth.menu.index', $menu);
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
        dd($id);
        $menu = Menu::findOrFail($id)->delete();
        return redirect()->route('admin.auth.menu.index', $menu);
    }
}
