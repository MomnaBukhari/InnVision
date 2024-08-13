@extends('customer.customerlayout')

@section('title', 'Weather Conditions')

@section('section1')
<div class="container mt-5">
    <h1>Weather Conditions for {{ $branch->name }}</h1>
    <p><strong>Hotel:</strong> {{ $branch->hotel->name }}</p>
    <p><strong>Location:</strong> {{ $branch->address }}</p>

    <div id="weather-info">
        <p>Loading weather information...</p>
    </div>
</div>

@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const branchAddress = "{{ $branch->address }}";
            const weatherContainer = document.getElementById('weather-info');

            const xhr = new XMLHttpRequest();
            xhr.withCredentials = true;

            xhr.addEventListener('readystatechange', function () {
                if (this.readyState === this.DONE) {
                    if (this.status === 200) {
                        const weatherData = JSON.parse(this.responseText);
                        const temp = weatherData.main.temp;
                        const description = weatherData.weather[0].description;
                        const humidity = weatherData.main.humidity;
                        const windSpeed = weatherData.wind.speed;

                        weatherContainer.innerHTML = `
                            <p><strong>Temperature:</strong> ${temp} F</p>
                            <p><strong>Weather:</strong> ${description}</p>
                            <p><strong>Humidity:</strong> ${humidity}%</p>
                            <p><strong>Wind Speed:</strong> ${windSpeed} m/s</p>
                        `;
                    } else {
                        weatherContainer.innerHTML = `<p>Error fetching weather data.</p>`;
                    }
                }
            });

            xhr.open('GET', `https://open-weather13.p.rapidapi.com/city/${branchAddress}/EN`);
            xhr.setRequestHeader('x-rapidapi-key', 'd695ebf6fdmsh591441bcdd71212p108a95jsndb68bd39dd2c');
            xhr.setRequestHeader('x-rapidapi-host', 'open-weather13.p.rapidapi.com');
            xhr.send();
        });
    </script>
@endsection
