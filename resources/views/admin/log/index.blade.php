<div class="box">
    @if(isset($title))
    <div class="box-header with-border">
        <h3 class="box-title"> {{ $title }}</h3>
    </div>
    @endif

    @if ( $grid->showTools() || $grid->showExportBtn() || $grid->showCreateBtn() )
    <div class="box-header with-border">
        <div class="pull-right">
            {!! $grid->renderColumnSelector() !!}
            {!! $grid->renderExportButton() !!}
            {!! $grid->renderCreateButton() !!}
        </div>
        @if ( $grid->showTools() )
        <div class="pull-left">
            {!! $grid->renderHeaderTools() !!}
        </div>
        @endif
    </div>
    @endif

    {!! $grid->renderFilter() !!}

    {!! $grid->renderHeader() !!}

    <!-- /.box-header -->
    <div class="box-body table-responsive no-padding">
        <table class="table table-hover" id="{{ $grid->tableID }}">
            <thead>
                <tr>
                    <th class="column-__row_selector__">
                        <div class="icheckbox_minimal-blue" aria-checked="false" aria-disabled="false" style="position: relative;">
                            <input type="checkbox" class="grid-select-all">
                        </div>
                    </th>
                    <th class="column-id">ID</th>
                    <th class="column-user-name">用户</th>
                    <th class="column-method">请求动作</th>
                    <th class="column-path">请求路径</th>
                    <th class="column-ip">Ip</th>
                    <th class="column-input">输入</th>
                    <th class="column-created_at">创建时间</th>
                    <th class="column-__actions__">操作</th>
                </tr>
            </thead>

            <tbody>

                @foreach($lists as $row)
                <tr>
                    <td class="column-__row_selector__">
                        <div class="icheckbox_minimal-blue" aria-checked="false" aria-disabled="false" style="position: relative;">
                            <input type="checkbox" class="grid-row-checkbox" data-id="{{ $row->id }}">                            
                        </div>
                    </td>
                    <td>
                        {{ $row->id }}
                    </td>
                    <td>
                        {{ $row->user->name }}
                    </td>
                    <td>
                        @php
                        $color = Arr::get($methodColors, $row->method, 'grey');
                        @endphp
                        <span class="badge bg-{!!$color!!}">{{ $row->method }}</span>
                    </td>
                    <td>
                        <span class="label label-info">{{ $row->path }}</span>
                    </td>
                    <td>
                        <span class="label label-primary">{{ $row->ip }}</span>
                    </td>
                    <td>
                        @php
                        $input = json_decode($row->input, true);
                        $input = Arr::except($input, ['_pjax', '_token', '_method', '_previous_']);
                        if (empty($input)) {
                            $input = '<code>{}</code>';
                        }else{
                            $input = '<pre>'.json_encode($input, JSON_PRETTY_PRINT | JSON_HEX_TAG).'</pre>';
                        }
                        @endphp
                        {!! $input !!}
                    </td>
                    <td>
                        {{ $row->created_at }}
                    </td>
                    <td class="column-__actions__">
                        <a href="javascript:void(0);" data-id="{{ $row->id }}" class="grid-row-delete">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>

    </div>

    <div class="box-footer clearfix">
        @include('admin::paginator')
    </div>
    
    <!-- /.box-body -->
</div>
<script>
    $('.grid-row-delete').unbind('click').click(function() {

        var id = $(this).data('id');

        swal({
            title: "确认删除?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "确认",
            showLoaderOnConfirm: true,
            cancelButtonText: "取消",
            preConfirm: function() {
                return new Promise(function(resolve) {
                    $.ajax({
                        method: 'post',
                        url: '{!! route('admin.auth.logs.index') !!}/' + id,
                        data: {
                            _method:'delete',
                            _token:LA.token,
                        },
                        success: function (data) {
                            $.pjax.reload('#pjax-container');

                            resolve(data);
                        }
                    });
                });
            }
        }).then(function(result) {
            var data = result.value;
            if (typeof data === 'object') {
                if (data.status) {
                    swal(data.message, '', 'success');
                } else {
                    swal(data.message, '', 'error');
                }
            }
        });
    });
</script>
