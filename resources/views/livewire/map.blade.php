<div class="w-full">
    <ul
        class="hidden text-sm font-medium text-center text-gray-500 rounded-lg shadow sm:flex">
        <li class="w-full cursor-pointer">
            <div id="greenhouseTab"
                 class="inline-block w-full p-4 bg-[#258641] text-gray-50 border-gray-200 hover:text-white hover:bg-[#206133] active focus:ring-4 focus:ring-green-300 focus:outline-none rounded-s-lg shadow-lg font-bold text-lg">
                گلخانه
                ها
            </div>
        </li>
        <li class="w-full cursor-pointer">
            <div id="companyTab"
                 class="inline-block w-full p-4 text-gray-900 bg-gray-200 border-gray-200 focus:ring-4 focus:ring-green-300 focus:outline-none rounded-e-lg shadow-lg font-bold text-lg">
                شرکت
                های اتوماسیون گلخانه
            </div>
        </li>
    </ul>

    <div id="map" class="w-full h-[700px] rounded-lg mt-3 border border-[#258641] z-30"></div>

    <link rel="stylesheet" href="./assets/css/map.css">
    <script>
        let greenhouseMarkers = [
                @foreach (App\Models\Greenhouse::all() as $greenhouse)
                @if($greenhouse->active)

            {
                coordinates: [{{ $greenhouse->coordinates }}],
                image: "{{ asset('storage/' . $greenhouse->image) }}",
                name: "{{ $greenhouse->name }}",
                area: "{{ $greenhouse->province }} - {{ $greenhouse->city }}",
                product: "{{ $greenhouse->product_type }} - {{ $greenhouse->substrate_type }}",
                space: "{{ $greenhouse->meterage }}",
                outsideTemp: '-',
                outsideHumidity: '-',
                lightIntensity: '-',
                windSpeed: '-',
                insideTemp: '-',
                insideHumidity: '-',
                company: false
            },
            @endif
            @endforeach
        ];

        let companyMarkers = [
                @foreach (App\Models\Company::all() as $company)
                @if($company->active)

            {
                coordinates: [{{ $company->coordinates }}],
                image: "{{ asset('storage/' . $company->company_logo) }}",
                name: "{{ $company->name }} <br/> {{ $company->type }}",
                area: "{{ $company->province }} - {{ $company->city }} - {{ $company->address }}",
                company: true
            },
            @endif
            @endforeach
        ];
    </script>

</div>
