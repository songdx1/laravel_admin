<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">详细</h3>

        <div class="box-tools">
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
                    <label class="col-sm-2 control-label">用户名</label>
                    <div class="col-sm-8">
                        <div class="box box-solid box-default no-margin box-show">
                            <div class="box-body">
                                {{ $model->username }}
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
                    <label class="col-sm-2 control-label">头像</label>
                    <div class="col-sm-8">
                        @if($model->avatar) 
                            <img src="{{ $model->avatar }}" style="width:100px;">
                        @endif
                    </div>
                </div>
                <div class="input-group mb-3">
                    <label class="col-sm-2 control-label">角色</label>
                    <div class="col-sm-8">
                        <div class="box box-solid box-default no-margin box-show">
                            <div class="box-body">
                            @foreach ($model->roles as $role)
                                <span class='label label-success'>{{$role->name}}</span>
                            @endforeach
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
                                <span class='label label-success'>{{$permission->name}}</span>
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