<script src="/vendor/laravel-admin/AdminLTE/plugins/select2/select2.full.min.js"></script>
<link rel="stylesheet" href="/vendor/laravel-admin/fontawesome-iconpicker/dist/css/fontawesome-iconpicker.min.css">
<script src="/vendor/laravel-admin/fontawesome-iconpicker/dist/js/fontawesome-iconpicker.min.js"></script>
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">编辑</h3>

        <div class="box-tools">
            {!! $tools !!}
        </div>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form action="{!! route('admin.auth.menu.update',$model) !!}" method="post" accept-charset="UTF-8" class="form-horizontal" pjax-container="">    

    <div class="box-body">
        <div class="fields-group">
            <div class="col-md-12">

                <div class="form-group ">
                    <label class="col-sm-2 control-label">ID</label>
                    <div class="col-sm-8">
                        <div class="box box-solid box-default no-margin box-show">
                            <div class="box-body">
                                {{ $model->id }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group  ">
                    <label for="parent_id" class="col-sm-2 control-label">父级菜单</label>
                    <div class="col-sm-8">
                        <select class="form-control parent_id select2-hidden-accessible" style="width: 100%;" name="parent_id" data-value="" tabindex="-1" aria-hidden="true">
                            @foreach($menuOptions as $select => $option)
                                <option value="{{$select}}" {{  $select == $model->parent_id ?'selected':'' }} >{{$option}}</option>
                            @endforeach
                        </select>                 
                    </div>
                </div> 

                <div class="form-group  ">
                    <label for="title" class="col-sm-2 asterisk control-label">标题</label>
                    <div class="col-sm-8">                        
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>                            
                            <input type="text" id="title" name="title" value="{{ $model->title }}" class="form-control name" placeholder="输入 标题">                            
                        </div>                        
                    </div>
                </div>
                
                <div class="form-group  ">
                    <label for="icon" class="col-sm-2 asterisk control-label">图标</label>
                    <div class="col-sm-8">        
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>            
                            <input style="width: 140px" type="text" id="icon" name="icon" value="{{ $model->icon }}" class="form-control icon iconpicker-element iconpicker-input" placeholder="输入 图标" required="1">
                        </div>        
                    </div>
                </div>

                <div class="form-group  ">
                    <label for="username" class="col-sm-2 control-label">路径</label>
                    <div class="col-sm-8">        
                        <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>            
                            <input type="text" id="uri" name="uri" value="{{ $model->uri }}" class="form-control uri" placeholder="输入 路径">            
                        </div>        
                    </div>
                </div>

                <div class="form-group">
                    <label for="roles" class="col-sm-2 control-label">角色</label>
                    <div class="col-sm-8">
                        <select class="form-control roles" style="width: 100%;" name="roles[]" multiple="multiple" data-placeholder="输入 角色" aria-hidden = "true" >
                            @foreach($roles as $select => $option)
                            <option value="{{$select}}" {{  in_array($select, $model->roles()->pluck('id')->toArray() ) ?'selected':'' }}>{{$option}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="form-group ">
                    <label class="col-sm-2 control-label">创建时间</label>
                    <div class="col-sm-8">
                        <div class="box box-solid box-default no-margin box-show">
                            <div class="box-body">
                                {{ $model->created_at }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group ">
                    <label class="col-sm-2 control-label">更新时间</label>
                    <div class="col-sm-8">
                        <div class="box box-solid box-default no-margin box-show">
                            <div class="box-body">
                                {{ $model->updated_at }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>            
        </div>
    </div>
    <!-- /.box-body -->

    <div class="box-footer">
        @csrf
        @method('PUT')
        <div class="col-md-2">
        </div>
        <div class="col-md-8">
            <div class="btn-group pull-right">
                <button type="submit" class="btn btn-primary">提交</button>
            </div>            
            <div class="btn-group pull-left">
                <button type="reset" class="btn btn-warning">重置</button>
            </div>
        </div>
    </div>

<!-- /.box-footer -->
    </form>
</div>
<script>
$(".roles").select2({"allowClear":true,"placeholder":{"id":"","text":"角色"}});
$(".parent_id").select2({"allowClear":true,"placeholder":{"id":"","text":"父级菜单"}});
$('.icon').iconpicker({placement:'bottomLeft'});
</script>

