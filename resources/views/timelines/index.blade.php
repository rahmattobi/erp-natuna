@extends('layouts.app')
@section('title', 'ERP - Natuna Global Ekapersada')

@section('contents')
<div class="row">
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-3">
            <h1 class="h3 mb-0 text-gray-800">Timeline</h1>
            <a href="{{ route('timeline.input') }}" class="d-none d-sm-inline-block btn btn-sm btn-outline-primary shadow-sm"><i
                class="fas fa-plus fa-sm text-primary-50"></i> Input Timeline</a>
        </div>
         {{-- alert --}}
        @if (Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('success') }}
            </div>
        @endif

         {{-- Calendar --}}
         <div class="row">
            <div class="col-xl-12 col-md-6 mb-4">
            <div id='calendar-container'>
                <div id='calendar'></div>
            </div>
            </div>
        </div>

        {{-- data table --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Timeline Table</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Start</th>
                                <th>End</th>
                                <th>Status</th>
                                <th style="width: 100px">Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Title</th>
                                <th>Start</th>
                                <th>End</th>
                                <th>Status</th>
                                <th style="width: 100px">Action</th>
                            </tr>
                        </tfoot>
                        <tbody>

                            @foreach ($timelines as $timelines)
                                <tr>
                                    <td>{{ $timelines->title }}</td>
                                    <td>{{ $timelines->start }}</td>
                                    <td class="show-read-more">{{ $timelines->end }}</td>
                                    <td>
                                        @if ($timelines->category == 0)
                                            <span class="badge badge-primary">On Progress</span>
                                        @else
                                            <span class="badge badge-success">Done</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group" >
                                            <a href="{{ route('timeline.edit', $timelines->id)}}">
                                                <button class="btn btn-warning"><i class="fas fa-edit"></i></button>
                                            </a>
                                            <a href="{{ route('timeline.delete', $timelines->id) }}" data-toggle="modal" data-target="#deleteModal{{ $timelines->id }}">
                                                <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                                @php
                                                     $data = $timelines->id;
                                                @endphp
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <div class="modal fade" id="deleteModal{{ $timelines->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel{{ $timelines->id }}">Are you sure ?</h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">Do you really want to delete these record ? this process cannot be undone.</div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                        <form action="{{ route('timeline.delete', $timelines->id) }}" method="POST" id="deleteForm">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>



    </div>
</div>


{{-- calendar js--}}
<script src='{{ asset ('fullcalendar/fullcalendar/packages/core/main.js') }}'></script>
<script src='{{ asset ('fullcalendar/fullcalendar/packages/interaction/main.js') }}'></script>
<script src='{{ asset ('fullcalendar/fullcalendar/packages/daygrid/main.js') }}'></script>
<script src='{{ asset ('fullcalendar/fullcalendar/packages/timegrid/main.js') }}'></script>
<script src='{{ asset ('fullcalendar/fullcalendar/packages/list/main.js') }}'></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
var calendarEl = document.getElementById('calendar');

// get currentDate
const currentDate = new Date();
const dateString = currentDate.toDateString();
const dateObject = new Date(dateString);
const today = dateObject.toISOString().slice(0, 10);

// getdata from database
var eventData = @php echo json_encode($jsonData); @endphp;
console.log(eventData);
var calendar = new FullCalendar.Calendar(calendarEl, {
 plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
 height: 'parent',
 header: {
   left: 'prev,next today',
   center: 'title',
   right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
 },
 defaultView: 'dayGridMonth',
 defaultDate: today,
 navLinks: true, // can click day/week names to navigate views
 editable: false,
 eventLimit: false, // allow "more" link when too many events
 events: eventData, //display data from database in calendar
//  eventColor: warnaStatus,
eventRender: function(info) {
                    // Customize the appearance based on the event's category
                    switch (info.event.extendedProps.category) {
                        case 0:
                            info.el.style.backgroundColor = '#3333cc';
                            break;
                        // Add more cases for other categories and set their colors
                        default:
                            info.el.style.backgroundColor = '#28a745';
                            break;
                    }
                }
});

calendar.render();
});

</script>

<script src="{{ asset ('fullcalendar/js/main.js')}}"></script>

@endsection
