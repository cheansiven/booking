@extends('frontend.layout')

@section('content')
    <div id="confirm_form_container" class="row" style="color: #333">
        <div id="greeting">
            Dear
            <span id="title">{{$status}} </span>
            <span id="firstname">{{$firstname}} </span>
            <span id="lastname">{{$lastname}} </span>
        </div>

        <div class="section">
            <p>We have well received your booking for : </p>

            @foreach($booking_rooms as $booking_room)
            <p class="red-darker text-capitalize">
                {{ $booking_room['total_room'] }} {{ $booking_room['name'] }}
            </p>
            @endforeach
        </div>

        <div class="section">
            <p>starting on the </p>
            <p class="red-darker"><?php echo date('F jS, Y', strtotime($checkin)); ?></p>
        </div>


        @if($totalnight > 0)
            <div class="section">
                for <span class="red-darker"> {{ $totalnight}} </span> {{ ($totalnight > 1) ? 'Nights' : 'Night' }}
            </div>
        @endif


        <div style="border-top:2px solid #88001b"></div>

        <div class="desc">
            <table>

                <tr>
                    <th>Total amount:</th>
                    <th>$ {{ money_format('%i', $totalprice) }}</th>
                </tr>
                <tr>
                    <td>Trans.Reference</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Trans.No.:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Receipt No.:</td>
                    <td></td>
                </tr>
            </table>
        </div>

        <div class="social Center">
            <a href="#">
                <i class="fa fa-facebook fa-2x"></i>
            </a>
            <a href="#">
                <i class="fa fa-foursquare fa-2x"></i>
            </a>
            <a href="#"><i class="fa fa-twitter fa-2x"></i></a>
        </div>

        <div class="address">
            <p style="font-size: 16px !important; padding: 30px; font-weight: 600;">amanjaya suites hotel</p>
            <div class="section">
                <p>#1 street 154</p>
                <p>[ corner with sisovath quay ]</p>
                <p>phnom penh kingdom of cambodia </p>
            </div>
            <p>T +855 (0) 23 21 47 47 </p>
            <p>F +855 (0) 23 21 95 45 </p>
        </div>
    </div>
@stop
