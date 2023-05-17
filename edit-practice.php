
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

    session_start();

if(isset($_SESSION["user_id"])){

    $mysqli = require __DIR__ . "/database.php";

    $sql = "SELECT * FROM users
            WHERE ID = {$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    $sql = "SELECT *
            FROM practices
            WHERE userID = {$_SESSION["user_id"]}";

    $result1 = $mysqli->query($sql);
    $practice = $result1->fetch_assoc();



}



?>

<!DOCTYPE html>
<html>
<head>
    <title> DocMeet Home </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/skeleton.css">
    <link rel="stylesheet" href="css/custom.css">

    <!--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/kimeiga/bahunya/dist/bahunya.min.css">-->
</head>

<body>


    <nav>

        <div class="divider"></div>
        <a href="index.php" >DocMeet Dashboard</a>

        <a href="appointment-view.php"> Appointments </a>

        <a href="edit-practice.php" style="font-weight: bold;"> Your Practice</a>

        <a href="message-view.php">Messages</a>

    </nav>



    <div class="container main-card">


        <h1 class="dash"> Your Practice </h1>


        <?php if (isset($practice)): ?>

            <h5> Practice Name </h5> <h3> <?php echo $practice["practiceName"]; ?></h3>



             <h5> Bio or description</h5>
            <h3> <?php echo $practice["bio"]; ?></h3>

            <h5> Address</h5>
        <h3> <?php echo $practice["streetAddress"] . ", " . $practice["city"] . ", " . $practice["country"] . " " . $practice["zipcode"]; ?></h3>

<!--            <a href="#"> Edit Practice</a>-->
<!--            <button> Edit Practice </button>-->

            <form method="post">
                <input type="submit" name="editPractice" value="Edit Practice"/>
            </form>


        <?php else: ?>
            <p>Looks like you haven't set up your practice yet. <a href="new-practice-view.php">Set up practice.</a></p>
        <?php endif; ?>

    </div>





    <?php
    if(isset($_POST['editPractice'])) {
        echo '<div class="container main-card fade">';


        echo '<div class="row">';
        echo '<div class="one-half column">';
        echo '<h1 class="dash"> Edit Practice </h1>';
        echo '</div>';
        echo '<div class="one-half column">';
        echo '';
        echo '<form method="post" id="closeButton">';
        echo '<input type="submit" name="closePractice" value="X"/>';
        echo '</form>';
        echo '';
        echo '</div>';
        echo '</div>';


        echo '';
        echo '';
        echo '    <form action="practice-view.php" method="post" novalidate>';
        echo '';
        echo '';
        echo '        <label for="practiceName">Practice Name  </label>';
        echo '        <input type="text" id="practiceName" name="practiceName" value="' . htmlspecialchars($practice["practiceName"]) . '"/>';
        echo '';
        echo '';
        echo '        <label for="bio">Practice Bio:  </label>';
        echo '        <textarea id="bio" name="bio" rows="2" cols="20" ></textarea>';
        echo '';
        echo '        <div>';
        echo '            <div>';
        echo '                <label for="street-address">Street address</label>';
        echo '                <input type="text" id="street-address" name="street-address" autocomplete="street-address" required enterkeyhint="next"';
        echo '                value="' . htmlspecialchars($practice["streetAddress"]) . '"></input>';
        echo '';
        echo '            </div>';
        echo '            <div>';
        echo '                <label for="postal-code">ZIP or postal code</label>';
        echo '                <input class="postal-code" id="postal-code" name="postal-code" autocomplete="postal-code" enterkeyhint="next"';
        echo '                       value="' . htmlspecialchars($practice["zipcode"]) . '">';
        echo '            </div>';
        echo '            <div>';
        echo '                <label for="city">City</label>';
        echo '                <input required type="text" id="city" name="city" autocomplete="address-level2" enterkeyhint="next" value="' . htmlspecialchars($practice["city"]) . '">';
        echo '            </div>';
        echo '            <div>';

        echo '<label for="country">Country or region</label>';
        echo '<select id="country" name="country" autocomplete="country" enterkeyhint="done" required>';
        echo '<option></option>';
        echo '<option value="AF">Afghanistan</option>';
        echo '<option value="AX">Åland Islands</option>';
        echo '<option value="AL">Albania</option>';
        echo '<option value="DZ">Algeria</option>';
        echo '<option value="AS">American Samoa</option>';
        echo '<option value="AD">Andorra</option>';
        echo '<option value="AO">Angola</option>';
        echo '<option value="AI">Anguilla</option>';
        echo '<option value="AQ">Antarctica</option>';
        echo '<option value="AG">Antigua &amp; Barbuda</option>';
        echo '<option value="AR">Argentina</option>';
        echo '<option value="AM">Armenia</option>';
        echo '<option value="AW">Aruba</option>';
        echo '<option value="AC">Ascension Island</option>';
        echo '<option value="AU">Australia</option>';
        echo '<option value="AT">Austria</option>';
        echo '<option value="AZ">Azerbaijan</option>';
        echo '<option value="BS">Bahamas</option>';
        echo '<option value="BH">Bahrain</option>';
        echo '<option value="BD">Bangladesh</option>';
        echo '<option value="BB">Barbados</option>';
        echo '<option value="BY">Belarus</option>';
        echo '<option value="BE">Belgium</option>';
        echo '<option value="BZ">Belize</option>';
        echo '<option value="BJ">Benin</option>';
        echo '<option value="BM">Bermuda</option>';
        echo '<option value="BT">Bhutan</option>';
        echo '<option value="BO">Bolivia</option>';
        echo '<option value="BA">Bosnia &amp; Herzegovina</option>';
        echo '<option value="BW">Botswana</option>';
        echo '<option value="BV">Bouvet Island</option>';
        echo '<option value="BR">Brazil</option>';
        echo '<option value="IO">British Indian Ocean Territory</option>';
        echo '<option value="VG">British Virgin Islands</option>';
        echo '<option value="BN">Brunei</option>';
        echo '<option value="BG">Bulgaria</option>';
        echo '<option value="BF">Burkina Faso</option>';
        echo '<option value="BI">Burundi</option>';
        echo '<option value="KH">Cambodia</option>';
        echo '<option value="CM">Cameroon</option>';
        echo '<option value="CA">Canada</option>';
        echo '<option value="CV">Cape Verde</option>';
        echo '<option value="BQ">Caribbean Netherlands</option>';
        echo '<option value="KY">Cayman Islands</option>';
        echo '<option value="CF">Central African Republic</option>';
        echo '<option value="TD">Chad</option>';
        echo '<option value="CL">Chile</option>';
        echo '<option value="CN">China</option>';
        echo '<option value="CX">Christmas Island</option>';
        echo '<option value="CC">Cocos (Keeling) Islands</option>';
        echo '<option value="CO">Colombia</option>';
        echo '<option value="KM">Comoros</option>';
        echo '<option value="CG">Congo - Brazzaville</option>';
        echo '<option value="CD">Congo - Kinshasa</option>';
        echo '<option value="CK">Cook Islands</option>';
        echo '<option value="CR">Costa Rica</option>';
        echo '<option value="CI">Côte d’Ivoire</option>';
        echo '<option value="HR">Croatia</option>';
        echo '<option value="CW">Curaçao</option>';
        echo '<option value="CY">Cyprus</option>';
        echo '<option value="CZ">Czechia</option>';
        echo '<option value="DK">Denmark</option>';
        echo '<option value="DJ">Djibouti</option>';
        echo '<option value="DM">Dominica</option>';
        echo '<option value="DO">Dominican Republic</option>';
        echo '<option value="EC">Ecuador</option>';
        echo '<option value="EG">Egypt</option>';
        echo '<option value="SV">El Salvador</option>';
        echo '<option value="GQ">Equatorial Guinea</option>';
        echo '<option value="ER">Eritrea</option>';
        echo '<option value="EE">Estonia</option>';
        echo '<option value="SZ">Eswatini</option>';
        echo '<option value="ET">Ethiopia</option>';
        echo '<option value="FK">Falkland Islands (Islas Malvinas)</option>';
        echo '<option value="FO">Faroe Islands</option>';
        echo '<option value="FJ">Fiji</option>';
        echo '<option value="FI">Finland</option>';
        echo '<option value="FR">France</option>';
        echo '<option value="GF">French Guiana</option>';
        echo '<option value="PF">French Polynesia</option>';
        echo '<option value="TF">French Southern Territories</option>';
        echo '<option value="GA">Gabon</option>';
        echo '<option value="GM">Gambia</option>';
        echo '<option value="GE">Georgia</option>';
        echo '<option value="DE">Germany</option>';
        echo '<option value="GH">Ghana</option>';
        echo '<option value="GI">Gibraltar</option>';
        echo '<option value="GR">Greece</option>';
        echo '<option value="GL">Greenland</option>';
        echo '<option value="GD">Grenada</option>';
        echo '<option value="GP">Guadeloupe</option>';
        echo '<option value="GU">Guam</option>';
        echo '<option value="GT">Guatemala</option>';
        echo '<option value="GG">Guernsey</option>';
        echo '<option value="GN">Guinea</option>';
        echo '<option value="GW">Guinea-Bissau</option>';
        echo '<option value="GY">Guyana</option>';
        echo '<option value="HT">Haiti</option>';
        echo '<option value="HM">Heard &amp; McDonald Islands</option>';
        echo '<option value="HN">Honduras</option>';
        echo '<option value="HK">Hong Kong</option>';
        echo '<option value="HU">Hungary</option>';
        echo '<option value="IS">Iceland</option>';
        echo '<option value="IN">India</option>';
        echo '<option value="ID">Indonesia</option>';
        echo '<option value="IR">Iran</option>';
        echo '<option value="IQ">Iraq</option>';
        echo '<option value="IE">Ireland</option>';
        echo '<option value="IM">Isle of Man</option>';
        echo '<option value="IL">Israel</option>';
        echo '<option value="IT">Italy</option>';
        echo '<option value="JM">Jamaica</option>';
        echo '<option value="JP">Japan</option>';
        echo '<option value="JE">Jersey</option>';
        echo '<option value="JO">Jordan</option>';
        echo '<option value="KZ">Kazakhstan</option>';
        echo '<option value="KE">Kenya</option>';
        echo '<option value="KI">Kiribati</option>';
        echo '<option value="XK">Kosovo</option>';
        echo '<option value="KW">Kuwait</option>';
        echo '<option value="KG">Kyrgyzstan</option>';
        echo '<option value="LA">Laos</option>';
        echo '<option value="LV">Latvia</option>';
        echo '<option value="LB">Lebanon</option>';
        echo '<option value="LS">Lesotho</option>';
        echo '<option value="LR">Liberia</option>';
        echo '<option value="LY">Libya</option>';
        echo '<option value="LI">Liechtenstein</option>';
        echo '<option value="LT">Lithuania</option>';
        echo '<option value="LU">Luxembourg</option>';
        echo '<option value="MO">Macao</option>';
        echo '<option value="MG">Madagascar</option>';
        echo '<option value="MW">Malawi</option>';
        echo '<option value="MY">Malaysia</option>';
        echo '<option value="MV">Maldives</option>';
        echo '<option value="ML">Mali</option>';
        echo '<option value="MT">Malta</option>';
        echo '<option value="MH">Marshall Islands</option>';
        echo '<option value="MQ">Martinique</option>';
        echo '<option value="MR">Mauritania</option>';
        echo '<option value="MU">Mauritius</option>';
        echo '<option value="YT">Mayotte</option>';
        echo '<option value="MX">Mexico</option>';
        echo '<option value="FM">Micronesia</option>';
        echo '<option value="MD">Moldova</option>';
        echo '<option value="MC">Monaco</option>';
        echo '<option value="MN">Mongolia</option>';
        echo '<option value="ME">Montenegro</option>';
        echo '<option value="MS">Montserrat</option>';
        echo '<option value="MA">Morocco</option>';
        echo '<option value="MZ">Mozambique</option>';
        echo '<option value="MM">Myanmar (Burma)</option>';
        echo '<option value="NA">Namibia</option>';
        echo '<option value="NR">Nauru</option>';
        echo '<option value="NP">Nepal</option>';
        echo '<option value="NL">Netherlands</option>';
        echo '<option value="NC">New Caledonia</option>';
        echo '<option value="NZ">New Zealand</option>';
        echo '<option value="NI">Nicaragua</option>';
        echo '<option value="NE">Niger</option>';
        echo '<option value="NG">Nigeria</option>';
        echo '<option value="NU">Niue</option>';
        echo '<option value="NF">Norfolk Island</option>';
        echo '<option value="KP">North Korea</option>';
        echo '<option value="MK">North Macedonia</option>';
        echo '<option value="MP">Northern Mariana Islands</option>';
        echo '<option value="NO">Norway</option>';
        echo '<option value="OM">Oman</option>';
        echo '<option value="PK">Pakistan</option>';
        echo '<option value="PW">Palau</option>';
        echo '<option value="PS">Palestine</option>';
        echo '<option value="PA">Panama</option>';
        echo '<option value="PG">Papua New Guinea</option>';
        echo '<option value="PY">Paraguay</option>';
        echo '<option value="PE">Peru</option>';
        echo '<option value="PH">Philippines</option>';
        echo '<option value="PN">Pitcairn Islands</option>';
        echo '<option value="PL">Poland</option>';
        echo '<option value="PT">Portugal</option>';
        echo '<option value="PR">Puerto Rico</option>';
        echo '<option value="QA">Qatar</option>';
        echo '<option value="RE">Réunion</option>';
        echo '<option value="RO">Romania</option>';
        echo '<option value="RU">Russia</option>';
        echo '<option value="RW">Rwanda</option>';
        echo '<option value="WS">Samoa</option>';
        echo '<option value="SM">San Marino</option>';
        echo '<option value="ST">São Tomé &amp; Príncipe</option>';
        echo '<option value="SA">Saudi Arabia</option>';
        echo '<option value="SN">Senegal</option>';
        echo '<option value="RS">Serbia</option>';
        echo '<option value="SC">Seychelles</option>';
        echo '<option value="SL">Sierra Leone</option>';
        echo '<option value="SG">Singapore</option>';
        echo '<option value="SX">Sint Maarten</option>';
        echo '<option value="SK">Slovakia</option>';
        echo '<option value="SI">Slovenia</option>';
        echo '<option value="SB">Solomon Islands</option>';
        echo '<option value="SO">Somalia</option>';
        echo '<option value="ZA">South Africa</option>';
        echo '<option value="GS">South Georgia &amp; South Sandwich Islands</option>';
        echo '<option value="KR">South Korea</option>';
        echo '<option value="SS">South Sudan</option>';
        echo '<option value="ES">Spain</option>';
        echo '<option value="LK">Sri Lanka</option>';
        echo '<option value="BL">St Barthélemy</option>';
        echo '<option value="SH">St Helena</option>';
        echo '<option value="KN">St Kitts &amp; Nevis</option>';
        echo '<option value="LC">St Lucia</option>';
        echo '<option value="MF">St Martin</option>';
        echo '<option value="PM">St Pierre &amp; Miquelon</option>';
        echo '<option value="VC">St Vincent &amp; Grenadines</option>';
        echo '<option value="SR">Suriname</option>';
        echo '<option value="SJ">Svalbard &amp; Jan Mayen</option>';
        echo '<option value="SE">Sweden</option>';
        echo '<option value="CH">Switzerland</option>';
        echo '<option value="TW">Taiwan</option>';
        echo '<option value="TJ">Tajikistan</option>';
        echo '<option value="TZ">Tanzania</option>';
        echo '<option value="TH">Thailand</option>';
        echo '<option value="TL">Timor-Leste</option>';
        echo '<option value="TG">Togo</option>';
        echo '<option value="TK">Tokelau</option>';
        echo '<option value="TO">Tonga</option>';
        echo '<option value="TT">Trinidad &amp; Tobago</option>';
        echo '<option value="TA">Tristan da Cunha</option>';
        echo '<option value="TN">Tunisia</option>';
        echo '<option value="TR">Turkey</option>';
        echo '<option value="TM">Turkmenistan</option>';
        echo '<option value="TC">Turks &amp; Caicos Islands</option>';
        echo '<option value="TV">Tuvalu</option>';
        echo '<option value="UG">Uganda</option>';
        echo '<option value="UA">Ukraine</option>';
        echo '<option value="AE">United Arab Emirates</option>';
        echo '<option value="GB">United Kingdom</option>';
        echo '<option value="US" selected>United States</option>';
        echo '<option value="UY">Uruguay</option>';
        echo '<option value="UM">US Outlying Islands</option>';
        echo '<option value="VI">US Virgin Islands</option>';
        echo '<option value="UZ">Uzbekistan</option>';
        echo '<option value="VU">Vanuatu</option>';
        echo '<option value="VA">Vatican City</option>';
        echo '<option value="VE">Venezuela</option>';
        echo '<option value="VN">Vietnam</option>';
        echo '<option value="WF">Wallis &amp; Futuna</option>';
        echo '<option value="EH">Western Sahara</option>';
        echo '<option value="YE">Yemen</option>';
        echo '<option value="ZM">Zambia</option>';
        echo '<option value="ZW">Zimbabwe</option>';
        echo '</select>';

        echo '</div>';
        echo '';
        echo '<label for="logo">Logo:</label>';
        echo '';
        echo '<input type="file"';
        echo 'id="logo" name="logo"';
        echo 'accept="image/png, image/jpeg">';
        echo '';
        echo '';
        echo '';
        echo '</div>';
        echo '';
        echo '';
        echo '';
        echo '';
        echo '<br>';
        echo '<div>';
        echo '<button>Submit</button>';
        echo '</div>';
        echo '';
        echo '</form>';
        echo '';
        echo '';
        echo '';
        echo '';
        echo '';
        echo '';
        echo '</div>';
        echo '';
        echo '';


    }
    ?>










</body>
</html>
