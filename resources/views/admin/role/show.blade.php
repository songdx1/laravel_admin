<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">详细</h3>

        <div class="text-right">
            {!! $tools !!}
        </div>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <div class="form-horizontal">

    <div class="card-body row">
        <div class="col-sm-2  control-label"></div>
        <div class="col-sm-8">

            <div class="input-group mb-3">
                <label class="col-sm-2 control-label">ID</label>
                <div class="col-sm-8">
                    <div class="box box-solid box-default no-margin box-show">
                        <div class="box-body">
                            {{ $model->id }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <label class="col-sm-2 control-label">标识</label>
                <div class="col-sm-8">
                    <div class="box box-solid box-default no-margin box-show">
                        <div class="box-body">
                            {{ $model->slug }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <label class="col-sm-2 control-label">名称</label>
                <div class="col-sm-8">
                    <div class="box box-solid box-default no-margin box-show">
                        <div class="box-body">
                            {{ $model->name }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <label class="col-sm-2 control-label">权限</label>
                <div class="col-sm-8">
                    <div class="box box-solid box-default no-margin box-show">
                        <div class="box-body">
                        @foreach ($model->permissions as $permission)
                            <span class='btn btn-default'>{{$permission->name}}</span>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <label class="col-sm-2 control-label">创建时间</label>
                <div class="col-sm-8">
                    <div class="box box-solid box-default no-margin box-show">
                        <div class="box-body">
                            {{ $model->created_at }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
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
        <!-- /.box-body -->
    </div>
</div>