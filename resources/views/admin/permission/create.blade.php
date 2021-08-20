<div class="box box-info">
    <div class="row">
        <h3 class="col-sm-6 box-title">创建</h3>
        <div class="col-sm-6 text-right">
            {!! $tools !!}
        </div>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form action="{!! route('admin.auth.permissions.index') !!}" method="post" accept-charset="UTF-8" class="form-horizontal" pjax-container=""> 

    <div class="card-body row">
        <div class="col-sm-2  control-label"></div>
        <div class="col-sm-8">                

            <div class="input-group mb-3">
                <label for="name" class="col-sm-2 asterisk control-label">名称</label>
                <div class="iinput-group-prepend">
                    <span class="input-group-text"><i class="fas fa-edit"></i></span>                            
                 </div>                        
                 <input type="text" id="name" name="name" value="" class="form-control name" placeholder="输入 名称">                            
            </div>

            <div class="input-group mb-3">
                <label for="username" class="col-sm-2 asterisk control-label">标识</label>
                <div class="iinput-group-prepend">
                    <span class="input-group-text"><i class="fas fa-edit"></i></span>            
                </div>        
                <input type="text" id="slug" name="slug" value="" class="form-control slug" placeholder="输入 标识">            
            </div>
            
            <div class="input-group mb-3">
                <label for="http_method" class="col-sm-2 control-label">HTTP方法</label>
                <div class="col-sm-10">
                    <select class="form-control http_method" style="width: 100%;" name="http_method[]" multiple="multiple" data-placeholder="HTTP方法" aria-hidden = "true" >
                        @foreach($methods as $select => $option)
                            <option value="{{$select}}" >{{$option}}</option>
                        @endforeach
                    </select>
                    <span class="help-block">
                        <i class="fa fa-info-circle"></i>&nbsp;为空默认为所有方法
                    </span>
                </div>
            </div>

            <div class="input-group mb-3">
                <label for="permissions" class="col-sm-2 control-label">HTTP路径</label>
                <div class="col-sm-8">        
                    <textarea name="http_path" class="form-control http_path" rows="5" placeholder="输入 HTTP路径"></textarea>        
                </div>
            </div>


        </div>            
    </div>
    <!-- /.box-body -->

    @include('admin::formFooter')

<!-- /.box-footer -->
    </form>
</div>
<script>
$(".http_method").select2({
    placeholder: "选择HTTP方法",
    allowClear: true
});
</script>

