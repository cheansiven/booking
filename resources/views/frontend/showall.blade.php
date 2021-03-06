@extends('frontend.layout')

@section('content')
<div class="container Show_Detail">
  <div class="Check_In_Out">
      <div class="col-sm-offset-2 col-sm-4">
          <p>Check in</p>
          <p>OCTOBER 23 2015</p>
      </div>
      <div class="col-sm-4">
          <p>Check out</p>
          <p>OCTOBER 30 2015</p>
      </div>
      <div class="col-sm-2">
          <p>Totel Nights</p>
          <p>8</p>
      </div>
    </div>

    <div class="Room_Display">
      <div class="Show_Room">
        <div class="col-sm-2" style="text-align:left;">
            Room 1
        </div>
        <div class="col-sm-4">
            <p style="font-size:32px;">Junior Suites</p>
            <p>8 nights x 142.65 = 1,141.20</p>
        </div>

        <div class="col-sm-offset-1 col-sm-5">
            <table class = "table Table_Include">
                 <tbody>
                    <tr>
                        <td>
                         <input id="ALL TAXES INCLUDED" class="option-input checkbox" name="include" type="checkbox" value="1">
                          <label for="ALL TAXES INCLUDED"  style="text-align:right">RATE FOR LATE CHECK OUT (FREE)</label>
                        </td>
                        <td>
                          <p id="price"></p>
                        </td>
                    </tr>
                    <tr>
                      <td>
                         <input id="RATE FOR EXTRA BED" class="option-input checkbox" name="include" type="checkbox" value="1">
                          <label for="RATE FOR EXTRA BED" style="text-align:right">RATE FOR EXTRA BED ($12.00)</label>
                        </td>
                        <td>
                          <p>12.00</p>
                        </td>
                    </tr>
                    <tr>
                      <td>
                         <input id="CHAMPAGNE ON ARRIVAL" class="option-input checkbox" name="include" type="checkbox" value="1">
                          <label for="CHAMPAGNE ON ARRIVAL" style="text-align:right">CHAMPAGNE ON ARRIVAL ($120.00)</label>
                        </td>
                        <td>
                          <p>120.00</p>
                        </td>
                    </tr>
                 </tbody>
          </table>
        </div>
      </div>

      <div class="Show_Room">
        <div class="col-sm-2" style="text-align:left;">
            Room 1
        </div>
        <div class="col-sm-4">
            <p style="font-size:32px;">Junior Suites</p>
            <p>8 nights x 142.65 = 1,141.20</p>
        </div>

        <div class="col-sm-offset-1 col-sm-5">
            <table class = "table Table_Include">
                 <tbody>
                    <tr>
                        <td>
                          <input id="ALL TAXES INCLUDED" class="option-input checkbox" name="include" type="checkbox" value="1">
                           <label for="ALL TAXES INCLUDED"  style="text-align:right">RATE FOR LATE CHECK OUT (FREE)</label>
                        </td>
                        <td>
                          <p id="ALL TAXES INCLUDED">0.00</p>
                        </td>
                    </tr>
                    <tr>
                      <td>
                        <input id="RATE FOR EXTRA BED" class="option-input checkbox" name="include" type="checkbox" value="1">
                         <label for="RATE FOR EXTRA BED" style="text-align:right">RATE FOR EXTRA BED ($12.00)</label>
                        </td>
                        <td>
                          <p>$12.00</p>
                        </td>
                    </tr>
                    <tr>
                      <td>
                        <input id="CHAMPAGNE ON ARRIVAL" class="option-input checkbox" name="include" type="checkbox" value="1">
                         <label for="CHAMPAGNE ON ARRIVAL" style="text-align:right">CHAMPAGNE ON ARRIVAL ($120.00)</label>
                        </td>
                        <td>
                          <p>$120.00</p>
                        </td>
                    </tr>
                 </tbody>
          </table>
        </div>
      </div>

    </div>
</div>
<footer>
    <div class="container">
        <div>
            2,114.40
        </div>
        <a href="{{URL::asset('/booking-form')}}">
            <button type = "button" class = "btn btn-default btn_Next">Process</button>
        </a>
    </div>
</footer>

<script type="text/javascript">
/*$(function(){
 $("#ALL TAXES INCLUDED").click(function(){
      if($('[type="checkbox"]').is(":checked")){
          $("#All_rate").append(display);
      }else{

       }
 })

});
*/

$(document).ready(function(){
        $('input[type="checkbox"]').click(function(){
            if($(this).is(":checked")){
                $("#price").append('<div>0.00</div>');
            }
            else if($(this).is(":not(:checked)")){
                alert("Checkbox is unchecked.");
            }
        });
    });

</script>
@stop
