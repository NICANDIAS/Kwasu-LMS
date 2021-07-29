@extends ('layouts.app-auth')
@section('content')

<div class="wrapper wrapper-content">
    <div class="col-sm-2">
    </div>
    <div class="col-sm-8">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title" style="text-align: center">LEAVE APPLICATION</h3>
            </div>
            <div class="panel-body">
                {{ Form::open(array('action' => 'LeaveController@index', 'method' => 'POST'))}}
                    <div class="form-group row">
                        {{ Form::label('leave type', 'LEAVE TYPE :',['class' => 'col-sm-3 col-form-label']) }}   
                        <div class="col-sm-8">
                            {{-- @foreach($leave_t as $leaveType) --}}
                            {{ Form::select('leaveType',['Select Leave Type'] + $leave_t->all(),'',['class' => 'form-control m-b']) }}
                            {{-- @endforeach --}}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{ Form::label('date from', 'DATE FROM :',['class' => 'col-sm-3 col-form-label']) }}   
                        <div class="col-sm-8">
                            {{ Form::date('dateFrom', '', ['class' => 'form-control','placeholder' =>'DATE FROM', 'required' => 'required']) }}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{ Form::label('discription', 'DISCRIPTION :',['class' => 'col-sm-3 col-form-label']) }}   
                        <div class="col-sm-8">
                            {{ Form::textarea('description', '', ['class' => 'form-control','placeholder' =>'DISCRIPTION', 'row' => '4', 'cols' => '30', 'required' => 'required']) }}
                        </div>
                    </div>
                    <div style="text-align:center;">
                        {{ Form::submit('APPLY', ['class'=>'btn btn-sm btn-primary m-t-n-xs']) }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
    {{-- <div class="col-sm-4">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">LEAVE DAYS</h3>
            </div>
            <div class="panel-body">
                <div class="form-group row"> 
                    <div class="col-sm-4"><span style="font-size:80px;">30Days</span></div>
                </div>
            </div>
        </div>
    </div> --}}
    @if(count($all_l) > 0)
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title" style="text-align:center;">APPLIED LEAVE</h3>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Leave Type</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Leave Days</th>
                                    <th>Discription</th>
                                    <th>Posting Date</th>
                                    <th>Hod Remark</th>
                                    <th>Provost Remark</th>
                                    <th>Registry Remark</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                    <th>Print</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $s = 1 ?>
                                @foreach($all_l as $allLeave)
                                <tr>
                                    <td>{{$s++}}</td>
                                    <td>{{$allLeave->leave_type}}</td>
                                    <td>{{$allLeave->start_date}}</td>
                                    <td>{{$allLeave->end_date}}</td>
                                    <td>{{$allLeave->leave_days}}</td>
                                    <td>{{$allLeave->leave_description}}</td>
                                    <td>{{$allLeave->posting_date}}<br>10:28</td>
                                    <td>{{$allLeave->hod_remark}}</td>
                                    <td>{{$allLeave->provost_remark}}</td>
                                    <td>{{$allLeave->registry_remark}}</td>                          
                                    <td>{{$allLeave->application_status}}</td>
                                    @if($allLeave->application_status != 'Applied') 
                                        <td>{{"Cant be Edited"}}</td>
                                    @else 
                                        <td><a class="btn btn-primary" onclick="return confirm('Are you sure you want to update?')" href="editApplication/{{$allLeave->id}}">Edit</a> | <a class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this leave application?')" href="application/{{$allLeave->id}}">Delete</a></td>
                                    @endif 
                                    <td><a class="btn btn-primary" href="#">Print</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>S/N</th>
                                    <th>Leave Type</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Leave Days</th>
                                    <th>Discription</th>
                                    <th>Posting Date</th>
                                    <th>Hod Remark</th>
                                    <th>Provost Remark</th>
                                    <th>Registry Remark</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                    <th>Print</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
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
    <script type="text/javascript">
        $(document).ready(function () {
           $('#leaveType').change(function () {
             var id = $(this).val();

             $('#leaveDays').find('option').not(':first').remove();

             $.ajax({
                url:'leaveType/'+id,
                type:'get',
                dataType:'json',
                success:function (response) {
                    var len = 0;
                    if (response.leaveDays != null) {
                        len = response.leaveDays.length;
                    }

                    if (len>0) {
                        for (var i = 0; i<len; i++) {
                             var id = response.leaveDays[i].id;
                             var leave_days = response.leaveDays[i].leave_days;

                             var option = "<option value='"+id+"'>"+leave_days+"</option>"; 

                             $("#leaveDays").append(option);
                        }
                    }
                }
             })
           });
        });
    </script>
@endsection