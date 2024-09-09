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
    background: #000000;
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
    flex: 2;
    margin-right: 20px;
  }
  .info div {
    font-size: 30px;
    background: #444; /* Dark background color for info items */
    color: white; /* White text color for info items */
    padding: 15px;
    margin-bottom: 10px;
    cursor: pointer; /* Make the div clickable */
  }
  .info div:hover {
  background-color: #555; /* Change background color on hover */
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
    font-size: 30px;
  }
  iframe {
    width: 100%;
    height: 700px;
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
  <div class="info" id="roomInfo"> <!-- Added an id to the info div -->
    <!-- Info divs will be added dynamically here -->
  </div>
  <div class="list">

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
        document.querySelectorAll('#floorNav button').forEach(btn => btn.classList.remove('active'));
        changePage(button, `image.php?image=${floor.path_image}`);
        clearList();
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
async function displayRoomData(data) {
  const container = document.getElementById('roomInfo'); // Get the container where room data will be appended

  // Clear previous content in the container
  container.innerHTML = '';

  // Loop through each room data and create elements for them
  for (const room of data) {
    const { id, name, remask, floor_id, path_image } = room; // Get the path_image
    const roomDiv = document.createElement('div');
    roomDiv.classList.add('room');

    // Replace null values with empty strings
    const displayName = name ?? '';
    const displayRemask = remask ?? '';

    roomDiv.innerHTML = `
      <strong>ห้อง:</strong> ${displayName} ${displayRemask}<br>
    `;

    // Add onclick event to the room div
    roomDiv.addEventListener('click', async () => {
      // You can define the action to be performed when a room is clicked here
      console.log('Room clicked:', displayName);
      // Activate the corresponding floor button
      const floorButton = document.querySelector(`#floorNav button[data-floor-id="${floor_id}"]`);
      if (floorButton) {
        // Remove 'active' class from all buttons
        document.querySelectorAll('#floorNav button').forEach(btn => btn.classList.remove('active'));
        // Add 'active' class to the corresponding button
        floorButton.classList.add('active');
      }
      // Change the page to the path_image associated with the room
      if (path_image) {
        var pageURL = `image.php?image=${path_image}`;
        document.getElementById("pageFrame").src = pageURL;
      } else {
        var pageURL = "404.php";
        document.getElementById("pageFrame").src = pageURL;

      }

      // Fetch timetable data for the room
      try {
        const response = await fetch(`api_timetable.php?action=fetchByName&name=${displayName}`);
        if (!response.ok) {
          throw new Error('Failed to fetch timetable data');
        }
        const timetableData = await response.json();

        if (timetableData[0].path_image) {
          let pageURL_ = timetableData[0].path_image;
          addItemToList('ตารางเรียน', pageURL_);

        }else{
          clearList();
        }
      } catch (error) {
        console.error('Error fetching timetable data:', error);
      }


      
// Replace 'roomIdValue' with the actual room ID you want to fetch teachers for
const roomId = displayName;

// Fetch teacher data based on room ID from the API
fetch(`api_teacher.php?action=fetchByRoomId&room_id=${roomId}`)
  .then(response => response.json())
  .then(data => {
    // Process the fetched data and add teachers to the list
    const listContainer = document.querySelector('.list'); // Get the list container

    // Loop through each teacher data and create elements for them
    data.forEach(teacher => {
      const listItem = document.createElement('div');
      listItem.classList.add('item'); // Add the 'item' class
      listItem.textContent = `${teacher.name ? teacher.name : ''}  ${teacher.phone ? teacher.phone : ''}`; // Set the text content to the teacher's name and phone number

      // Add click event listener to the list item
      listItem.addEventListener('click', () => {
        // You can define the action to be performed when a teacher item is clicked here
        console.log('Teacher clicked:', teacher.name);
        // Example: Open a modal with teacher details, etc.
      });

      // Append the list item to the list container
      listContainer.appendChild(listItem);
    });
  })
  .catch(error => {
    console.error('Error fetching teacher data:', error);
  });


    });


    container.appendChild(roomDiv); // Append the room element to the container

    // If this is the first room, activate its corresponding floor button
    if (container.children.length === 1) {
      const floorButton = document.querySelector(`#floorNav button[data-floor-id="${floor_id}"]`);
      if (floorButton) {
        // Remove 'active' class from all buttons
        document.querySelectorAll('#floorNav button').forEach(btn => btn.classList.remove('active'));
        // Add 'active' class to the corresponding button
        floorButton.classList.add('active');
      }
    }
  }
}
// Function to clear all items in the list
function clearList() {
  const listContainer = document.querySelector('.list'); // Get the list container
  listContainer.innerHTML = ''; // Set innerHTML to empty string to clear all items
}
// Function to add a teacher item to the list
function addTeacherToList(teacher) {
  const listContainer = document.querySelector('.list'); // Get the list container

  // Create a new list item
  const listItem = document.createElement('div');
  listItem.classList.add('item'); // Add the 'item' class
  
  // Set the text content to the teacher's name and phone number
  listItem.textContent = `${teacher.name} - ${teacher.phone}`;

  // Add click event listener to the list item
  listItem.addEventListener('click', () => {
    // You can define the action to be performed when a teacher item is clicked here
    console.log('Teacher clicked:', teacher.name);
    // Example: Open a modal with teacher details, etc.
  });

  // Append the list item to the list container
  listContainer.appendChild(listItem);
}
// Function to add an item to the list
function addItemToList(displayName, path_image) {
  const listContainer = document.querySelector('.list'); // Get the list container
  
  // Clear the list container before adding new items
  listContainer.innerHTML = '';

  // Create a new list item
  const listItem = document.createElement('div');
  listItem.classList.add('item'); // Add the 'item' class
  listItem.textContent = displayName; // Set the text content to the room name
  listItem.addEventListener('click', () => {
    // Change the page to the path_image associated with the room when the item is clicked
    const pageURL = `image.php?image=${path_image}`;
    document.getElementById("pageFrame").src = pageURL;
  });
  listContainer.appendChild(listItem); // Append the list item to the list container
}



function _changePage(url) {
  var buttons = document.querySelectorAll('.nav button');
  buttons.forEach(btn => btn.classList.remove('active')); // Remove 'active' class from all buttons
  button.classList.add('active'); // Add 'active' class to the clicked button
  var pageURL = pageNumber;
  document.getElementById("pageFrame").src = pageURL;

  // Clear items in the info div
  var infoDiv = document.getElementById('roomInfo');
  infoDiv.innerHTML = ''; // Clear the content
}

function changePage(button, pageNumber) {
  var buttons = document.querySelectorAll('.nav button');
  buttons.forEach(btn => btn.classList.remove('active')); // Remove 'active' class from all buttons
  button.classList.add('active'); // Add 'active' class to the clicked button
  var pageURL = pageNumber;
  document.getElementById("pageFrame").src = pageURL;

  // Clear items in the info div
  var infoDiv = document.getElementById('roomInfo');
  infoDiv.innerHTML = ''; // Clear the content
}


// Trigger click event on the "home" button when the page loads
document.addEventListener("DOMContentLoaded", function() {
  document.getElementById("home").click();
});

</script>


</body>
</html>
