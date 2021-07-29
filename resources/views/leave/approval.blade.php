@extends ('layouts.app-auth')
@section('content')

<div class="wrapper wrapper-content">
    <div class="col-sm-8">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">LEAVE APPROVAL</h3>
            </div>
            <div class="panel-body">
                {{ Form::open(array('action' => ['LeaveController@approval', $all_l->id], 'method' => 'POST'))}}
                    <div class="form-group row">
                        {{ Form::label('leave type', 'LEAVE TYPE :',['class' => 'col-sm-3 col-form-label']) }}   
                        <div class="col-sm-8">
                            {{ Form::text('leaveType', $all_l->leave_type,['class' => 'form-control','placeholder' =>'DATE FROM', 'required' => 'required','readonly']) }}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{ Form::label('date from', 'DATE FROM :',['class' => 'col-sm-3 col-form-label']) }}   
                        <div class="col-sm-8">
                            {{ Form::text('dateFrom', $all_l->start_date, ['class' => 'form-control','placeholder' =>'DATE FROM', 'required' => 'required','readonly']) }}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{ Form::label('discription', 'DISCRIPTION :',['class' => 'col-sm-3 col-form-label']) }}   
                        <div class="col-sm-8">
                            {{ Form::textarea('description', $all_l->leave_description, ['class' => 'form-control','placeholder' =>'DISCRIPTION', 'row' => '4', 'cols' => '30', 'required' => 'required','readonly']) }}
                        </div>
                    </div>
                    @if (Auth::user()->user_access_id == '2' or Auth::user()->user_access_id == '5')
                        <div class="form-group row">
                            {{ Form::label('hodRemark', 'HOD REMARK :',['class' => 'col-sm-3 col-form-label']) }}   
                            <div class="col-sm-8">
                                {{ Form::textarea('hodRemark', $all_l->hod_remark, ['class' => 'form-control','placeholder' =>'ADMIN REMARK', 'row' => '4', 'cols' => '30', 'required' => 'required','readonly']) }}
                            </div>
                        </div>
                    @endif
                    @if (in_array(Auth::user()->user_access_id, array('3','4','5')))
                        <div class="form-group row">
                            {{ Form::label('provostRemark', 'PROVOST REMARK :',['class' => 'col-sm-3 col-form-label']) }}   
                            <div class="col-sm-8">
                                {{ Form::textarea('provostRemark', $all_l->provost_remark, ['class' => 'form-control','placeholder' =>'PROVOST REMARK', 'row' => '4', 'cols' => '30', 'required' => 'required','readonly']) }}
                            </div>
                        </div>
                    @endif
                    <div style="text-align:center;">
                        @if (Auth::user()->user_access_id == '2' or Auth::user()->user_access_id == '5')
                            @if ($all_l->application_status == 'Applied')
                                {{ Form::submit('HOD APPROVE', array('name' => 'submitButton','class'=>'btn btn-sm btn-primary m-t-n-xs')) }} |
                                {{ Form::submit('HOD DECLINE', array('name' => 'submitButton','class'=>'btn btn-sm btn-primary m-t-n-xs')) }}
                            @elseif (in_array($all_l->application_status, array('HOD has approved','PROVOST has approved')))
                                {{"APPROVED"}}
                            @elseif ($all_l->application_status == 'HOD has declined')
                                {{"DECLINED"}}
                            @endif
                        @endif
                        @if (Auth::user()->user_access_id == '3')
                            <div class="form-group row">
                                {{ Form::label('provostRemark', 'PROVOST REMARK :',['class' => 'col-sm-3 col-form-label']) }}   
                                <div class="col-sm-8">
                                    {{ Form::textarea('provostRemark', $all_l->provost_remark, ['class' => 'form-control','placeholder' =>'PROVOST REMARK', 'row' => '4', 'cols' => '30', 'required' => 'required']) }}
                                </div>
                            </div>
                        @endif
                        <br>
                        @if (Auth::user()->user_access_id == '3' or Auth::user()->user_access_id == '5')
                            @if ($all_l->application_status == 'HOD has Approved')
                                {{"HOD HAS APPROVED"}}<br><br>
                                {{ Form::submit('PROVOST APPROVE', array('name' => 'submitButton','class'=>'btn btn-sm btn-primary m-t-n-xs')) }} |
                                {{ Form::submit('PROVOST DECLINE', array('name' => 'submitButton','class'=>'btn btn-sm btn-primary m-t-n-xs')) }}
                            @elseif ($all_l->application_status == 'PROVOST has approved')
                                {{"APPROVED"}}
                            @elseif ($all_l->application_status == 'PROVOST has declined')
                                {{"DECLINED"}}
                            @elseif ($all_l->application_status == 'Applied')
                                {{ "Awiating HOD's approval" }}
                            @endif
                        @endif
                        <br>
                        @if (Auth::user()->user_access_id == '4' or Auth::user()->user_access_id == '5')
                            @if ($all_l->application_status == 'PROVOST has approved')
                                {{"PROVOST HAS APPROVED"}}<br><br>
                                {{ Form::submit('REGISTRY APPROVE', array('name' => 'submitButton','class'=>'btn btn-sm btn-primary m-t-n-xs')) }} |
                                {{ Form::submit('REGISTRY DECLINE', array('name' => 'submitButton','class'=>'btn btn-sm btn-primary m-t-n-xs')) }}
                            @elseif ($all_l->application_status == 'REGISTRY has approved')
                                {{"APPROVED"}}
                            @elseif ($all_l->application_status == 'REGISTRY has declined')
                                {{"DECLINED"}}
                            @elseif ($all_l->application_status == 'HOD has approved')
                                {{ "Awiating PROVOST approval" }}
                            @elseif ($all_l->application_status == 'Applied')
                                {{ "Awiating HOD's approval" }}
                            @endif
                        @endif
                        <br>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

<!-- Mainly scripts -->
<script src="js/jquery-2.1.1.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<script src="js/plugins/dataTables/datatables.min.js"></script>
<script src="js/plugins/footable/footable.all.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="js/inspinia.js"></script>
<script src="js/plugins/pace/pace.min.js"></script>

<script>
        $(document).ready(function(){
            $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'ExampleFile'},
                    {extend: 'pdf', title: 'ExampleFile'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });

        });

    </script>
@endsection