<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>3D Model Viewer</title>
    <style>
        body { margin: 0; background-color: #000; }
        canvas { display: block; }

        .button-container {
            position: absolute;
            top: 10px;
            left: 0;
            right: 0;
            display: flex;
            flex-direction: row; /* Align buttons horizontally */
        }
        .button {
            flex-grow: 1; /* Buttons take up equal space */
            background-color: #000; /* Black background */
            color: white; /* White text */
            border: 2px solid white; /* White border */
            padding: 15px 0; /* Padding top and bottom */
            text-align: center; /* Centered text */
            text-decoration: none;
            font-size: 16px;
            cursor: pointer; /* Pointer cursor on hover */
            transition: background-color 0.3s; /* Smooth transition for background color */
        }
        .button:not(:last-child) {
            border-right: none; /* Remove the right border for all but the last button */
        }
        .button:hover {
            background-color: #222; /* Slightly lighter black when hovered over */
        }
        #zoom-controls { position: absolute; top: 10px; left: 10px; }
        .divider {
            width: 100%;
            height: 2px;
            background-color: white;
            position: absolute;
            top: 50px; /* Adjust top position as per your requirement */
        }
        .bottom-section {
            position: absolute;
            top: 400px; /* Adjust top position to be below the divider */
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            flex-direction: row;
            justify-content: space-around;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="button-container">
        <button class="button" onclick="zoomIn()">Zoom In</button>
        <button class="button" onclick="zoomOut()">Zoom Out</button>
        <button class="button" onclick="centerObject()">Default</button>
        <button class="button" onclick="location.reload()">Refresh</button>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r126/three.min.js"></script>
    <script src="https://unpkg.com/three@0.126.0/examples/js/loaders/GLTFLoader.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.101.1/examples/js/controls/OrbitControls.js"></script>

    <script>
        let scene, camera, renderer, controls, model;
        let autoRotateSpeed = 0.2; // Speed of auto-rotation
        let lastTime = 0; // Last time of the animation frame

        function init() {
            scene = new THREE.Scene();
            scene.background = new THREE.Color(0x000000);
            camera = new THREE.PerspectiveCamera(75, window.innerWidth / (window.innerHeight - 52), 0.1, 1000);
            camera.position.set(17, 12, 62);

            renderer = new THREE.WebGLRenderer();
            renderer.setSize(window.innerWidth, window.innerHeight - 52);
            document.body.appendChild(renderer.domElement);

            // Lighting setup
            setupLighting();

            const loader = new THREE.GLTFLoader();
            loader.load('-_Copy.glb', function(gltf) {
                model = gltf.scene;
                scene.add(model);
                centerObject(); // Center and zoom out on the model initially
            }, undefined, function(error) {
                console.error('An error happened', error);
            });

            controls = new THREE.OrbitControls(camera, renderer.domElement);
            controls.enableDamping = true;
            controls.dampingFactor = 0.25;
            controls.rotateSpeed = 0.5;

            animate();
        }

        function setupLighting() {
            const hemiLight = new THREE.HemisphereLight(0xffffff, 0x444444, 0.5);
            hemiLight.position.set(0, 1, 0);
            scene.add(hemiLight);

            // Additional directional lights for 360-degree lighting
            addDirectionalLight(-1, 1, 1, 0.5);
            addDirectionalLight(1, 1, 1, 0.5);
            addDirectionalLight(-1, -1, 1, 0.5);
            addDirectionalLight(1, -1, 1, 0.5);
            addDirectionalLight(1, 1, -1, 0.5);
            addDirectionalLight(-1, 1, -1, 0.5);
        }

        function addDirectionalLight(x, y, z, intensity) {
            const dirLight = new THREE.DirectionalLight(0xffffff, intensity);
            dirLight.position.set(x, y, z);
            scene.add(dirLight);
        }

        function animate(time) {
            requestAnimationFrame(animate);

            const deltaTime = (time - lastTime) / 1000;
            lastTime = time;

            if (model && !controls.enabledDamping) {
                model.rotation.y += autoRotateSpeed * deltaTime;
            }

            controls.update();
            render();
        }

        function render() {
            renderer.render(scene, camera);
        }

        function zoomIn() {
            camera.position.z -= 1; // Decrease the camera's z position to zoom in
        }

        function zoomOut() {
            camera.position.z += 1; // Increase the camera's z position to zoom out
        }

        function centerObject() {
            camera.position.set(17, 12, 62); // Reset camera position
            controls.target.set(0, 0, 0); // Optionally, center the target of the orbit controls
            controls.update(); // Ensure the controls are updated with the new camera position
        }

        function changePage(page) {
            // Handle page change functionality here
            console.log(`Changing to page ${page}`);
        }

        init();
    </script>
</body>
</html>
