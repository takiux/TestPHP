<?php
require 'Manager.php';
use TestManager\Manager;
    
$manager = new manager;
// echo $manager->getAnnualInterestRateByCountry([1, 2]); // Akram : fixed typo
try{

    $countries = $manager->getCountries();
}
catch (Exception $e) 
{
    echo $manager->error(400, 'Error: ' .  $e->getMessage());
    exit();
}        

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>techBanx test</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css" />
        <link rel="stylesheet" href="style.css" />
    </head>
    <body>
        <form method="post">
            <div class="row">        
                <div class="input-field col s12">
                    <select id="country" name="country">
                        <option value="" disabled selected>Select a country</option>
                        <?php
                            foreach($countries as $value){
                                echo "<option value=" . $value['idCountry'] . ">" . $value['name'] . "</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
            
            <div class="row">
                <div class="input-field col s12">
                <input id="amount" type="number" min="0.00" max="10000.00" step="0.01"  name="amount" class="validate" required />
                <label for="amount">Amount</label>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s12">
                <input id="duration" type="number" name="duration" class="validate" required />
                <label for="duration">Duration</label>
                </div>
            </div>

            <button class="btn waves-effect waves-light" type="submit" name="submit">Calculate</button>
        </form>
        <div id="result">

        </div>
        <script
			  src="https://code.jquery.com/jquery-2.2.4.min.js"
			  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
			  crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"/></script>
        <script>
             $(document).ready(function(){
                $('select').material_select();

                $('form').on('submit', (event) => {
                    event.preventDefault();
                    const data = $('form').serializeArray();
                    
                    const validCountry = parseInt(data[0].value);
                    const validAmount = parseFloat(data[1].value);
                    const validDuration = parseInt(data[2].value);
                    
                    if(validCountry && validAmount && validDuration){
                        $.post('getResult.php', {
                            country : $('#country').val(),
                            amount : $('#amount').val(),
                            duration : $('#duration').val()
                        }).then(interest => {
                            interest = JSON.parse(interest);
                            const country = Object.keys(interest)[0];
                            const html = `<h1>${country}</h1>  ${interest[country]} $`;
                            $('#result').html(html);
                        });
                    }
                })
            });
        </script>
    </body>
</html>
