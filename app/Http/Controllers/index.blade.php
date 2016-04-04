@extends('template')

{{--start section content--}}
@section('content')

    <div class="col-sm-12">
        <h2 class="page_title text-uppercase">Bookings</h2>
    </div>



    <div class="col-sm-12">
        @if($bookings->count() > 0)
            <?php
            $first_arrival = strtotime($bookings[0]->checkin);
            $last_arrival = strtotime($bookings[($bookings->count() - 1)]->checkin);

            $total_days = floor(($last_arrival - $first_arrival) / (60 * 60 * 24)) + 1;

            $date = date('Y-m-d', strtotime($bookings[0]->checkin));

            $dates_loop_increment = 0;

            $booking_index = 0;

            $skip = false;

            ?>

            @for($i = 0; $i < $total_days; $i++)

                <div class="reservation_container" style="display: none;">
                    <div class="col-sm-12 row btn_date_container" style="margin-bottom: 20px;" id="btn_date_container_{{ $dates_loop_increment }}">
                        <button data-toggle="collapse" data-target="#booking_{{ $dates_loop_increment }}" class="btn">
                            {{ $date }}
                        </button>

                        @if($date == date('Y-m-d'))
                            <span class="today_arrival">Today's arrival</span>
                        @elseif($date == date('Y-m-d', strtotime("+1 day")))
                            <span class="tomorrow_arrival date_label">Tomorrow's arrival</span>
                        @endif
                    </div>

                    <div id="booking_{{ $dates_loop_increment }}" class="collapse in reservation_table_container">

                        <table class="table reservation_table" id="table_{{ $dates_loop_increment }}" style="display: none;">
                            <thead>
                            <tr>
                                <th></th>
                                <th style="min-width: 110px;">Room Type</th>
                                <th class="center">Qty</th>
                                <th style="min-width: 80px;">Checkout</th>
                                <th class="center" style="min-width: 60px"># nights</th>
                                <th class="center"># guests</th>
                                <th style="min-width: 130px;">Nationality</th>
                                <th class="center">Full amount</th>
                                <th class="center">Paid</th>
                                <th>Trans #</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($bookings as $booking)

                                @if(date('Y-m-d', strtotime($booking->checkin)) == $date)

                                    <?php
                                    $booking_room_rate = 0;
                                    $total_all_rooms = 0;

                                    $room = $booking->booking_room[0]->room;

                                    $room_type = $room->name;
                                    $booking_room_rate = $room->standard_rate;
                                    $total_all_rooms = $room->standard_rate * $booking->total_rooms * $booking->total_nights;
                                    $total_all_nights = $room->standard_rate * $booking->total_rooms * $booking->total_nights;
                                    ?>
                                    <tbody class="show_booking_detail" data-target="#detail_{{ $booking->id }}">
                                    <tr>
                                        <td class="text-uppercase">
                                            {{ $booking->lastname }}
                                            {{ $booking->firstname }}
                                            ({{ $booking->status }})
                                        </td>
                                        <td class="text-uppercase">
                                            {{ $room_type }}
                                        </td>
                                        <td class="center">
                                            {{ $booking->total_rooms }}
                                        </td>
                                        <td>
                                            {{ $booking->checkout }}
                                        </td>
                                        <td class="center">
                                            {{ $booking->total_nights }}
                                        </td>
                                        <td class="center">
                                            {{ $booking->number_of_guests }}
                                        </td>
                                        <td>
                                            <img src="{{ url('public/img/flags') }}/{{ $booking->country }}.png"
                                                 alt="{{ $booking->country }}" class="country_flag">
                                            {{ $booking->country }}
                                        </td>
                                        <td class="center">
                                            {{ $booking->total_price }}
                                        </td>
                                        <td class="center">
                                            @if($booking->is_paid == 0)
                                                <i class="fa fa-times text-danger"></i>
                                            @else
                                                <i class="fa fa-check text-success"></i>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $booking->transaction_number }}
                                        </td>
                                    </tr>
                                    </tbody>

                                    <tbody id="detail_{{ $booking->id }}" class="booking_detail" style="display: none;">
                                    <tr>
                                        <td colspan="10">
                                            <div class="row">
                                                <div class="col-lg-2">
                                                    <a href="#" class="email text-info">{{ $booking->email }}</a>
                                                </div>
                                                <div class="col-sm-2">
                                                    {{ $booking->contact_phone }}
                                                </div>
                                                <div class="col-sm-4 text-uppercase">
                                                    <table border="0">
                                                        <tr>
                                                            <td style="min-width: 90px;">Room Rate</td>
                                                            <td>{{ $booking_room_rate }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Total Rooms</td>
                                                            <td>{{ $total_all_rooms }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Total Nights</td>
                                                            <td>{{ $total_all_nights }}</td>
                                                        </tr>
                                                    </table>
                                                </div>

                                                <div class="col-sm-4 text-uppercase">
                                                    <?php $addons_room_store = []; ?>
                                                    @foreach($booking->booking_room as $booking_room)

                                                        @foreach($booking_room->getBookingRoomAddons() as $index => $booking_room_addons)

                                                            <?php $addon = $booking_room_addons->getAddon(); ?>

                                                            @if (isset($addons_room_store[$booking->id . '_' . $booking_room_addons->addon_id]))
                                                                <?php
                                                                $addons_room_store[$booking->id . '_' . $booking_room_addons->addon_id]['qty'] += 1;
                                                                $addons_room_store[$booking->id . '_' . $booking_room_addons->addon_id]['price'] += doubleval($addon->getPrice($booking_room->room_id));
                                                                ?>
                                                            @else
                                                                <?php
                                                                $addons_room_store[$booking->id . '_' . $booking_room_addons->addon_id]['qty'] = 1;
                                                                $addons_room_store[$booking->id . '_' . $booking_room_addons->addon_id]['price'] = doubleval($addon->getPrice($booking_room->room_id));
                                                                ?>
                                                            @endif

                                                            <?php $addons_room_store[$booking->id . '_' . $booking_room_addons->addon_id]['name'] = $addon->name; ?>

                                                        @endforeach

                                                    @endforeach


                                                    @foreach($addons_room_store as $addon_data)
                                                        <div class="col-sm-12">
                                                            <div class="col-sm-8">
                                                                {{ $addon_data['name'] }} ({{ $addon_data['qty'] }})
                                                            </div>
                                                            <div class="col-sm-4">
                                                                {{ money_format('%i', $addon_data['price']) }}
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                </div>
                                            </div>
                                        </td>

                                    </tr>

                                    <tr>
                                        <td colspan="10">
                                            <p>Comments</p>
                                            <div>
                                                ...
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                @endif
                            @endforeach
                        </table>

                    </div>

                </div>

                <?php $dates_loop_increment++ ?>
                <?php $date = date('Y-m-d', strtotime($date) + (60 * 60 * 24)); ?>

            @endfor
        @endif
    </div>

@stop
{{--end section content--}}

@section('script')

    <script>
        $(document).ready(function () {
            $('.reservation_table').each(function () {
                if($(this).find('tbody.booking_detail').length == 0) {
                    $(this).parent().hide();

                    var table_id = $(this).parent().attr('id').split('_');
                    var id = table_id[1];

                    var date_label = $('#btn_date_container_' + id).find('.date_label');

                    date_label.text('no booking').addClass('no_booking');
                }
            });

            $('.reservation_table').show();

            $('.reservation_container').show();
        });

        $(function () {
            $('.show_booking_detail').click(function() {
                $(this).toggleClass('active');

                $(this).next().toggle();
            });
        });

    </script>

@stop