@extends('layouts.app')

@section('content')
    <div class="container">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Event Management</h1>
                    </div>

                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif


                                <h3 class="card-title">Event </h3>
                                <button id="btnadd_event" type="button" data-toggle="modal" data-target="#AddEvent" class="btn btn-dark btn-md float-right">Add Event</button>
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">

                                <table id="eventdatatable" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>Event Title</th>
                                        <th>Dates</th>
                                        <th>Occurrence</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>

                                    <tfoot>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        
                                    </tr>
                                    </tfoot>

                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->


                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->

            <!-- Add Model -->
            <div class="modal fade" id="AddEvent">
                <div class="modal-dialog modal-lg">
                    <form id="add-edit-Event" method="post">
                        <input type="hidden" name="EventID">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Add Event</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">

                                <div class="form-group">
                                    <label for="inputName">Event Title</label>
                                    <input type="text" id="EventTitle" name="EventTitle" class="form-control">
                                </div>


                                <div class="form-group">
                                    <label for="inputName">Start Date</label>
                                    <input class="date form-control"  type="text" id="StartDate" name="StartDate">

                                </div>

                                <div class="form-group">
                                    <label for="inputName">End Date</label>
                                    <input class="date form-control"  type="text" id="EndDate" name="EndDate">

                                </div>

                                <div class="form-group">

                                    <label for="inputName">Recurrence: </label>
                                    <br>
                                    <div class="form-check form-check-inline">
                                   <input type="radio" name="RepeatType" id="RepeatType0" class="form-check-input" value="repeat" checked> Repeat &nbsp;&nbsp; {{ Form::select('RepeatOrder',['every'=>'Every','everyother'=>'Every Other','everythird'=>'Every Third','everyfourth'=>'Every Fourth'], '', array("class"=>"form-check-input select2 small")) }}
                                     {{ Form::select('RepeatDays',['day'=>'Day','week'=>'Week','month'=>'Month','year'=>'Year'], '', array("class"=>"form-check-input select2 small")) }}
                                    </div>

                                    <br>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="RepeatType1" name="RepeatType" class="form-check-input" value="repeaton"> Repeat on the &nbsp;&nbsp; {{ Form::select('RepeatOrderon',['first'=>'First','second'=>'Second','third'=>'Third','fourth'=>'Fourth'], '', array("class"=>"form-check-input select2 small")) }}
                                        {{ Form::select('RepeatDayson',['sun'=>'sun','mon'=>'mon','tue'=>'tue','wed'=>'wed','thu'=>'thu','fri'=>'fri','sat'=>'sat'], '', array("class"=>"form-check-input select2 small")) }}
                                        {{ Form::select('RepeatMonth',['month'=>'month','3month'=>'3 month','4month'=>'4 month','6month'=>'6 month','year'=>'year'], '', array("class"=>"form-check-input select2 small")) }}

                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                        <!-- /.modal-content -->
                    </form>
                </div>
                <!-- /.modal-dialog -->
            </div>



        </section>
        <!-- /.content -->
    </div>


    </div>

    <script>
        $(function () {
            var data_table;
            var URL = '';
            var list_fields  = ['EventTitle','StartDate','EndDate','Recurrence','EventID','RepeatType','RepeatOrder','RepeatDays','RepeatMonth'];

            //alert($("input[type='search']").val());
            function Event_datatable(){
                data_table =  $('#eventdatatable').DataTable({
                    "bDestroy": true,
                    "bProcessing": true,
                    "bServerSide": true,
                    ajax:{
                        url: baseurl + "/event/ajax_datagrid",

                    },

                    order: [ [0, 'desc'] ],

                    "aoColumns": [
                        {"bSortable": true}, // 1. EventName
                        {  "bSortable": true,
                            mRender: function (id, type, full) {
                                var dates=full[1]+" to "+ full[2];
                                return dates;
                            }


                        },  // 2. Dates
                        {  "bSortable": true,
                            mRender: function (id, type, full) {

                                return full[3];
                            }


                        },  //3. Occurrence
                        {                       //  4. Action
                            "bSortable": false,
                            mRender: function (id, type, full) {

                                var delete_ = "{{ URL::to('event/{id}/delete')}}";
                                delete_  = delete_ .replace( '{id}', full[4] );

                                var view_ = "{{ URL::to('event/{id}/view')}}";
                                view_  = view_ .replace( '{id}', full[4] );


                                action = '<div class = "hiddenRowData" >';
                                for(var i = 0 ; i< list_fields.length; i++){
                                    action += '<input type = "hidden"  name = "' + list_fields[i] + '"       value = "' + (full[i] != null?full[i]:'')+ '" / >';
                                }

                                action += '</div>';

                                action += ' <a href="javascript:void(0);" data-name = "' + full[4] + '" data-id="' + full[4] + '" title="Edit" class="btn-sm edit-event btn-default" data-original-title="Edit" title="" data-placement="top" data-toggle="tooltip"><i class="fas fa-edit"></i>&nbsp;</a>';
                                action += ' <a href="'+view_+'" target="_blank" data-name = "' + full[4] + '" data-id="' + full[4] + '" title="Edit" class="btn-sm view-event btn-default" data-original-title="View" title="" data-placement="top"  data-toggle="tooltip"><i class="fas fa-eye"></i>&nbsp;</a>';

                                action += ' <a href="'+delete_+'" data-redirect="{{ URL::to('event')}}" title="Delete"  class="btn-sm delete-event btn-danger" data-original-title="Delete" title="" data-placement="top" data-toggle="tooltip"><i class="fas fa-trash"></i></a>';

                                return action;
                                //return '';
                            }
                        }
                    ],

                });
            }

            Event_datatable();

            $('.modal').on('hidden.bs.modal', function(){
                $(this).find('form')[0].reset();
            });


            //Add button click
            $('#btnadd_event').click(function (ev) {
                ev.preventDefault();
                console.log("add btn");
                $("#add-edit-Event [name='EventID']").val("");

            });


            $('#add-edit-Event').submit(function(e){
                e.preventDefault();
                var modal = $(this).parents('.modal');
                var formData=new FormData(($('#add-edit-Event')[0]));

                var EventID = $("#add-edit-Event [name='EventID']").val();

                if( typeof EventID != 'undefined' && EventID != ''){
                    URL = baseurl + '/event/'+EventID+'/update';
                }else{
                    URL = baseurl + '/event/add';
                }

                $.ajax({
                    url: URL, //Server script to process data
                    type: 'POST',
                    dataType: 'json',
                    success: function(response){
                        if(response.status == 'success'){
                            modal.modal('hide');
                            data_table.draw();
                            toastr.success(response.message, "Success");
                        }else{

                            toastr.error(response.message, "Error");
                        }
                    },
                    error: function(error) {
                        //toastr.error('Something went wrong.')
                        // alert("Something went wrong");
                    },
                    // Form data
                    data: formData,
                    //Options to tell jQuery not to process data or worry about content-type.
                    cache: false,
                    contentType: false,
                    processData: false
                });


            });



// Edit expense
            $('table tbody').on('click', '.edit-event', function (ev) {
                ev.preventDefault();
                ev.stopPropagation();
                $('#add-edit-Event').trigger("reset");
                var EveType;
                var cur_obj = $(this).prev("div.hiddenRowData");
                for(var i = 0 ; i< list_fields.length; i++){
                    if(list_fields[i]=='StartDate'){
                        $("#add-edit-Event [name='StartDate']").val(cur_obj.find("input[name='"+list_fields[i]+"']").val());
                    }else if(list_fields[i]=='RepeatType'){
                        var Type=cur_obj.find("input[name='"+list_fields[i]+"']").val();
                        EveType =Type;
                        if(Type==0){
                            $("#RepeatType0").prop("checked",true);
                            $("#RepeatType1").prop("checked",false);
                        }else{
                            $("#RepeatType1").prop("checked",true);
                            $("RepeatType0").prop("checked",false);
                        }

                       // $("#add-edit-Event [name='RepeatType']").val(cur_obj.find("input[name='"+list_fields[i]+"']").val()).trigger('change');
                    }else if(list_fields[i]=='RepeatOrder'){
                       if(EveType==0){
                           $("#add-edit-Event [name='RepeatOrder']").val(cur_obj.find("input[name='"+list_fields[i]+"']").val()).trigger('change');
                       }else{
                           $("#add-edit-Event [name='RepeatOrderon']").val(cur_obj.find("input[name='"+list_fields[i]+"']").val()).trigger('change');
                       }

                    }
                    else if(list_fields[i]=='RepeatDays'){
                        if(EveType==0){
                            $("#add-edit-Event [name='RepeatDays']").val(cur_obj.find("input[name='"+list_fields[i]+"']").val()).trigger('change');
                        }else{
                            $("#add-edit-Event [name='RepeatDayson']").val(cur_obj.find("input[name='"+list_fields[i]+"']").val()).trigger('change');
                        }

                    }
                    else if(list_fields[i]=='RepeatMonth'){
                        if(EveType==1){

                            $("#add-edit-Event [name='RepeatMonth']").val(cur_obj.find("input[name='"+list_fields[i]+"']").val()).trigger('change');
                        }

                    }
                    else{
                        $("#add-edit-Event [name='"+list_fields[i]+"']").val(cur_obj.find("input[name='"+list_fields[i]+"']").val());
                    }



                }

                //$("#add-edit-modal-itemtype [name='ProductClone']").val(0);
                //$('#add-edit-modal-itemtype h4').html('Edit Item Type');
                $('#AddEvent').modal('show');
            });

//Delete Expense
            $('body').on('click', '.delete-event', function (e) {
                e.preventDefault();

                if(confirm('Are you sure you want to delete this event?')){
                    $.ajax({
                        url: $(this).attr("href"),
                        type: 'POST',
                        dataType: 'json',
                        headers: {
                            "X-CSRF-Token": $("#add-edit-Event [name='_token']").val(),

                        },
                        success: function (response) {
                            $(".delete-event").button('reset');
                            if (response.status == 'success') {
                                data_table.draw();
                                toastr.success(response.message, "Success");
                            } else {
                                toastr.error(response.message, "Error", toastr_opts);
                            }
                        },
                        // Form data
                        //data: {},
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                }

                return false;

            });




        });


        //Date range picker
        $('#StartDate').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
        });

        $('#EndDate').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        });

    </script>





@endsection
