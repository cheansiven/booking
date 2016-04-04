@extends('template')

@section('style')
    <style>
        td {
            text-transform: uppercase;
        }
    </style>
@stop

@section('content')

    <div class="container">
        <h2 class="page_title">Rooms & Suites</h2>
    </div>

    <div class="center">
        <select name="display_by" id="display_by">
            <option value="today">as of today</option>
            <option value="this-week">as of this week</option>
            <option value="this-month">as of this month</option>
        </select>
    </div>

    <table class="table" id="room_list">
        <thead>
        <tr>
            <th>&nbsp;</th>
            <th>Name</th>
            <th class="center">Current Rate</th>
            <th class="center">Currently Open</th>
            <th class="center red">Booked Today</th>
            <th class="center">&nbsp;</th>
        </tr>
        </thead>

        <tbody>
        </tbody>

    </table>
@stop

@section('script')
    <script>
        var base_url = "{{ url() }}";

        function createRoomList() {
            var display_by = $('#display_by').val();

            $.ajax({
                url: base_url + '/rooms/ajax/get-list-data/' + display_by,
                success: function (response) {
                    var data_length = Object.keys(response.rooms).length;

                    var markup = '';
                    var total_booked_rooms = 0;
                    for (var i = 0; i < data_length; i++) {
                        total_booked_rooms += parseInt(response.rooms[i]['number_booked_room'])  || 0;

                        markup += '<tr>';
                        markup += '<td class="room_name_label col-md-2"></td>';
                        markup += '<td><a href="' + base_url + '/rooms/' + response.rooms[i]['id'] + '/edit">' + response.rooms[i]['name'] + '</a></td>';
                        markup += '<td class="center">' + response.rooms[i]['current_rate'] + '</td>';
                        markup += '<td class="center">' + response.rooms[i]['number_room_available'] + '</td>';
                        markup += '<td class="center red bold">' + response.rooms[i]['number_booked_room'] + '</td>';
                        markup += '<td class="center">' + response.rooms[i]['name'] + '</td>';
                        markup += '</tr>';
                    }

                    markup += '<tr>';
                    markup += '<td></td>';
                    markup += '<td></td>';
                    markup += '<td></td>';
                    markup += '<td></td>';
                    markup += '<td class="center red bold">' + total_booked_rooms + '</td>';
                    markup += '<td></td>';
                    markup += '</tr>';

                    $('table tbody').html(markup);
                }
            })
        }

        $(document).ready(function () {
            createRoomList();
        });

        $(function () {
            $('#display_by').change(function () {
                createRoomList();
            });
        });
    </script>
@stop