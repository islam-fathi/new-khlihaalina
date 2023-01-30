@extends('layouts.front-end.app')

@section('title',\App\CPU\translate('My Address'))

@push('css_or_js')
    <link rel="stylesheet" media="screen"
          href="{{asset('public/assets/front-end')}}/vendor/nouislider/distribute/nouislider.min.css"/>

    <style>
        .headerTitle {
            font-size: 24px;
            font-weight: 600;
            margin-top: 1rem;
        }

        body {
            font-family: 'Titillium Web', sans-serif
        }

        .product-qty span {
            font-size: 14px;
            color: #6A6A6A;
        }

        .font-nameA {

            display: inline-block;
            margin-top: 5px !important;
            font-size: 13px !important;
            color: #030303;
        }

        .font-name {
            font-weight: 600;
            font-size: 15px;
            padding-bottom: 6px;
            color: #030303;
        }

        .modal-footer {
            border-top: none;
        }

        .cz-sidebar-body h3:hover + .divider-role {
            border-bottom: 3px solid {{$web_config['primary_color']}} !important;
            transition: .2s ease-in-out;
        }

        label {
            font-size: 15px;
            margin-bottom: 8px;
            color: #030303;

        }

        .nav-pills .nav-link.active {
            box-shadow: none;
            color: #ffffff !important;
        }

        .modal-header {
            border-bottom: none;
        }

        .nav-pills .nav-link {
            padding-top: .575rem;
            padding-bottom: .575rem;
            background-color: #ffffff;
            color: #050b16 !important;
            font-size: .9375rem;
            border: 1px solid #e4dfdf;
        }

        .nav-pills .nav-link :hover {
            padding-top: .575rem;
            padding-bottom: .575rem;
            background-color: #ffffff;
            color: #050b16 !important;
            font-size: .9375rem;
            border: 1px solid #e4dfdf;
        }

        .nav-pills .nav-link.active, .nav-pills .show > .nav-link {
            color: #fff;
            background-color: {{$web_config['primary_color']}};
        }

        .iconHad {
            color: {{$web_config['primary_color']}};
            padding: 4px;
        }

        .iconSp {
            margin-top: 0.70rem;
        }

        .fa-lg {
            padding: 4px;
        }

        .fa-trash {
            color: #FF4D4D;
        }

        .namHad {
            color: #030303;
            position: absolute;
            padding-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}: 13px;
            padding-top: 8px;
        }

        .donate-now {
            list-style-type: none;
            margin: 25px 0 0 0;
            padding: 0;
        }

        .donate-now li {
            float: left;
            margin: {{Session::get('direction') === "rtl" ? '0 0 0 5px' : '0 5px 0 0'}};
            width: 100px;
            height: 40px;
            position: relative;
            padding: 22px;
            text-align: center;
        }

        .donate-now label,
        .donate-now input {
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

        .donate-now input[type="radio"] {
            opacity: 0.01;
            z-index: 100;
        }

        .donate-now input[type="radio"]:checked + label,
        .Checked + label {
            background: {{$web_config['primary_color']}};
            color: white !important;
            border-radius: 7px;
        }

        .donate-now label {
            padding: 5px;
            border: 1px solid #CCC;
            cursor: pointer;
            z-index: 90;
        }

        .donate-now label:hover {
            background: #DDD;
        }

        #edit{
            cursor: pointer;
        }
        .pac-container { z-index: 100000 !important; }

        @media (max-width: 600px) {
            .sidebar_heading h1 {
                text-align: center;
                color: aliceblue;
                padding-bottom: 17px;
                font-size: 19px;
            }
        }
        #location_map_canvas{
            height: 100%;
        }
        @media only screen and (max-width: 768px) {
            /* For mobile phones: */
            #location_map_canvas{
                height: 200px;
            }
        }
    </style>
@endpush

