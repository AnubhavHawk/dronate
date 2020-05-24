<?php
	include("includes/utility.php");
	include("includes/headers.php");
	include("includes/navbar.php");
?>
<?php
	if(isset($_REQUEST['s']))
	{
		if($_REQUEST['s'] == 's')
		{
			?>
			<script>
				window.alert("We have noted your marked location. Someone will reach out to there shortly");
			</script>
			<?php
		}
		else
		{
			?>
			<script>
				window.alert("Failed to add location, please try again");
			</script>
			<?php
		}
	}
?>
<div class="row">
	<div class="col-sm-12 col-md-2 soft-yellow-bg link-section">
		<span data-toggle="tooltip" title="Donate your fresh made or left over food to help the needy labourers who are starving. Mark your location and someone will reach out to you to collect food"><a href="<?=baseurl()?>/mark.php">Donate food</a></span>
		<span data-toggle="tooltip" title="If you know places where there are labourers or people starving in this pandemic, then mark their location and someone will try to provide fooding"><a href="<?=baseurl()?>/request.php">Request food</a></span>
		<span data-toggle="tooltip" title="Pick food from the donators(green) and deliver it to needy ones(red) via drone or manually. Use the cities on left to explore"><a href="#" class="t-shadow">Courier food</a></span>
	</div>
	<div class="col-sm-12 container-fluid m-0 p-4 col-md-8" style="height: 86vh;">
		<div class="mapContainer" id="mapContainer"></div>
	</div>
	<div class="col-sm-12 col-md-2 bg-light text-center pt-3 pb-2">
		<h6 title="Pick food from green marker and provide it to red markers"><b>Help sharing food</b></h6>
		<?php
			include("includes/db_connection.php");
			$sql = "SELECT DISTINCT city FROM donate_info UNION SELECT DISTINCT city FROM request_info";
			$result = $conn->query($sql);
			if($result->num_rows > 0)
			{
				while($row = $result->fetch_assoc())
				{
					echo '<div style="display:inline-block; margin-left:10px;"><a href="#" class="city-link">'.$row['city'].'</a></div>';
				}
			}
		?>
		<hr>
		<b>Can't find your city?</b>
		<div>
			<small>Donate in your city: <a href="<?=baseurl()?>/mark.php">Click here</a></small>
		</div>
		<div>
			<small>Request help in your city: <a href="<?=baseurl()?>/request.php">Click here</a></small>
		</div>
	</div>
</div>
<?php
	include("includes/bottom-scripts.php");
?>
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

		// Instantiate the default behavior, providing the mapEvents object:
		var behavior = new H.mapevents.Behavior(mapEvents);
		// group = new H.map.Group();

		function addMarkerToGroup(group, coords, html, color) {
			  var icon = new H.map.Icon('<?=baseurl()?>/assets/img/'+color+'-marker.png');
				marker = new H.map.Marker(coords, {icon:icon});
			  // add custom data to the marker
			  marker.setData(html);
			  group.addObject(marker);
			}
			function addInfoBubble(map, coords, color, description) {
			  var group = new H.map.Group();
			  map.addObject(group);
			  group.addEventListener('tap', function (evt) {
			    var bubble =  new H.ui.InfoBubble(evt.target.getGeometry(), {
			      // read custom data
			      content: evt.target.getData()
			    });
			    // show info bubble
			    ui.addBubble(bubble);
			  }, false);
			  addMarkerToGroup(group, coords, description, color);
			}


		function add_markers(coords, color, description)
		{
			var icon = new H.map.Icon('<?=baseurl()?>/assets/img/'+color+'-marker.png');
			// marker = new H.map.Marker(coords, {icon:icon});
			// map.addObject(marker);
			addInfoBubble(map, coords, color, description);
			map.setCenter(coords);
		}
		window.addEventListener('resize', () => map.getViewPort().resize());
		$('.city-link').click(function(){
			var city = $(this).text();
			if(window.city_name == city)
			{
				alert("The results are already displaying for this city");
				return;
			}
			window.city_name = city;
			console.log(city);
			var donate_url = "<?=baseurl()?>/includes/fetch_donator.php"
			var request_url = "<?=baseurl()?>/includes/fetch_requestor.php"

			// AJAX call for finding donators
			$.ajax({
			    type: 'POST',
			    dataType: 'json',
			    url: donate_url,
			    data:{city:city},
			    success:  function (data) {
			      for(i = 0; i < data.length; i++)
			      {
			      	var description = "<u>Name:</u> "+data[i].user_name+"<br><u>Contact No:</u> "+data[i].user_mobile+" <br><u>Email:</u> "+data[i].user_email + " <br><u>Food providing:</u> "+data[i].description;
			      	add_markers({lat:data[i].latitude, lng: data[i].longitutde}, 'green', description);
			      }
			    },
			    fail: function(data)
			    {
			    	alert("Failed to laod information for the city");
			    }
			});
			// AJAX call for requesters
			$.ajax({
			    type: 'POST',
			    dataType: 'json',
			    url: request_url,
			    data:{city:city},
			    success:  function (data) {
			      for(i = 0; i < data.length; i++)
			      {
			      	var description = data[i].description;
			      	add_markers({lat:data[i].latitude, lng: data[i].longitutde}, 'red', description);
			      }
			    },
			    fail: function(data)
			    {
			    	alert("Failed to load information for the city");
			    }
			});
		})
	</script>
