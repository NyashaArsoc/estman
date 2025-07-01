<div class="clearfix mb-0-25">
    <span class="float-xs-left">Leave Type:</span>
    <span class="float-xs-right" id="leavetype">{{$typegroup->description}} </span>
</div>
<div class="clearfix mb-0-25">
    <span class="float-xs-left">Available:</span>
    <span class="float-xs-right" id="daysavailable" type="text">{{$days->days ?? 0}} days</span>
    <input type="hidden" name="daysavailable" id="daysavailable_input" value="{{ $days->days ?? 0 }}">
</div>