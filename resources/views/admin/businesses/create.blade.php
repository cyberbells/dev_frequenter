@extends('admin.layouts.master')
@section('title', 'Business Create')
@section('content')
<style>
  /* upload images css */
img.preview-image{
    object-fit: cover;
}
.cursor-pointer{
cursor: pointer;
}
</style>

 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Business</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Business Create</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">



      <!--begin::App Content-->
      <div class="app-content">
      @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
      @endif
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Form Validation-->
        <div class="card card-info card-outline mb-4">
          <!--begin::Header-->
          <div class="card-header"><div class="card-title">Business Create</div></div>
          <!--end::Header-->
          <!--begin::Form-->
          <form action="{{route('businesses.store')}}" method="post" class="needs-validation" novalidate enctype="multipart/form-data">
          @csrf
            <!--begin::Body-->
            <div class="card-body">
              <!--begin::Row-->
              <div class="row g-3">
                <!--begin::Col-->
                <div class="col-md-4 form-group">
                  <label for="name" class="form-label">Name</label>
                  <input
                    type="text"
                    class="form-control"
                    id="name"
                    name="name"
                    value=""
                    required
                  />
                  <div class="valid-feedback">Looks good!</div>
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-md-4 form-group">
                    <label for="validationCustomUsername" class="form-label">Email Address</label>
                  <div class="input-group has-validation">
                    <span class="input-group-text" id="email">@</span>
                    <input
                      type="email"
                      name="email"
                      class="form-control"
                      id="validationCustomUsername"
                      aria-describedby="email"
                      required
                    />
                    @error('email')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="invalid-feedback">Email should be unique.</div>
                  </div>
                </div>

                <!--begin::Col-->
                <div class="col-md-4 form-group">
                    <label for="password" class="form-label">Password</label>
                  <div class="input-group has-validation">
                    <input
                      type="password"
                      name="password"
                      class="form-control"
                      id="password"
                      required
                    />
                    <div class="invalid-feedback">Create valid password</div>
                  </div>
                </div>

                <!--begin::Col-->
                <div class="col-md-4 form-group">
                    <label for="mobileNumber" class="form-label">Mobile</label>
                    <input 
                        type="tel" 
                        class="form-control" 
                        id="mobileNumber" 
                        name="mobile" 
                        pattern="^\d{10,15}$" 
                        placeholder="Enter your mobile number"
                        required 
                    />
                    <div class="valid-feedback">Looks good!</div>
                    <div class="invalid-feedback">Please enter a valid mobile number (10-15 digits).</div>
                </div>

                <div class="col-md-4 form-group">
                  <label for="category" class="form-label">Category</label>
                  <input
                    type="text"
                    class="form-control"
                    id="category"
                    name="category"
                    value=""
                    required
                  />
                  <div class="valid-feedback">Looks good!</div>
                </div>

                <div class="col-md-4 form-group">
                  <label for="website" class="form-label">Website <small class="text-muted">(e.g., https://www.example.com)</small></label>
                  <input
                    type="text"
                    class="form-control"
                    id="website"
                    name="website"
                    value=""
                    placeholder="https://www.example.com/"
                  />
                  @error('website')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                  <div class="valid-feedback">Looks good!</div>
                </div>
                <!--end::Col-->

                <div class="col-md-4  mb-3">
                    <label for="images" class="form-label">Upload Images</label>
                    <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*">
                      
                </div>
                <!-- images upload -->
                  <div class="col-md-12 text-center">
                      <div id="image-preview" class="mt-3"></div>
                  </div>

                

                <!--end::Col-->
                <div class="col-md-12 mb-3">
                  <label for="description" class="form-label">Description</label>
                  <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>
                <div class="col-12 form-group">
                    <label for="inputAddress" class="form-label">Address</label>
                    <input type="text" name="address1" class="form-control" id="inputAddress" placeholder="1234 Main St">
                </div>
                <div class="col-12 form-group">
                    <label for="inputAddress2" class="form-label">Address 2</label>
                    <input type="text" name="address2" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
                </div>
                
                
                <!-- <div class="col-md-3">
                    <label for="inputState" class="form-label">State</label>
                    <input type="text" name="state" class="form-control" id="inputState">
                </div>
                <div class="col-md-3">
                    <label for="inputCity" class="form-label">City</label>
                    <input type="text" name="city" class="form-control" id="inputCity">
                </div> -->

                <div class="col-md-3 form-group">
                  <label for="inputState" class="form-label">State</label>
                    <select id="inputState" name="state" class="form-control">
                      <option value="">Select State</option>
                    </select>
                </div>

                <div class="col-md-3 form-group">
                  <label for="inputCity" class="form-label">City</label>
                    <select id="inputCity" name="city" class="form-control">
                      <option value="">Select City</option>
                    </select>
                </div>

                <div class="col-md-3 form-group">
                    <label for="inputZip" class="form-label">Zip</label>
                    <input type="text" name="zip_code" class="form-control" id="inputZip">
                </div>

                <!-- <div class="col-md-3 form-group">
                    <label for="inputCountry" class="form-label">Country</label>
                    <input type="text" name="country" class="form-control" id="inputCountry">
                </div> -->

                <div class="col-md-3 form-group">
                  <label for="inputCountry" class="form-label">Country</label>
                    <select id="inputCountry" name="country" class="form-control">
                      <option value="">Select Country</option>
                    </select>
                </div>

                <div class="col-md-3 form-group">
                    <label for="latitude" class="form-label">Latitude</label>
                    <input type="text" name="latitude" class="form-control" id="latitude">
                </div>

                <div class="col-md-3 form-group">
                    <label for="longitude" class="form-label">Longitude</label>
                    <input type="text" name="longitude" class="form-control" id="longitude">
                </div>

                <!--end::Col-->
              </div>
              <!--end::Row-->
              </br>

              <!-- Business Hours Table -->
              <div id="business-hours-section">
                <h4>Business Hours</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Day</th>
                            <th class="text-center">Open Time</th>
                            <th class="text-center">Close Time</th>
                            <th class="text-center">Closed?</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                        @endphp
                        @foreach($days as $key => $day)
                        <tr>
                            <td>{{ $day }}</td>
                            <td>
                                <input type="time" name="business_hours[{{ $key }}][open_time]" class="form-control open-time" required>
                            </td>
                            <td>
                                <input type="time" name="business_hours[{{ $key }}][close_time]" class="form-control close-time" required>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" name="business_hours[{{ $key }}][is_closed]" class="closed-checkbox" value="1">
                            </td>
                            <input type="hidden" name="business_hours[{{ $key }}][day_of_week]" value="{{ strtolower($day) }}">
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="button" id="copy-monday" class="btn btn-dark">Copy Monday’s Hours to All</button>
            </div>
            <!-- End Business Hours Table -->


            </div>
            <!--end::Body-->
            <!--begin::Footer-->
            <div class="card-footer">
              <button class="btn btn-info" type="submit">Create Business</button>
            </div>
            <!--end::Footer-->
          </form>
          <!--end::Form-->
          <!--begin::JavaScript-->
          <script>
            // Example starter JavaScript for disabling form submissions if there are invalid fields
            (() => {
              'use strict';

              // Fetch all the forms we want to apply custom Bootstrap validation styles to
              const forms = document.querySelectorAll('.needs-validation');

              // Loop over them and prevent submission
              Array.from(forms).forEach((form) => {
                form.addEventListener(
                  'submit',
                  (event) => {
                    if (!form.checkValidity()) {
                      event.preventDefault();
                      event.stopPropagation();
                    }

                    form.classList.add('was-validated');
                  },
                  false,
                );
              });
            })();
          </script>
          <!--end::JavaScript-->
        </div>
        <!--end::Form Validation-->

    </div>
    <!--end::Row-->
</div>
<!--end::Container-->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection