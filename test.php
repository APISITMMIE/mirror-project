<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Page HTML Load</title>
<style>
  body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background: #f4f4f4;
  }
  .header {
    background: #333; /* Dark background color */
    color: #fff; /* White text color */
    padding: 20px;
    text-align: center;
  }
  .nav {
    background: #222; /* Dark background color for navigation */
    padding: 10px;
    text-align: center;
    width: 100%; /* Full width */
    display: flex; /* Use flexbox */
    justify-content: space-around; /* Distribute items evenly */
  }
  .nav button {
    background: #444; /* Dark background color for buttons */
    border: none;
    color: white;
    padding: 10px 20px;
    margin: 5px;
    cursor: pointer;
    width: 100%;
    font-size: 30px;
  }
  .nav button.active {
    background: #666; /* Change background color for active button */
  }
  .content {
    display: flex;
    padding: 20px;
  }
  .info {
    flex: 1;
    margin-right: 20px;
  }
  .info div {
    background: #444; /* Dark background color for info items */
    color: white; /* White text color for info items */
    padding: 15px;
    margin-bottom: 10px;
  }
  .list {
    flex: 2;
    background: #666; /* Dark background color for list section */
    padding: 15px;
  }
  .list .item {
    background: #444; /* Dark background color for list items */
    color: white; /* White text color for list items */
    padding: 10px;
    margin-bottom: 10px;
  }
  iframe {
    width: 100%;
    height: 1300px;
  }
</style>
</head>
<body>

<div class="header">
  <iframe id="pageFrame" src="3d-buiding.php" frameborder="0"></iframe>
</div>

<div class="nav" id="floorNav">
<button id="home" onclick="changePage(this, '3d-buiding.php')">3D Model</button>

</div>

<div class="content">
  <div class="info">
  <div>Info Item 1</div>
  </div>
  <div class="list">
    <div class="item">List Item 1</div>
    <div class="item">List Item 2</div>
  </div>
</div>
<?php include 'layouts/vendor-scripts.php'; ?>
<script>
// Fetch floor data from the API
fetch('api_floor.php?action=fetch')
  .then(response => response.json())
  .then(data => {
    // Process the fetched data
    createFloorButtons(data);
  })
  .catch(error => {
    console.error('Error fetching floor data:', error);
  });

// Function to create floor navigation buttons
function createFloorButtons(data) {
  const floorNav = document.getElementById('floorNav');

  // Check if data is available
  if (data && data.rows && data.rows.length > 0) {
    // Loop through each floor and create a button
    data.rows.forEach(floor => {
      const button = document.createElement('button');
      button.textContent = `Floor ${floor.name}`;
      button.onclick = () => {
        // Remove active class from all buttons
        document.querySelectorAll('.nav button').forEach(btn => btn.classList.remove('active'));
        // Add active class to the clicked button
        button.classList.add('active');
        // Fetch and display room data for the clicked floor
        fetchAndDisplayRoomData(floor.floor_id); // Use floor.floor_id instead of floor.id
      };
      floorNav.appendChild(button);
    });
  } else {
    floorNav.textContent = 'No floor data available.';
  }
}

// Function to fetch and display room data for a specific floor
function fetchAndDisplayRoomData(floorId) {
  fetch(`api_room.php?action=getById&floor_id=${floorId}`)
    .then(response => response.json())
    .then(data => {
      // Process the fetched data
      displayRoomData(data);
    })
    .catch(error => {
      console.error(`Error fetching room data for floor ${floorId}:`, error);
    });
}

// Function to display room data by creating elements dynamically
function displayRoomData(data) {
  const container = document.querySelector('.info'); // Get the container where room data will be appended

  // Clear previous content in the container
  container.innerHTML = '';

  // Loop through each room data and create elements for them
  data.forEach(room => {
    const { name, remark } = room;
    const roomDiv = document.createElement('div');
    roomDiv.classList.add('room');

    roomDiv.innerHTML = `
      <strong>Name:</strong> ${name}<br>
      <strong>Remark:</strong> ${remark}<br>
      <button class="roomButton">Action</button>
    `;

    container.appendChild(roomDiv); // Append the room element to the container
  });
}


function changePage(button, pageNumber) {
  var buttons = document.querySelectorAll('.nav button');
  buttons.forEach(btn => btn.classList.remove('active')); // Remove 'active' class from all buttons
  button.classList.add('active'); // Add 'active' class to the clicked button
  var pageURL = pageNumber;
  document.getElementById("pageFrame").src = pageURL;
}

// Trigger click event on the "home" button when the page loads
document.addEventListener("DOMContentLoaded", function() {
  document.getElementById("home").click();
});

</script>


</body>
</html>
