<form class="ctamobilebooking" method="post" action="http://m.directwithhotels.com/mobile/processDates/<?php echo $hotelid;?>/0" data-ajax="false">
									
	<div class="cta-calendar-container">
		<span class="calendar-label">Start Date:</span>
		<div class="calendar-input">
			<input class="text_reserve" type="date" name="arrival" value="">
		</div>
	</div>
	<div class="cta-calendar-container">
		<span class="calendar-label">End Date:</span>
		<div class="calendar-input">
			<input class="text_reserve" type="date" name="departure" value="">
		</div>
	</div>

	<input type="hidden" name="language" id="fldLang" value="en" />
    <input type="hidden" name="property_id" id="property_id" value="<?php echo $hotelid;?>" />
    <input type="hidden" name="reservation_id" id="reservation_id" value="0" />
    <input type="hidden" name="auth_key" id="auth_key" value="0">
    <input type="hidden" name="user_id" id="user_id" value="0" />
    <input type="hidden" name="activefld" id="fldActive" value="arrival" />
    <input type="hidden" name="arrival" id="fldArrival" value="" />
    <input type="hidden" name="departure" id="fldDeparture" value="" />
	<input type="submit" name="submit" class="button ctamobilepromobutton" onclick="_gaq.push(['_trackEvent', 'organic-clickers', 'go-to-showrooms', 'calendar-widget',, false]);" value="Check availability and prices">

</form>	