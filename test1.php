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
    height: 900px;
  }
</style>
</head>
<body>

<div class="header">
  <iframe id="pageFrame" src="3d.php" frameborder="0"></iframe>
</div>

<div class="nav">
<button onclick="changePage('3d.php')">3D Model</button>
  <button onclick="changePage('image.php?image=uploads/f1.png')">Floor 1</button>
  <button onclick="changePage('image.php?image=uploads/f2.png')">Floor 2</button>
  <button onclick="changePage('image.php?image=uploads/f3.png')">Floor 3</button>
</div>

<div class="content">
  <div class="info">
    <div>Info Item 1</div>
    <div>Info Item 2</div>
    <div>Info Item 3</div>
    <div>Info Item 4</div>
  </div>
  <div class="list">
    <div class="item">List Item 1</div>
    <div class="item">List Item 2</div>
  </div>
</div>

<script>
  function changePage(pageNumber) {
    var pageURL =  pageNumber;
    document.getElementById("pageFrame").src = pageURL;
  }
</script>

</body>
</html>
