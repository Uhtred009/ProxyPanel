@extends('admin.layouts')

@section('css')
@endsection
@section('title', '控制面板')
@section('content')
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE BREADCRUMB -->
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{{url('admin/applyList')}}">提现管理</a>
                <i class="fa fa-circle"></i>
            </li>
        </ul>
        <!-- END PAGE BREADCRUMB -->
        <!-- BEGIN PAGE BASE CONTENT -->
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <span class="caption-subject font-dark bold uppercase">提现申请详情</span>
                        </div>
                        <div class="actions">
                            @if($info->status == -1)
                                <span class="label label-default label-danger"> 已驳回 </span>
                            @elseif($info->status == 2)
                                <span class="label label-default label-success"> 已打款 </span>
                            @else
                                <div class="btn-group">
                                    <a class="btn btn-sm blue dropdown-toggle" href="javascript:;" data-toggle="dropdown"> 审核
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        @if($info->status == 0)
                                        <li>
                                            <a href="javascript:setStatus('1');"> <i class="fa fa-check"></i> 审核通过 </a>
                                        </li>
                                        <li>
                                            <a href="javascript:setStatus('-1');"> <i class="fa fa-remove"></i> 驳回 </a>
                                        </li>
                                        @endif
                                        @if($info->status == 1)
                                        <li>
                                            <a href="javascript:setStatus('2');"> <i class="fa fa-circle-o"></i> 已打款 </a>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-scrollable">
                            <table class="table table-striped table-bordered table-hover table-checkable order-column">
                                <thead>
                                    <tr class="uppercase">
                                        <th colspan="6">ID：{{$info->id}} | 申请人：{{$info->user->username}} | 提现金额：{{$info->amount}} | 申请时间：{{$info->created_at}}</th>
                                    </tr>
                                    <tr class="uppercase">
                                        <th> ID </th>
                                        <th> 发生人 </th>
                                        <th> 发生订单 </th>
                                        <th> 发生金额 </th>
                                        <th> 返利金额 </th>
                                        <th> 发生时间 </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($list->isEmpty())
                                        <tr>
                                            <td colspan="6" style="text-align: center;">暂无数据</td>
                                        </tr>
                                    @else
                                        @foreach($list as $vo)
                                            <tr>
                                                <td> {{$vo->id}} </td>
                                                <td> {{$vo->user->username}} </td>
                                                <td> {{$vo->order_id}} - </td>
                                                <td> {{$vo->amount}} </td>
                                                <td> {{$vo->ref_amount}} </td>
                                                <td> {{$vo->created_at}} </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-4">
                                <div class="dataTables_info" role="status" aria-live="polite">共 {{$list->total()}} 个申请</div>
                            </div>
                            <div class="col-md-8 col-sm-8">
                                <div class="dataTables_paginate paging_bootstrap_full_number pull-right">
                                    {{ $list->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE BASE CONTENT -->
    </div>
    <!-- END CONTENT BODY -->
@endsection
@section('script')
    <script src="/assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>

    <script type="text/javascript">
        // 更改状态
        function setStatus(status) {
            $.post("{{url('admin/setApplyStatus')}}", {_token:'{{csrf_token()}}', id:'{{$info->id}}', status:status}, function(ret){
                bootbox.alert(ret.message, function () {
                    window.location.reload();
                });
            });
        }
    </script>
@endsection