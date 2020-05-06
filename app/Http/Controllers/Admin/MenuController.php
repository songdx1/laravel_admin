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

                // $row->column(6, $this->createView());

                $row->column(6, function (Column $column) {
                    $form = new \Encore\Admin\Widgets\Form();
                    $form->action(admin_url('auth/menu'));

                    $menuModel = config('admin.database.menu_model');
                    $permissionModel = config('admin.database.permissions_model');
                    $roleModel = config('admin.database.roles_model');

                    $form->select('parent_id', trans('admin.parent_id'))->options($menuModel::selectOptions());
                    $form->text('title', trans('admin.title'))->rules('required');
                    $form->icon('icon', trans('admin.icon'))->default('fa-bars')->rules('required')->help($this->iconHelp());
                    $form->text('uri', trans('admin.uri'));
                    $form->multipleSelect('roles', trans('admin.roles'))->options($roleModel::all()->pluck('name', 'id'));
                    if ((new $menuModel())->withPermission()) {
                        $form->select('permission', trans('admin.permission'))->options($permissionModel::pluck('name', 'slug'));
                    }
                    $form->hidden('_token')->default(csrf_token());

                    $column->append((new Box(trans('admin.new'), $form))->style('success'));
                });
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
        $form = new Form(new Menu);
        $builder =new \Encore\Admin\Form\Builder($form);
        $tools = new \Encore\Admin\Tools(new Menu);
        $icon = new Form\Icon;
        return view(
            'admin.menu.create',
            [
                'tools'=>$tools->renderList(),
                'form'=>$builder,
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
        $form = new Form($model);
        $builder =new \Encore\Admin\Form\Builder($form);
        $tools = new \Encore\Admin\Tools($model);

        return $content
            ->title('菜单')
            ->breadcrumb(['text'=>'系统管理'],['text'=>'菜单'],['text'=>'新增'])
            ->description($this->description['create'] ?? trans('admin.create'))
            ->view(
                'admin.menu.edit',
                [
                    'tools'=>$tools->render(),
                    'form'=>$builder,
                    'menuOptions'=>Menu::selectOptions(),
                    'roles'=>$roleModel::all()->pluck('name', 'id')->toArray(),
                    'model'=>$model,
                ]
            );
        return $content
            ->title(trans('admin.menu'))
            ->breadcrumb(['text'=>'系统管理'],['text'=>trans('admin.menu')],['text'=>'编辑'])
            ->description(trans('admin.edit'))
            ->row($this->form()->edit($id));
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    public function form()
    {
        $menuModel = config('admin.database.menu_model');
        $permissionModel = config('admin.database.permissions_model');
        $roleModel = config('admin.database.roles_model');

        $form = new Form(new $menuModel());

        $form->display('id', 'ID');

        $form->select('parent_id', trans('admin.parent_id'))->options($menuModel::selectOptions());
        $form->text('title', trans('admin.title'))->rules('required');
        $form->icon('icon', trans('admin.icon'))->default('fa-bars')->rules('required')->help($this->iconHelp());
        $form->text('uri', trans('admin.uri'));
        $form->multipleSelect('roles', trans('admin.roles'))->options($roleModel::all()->pluck('name', 'id'));
        if ($form->model()->withPermission()) {
            $form->select('permission', trans('admin.permission'))->options($permissionModel::pluck('name', 'slug'));
        }

        $form->display('created_at', trans('admin.created_at'));
        $form->display('updated_at', trans('admin.updated_at'));

        return $form;
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
        $menu = Menu::findOrFail($id)->delete();
        return redirect()->route('admin.auth.menu.index', $menu);
    }
}
