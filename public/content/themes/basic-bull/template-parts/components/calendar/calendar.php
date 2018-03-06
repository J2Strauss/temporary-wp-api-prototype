<?php
/**
 *
 * @package bull
 */
 	
	$request = wp_remote_get( 'http://wordpress.localhost/wp-json/wp/v2/events?filter[meta_key]=event_start_date&filter[orderby]=meta_value_num&order=asc' );
	
	if( is_wp_error( $request ) ) {

		return false; // Bail early

	}

	$response = wp_remote_retrieve_body( $request );
	$data = json_decode( $response );
	$eventsObject = "";

	//print_r($data);


	if( ! empty( $data ) ) :
		
		foreach( $data as $post ) : 

			$eventTitle = $post->title->rendered;
			$eventDescription = $post->acf->event_description;
			$eventStartDate = $post->acf->event_start_date;
			$eventEndDate = $post->acf->event_end_date;
			$eventStartTime = $post->acf->event_start_time;
			$eventEndTime = $post->acf->event_end_time;

			$eventsObject .="{
				start: '".$eventStartDate."',
				end: '".$eventEndDate."',
				title: '".$eventTitle."',
				desc: '".$eventDescription."',
				time: '".$eventStartTime."'
			},";
?>

	<?php endforeach; ?>

	<?php $eventsObject = "[ " . strip_tags(rtrim($eventsObject), ",") . " ]"; ?>

	<?php print_r($eventsObject); ?>

<?php endif; ?>

<div id="calendar">

	<script type="text/template"  id="calendar-template">

		<!-- STANDARD CLNDR MARKUP -->
		<div class="clndr-controls">
		     <div class="clndr-previous-button">‹</div>
		     <div class="current-month"><%= month %> <%= year %></div>
		     <div class="clndr-next-button">›</div>
		</div>
		<div class="clndr-grid">
		    <div class="days-of-the-week clndr-clearfix">
		        <% _.each(daysOfTheWeek, function(day) { %>
		        <div class="header-day"><%= day %></div>
		        <% }); %>
		    </div>
		    <div class="days clndr-clearfix">
		        <% _.each(days, function(day) { %>
		        <div class="<%= day.classes %>" id="<%= day.id %>"><span class="day-number"><%= day.day %></span></div>
		        <% }); %>
		    </div>
		</div>
		<div class="event-listing">
		    <div class="event-listing-title">Events</div>

		    <% _.each(eventsThisMonth, function(event) { %>
		        <% if (event.url) {  %><a target="<%= event.url_target %>" href="<%= event.url %>" <% } else {  %><div <% }  %> class="event-item clndr-clearfix">
		            <span class="event-item-date">
		                <% if (event.startDate != event.start) {  %>
		                	<%= moment(event.startDate).format("D MMMM") %>
		                <% } %>
		                <% if (event.end != event.start) {  %>
		                     – <%= moment(event.end).format("D MMMM") %>
		                <% } %>
		            </span>
		            <span class="event-item-name"><%= event.title %></span>
		            <% if (event.time) {  %>
		                <span class="event-item-time"><%= event.time %></span>
		            <% } %>
		            <% if (event.desc) {  %>
		                <span class="event-item-desc"><%= event.desc %></span>
		            <% } %>
		        <% if (event.url) {  %></a><% } else {  %></div><% }  %>
		    <% }); %>
		</div>

	</script>

</div>