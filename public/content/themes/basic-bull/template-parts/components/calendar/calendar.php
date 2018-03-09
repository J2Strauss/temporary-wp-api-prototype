<div id="events-container">

	<div class="brand-loader">

		<svg viewBox="0 0 200 200">

			<path class="stroke" d="M166.3,76.8c-0.6,0-1.1,0-1.5,0.1c-0.2,0-0.3,0-0.5,0c-3.6,0.4-11.3,2.1-28.2,8.4l-4.1,1.5L130,83
			c-10.8-20.2-23.6-44.9-29.9-57c0-0.1-0.1-0.1-0.1-0.1c0,0,0,0,0,0c-0.1,0-0.2,0.1-0.2,0.2v73.8l-3,1.3c-7.9,3.4-16.9,7.2-24.7,10.3
			l-4.1,1.7l-2.1-3.9c-5.4-9.8-10.6-19.1-12.4-21.7l-0.1-0.1l-0.1-0.1c-0.2-0.3-0.5-0.7-0.8-1c-0.2-0.3-0.4-0.5-0.6-0.8
			c-4.6-5.6-11.3-8.8-18.3-8.8c-13,0-23.6,10.6-23.6,23.7c0,13,10.6,23.6,23.6,23.6c0.7,0,1.3,0,1.6-0.1c0.1,0,0.2,0,0.3,0
			c3.7-0.4,11.7-2.3,28.1-8.7l4.1-1.6l2.1,3.9c9.9,18.2,21.7,40.8,29.9,56.4c0.1,0.1,0.1,0.1,0.2,0.1c0.1,0,0.2,0,0.2,0c0,0,0,0,0,0
			v-73.8l3-1.3c10.1-4.3,18-7.5,24.6-10.1l4.1-1.6l2.1,3.8c4.8,8.8,10.6,19.3,12.6,22.1l0.2,0.3c0.1,0.1,0.8,1,0.9,1.1
			c4.6,6,11.5,9.4,18.8,9.4c13,0,23.6-10.6,23.6-23.7C189.9,87.4,179.4,76.8,166.3,76.8z"/>

		</svg>

	</div>

	<?php 
		$filterArgs = array(
			'orderby'       => 'term_id', 
			'order'         => 'ASC',
			'hide_empty'    => true, 
		);

		$eventCategories = get_terms('event_category', $filterArgs);

			foreach($eventCategories as $eventCategory) : 

     			$eventCategorySlug = $eventCategory->slug;
     			$eventCategoryName = $eventCategory->name;
     			$eventCategoryId = $eventCategory->term_id;
     			$taxonomyName = $eventCategory->taxonomy;


	?>

		<a href="<?php echo $eventCategorySlug; ?>" data-type="<?php echo $taxonomyName; ?>" data-category-slug="<?php echo $eventCategorySlug; ?>" data-category-id="<?php echo $eventCategoryId; ?>" class="event-filter">

			<?php echo $eventCategoryName; ?>

		</a>

    <?php endforeach; ?>

    <a href="<?php echo $eventCategorySlug; ?>" class="event-filter reset-events">All Events</a>

	<div id="calendar">

		<script type="text/template"  id="calendar-template">

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

			<div id="events-list" class="event-listings-container">
			    
			    <div class="event-listings-title">Events</div>

			    <input id="events-filter" placeholder="Filter" />

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

</div>