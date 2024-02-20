const contactForm = document.getElementById("contact-form");
const loadingSpinner = document.getElementById("ring");

document.addEventListener("DOMContentLoaded", function () {
  loadingSpinner.style.display = "none";
  const nameInput = document.getElementById("name");
  const emailInput = document.getElementById("email");
  const messageTextarea = document.getElementById("message");

  const createLabelWithTransition = (inputElement) => {
    const label = inputElement.parentElement.querySelector("label");
    label.innerHTML = "";

    for (let i = 0; i < inputElement.name.length; i++) {
      const span = document.createElement("span");
      span.style.transitionDelay = i * 50 + "ms";
      span.textContent = i === 0 ? inputElement.name[i].toUpperCase() : inputElement.name[i];
      label.appendChild(span);
    }
    inputElement.addEventListener("input", () => { label.classList.toggle("active", inputElement.value !== ""); });
  };

  const body = document.getElementById('theme');
  const themeCheckbox = document.getElementById('themeCheckbox');
  themeCheckbox.addEventListener('change', function () {
      body.classList.toggle('light-mode');
      const selectedTheme = body.classList.contains('light-mode') ? 'light-mode' : '';
      document.cookie = 'selectedTheme=' + selectedTheme + '; max-age=' + 3600 * 24 * 30;
  });

  const radioButtons = document.querySelectorAll(".radio");
  const projectItems = document.querySelectorAll(".project");
  console.log(projectItems);

  radioButtons.forEach(radio => {
    radio.addEventListener("click", () => {
      const selectedCategory = document.querySelector('input[name="radio"]:checked').getAttribute("category");
  
      projectItems.forEach(project => {
        const projectCategory = project.getAttribute("category");
  
        if (selectedCategory === "all" || selectedCategory === projectCategory) {
          project.style.display = "block";
        } else {
          project.style.display = "none";
        }
      });
    });
  });
  
  contactForm.addEventListener("submit", async function (e) {
    e.preventDefault();

    const nameValue = nameInput.value;
    const emailValue = emailInput.value;
    const namePattern = /^[A-Za-z\s]+$/;
    const emailPattern = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/;

    if (!namePattern.test(nameValue)) {
      alert("Name must contain only letters (A-Z and a-z).");
      nameInput.focus();
      return;
    }
    if (!emailPattern.test(emailValue)) {
      alert("Invalid email address.");
      emailInput.focus();
      return;
    }

    contactForm.style.display = "none";
    loadingSpinner.style.display = "block";

    const formData = new FormData(contactForm);

    try {
      const response = await fetch("process_contact.php", {
        method: "POST",
        body: formData,
      });

      if (response.ok) {
        const data = await response.json();
        if (data.success) {
          await new Promise((resolve) => setTimeout(resolve, 2000));
          contactForm.reset();
        }  else { alert("Error: " + data.message); }
      } else { alert("Error: Server response was not OK"); }
    } catch (error) {
      alert("Error: " + error.message);
    } finally {
      loadingSpinner.style.display = "none";
      contactForm.style.display = "block";
    }
  });

  createLabelWithTransition(nameInput);
  createLabelWithTransition(emailInput);
  createLabelWithTransition(messageTextarea);
});

let map;
async function initMap() {
  const position = { lat: -25.344, lng: 131.031 };
  // Request the necessary library
  const script = document.createElement("script");
  script.src = `https://maps.googleapis.com/maps/api/js?key=AIzaSyCtme10pzgKSPeJVJrG1O3tjR6lk98o4w8&callback=loadMap`;
  document.body.appendChild(script);
  script.addEventListener("error", () => { console.error("Failed to load Google Maps API."); });
}

function loadMap() {
  const position = { lat: -25.344, lng: 131.031 };
  const mapOptions = { zoom: 4, center: position };

  // Create the map
  map = new google.maps.Map(document.getElementById("map"), mapOptions);
  new google.maps.Marker({
    position: position,
    map: map,
    title: "Uluru",
  });
}

initMap();