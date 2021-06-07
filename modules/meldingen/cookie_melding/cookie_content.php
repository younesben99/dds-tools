<style>
    .cookies_wrap {
    width: 100%;
    display:flex;
    flex-wrap: nowrap;
    padding: 5px;
    background: whitesmoke;
    position: fixed;
    bottom: 0;
    left: 0;
    box-shadow: 0 4px 4px rgb(0 0 0 / 10%), 0 0 0 1px rgb(0 0 0 / 8%);
    overflow: hidden;
    text-align: left;
    transform: translate3d(0, 0, 0);
    transition: all 0.75s, height 0s;
    transition-timing-function: cubic-bezier(0.25, 1.37, 0.44, 0.93);
    -webkit-tap-highlight-color: rgba(0,0,0,0);
    opacity:0.96;
    backdrop-filter: blur(11px);
    z-index: 100;
    justify-content: center;
    align-items: center;
}
.cookies_wrap h2 {
    font-size: 20px;
}

.cookies_wrap p {
    font-size: 11px;
    margin: 0;
    padding: 10px 5%;
}
button#cookie_allow {
    font-size: 12px;
    border: 0;
    border-radius: 5px;
    background: #28c553;
    color: white;
    font-weight: 600;
    cursor: pointer;
    width: 100px;
    height: 35px;
}
.privacylink{
    color: #1995ff !important;
    font-weight: 500;
}
.cookies_close {
    position: absolute;
    right: 15px;
    top: 15px;
}
@media only screen and (max-width: 1000px) {

    .cookies_wrap p {
        width: 80%;
        font-size:9px;
    padding: 0px;
}
.cookies_close {
    display: none;
}
button#cookie_allow {
    width: 35%;
    margin: 15px;
}
}
</style>
<?php

$privacyurl = get_site_url() . "/privacybeleid";

?>
<div class="cookies_wrap" style="display:none;">
<div class="cookies_close" style="cursor:pointer;">&#x2715</div>
<p>We gebruiken cookies om ervoor te zorgen dat we u de beste ervaring op onze website kunnen aanbieden.<br>
<a href="<?php 
echo $privacyurl;
?>" class="privacylink">Privacyverklaring</a>
</p>
<button class="cookie_allow" id="cookie_allow">Akkoord</button>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
function getCookie(name) {
    var dc = document.cookie;
    var prefix = name + "=";
    var begin = dc.indexOf("; " + prefix);
    if (begin == -1) {
        begin = dc.indexOf(prefix);
        if (begin != 0) return null;
    }
    else
    {
        begin += 2;
        var end = document.cookie.indexOf(";", begin);
        if (end == -1) {
        end = dc.length;
        }
    }
    return decodeURI(dc.substring(begin + prefix.length, end));
} 

     var checkcookieBestaan = getCookie("cookie_geaccepteerd");

    if (checkcookieBestaan == null) {
        document.querySelector(".cookies_wrap").style.display = "flex";
    }

    document.querySelector(".cookies_close").addEventListener("click", function(){
        document.querySelector(".cookies_wrap").style.display = "none";
    });
    document.getElementById("cookie_allow").addEventListener("click", allowcookies);
    function allowcookies(){
        setCookie("cookie_geaccepteerd","true",365);
        document.querySelector(".cookies_wrap").style.display = "none";
    }

});
</script>
