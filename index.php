<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.1/mdb.min.css" rel="stylesheet" />
</head>

<body>
    <section class="vh-100">
        <div class="container py-5">
            <div class="row d-flex justify-content-center h-100">
                <h3 class="mb-4 pb-2 fw-normal">Check the weather forecast</h3>

                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="GET">
                    <div class="input-group rounded mb-3">
                        <input type="search" name="location" class="form-control rounded" placeholder="City" aria-label="Search" aria-describedby="search-addon" />
                        <button type="submit" class="btn btn-primary">Check!</button>
                    </div>

                    <div class="mb-4 pb-2">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="units" id="inlineRadio1" value="metric" checked />
                            <label class="form-check-label" for="inlineRadio1">Celsius</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="units" id="inlineRadio2" value="imperial" />
                            <label class="form-check-label" for="inlineRadio2">Fahrenheit</label>
                        </div>
                    </div>
                </form>
                    <div class="container">
                        <div class="row">
                                <?php
                                if (isset($_GET['location']) && (isset($_GET['units']))) {
                                    $location = $_GET['location'];
                                    $units = $_GET['units'];
                                    $apiKey = 'e0816140a2197fd99215952e5b8402e1';
                                    $url = "https://api.openweathermap.org/data/2.5/forecast?q=$location&appid=$apiKey&units=$units";
                                    $response = file_get_contents($url);
                                    $data = json_decode($response);

                                    if ($data) {
                                        $city = $data->city->name;
                                        $country = $data->city->country;

                                        // Group the forecast data by date
                                        $grouped_data = [];
                                        foreach ($data->list as $forecast) {
                                            $date = date('jS F Y', $forecast->dt);
                                            $time = date('h:i A', $forecast->dt);
                                            $grouped_data[$date][] = $forecast;
                                        }
                                ?>
                                        <h4 class="mb-4 pb-2 fw-normal"><?php echo $city; ?>, <?php echo $country; ?></h4>
                                        <?php
                                        foreach ($grouped_data as $date => $daily_forecasts) {
                                            $first_forecast = $daily_forecasts[0]; // Get the first forecast of the day
                                            $icon = $first_forecast->weather[0]->icon;
                                            $description = $first_forecast->weather[0]->description;
                                            $temp = $first_forecast->main->temp;
                                            $feels_like = $first_forecast->main->feels_like;
                                            $temp_min = $first_forecast->main->temp_min;
                                            $temp_max = $first_forecast->main->temp_max;
                                            $humidity = $first_forecast->main->humidity;
                                            $pressure = $first_forecast->main->pressure;
                                        ?>
                                        <div class="col-sm-12 col-md-6 col-lg-4">
                                            <div class="card shadow-0 border mt-4 mb-4">
                                                <div class="card-body p-4">
                                                    <h4 class="mb-1"><?php echo $date; ?> <?php echo $time; ?></h4>
                                                    <p class="mb-2">Temperature: <strong><?php echo $temp; ?></strong></p>
                                                    <p>Feels like: <strong><?php echo $feels_like; ?></strong></p>
                                                    <p>Max: <strong><?php echo $temp_max; ?></strong>, Min: <strong><?php echo $temp_min; ?></strong></p>
                                                    <p>Humidity: <strong><?php echo $humidity; ?></strong></p>
                                                    <p>Pressure: <strong><?php echo $pressure; ?></strong></p>
                                                    <div class="d-flex flex-row align-items-center">
                                                        <p class="mb-0 me-4"><?php echo $description; ?></p>
                                                        <img src="https://openweathermap.org/img/wn/<?php echo $icon; ?>.png" alt="Weather icon">
                                                    </div>
                                                </div>
                                            </div>
                            </div>
                                <?php
                                        }
                                    } else {
                                        echo "<p class='mt-5 has-text-centered'>Location not found.</p>";
                                    }
                                }
                                ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Add MDB JS and FontAwesome at the end of the body tag -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.0/mdb.min.js" integrity="sha512-ohU5Y/sNJ5Jdcpr8KbJTHsWkRoJub1sy85JNNdj6DrpgSkM7+ZwUqKYDTko5CzLgT5gZCC2Nn2k+xy3oknNTg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js" integrity="sha512-H7TrNBvHzcNlvx3h6Jmpw+1hZ6oHmuYxHffG23a2Nc3uU3JwaahcS66K3td+wJ6goz15gC7+7XzCbXbS03jFQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>