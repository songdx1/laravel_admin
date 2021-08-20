<script src="/vendor/laravel-admin/bootstrap-duallistbox/dist/jquery.bootstrap-duallistbox.min.js"></script>
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">创建</h3>

        <div class="box-tools">
            {!! $tools !!}
        </div>
    </div>
    <!-- /.box-header -->
    <!-- form start -->  
    <form action="{!! route('admin.auth.roles.index') !!}" method="post" accept-charset="UTF-8" class="form-horizontal" pjax-container="">

    <div class="card-body row">
        <div class="col-sm-2  control-label"></div>
        <div class="col-sm-8">               

            <div class="input-group mb-3">
                <label for="name" class="col-sm-2 asterisk control-label">名称</label>
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-edit"></i></span>                             
                </div>                        
                <input type="text" id="name" name="name" value="" class="form-control name" placeholder="输入 名称">                            
            </div>

            <div class="input-group mb-3">
                <label for="username" class="col-sm-2 asterisk control-label">标识</label>
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-edit"></i></span>            
                </div>        
                <input type="text" id="slug" name="slug" value="" class="form-control slug" placeholder="输入 标识">            
            </div>
            
            <div class="input-group mb-3">
                <label for="permissions" class="col-sm-2 control-label">权限</label>
                <div class="col-sm-10">
                    <select class="form-control permissions" name="permissions[]" multiple="multiple" data-placeholder="输入 权限" data-value >
                        @foreach($permissions as $select => $option)
                            <option value="{{$select}}">{{$option}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>            
    </div>
    <!-- /.box-body -->

    @include('admin::createFormFooter')

<!-- /.box-footer -->
    </form>
</div>
<script>
$(".permissions").select2({
    placeholder: "选择权限",
    allowClear: true
});
</script>

