<?php
	include("includes/utility.php");
	include("includes/headers.php");
	include("includes/navbar.php");
?>
<div class="row">
	<div class="col-sm-12 col-md-2 soft-yellow-bg link-section">
		<span data-toggle="tooltip" title="Donate your fresh made or left over food to help the needy labourers who are starving. Mark your location and someone will reach out to you to collect food"><a href="<?=baseurl()?>/mark.php">Donate food</a></span>
		<span data-toggle="tooltip" title="If you know places where there are labourers or people starving in this pandemic, then mark their location and someone will try to provide fooding"><a href="#" id="request-link" class="t-shadow">Mark requester's location</a></span>
		<span data-toggle="tooltip" title="Pick food from the donators and deliver it to needy ones via drone or manually"><a href="<?=baseurl()?>/">Courier food</a></span>
	</div>
	<div class="col-sm-12 container-fluid m-0 p-4 col-md-10" style="height: 86vh;">
		<small class="text-warning text-center">
			Please make sure the location you are going to mark is not previously marked <a href="<?=baseurl()?>/">here</a>
		</small>
		<div class="mapContainer mt-1" id="mapContainer"></div>
	</div>
</div>
<?php
	include("includes/bottom-scripts.php");
?>
<!-- Request Modal Start -->
<div class="modal fade" id="request-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Food requesting details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="row pb-2" action="<?=baseurl()?>/includes/insert-request-info.php" method="POST">
	        <div class="form-group col-12">
	        	<textarea name="description" placeholder="Please give information about the how many people are there" class="form-control"></textarea>
	        </div>
	        <input type="hidden" name="lat" id="hidden-request-lat">
	        <input type="hidden" name="long" id="hidden-request-long">
	        <input type="hidden" name="city" id="hidden-request-city">
	        <div class="col-12 text-center">
	        	<input type="submit" name="submit" class="btn btn-warning" value="Request food at this location"/>
	        </div>
        </form>
      </div>
      <div class="modal-footer">
      	<small>If this is not the appropriate location then <u data-dismiss="modal">click here</u>, and please drag the marker to point the correct location</small>
      </div>
    </div>
  </div>
</div>
<!-- Request Modal End -->
	<script>
		$(function () {
		    $('[data-toggle="tooltip"]').tooltip()
		})
		var platform = new H.service.Platform({'apikey':'Q8YJrd6nSQYp_S8WNXt0r1EzGWvTv4KkssNS5eEooow'});
		var defaultLayers = platform.createDefaultLayers();

		var map = new  H.Map(
			document.getElementById('mapContainer'),
			defaultLayers.vector.normal.map,
			{
				zoom: 10,
				center: {lat: 26.8467, lng: 80.9462 }
			}
		)
		var ui = H.ui.UI.createDefault(map, defaultLayers);
		// Enable the event system on the map instance:
		var mapEvents = new H.mapevents.MapEvents(map);

		// Add event listeners:
		map.addEventListener('tap', function(evt) {
		    // Log 'tap' and 'mouse' events:
		    console.log(evt);
		});

		// Instantiate the default behavior, providing the mapEvents object:
		var behavior = new H.mapevents.Behavior(mapEvents);
		group = new H.map.Group();

		// add a resize listener to make sure that the map occupies the whole container
		window.addEventListener('resize', () => map.getViewPort().resize());
		var final_lat, final_long, city;
		// functionality for requesting food
		$('#request-link').click(()=>{
			alert("Please adjust the marker to point where people need food. By default, marker is placed at your location.\nDrag the marker a little to continue.");
			// Create an icon, an object holding the latitude and longitude, and a marker:
			var lat, long;
			navigator.geolocation.getCurrentPosition((e)=>{
				lat = e.coords.latitude
				long = e.coords.longitude
				var coords = {lat: lat, lng: long },
				// now create a draggable marker
				marker = new H.map.Marker(coords, {volatility: true});
				marker.draggable = true;
				map.addObject(marker);
				map.setCenter(coords);
				map.addEventListener('dragstart', function(ev) {
					var target = ev.target,
					pointer = ev.currentPointer;
					if (target instanceof H.map.Marker) {
						var targetPosition = map.geoToScreen(target.getGeometry());
						target['offset'] = new H.math.Point(pointer.viewportX - targetPosition.x, pointer.viewportY - targetPosition.y);
						behavior.disable();
					}
				}, false);


				// re-enable the default draggability of the underlying map
			  	// when dragging has completed
			  	map.addEventListener('dragend', function(ev) {
				  	var target = ev.target;
				  	if (target instanceof H.map.Marker) {
				  		behavior.enable();
				  		// now ask for details of the food donator using modal
				  		$('#request-modal').modal();
				  		final_lat = marker.b.lat;
				  		final_long = marker.b.lng;
				  		// console.log(final_lat + ", "+final_long)
				  		document.getElementById('hidden-request-long').value = final_long;
				  		document.getElementById('hidden-request-lat').value = final_lat;
				  		$.ajax({
						  url: 'https://reverse.geocoder.ls.hereapi.com/6.2/reversegeocode.json',
						  type: 'GET',
						  dataType: 'jsonp',
						  jsonp: 'jsoncallback',
						  data: {
						    prox: final_lat+','+final_long,
						    mode: 'retrieveAddresses',
						    maxresults: '1',
						    gen: '9',
						    apiKey: 'Q8YJrd6nSQYp_S8WNXt0r1EzGWvTv4KkssNS5eEooow'
						  },
						  success: function (data) {
						    document.getElementById('hidden-request-city').value = data.Response.View[0].Result[0].Location.Address.City;
						    // console.log(document.getElementById('hidden-city').value)
						  },
						  fail: function(data){
						  	document.getElementById('hidden-request-city').value = 'undefined';
						  }
						});
				  	}
				  }, false);

			  	// Listen to the drag event and move the position of the marker
				// as necessary
				map.addEventListener('drag', function(ev) {
				  	var target = ev.target,
				  	pointer = ev.currentPointer;
				  	if (target instanceof H.map.Marker) {
				  		target.setGeometry(map.screenToGeo(pointer.viewportX - target['offset'].x, pointer.viewportY - target['offset'].y));
				  	}
				  }, false);
			})
		})
	</script>
