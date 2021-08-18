<link rel="stylesheet" href="/vendor/bootstrap-iconpicker/dist/css/bootstrap-iconpicker.min.css">
<script src="/vendor/bootstrap-iconpicker/dist/js/bootstrap-iconpicker.bundle.min.js"></script>
<script src="/vendor/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">编辑</h3>

        <div class="box-tools float-right">
            {!! $tools !!}
        </div>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form action="{!! route('admin.auth.menu.update',$model) !!}" method="post" accept-charset="UTF-8" class="form-horizontal" pjax-container="">    

    <div class="box-body">
        <div class="fields-group">
            <div class="col-md-12">

                <div class="input-group">
                    <label class="col-sm-2 control-label"> ID</label>
                    <div class="box-body">
                        {{ $model->id }}
                    </div>   
                </div> 

                <div class="input-group ">
                    <label for="parent_id" class="col-sm-2 control-label">父级菜单</label>
                    <select class="form-control" name="parent_id" data-value="" tabindex="-1" aria-hidden="true">
                        @foreach($menuOptions as $select => $option)
                            <option value="{{$select}}" {{  $select == $model->parent_id ?'selected':'' }} >{{$option}}</option>
                        @endforeach
                    </select>                 
                </div>  

                <div class="input-group">
                    <label class="col-sm-2 control-label"> 标题</label>
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-edit"></i></span>
                    </div>
                    <input type="text" class="form-control"  id="title" name="title" value="{{ $model->title }}" class="form-control name" placeholder="输入 标题">        
                </div> 

                <div class="input-group">
                    <label class="col-sm-2 control-label"> 路径</label>
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-edit"></i></span>
                    </div>
                    <input type="text" class="form-control"  id="uri" name="uri" value="{{ $model->uri }}" class="form-control uri" placeholder="输入 路径">         
                </div>

                <div class="input-group">
                    <label for="roles" class="col-sm-2 control-label">角色</label>
                    <select class="form-control" name="roles[]" multiple data-placeholder="选择角色" aria-hidden = "true" >
                        @foreach($roles as $select => $option)
                        <option value="{{$select}}" {{  in_array($select, $model->roles()->pluck('id')->toArray() ) ?'selected':'' }}>{{$option}}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group  ">
                    <label for="icon" class="col-sm-2 control-label">图标</label>
                    <div class="col-sm-8">        
                        <div id="convert_example_1" name="icon" data-icon="{{ $model->icon }}" ></div>
                    </div>
                </div>

                <div class="input-group">
                    <label class="col-sm-2 control-label"> 创建时间</label>
                    <div class="box-body">
                        {{ $model->created_at }}
                    </div>         
                </div>
                <div class="input-group">
                    <label class="col-sm-2 control-label"> 更新时间</label>
                    <div class="box-body">
                        {{ $model->updated_at }}
                    </div>         
                </div>

            </div>            
        </div>
    </div>
    <!-- /.box-body -->

    <div class="card-foote row">
        @csrf
        @method('PUT')
        <div class="col-md-8">
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary">提交</button>
            <button type="reset" class="btn btn-warning">重置</button>
        </div>
    </div>

<!-- /.box-footer -->
    </form>
</div>

<script>
$('#convert_example_1').iconpicker({
    cols: 20,
    rows: 6,
});
</script>