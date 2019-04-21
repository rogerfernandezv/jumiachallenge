<?php

require_once(__DIR__  . "/../vendor/autoload.php");

use Jumia\Action\CustomerAction;

/** @var CustomerAction $action */
$action = new CustomerAction();

// Check variables from POST
$state = !empty($_POST['state']) ? $_POST['state'] : null;
$countryCode = !empty($_POST['country']) ? $_POST['country'] : null;

if (empty($state) && empty($countryCode)) {
    $phones = $action->getPhones();
} else {
    $phones = $action->searchBy(['state'=> $state, 'countryCode' => $countryCode]);
}

/** @var array $countries */
$countries = $action->getCountries();

?>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <title>Jumia Phones</title>
    </head>
    <body>
        <br>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card card-default">
                        <div class="card-header">
                            <img src="https://ng.jumia.is/cms/jumialogonew.png" class="logo">
                            Phones
                        </div>
                        <div class="card-body">
                            <form method="post" action="index.php">
                            <div class="row">
                                <div class="col">
                                    <select class="form-control" name="country">
                                        <option value="">Select Country</option>
                                        <?php foreach ($countries as $country) :?>
                                            <option value="<?php echo $country['code']; ?>"><?php echo $country['desc']; ?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <div class="col">
                                    <div class="row">
                                        <div class="col-8">
                                            <select class="form-control" name="state">
                                                <option value="">Select State</option>
                                                <option value="ok">Valid phone numbers</option>
                                                <option value="nok">Invalid Phone numbers</option>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <button type="submit" class="btn-primary">Filter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>
                            <br>
                            <table class="table">
                                <thead>
                                    <th>Country</th>
                                    <th>State</th>
                                    <th>Country Code</th>
                                    <th>Phone number</th>
                                </thead>
                                <tbody>

                                <?php foreach ($phones as $phone):?>
                                <tr>
                                    <td><?php echo $phone['desc']; ?></td>
                                    <td><?php echo $phone['state'] ? "OK" : "NOK"; ?></td>
                                    <td><?php echo "+" . $phone['countryCode']; ?></td>
                                    <td><?php echo $phone['phone']; ?></td>
                                </tr>
                                <?php endforeach;?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
