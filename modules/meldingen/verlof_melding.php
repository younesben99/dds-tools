<?php
function voeg_verlof_melding_toe() {


    $digiflow_settings_options = get_option('digiflow_settings_option_name');
    $verlof_melding = $digiflow_settings_options['verlof_melding']; 
    
    if(!empty($verlof_melding)){
        
 
    ?>
    <style>
    #verlof-melding {
    display: none;
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    background-color: #c50505;
    background: linear-gradient(45deg, #b32020, #bb0c0c);
    color: white;
    text-align: center;
    padding: 20px;
    z-index: 1000;
    font-size: 28px;
    z-index: 10000000;
}
        #verlof-melding button {
            margin-left: 10px;
display:block;

    margin-left: 10px;
    background: white;
    color: #c50505;
    font-weight: 500;
margin-bottom:10px;
width:100%;

        }
button#sluit-melding {
    background: transparent;
    color: white;
    border: 3px solid white;
}
@media (min-width: 568px) {
 #verlof-melding button {
	max-width:300px;
	margin:5px auto;
}
}
    </style>

   

    <div id="verlof-melding">
        
        <span><?php echo $verlof_melding; ?></span>
        <button id="sluit-melding">&#x2715 Sluit</button>
        <button id="niet-meer-weergeven">Niet meer weergeven</button>
    </div>

    <script>
        jQuery(document).ready(function($) {
            if (!getCookie('verlofMeldingGezien')) {
                $('#verlof-melding').slideDown();
            }

            $('#sluit-melding').click(function() {
                $('#verlof-melding').slideUp();
            });

            $('#niet-meer-weergeven').click(function() {
                setCookie('verlofMeldingGezien', '1', 30);
                $('#verlof-melding').slideUp();
            });

            function setCookie(name, value, days) {
                var expires = "";
                if (days) {
                    var date = new Date();
                    date.setTime(date.getTime() + (days*24*60*60*1000));
                    expires = "; expires=" + date.toUTCString();
                }
                document.cookie = name + "=" + (value || "")  + expires + "; path=/";
            }

            function getCookie(name) {
                var nameEQ = name + "=";
                var ca = document.cookie.split(';');
                for(var i=0;i < ca.length;i++) {
                    var c = ca[i];
                    while (c.charAt(0)==' ') c = c.substring(1,c.length);
                    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
                }
                return null;
            }
        });
    </script>


    <?php

}
}
add_action('wp_footer', 'voeg_verlof_melding_toe');
