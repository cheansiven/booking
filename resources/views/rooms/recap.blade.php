@extends('template')

@section('style')
    <style>
        .table>thead>tr>th {
            padding: 0 8px!important;
        }

        .table>tbody {
            border-top: 30px solid white !important;
        }

        .table>tbody>tr>td {
            border: 0;
        }

        .table>tbody>tr:first-child>td {
            border-bottom: 1px solid #ddd;
        }

        .table>tbody>tr:first-child>td:first-child {
            font-size: 14px;
        }

        tr:last-child td {
            font-weight: 600;
        }

        td:first-child {
            font-size: 11px;
            text-transform: uppercase;
        }
    </style>
@stop

@section('content')

    <h2 class="page_title">Rooms recap</h2>

    <?php

    $first_arrival = strtotime(date('d-m-Y'));
    $last_arrival = strtotime(date('d-m-Y') . '+14 days');

    $total_days = floor(($last_arrival - $first_arrival) / (60 * 60 * 24)) + 1;

    ?>

    <div class="content">
        <table class="table">

            <thead>
            <tr>
                <th>Name</th>

                @for($i=0; $i < $total_days; $i++)

                    <th class="text-right">
                        <?php echo date('M d', strtotime(date('d-m-Y') . '+' . $i . ' days'));?>
                    </th>

                @endfor

            </tr>
            </thead>

            @foreach($rooms as $index => $room)

                <tbody class="text-right" style="{{ (($index == 0) ? 'border-top: 10px solid white !important' : '') }}">
                <tr>
                    <td>{{ $room->name }}</td>

                    @for($i=0; $i < $total_days; $i++)

                        <td>{{ $room->max_capacity }}</td>

                    @endfor

                </tr>
                <tr>
                    <td>Rooms Open</td>

                    @for($i=0; $i < $total_days; $i++)

                        <?php
                        $date = date('d-m-Y', strtotime(date('d-m-Y') . '+' . $i . ' days'));

                        $room_available = array_filter($room->room_available->toArray(), function ($row) use ($date) {
                            return $row['start_date'] >= date('Y-m-d', strtotime($date));
                        });

                        ?>
                        <td>

                            @if(isset($room_available[0]['number_room_available']))
                                {{ $room_available[0]['number_room_available'] }}
                            @else
                                {{ $room->max_capacity }}
                            @endif
                        </td>

                    @endfor

                </tr>
                <tr>
                    <td>Rooms Booked</td>

                    @for($i=0; $i < $total_days; $i++)

                        <?php
                        $date = date('Y-m-d', strtotime(date('Y-m-d') . '+' . $i . ' days'));

                        $booked_rooms = [];

                        $room_id = $room->id;

                        $booking_rooms = [];

                        foreach ($bookings as $booking) {

                            if (date('Y-m-d', strtotime($booking->checkin)) <= $date
                                    && date('Y-m-d', strtotime($booking->checkout)) >= $date
                            ) {

                                foreach ($booking->booking_room as $booking_room) {
                                    if ($room_id == $booking_room->room_id) {
                                        $booking_rooms[] = [
                                                'room_id' => $booking_room->room_id,
                                                'booking_id' => $booking->id,
                                                'checkin' => $booking->checkin,
                                                'checkout' => $booking->checkout
                                        ];
                                    }
                                }
                            }
                        }

                        $booked_room_counted = count($booking_rooms);

                        echo "<td>" . (($booked_room_counted > 0) ? $booked_room_counted: '-') . "</td>";
                        ?>

                    @endfor

                </tr>
                <tr>
                    <td>Rooms Available</td>

                    @for($i=0; $i < $total_days; $i++)

                        <?php
                        $date = date('Y-m-d', strtotime(date('Y-m-d') . '+' . $i . ' days'));

                        $booked_rooms = [];

                        $room_id = $room->id;

                        $booking_rooms = [];

                        foreach ($bookings as $booking) {

                            if (date('Y-m-d', strtotime($booking->checkin)) <= $date
                                    && date('Y-m-d', strtotime($booking->checkout)) >= $date
                            ) {

                                foreach ($booking->booking_room as $booking_room) {
                                    if ($room_id == $booking_room->room_id) {
                                        $booking_rooms[] = [
                                                'room_id' => $booking_room->room_id,
                                                'booking_id' => $booking->id,
                                                'checkin' => $booking->checkin,
                                                'checkout' => $booking->checkout
                                        ];
                                    }
                                }
                            }
                        }

                        $room_available = array_filter($room->room_available->toArray(), function ($row) use ($date) {
                            return $row['start_date'] >= date('Y-m-d', strtotime($date));
                        });

                        if (isset($room_available[0]['number_room_available'])) {
                            $final_room_available = ($room_available[0]['number_room_available'] - count($booking_rooms));
                        } else {
                            $final_room_available = $room->max_capacity - count($booking_rooms);
                        }

                        echo "<td>";
                        echo ($final_room_available > 0) ? $final_room_available : '<i class="fa fa-times"></i>';
                        echo "</td>";

                        ?>

                    @endfor

                </tr>
                </tbody>

            @endforeach

        </table>
    </div>

@stop