@section('content')
<div class="container pb-5 mb-2 mb-md-4 mt-3 rtl" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
    <div class="row">
        <!-- Sidebar-->
    @include('web-views.partials._profile-aside')
    <section class="col-lg-9 mt-3 col-md-9">
        <div class="row">
            <div class="col-lg-12 col-md-12  d-flex justify-content-between overflow-hidden">
                <div class="col-md-4">
                    <h1 class="h3  mb-0 folot-left headerTitle">{{\App\CPU\translate('UPDATE_ADDRESSES')}}</h1>
                </div>
            </div>
        </div>

            <div class="card">
                <div class="card-body">
                    <div class="col-12">
                        <form action="{{route('address-update')}}" method="post">
                            @csrf
                            <div class="row pb-1">
                                <div class="col-md-6" style="display: flex">
                                    <!-- Nav pills -->
                                    <input type="hidden" name="id" value="{{$shippingAddress->id}}">
                                    <ul class="donate-now">
                                        <li class="address_type_li">
                                            <input type="radio" class="address_type" id="a25" name="addressAs" value="permanent"  {{ $shippingAddress->address_type == 'permanent' ? 'checked' : ''}} />
                                            <label for="a25" class="component">{{\App\CPU\translate('permanent')}}</label>
                                        </li>
                                        <li class="address_type_li">
                                            <input type="radio" class="address_type" id="a50" name="addressAs" value="home" {{ $shippingAddress->address_type == 'home' ? 'checked' : ''}} />
                                            <label for="a50" class="component">{{\App\CPU\translate('Home')}}</label>
                                        </li>
                                        <li class="address_type_li">
                                            <input type="radio" class="address_type" id="a75" name="addressAs" value="office" {{ $shippingAddress->address_type == 'office' ? 'checked' : ''}}/>
                                            <label for="a75" class="component">{{\App\CPU\translate('Office')}}</label>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6" style="display: flex">
                                    <!-- Nav pills -->
                                    <input type="hidden" id="is_billing" value="{{$shippingAddress->is_billing}}">
                                    <ul class="donate-now">
                                        <li class="address_type_bl">
                                            <input type="radio" class="bill_type" id="b25" name="is_billing" value="0"  {{ $shippingAddress->is_billing == '0' ? 'checked' : ''}} />
                                            <label for="b25" class="component">{{\App\CPU\translate('shipping')}}</label>
                                        </li>
                                        <li class="address_type_bl">
                                            <input type="radio" class="bill_type" id="b50" name="is_billing" value="1" {{ $shippingAddress->is_billing == '1' ? 'checked' : ''}} />
                                            <label for="b50" class="component">{{\App\CPU\translate('billing')}}</label>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                            <!-- Tab panes -->
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="person_name">{{\App\CPU\translate('contact_person_name')}}</label>
                                    <input class="form-control" type="text" id="person_name"
                                        name="name"
                                        value="{{$shippingAddress->contact_person_name}}"
                                        required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="own_phone">{{\App\CPU\translate('Phone')}}</label>
                                    <input class="form-control" type="text" id="own_phone" name="phone" value="{{$shippingAddress->phone}}" required="required">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="city">{{\App\CPU\translate('City')}}</label>

                                    <input class="form-control" type="text" id="city" name="city" value="{{$shippingAddress->city}}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="zip_code">{{\App\CPU\translate('zip_code')}}</label>
                                    <input class="form-control" type="number" id="zip_code" name="zip" value="{{$shippingAddress->zip}}" required>
                                </div>
                            </div>
                            {{-- <div class="form-row">
                                <div class="form-group col-md-6">
                                <label for="own_state">{{\App\CPU\translate('State')}}</label>
                                    <input type="text" class="form-control" name="state" value="{{ $shippingAddress->state }}" id="own_state"  placeholder="" required>
                                </div>
                                <div class="form-group col-md-6">
                                <label for="own_country">{{\App\CPU\translate('Country')}}</label>
                                    <input type="text" class="form-control" id="own_country" name="country" value="{{ $shippingAddress->country }}" placeholder="" required>
                                </div>
                            </div> --}}
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="own_address">{{\App\CPU\translate('address')}}</label>
                                    <textarea class="form-control" id="address"
                                        type="text"  name="address" required>{{$shippingAddress->address}}</textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <input id="pac-input" class="controls rounded" style="height: 3em;width:fit-content;" title="{{\App\CPU\translate('search_your_location_here')}}" type="text" placeholder="{{\App\CPU\translate('search_here')}}"/>
                                    <div style="height: 200px;" id="location_map_canvas"></div>
                                </div>
                            </div>
                            @php($shipping_latitude=$shippingAddress->latitude)
                            @php($shipping_longitude=$shippingAddress->longitude)
                            <input type="hidden" id="latitude"
                                name="latitude" class="form-control d-inline"
                                placeholder="Ex : -94.22213" value="{{$shipping_latitude??0}}" required readonly>
                            <input type="hidden"
                                name="longitude" class="form-control"
                                placeholder="Ex : 103.344322" id="longitude" value="{{$shipping_longitude??0}}" required readonly>
                            <div class="modal-footer">
                                <button type="button" class="closeB btn btn-secondary" data-dismiss="modal">{{\App\CPU\translate('close')}}</button>
                                <button type="submit" class="btn btn-primary">{{\App\CPU\translate('update')}}  </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

    </section>
