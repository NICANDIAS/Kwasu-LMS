@extends ('layouts.app')
@section('content')

<div class="wrapper wrapper-content">
    <div class="col-lg-8">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">ADD LEAVE DEPARTMENT</h3>
            </div>
            <div class="panel-body">
                {{ Form::open(array('action' => ['LeavesController@editLeaveDepartment', $leave_d->id], 'method' => 'POST'))}}
                    <div class="form-group row">
                        {{ Form::label('Department Name', 'Department Name :',['class' => 'col-sm-3 col-form-label']) }}   
                        <div class="col-sm-8">
                            {{ Form::text('departmentName', $leave_d->department_name, ['class' => 'form-control','placeholder' =>'Department Name']) }}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{ Form::label('Departmrnt Short Name', 'Department Short Code :',['class' => 'col-sm-3 col-form-label']) }}   
                        <div class="col-sm-8">
                            {{ Form::text('departmentShortName', $leave_d->department_short_code, ['class' => 'form-control','placeholder' =>'Department Short Code']) }}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{ Form::label('Department Code', 'Department Code :',['class' => 'col-sm-3 col-form-label']) }}   
                        <div class="col-sm-8">
                            {{ Form::text('departmentCode', $leave_d->department_code, ['class' => 'form-control','placeholder' =>'Department Code']) }}
                        </div>
                    </div>
                    <div style="text-align:center;">
                        {{ Form::submit('SAVE', ['class'=>'btn btn-sm btn-primary m-t-n-xs']) }}
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