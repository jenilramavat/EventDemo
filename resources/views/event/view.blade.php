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

        <div class="card-header">
            EventName : <b>{{$EventTitle}}</b>
        </div>


        <br><br><br>
       <div>
           <table border="1">
           @foreach($ResultArray as $res)
               <tr>
                   <td>
               {{$res}}
               @endforeach
                   </td>
               </tr>
           </table>

           <label>Total Count : <b>{{count($ResultArray)}}</b></label>
       </div>



</div>

@endsection
