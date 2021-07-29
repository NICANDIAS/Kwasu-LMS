@extends ('layouts.app-auth')
@section('content')

<div class="wrapper wrapper-content">
    <div class="col-lg-8">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title" style="text-align: center">ADD FACULTY</h3>
            </div>
            <div class="panel-body">
                {{ Form::open(array('action' => 'FacultyController@create', 'method' => 'POST'))}}
                    <div class="form-group row">
                        {{ Form::label('faculty', 'Faculty Name :',['class' => 'col-sm-3 col-form-label']) }}   
                        <div class="col-sm-8">
                            {{ Form::text('faculty', '', ['class' => 'form-control','placeholder' =>'Faculty Name']) }}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{ Form::label('facultyShortCode', 'Faculty Short Code :',['class' => 'col-sm-3 col-form-label']) }}   
                        <div class="col-sm-8">
                            {{ Form::text('facultyShortCode', '', ['class' => 'form-control','placeholder' =>'Faculty Short Code']) }}
                        </div>
                    </div>
                    <div style="text-align:center;">
                        {{ Form::submit('ADD FACULTY', ['class'=>'btn btn-sm btn-primary m-t-n-xs']) }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
    @if(count($faculty) > 0)
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h5 class="panel-title" style="text-align: center">LEAVE FACULTY</h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>DEPARTMENT NAME</th>
                                    <th>FACULTY SHORT NAME</th>
                                    <th>CREATED DATE</th>
                                    <th>UPDATED DATE</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            @foreach ($faculty as $faculty)
                                <tbody>
                                    <tr>
                                        <td>{{$faculty->id}}</td>
                                        <td>{{$faculty->faculty}}</td>
                                        <td>{{$faculty->faculty_short_code}}</td>
                                        <td>{{$faculty->created_at}}</td>
                                        <td>{{$faculty->updated_at}}</td>
                                        <td><a class="btn btn-primary" href="editLeaveDepartment/{{$faculty->id}}/edit">Edit</a> | <a class="btn btn-danger" href="deleteLeaveDepartment/{{$faculty->id}}/delete">Delete</a></td>
                                    </tr>
                                </tbody>
                            @endforeach
                            <tfoot>
                                <tr>
                                    <th>S/N</th>
                                    <th>DEPARTMENT NAME</th>
                                    <th>FACULTY SHORT NAME</th>
                                    <th>CREATED DATE</th>
                                    <th>UPDATED DATE</th>
                                    <th>ACTION</th>
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
@endsection