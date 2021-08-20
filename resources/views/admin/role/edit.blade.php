<link rel="stylesheet" href="/vendor/admin-lte/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
<script src="/vendor/admin-lte/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">编辑</h3>

        <div class="text-right">
            {!! $tools !!}
        </div>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form action="{!! route('admin.auth.roles.update',$model) !!}" method="post" accept-charset="UTF-8" class="form-horizontal" pjax-container="">  

    <div class="card-body row">
        <div class="col-sm-2  control-label"></div>
        <div class="col-sm-8">

            <div class="input-group mb-3">
                <label class="col-sm-2 control-label">ID</label>
                <div class="box-body">
                    {{ $model->id }}
                </div>
            </div>

            <div class="input-group mb-3">
                <label for="name" class="col-sm-2 asterisk control-label">名称</label>
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-edit"></i></span>                            
                </div>       
                <input type="text" id="name" name="name" value="{{ $model->name }}" class="form-control name" placeholder="输入 名称">                            
            </div>

            <div class="input-group mb-3">
                <label for="username" class="col-sm-2 asterisk control-label">标识</label>
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-edit"></i></span>           
                </div>        
                <input type="text" id="slug" name="slug" value="{{ $model->slug }}" class="form-control slug" placeholder="输入 标识">            
            </div>
            
            <div class="input-group mb-3">
                <label for="permissions" class="col-sm-2 control-label">权限</label>
                <div class="col-sm-10">
                    <select class="form-control permissions" style="width: 100%;" name="permissions[]" multiple="multiple" data-placeholder="输入 权限" data-value >
                        @foreach($permissions as $select => $option)
                            <option value="{{$select}}" {{  in_array($select, $model->permissions()->pluck('id')->toArray() ) ?'selected':'' }}>{{$option}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="input-group mb-3">
                <label class="col-sm-2 control-label">创建时间</label>
                <div class="input-group-prepend">
                    {{ $model->created_at }}
                </div>
            </div>
            <div class="input-group mb-3">
                <label class="col-sm-2 control-label">更新时间</label>               
                <div class="input-group-prepend">
                    {{ $model->updated_at }}
                </div>
            </div>
            @method('PUT')
        </div>            
    </div>
    <!-- /.box-body -->

    @include('admin::formFooter')

<!-- /.box-footer -->
    </form>
</div>
<script>
$(".permissions").bootstrapDualListbox({
    "infoText":"总共 {0} 项",
    "infoTextEmpty":"空列表",
    "infoTextFiltered":"{0} / {1}",
    "filterTextClear":"显示全部",
    "filterPlaceHolder":"过滤",
    "selectorMinimalHeight":200
});
</script>

