  var selectedState;
  var selectedCountry;
  // Fetch states when page load
  fetch('/api/states')
  .then(response => response.json())
  .then(data => {
      let dropdown = $('#inputState');
      dropdown.empty(); // Clear previous options
      dropdown.append('<option value="">Select State</option>');

      data.data.forEach(state => {
          let option = $('<option></option>').attr('value', state.state).text(state.state);
          if (state.state === selectedState) {
              option.attr('selected', 'selected'); // Set selected if it matches
          }
          dropdown.append(option);
      });
  });

  // Fetch cities based on selected state
  document.getElementById('inputState').addEventListener('change', function () {
    let state = this.value;
    fetch(`/api/cities/filter?state=${state}`)
        .then(response => response.json())
        .then(data => {
            let dropdown = document.getElementById('inputCity');
            dropdown.innerHTML = '<option value="">Select City</option>';
            data.data.forEach(city => {
                let option = document.createElement('option');
                option.value = city.city_name;
                option.textContent = city.city_name;
                dropdown.appendChild(option);
            });
        });
  });


  // Auto selected City using State name
  window.onload = function () {
    let stateDropdown = document.getElementById('inputState');
    let cityDropdown = document.getElementById('inputCity');
    if (!stateDropdown) {
      console.error("Error: #inputState dropdown not found.");
      return;
    }

    let state = selectedState;
    console.log('state',state);
    fetch(`/api/cities/filter?state=${state}`)
      .then(response => response.json())
      .then(data => {
          cityDropdown.innerHTML = '<option value="">Select City</option>';
          data.data.forEach(city => {
            let option = document.createElement('option');
            option.value = city.city_name;
            option.textContent = city.city_name;
            //Set the selected city if it matches
            if (city.city_name === selectedCity) {
              option.selected = true;
            }
            cityDropdown.appendChild(option);
          });
      })
      .catch(error => console.error("Error fetching cities:", error));
  };

  // Fetch Countries
  fetch('/api/countries')
    .then(response => response.json())
    .then(data => {
      let dropdown = $('#inputCountry');
      dropdown.empty(); // Clear previous options
      dropdown.append('<option value="">Select State</option>');

      data.data.forEach(country => {
          let option = $('<option></option>').attr('value', country.country).text(country.country);
          if (country.country === selectedCountry) {
              option.attr('selected', 'selected'); // Set selected if it matches
          }
          dropdown.append(option);
      });
   });

  // Preview Uploaded Images 
  // document.getElementById('images').addEventListener('change', function(event) {
  //   let previewContainer = document.getElementById('image-preview');
  //   previewContainer.innerHTML = ""; // Clear previous images
  //   Array.from(event.target.files).forEach(file => {
  //       let reader = new FileReader();
  //       reader.onload = function(e) {
  //           let imgElement = document.createElement("img");
  //           imgElement.className = 'preview-image border border-dark rounded';
  //           imgElement.src = e.target.result;
  //           imgElement.style.width = "100px";
  //           imgElement.style.height = "100px";
  //           imgElement.style.margin = "5px";
  //           previewContainer.appendChild(imgElement);
  //       };
  //       reader.readAsDataURL(file);
  //   });
  // });

  document.querySelectorAll('#images, #profile_image').forEach(function(element) {
    element.addEventListener('change', function(event) {
        console.log(event.target.id + ' changed!');
        let previewContainer = document.getElementById('image-preview');
        previewContainer.innerHTML = ""; // Clear previous images
        Array.from(event.target.files).forEach(file => {
            let reader = new FileReader();
            reader.onload = function(e) {
                let imgElement = document.createElement("img");
                imgElement.className = 'preview-image border border-dark rounded';
                imgElement.src = e.target.result;
                imgElement.style.width = "100px";
                imgElement.style.height = "100px";
                imgElement.style.margin = "5px";
                previewContainer.appendChild(imgElement);
            };
            reader.readAsDataURL(file);
        });
    });
  });


  // Preview Quick View Images
  $(document).ready(function () {
    $(".preview-image").click(function () {
      var src = $(this).attr("data-src");
      $("#previewImage").attr("src", src);
      $("#imagePreviewModal").fadeIn();
    });

    $("#imagePreviewModal").click(function () {
      $(this).fadeOut();
    });

    // Copy Monday's hours to all days
    $("#copy-monday").click(function () {
        let mondayOpen = $("input[name='business_hours[0][open_time]']").val();
        let mondayClose = $("input[name='business_hours[0][close_time]']").val();
        
        $(".open-time").each(function (index) {
            if (index !== 0) { // Skip Monday itself
                $(this).val(mondayOpen);
            }
        });

        $(".close-time").each(function (index) {
            if (index !== 0) { // Skip Monday itself
                $(this).val(mondayClose);
            }
        });
    });

    // Disable time inputs if closed checkbox is checked
    $(".closed-checkbox").change(function () {
        let row = $(this).closest("tr");
        if ($(this).is(":checked")) {
            row.find(".open-time, .close-time").prop("disabled", true).val('');
        } else {
            row.find(".open-time, .close-time").prop("disabled", false);
        }
    });
  });
