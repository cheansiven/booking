
		<header>
        <div class="Line"></div>
		    <img class="Home_Logo" src="public/Images/logo.png" ></img>
		</header>
      <div class="Confirm_Show">
        <div class="Center"> Dear {{$status}} {{$firstname}} {{$lastname}}</div>
            <div class="Center">
                <p>We have well received your booking for : </p>
                  @if($room1 >0)
                    @if($room1 ==1)
                        <p style="color:#bf2020">{{$room1}} Executive suite</p>
                    @else
                        <p style="color:#bf2020">{{$room1}} Executive suites</p>
                    @endif
                  @endif
                  @if($room2 >0)
                    @if($room2 ==1)
                        <p style="color:#bf2020">{{$room2}} Panoranic suite</p>
                    @else
                        <p style="color:#bf2020">{{$room2}} Panoranic suites</p>
                    @endif
                  @endif
                  @if($room3 >0)
                    @if($room3 ==1)
                        <p style="color:#bf2020">{{$room3}} Executive suite</p>
                    @else
                        <p style="color:#bf2020">{{$room3}} Executive suites</p>
                    @endif
                  @endif
            </div>
            <div class="Center">
                <p>starting on the </p>
                <p style="color:#bf2020">{{$checkin}}</p>
            </div>
            @if($totalnight > 0)
            <div class="Center"> for <span style="color: #bf2020"> {{$totalnight}} </span>
                @if($totalnight==1)
                    night</div>
                @else
                    nights </div>
              @endif
            @endif
            <div style="border-top:2px solid #bf2020"></div>
            <div class="padding-left">
                <div class="trans">
                    <div style="padding:0; color:#bf2020">Total amount: {{$totalprice}}</div>
                    <p>Trans.Reference</p>
                    <p>Trans.No:</p>
                    <p>Receipt No.:</p>
                </div>
            </div>
            <div class="social Center">
              <a href="#"><i class="fa fa-facebook fa-2x"></i></a><a href="#"><i class="fa fa-foursquare fa-2x"></i></a><a href="#"><i class="fa fa-twitter fa-2x"></i></a>
            </div>
            <div class="address Center">
                <p style="font-size: 16px !important; padding: 30px">amanjaya suites hotel</p>
                <div>
                    <p>#1 street 154</p>
                    <p>[ corner with sisovath quay ]</p>
                    <p>phnom penh kingdom of cambodia </p>
                </div>
                <p>T +855 (0) 23 21 47 47 </p>
                <p>F +855 (0) 23 21 95 45 </p>
            </div>
      </div>
