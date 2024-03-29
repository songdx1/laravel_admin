<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">编辑</h3>

        <div class="text-right">
            {!! $tools !!}
        </div>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form action="{!! route('admin.auth.permissions.update',$model) !!}" method="post" accept-charset="UTF-8" class="form-horizontal" pjax-container="">  

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
                <div class="iinput-group-prepend">
                    <span class="input-group-text"><i class="fas fa-edit"></i></span>                            
                </div>                        
                <input type="text" id="name" name="name" value="{{ $model->name }}" class="form-control name" placeholder="输入 名称">                            
            </div>

            <div class="input-group mb-3 ">
                <label for="username" class="col-sm-2 asterisk control-label">标识</label>
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-edit"></i></span>      
                </div>        
                <input type="text" id="slug" name="slug" value="{{ $model->slug }}" class="form-control slug" placeholder="输入 标识">            
            </div>
            
            <div class="input-group mb-3">
                <label for="http_method" class="col-sm-2 control-label">HTTP方法</label>
                <div class="input-group-prepend col-sm-10">
                    <select multiple class="form-control http_method" name="http_method[]">
                        @foreach($methods as $select => $option)
                            <option value="{{$select}}" {{  in_array($select, $model->http_method??[] ) ?'selected':'' }}>{{$option}}</option>
                        @endforeach
                    </select>
                    <span class="help-block">
                        <i class="fa fa-info-circle"></i>为空默认为所有方法
                    </span>
                </div>
            </div>

            <div class="input-group mb-3">
                <label for="permissions" class="col-sm-2 control-label">HTTP路径</label>
                <div class="col-sm-8">        
                    <textarea name="http_path" class="form-control http_path" rows="5" placeholder="输入 HTTP路径">{{ $model->http_path }}</textarea>        
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
$(".http_method").select2({
    placeholder: "选择HTTP方法",
    allowClear: true
});
</script>