</div>
@endsection

@push('script')
<script src="https://maps.googleapis.com/maps/api/js?key={{\App\CPU\Helpers::get_business_settings('map_api_key')}}&libraries=places&v=3.45.8"></script>
<script>

    function initAutocomplete() {
        var myLatLng = { lat: {{$shipping_latitude??'-33.8688'}}, lng: {{$shipping_longitude??'151.2195'}} };

        const map = new google.maps.Map(document.getElementById("location_map_canvas"), {
            center: { lat: {{$shipping_latitude??'-33.8688'}}, lng: {{$shipping_longitude??'151.2195'}} },
            zoom: 13,
            mapTypeId: "roadmap",
        });

        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
        });

        marker.setMap( map );
        var geocoder = geocoder = new google.maps.Geocoder();
        google.maps.event.addListener(map, 'click', function (mapsMouseEvent) {
            var coordinates = JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2);
            var coordinates = JSON.parse(coordinates);
            var latlng = new google.maps.LatLng( coordinates['lat'], coordinates['lng'] ) ;
            marker.setPosition( latlng );
            map.panTo( latlng );

            document.getElementById('latitude').value = coordinates['lat'];
            document.getElementById('longitude').value = coordinates['lng'];

            geocoder.geocode({ 'latLng': latlng }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[1]) {
                        document.getElementById('address').value = results[1].formatted_address;
                        console.log(results[1].formatted_address);
                    }
                }
            });
        });

        // Create the search box and link it to the UI element.
        const input = document.getElementById("pac-input");
        const searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);
        // Bias the SearchBox results towards current map's viewport.
        map.addListener("bounds_changed", () => {
            searchBox.setBounds(map.getBounds());
        });
        let markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener("places_changed", () => {
            const places = searchBox.getPlaces();

            if (places.length == 0) {
            return;
            }
            // Clear out the old markers.
            markers.forEach((marker) => {
            marker.setMap(null);
            });
            markers = [];
            // For each place, get the icon, name and location.
            const bounds = new google.maps.LatLngBounds();
            places.forEach((place) => {
                if (!place.geometry || !place.geometry.location) {
                    console.log("Returned place contains no geometry");
                    return;
                }
                var mrkr = new google.maps.Marker({
                    map,
                    title: place.name,
                    position: place.geometry.location,
                });

                google.maps.event.addListener(mrkr, "click", function (event) {
                    document.getElementById('latitude').value = this.position.lat();
                    document.getElementById('longitude').value = this.position.lng();

                });

                markers.push(mrkr);

                if (place.geometry.viewport) {
                    // Only geocodes have viewport.
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
            });
            map.fitBounds(bounds);
        });
    };
    $(document).on('ready', function () {
        initAutocomplete();

    });

    $(document).on("keydown", "input", function(e) {
      if (e.which==13) e.preventDefault();
    });
</script>
@endpush
