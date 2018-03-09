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

		$eventTitle = "";
		$eventExcerpt = "";
		$eventStartDate = "";
		$eventEndDate = "";
		$eventStartTime = "";
		$eventEndTime = "";
		$eventLocation = "";
		$eventCategory = "";
		$eventCategoryName = "";
		$eventCategorySlug = "";
		
		foreach( $data as $post ) : 

			$eventTitle = $post->title->rendered;
			$eventExcerpt = $post->acf->event_excerpt;
			$eventStartDate = $post->acf->event_start_date;
			$eventEndDate = $post->acf->event_end_date;
			$eventStartTime = $post->acf->event_start_time;
			$eventEndTime = $post->acf->event_end_time;
			$eventLocation = $post->acf->event_location;
			$eventCategory = $post->acf->event_category;
			if ( $eventCategory != false ) { 
				$eventCategoryName = $post->acf->event_category->name;
				$eventCategorySlug = $post->acf->event_category->slug;
			} 
			// $eventTerms = array();
			// $eventTerms = $post->event_category;
			// $eventTerms = implode(' ', $eventTerms);
			// foreach( $eventTerms as $term ) {
			// 	echo $term;
			// };

			$eventsObject .="{
				start: '".$eventStartDate."',
				end: '".$eventEndDate."',
				title: '".$eventTitle."',
				desc: '".$eventExcerpt."',
				time: '".$eventStartTime."',
				location: '".$eventLocation."',
				categoryName: '".$eventCategoryName."',
				categorySlug: '".$eventCategorySlug."'
			},";
?>

	<?php endforeach; ?>

	<?php $eventsObject = "[ " . strip_tags(rtrim($eventsObject), ",") . " ]"; ?>

	<?php // print_r($eventsObject); ?>

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
		        <div class="<%= day.classes %>" id="<%= day.id %>">
		        	<span class="day-number"><%= day.day %></span>
		        	<% if (day.events) {  %>
		        		<div class="day-event-listing"></div>
		        	<% } %>
		        </div>
		        <% }); %>
		    </div>
		</div>
		<div class="event-listings-container">
		    
		    <div class="event-listings-title">Events</div>

		    <% _.each(eventsThisMonth, function(event) { %>	
		        
		        <% if (event.link) {  %><a target="<%= event.url_target %>" href="<%= event.link %>" <% } else {  %><div <% }  %> class="event-listing clndr-clearfix" data-date="<%= event.startDate %>" data-day="<%= event.startDate %>">

		        	 <% if (event.imageThumbnail) { %>
		            	
		            	<div class="event-detail-image">
		            		<img src="<%= event.imageThumbnail %>" alt="">
		            	</div>

		            <%  } %>
					
					<div class="event-detail-date-time">

		            	<span>Event Date:

		                <% if (event.startDate != event.start) {  %>

		                	<%= moment(event.startDate).format("MMMM D, Y") %>

		                <% } %>

		              	<% if ( !_.isEmpty(event.endDate) ) { %>

			                <% if (event.endDate != event.startDate) {  %>

			                     – <%= moment(event.endDate).format("MMMM D, Y") %>

			                <% } %>

		                <% } %>

		                </span>

		             	<% if (event.startTime) {  %>

		                	<span> | Event Time:

		                	<%= event.startTime %>

		                	<% if (event.endTime) {  %>

			                	<% if ( !_.isEqual(event.endTime , event.startTime) ) {  %>

				                     – <%= event.endTime %>

				                <% } %>
		                		
							<% } %>

							</span>

			            <% } %>

		            </div>

		            <div class="event-detail-title"><h3>Event Title: <%= event.title %></h3></div>

		            <% if (event.location) { %>
		            	
		            	<div class="event-detail-location">Event Location: <%= event.location %></div>

		            <%  } %>

		            <% if (event.eventExcerpt) {  %>
		                
		                <div class="event-detail-excerpt">Event Excerpt: <%= event.excerpt %></div>

		            <% } %>

		            <% if (event.streetAddress) { %>
		            	
		            	<div class="event-detail-address">Event Address: <%= event.streetAddress %></div>

		            <%  } %>

		            <% if (event.city) { %>
		            	
		            	<div class="event-detail-address">Event City: <%= event.city %></div>

		            <%  } %>

		            <% if (event.zipCode) { %>
		            	
		            	<div class="event-detail-address">Event Zip Code: <%= event.zipCode %></div>

		            <%  } %>

		            <% if (!_.contains(['undefined'], event.categoryName)) { %>
		            	
		            	<div class="event-detail-category-name">Event Category Name: <%= event.categoryName %></div>

		            <%  } %>

		            <% if (!_.contains(['undefined'], event.categorySlug)) { %>
		            	
		            	<div class="event-detail-category-slug">Event Category Slug: <%= event.categorySlug %></div>

		            <%  } %>

		        <% if (event.link) {  %></a><% } else {  %></div><% }  %>

		        <br>

		    <% }); %>

		</div>

	</script>

</div>