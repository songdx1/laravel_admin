<script src="/vendor/laravel-admin/AdminLTE/plugins/select2/select2.full.min.js"></script>
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">编辑</h3>

        <div class="box-tools">
            {!! $tools !!}
        </div>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form action="{!! route('admin.auth.permissions.update',$model) !!}" method="post" accept-charset="UTF-8" class="form-horizontal" pjax-container="">  

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
                    <label for="name" class="col-sm-2 asterisk control-label">名称</label>
                    <div class="col-sm-8">                        
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>                            
                            <input type="text" id="name" name="name" value="{{ $model->name }}" class="form-control name" placeholder="输入 名称">                            
                        </div>                        
                    </div>
                </div>

                <div class="form-group  ">
                    <label for="username" class="col-sm-2 asterisk control-label">标识</label>
                    <div class="col-sm-8">        
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>            
                            <input type="text" id="slug" name="slug" value="{{ $model->slug }}" class="form-control slug" placeholder="输入 标识">            
                        </div>        
                    </div>
                </div>
                
                @php
                    if($model->http_method)
                    {
                        $http_methods = explode($model->http_method);
                    }else{
                        $http_methods = [];
                    }
                @endphp
                <div class="form-group">
                    <label for="http_method" class="col-sm-2 control-label">HTTP方法</label>
                    <div class="col-sm-8">
                        <select class="form-control http_method" style="width: 100%;" name="http_method[]" multiple="multiple" data-placeholder="HTTP方法" aria-hidden = "true" >
                            @foreach($methods as $select => $option)
                                <option value="{{$select}}" {{  in_array($select, $http_methods ) ?'selected':'' }}>{{$option}}</option>
                            @endforeach
                        </select>
                        <span class="help-block">
                            <i class="fa fa-info-circle"></i>&nbsp;为空默认为所有方法
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="permissions" class="col-sm-2 control-label">HTTP路径</label>
                    <div class="col-sm-8">        
                        <textarea name="http_path" class="form-control http_path" rows="5" placeholder="输入 HTTP路径">{{ $model->http_path }}</textarea>        
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
$(".http_method").select2({"allowClear":true,"placeholder":{"id":"","text":"权限"}});
</script>

