<style>
    .privacy_wrap{
        max-width:1080px;
        margin:auto;
    }
    .privacy_wrap p{
        font-size:16px !important;
    }
    .privacy_wrap h1{
        font-size: 30px;
        font-weight:600 !important;
    }
    .privacy_wrap h2,h3,h4{
        font-size: 25px;
        font-weight:500 !important;
    }
</style>
<?php

$company_var = get_option("dds_settings_option_name");
$digiflow_settings_options = get_option( 'digiflow_settings_option_name' );

$company_url = get_site_url();
$company_name = $company_var['dealer_handelsnaam_8'];
$company_email = $company_var['dealer_contact_mail'];
$company_address  = $company_var['dealer_adres_9'];

if(empty($company_name)){
    $company_name = $digiflow_settings_options['company_name'];
}

if(empty($company_mail)){
    $company_email = $digiflow_settings_options['company_mail'];
}

if(empty($company_address)){
    $company_address = $digiflow_settings_options['company_address'];
}



?>
<div class="privacy_wrap">
<h1>Verklaring met betrekking tot de gegevensprivacy</h1>
<p>Bedankt voor uw interesse in ons bedrijf en uw bezoek aan onze website <?php echo $company_url; ?> (hierna &ldquo;Website&rdquo; genoemd).</p>
<p><?php echo $company_name; ?> (hierna &ldquo;<?php echo $company_name; ?> &rdquo; of &ldquo;wij&rdquo; &rdquo;) neemt de bescherming van uw persoonsgegevens zeer serieus.</p>
<p>Indien persoonsgegevens worden verwerkt (bijv. naam, adres, e-mailadres of telefoonnummer van de betrokken persoon [deze persoon wordt hierna &ldquo;Gegevenssubject&rdquo; genoemd]), dan wordt dit enkel en alleen gedaan in overeenstemming met de Europese, algemene verordening gegevensbescherming (hierna &ldquo;AVG&rdquo;) en landspecifieke gegevensbeschermingsbepalingen die van toepassing zijn op <?php echo $company_name; ?>.</p>
<p>Het verwerken van persoonsgegevens waarvoor geen rechtsgrondslag bestaat, zal (indien nodig) alleen met de toestemming van het Gegevenssubject gebeuren.</p>
<p>Deze verklaring met betrekking tot gegevensprivacy verschaft informatie over de aard, het toepassingsgebied en het doel van de persoonsgegevens die door <?php echo $company_name; ?> verwerkt worden en over de rechten die u hebt met betrekking tot deze gegevens.</p>
<h5>1. De beheerder verantwoordelijk voor de verwerking van uw persoonsgegevens</h5>
<p>De beheerder verantwoordelijk voor de verwerking van uw persoonsgegevens in de zin van de AVG en andere bepalingen van de wet inzake gegevensbescherming is</p>
<ul>
<li><?php echo $company_name; ?></li>
<li>Adres: <?php echo $company_address; ?></li>
<li>E-mailadres: <?php echo $company_email; ?></li>
</ul>
<h5>2. Verwerking van gebruiksgegevens</h5>
<p>Elke keer dat deze Website bezocht wordt door een bezoeker, verzamelt deze Website algemene gegevens en informatie. Deze algemene gegevens en informatie worden in de logbestanden van de server opgeslagen. Het betreft de volgende gegevens:</p>
<ul>
<li>gebruikte browsertypes en versies,</li>
<li>het besturingssysteem dat het toegangssysteem gebruikt,</li>
<li>de webpagina van waaruit een toegangssysteem op deze Website uitkomt (ook bekend als verwijzer),</li>
<li>de sub-websites waar via een toegangssysteem toegang tot verkregen wordt op deze Website,</li>
<li>de datum en tijd waarop de Website bezocht wordt,</li>
<li>het IP-adres,</li>
<li>de internetaanbieder dat het toegangssysteem gebruikt,</li>
</ul>
<p>en</p>
<ul>
<li>andere vergelijkbare gegevens en informatie dat gevaren afwendt in geval van aanvallen onze IT-systemen.</li>
</ul>
<p>Bij de verwerking van deze gebruiksgegevens trekt <?php echo $company_name; ?> geen enkele conclusie over het Gegevenssubject. <?php echo $company_name; ?> heeft deze gegevens nodig om</p>
<ul>
<li>de inhoud van deze Website op correcte manier aan te bieden,</li>
<li>de inhoud van en de advertenties voor deze Website te optimaliseren,</li>
<li>het doorlopend functioneren van onze IT-systemen en de technologie achter deze Website te verzekeren</li>
</ul>
<p>en</p>
<ul>
<li>de wethandhavingsautoriteiten informatie te verschaffen die nodig is voor voeren van een strafprocedure in geval van een cyberaanval.</li>
</ul>
<p>De rechtsgrondslag voor deze verwerking is Art. 6(1) (f) AVG. <?php echo $company_name; ?> analyseert deze gegevens in anonieme vorm voor de statistieken en met als doel de gegevensbescherming en gegevensveiligheid te verbeteren. De anonieme gegevens in de logbestanden van de server worden gescheiden opgeslagen van alle persoonsgegevens die door het Gegevenssubject verschaft zijn.</p>
<p>&nbsp;</p>
<h5>3. Overdracht van persoonsgegevens aan externe dienstverleners</h5>
<p><?php echo $company_name; ?> krijgt hulp van externe dienstverleners voor bepaalde analyses, verwerkings- of opslagprocessen van technische gegevens (bijv. om samengevoegde, niet-persoonlijke statistieken uit gegevensbanken te verkrijgen of voor de opslag van back-upkopie&euml;n). Deze dienstverleners worden zorgvuldig geselecteerd en voldoen aan strenge normen betreffende gegevensbescherming en gegevensveiligheid. Ze zijn verplicht de persoonsgegevens op strikt vertrouwelijke wijze te behandelen en deze alleen te verwerken als <?php echo $company_name; ?> dit vraagt en volgens de instructies van <?php echo $company_name; ?>. De rechtsgrondslag voor de betrokkenheid van zulke dienstverleners is Art. 28 AVG.</p>
<p><?php echo $company_name; ?> werkt samen met bedrijven en andere entiteiten die gespecialiseerde expertise bieden met betrekking tot speciale onderdelen (bijv. belastingadviseurs, rechtshulp, accountants, logistieke bedrijven). Deze entiteiten zijn wettelijk of contractueel verplicht vertrouwelijkheid te garanderen. Als overdracht van persoonsgegevens aan deze entiteiten nodig is, dan is de rechtsgrondslag, afhankelijk van de soort samenwerking, Artikel 6(1)(b) of, (f) AVG.</p>
<h5>4. Cookies</h5>
<p>De Website gebruikt cookies. Cookies zijn tekstbestanden die via een internet browser op een computersysteem worden geplaatst en opgeslagen. Cookies worden op de harde schijf van de computer van de gebruiker bewaard en beschadigen de computer in geen enkel opzicht. De cookies van de Website bevatten persoonsgegevens over de gebruiker. Cookies besparen de gebruiker van de Website heel wat moeite; de gebruiker hoeft bepaalde gegevens niet elke keer in te voeren, ze vereenvoudigen de overdracht van specifieke inhoud en helpen <?php echo $company_name; ?> bij het identificeren van specifieke, populaire onderdelen van de Website. Zo kan <?php echo $company_name; ?>, onder andere, de inhoud van de Website aanpassen aan de behoeften van de gebruikers. De rechtsgrondslag voor deze verwerking is Art. 6(1) (f) AVG. De gebruiker kan, op elk moment, het plaatsen van cookies door deze Website weigeren door de instellingen van de gebruikte internetbrowser te wijzigen en daardoor het plaatsen van cookies permanent te weigeren. Bovendien kunnen cookies die al op de computer staan op elk moment verwijderd worden via de internetbrowser of andere software. Dit is mogelijk in alle gebruikelijke internetbrowsers. Indien de gebruiker het plaatsen van cookies in de gebruikte internetbrowser deactiveert, kunnen bepaalde functies van deze Website niet volledig gebruikt worden.</p>
<h5>5. Google Analytics</h5>
<p>Deze Website gebruikt Google Analytics. Google Analytics is een webanalyse-dienst. Webanalyse is de verzameling, bundeling en analyse van gegevens betreffende het gedrag van website bezoekers. Een webanalyse-dienst verzamelt, onder andere, gegevens met betrekking tot welke webpagina een Gegevenssubject gebruikt om op een andere webpagina te komen (ook verwijzer genoemd), welke sub-sites van de website bezocht zijn en hoe vaak en voor hoe lang een sub-site werd bezocht. Een webanalyse wordt voornamelijk gebruikt om een webpagina te optimaliseren en een kosten-baten analyse van internetreclame uit te voeren.</p>
<p>De werkmaatschappij van het Google-Analytics component is Google Inc., 1600 Amphitheatre Pkwy, Mountain View, CA 94043-1351, USA. GoogleLLC is gecertificeerd door het Privacy-Shield framework en garandeert daarom dat het voldoet aan de Europese gegevensbeschermingswet (<a href="https://www.privacyshield.gov/participant?id=a2zt000000001L5AAI&amp;status=Active">https://www.privacyshield.gov/participant?id=a2zt000000001L5AAI&amp;status=Active</a>).</p>
<p>Voor webanalyse via Google Analytics gebruikt <?php echo $company_name; ?> het achtervoegsel &ldquo;_gat._anonymizeIp&rdquo;. Door middel van dit achtervoegsel wordt het IP-adres van de internetverbinding van het Gegevenssubject ingekort en anoniem gemaakt door Google indien onze Website bezocht wordt vanuit een lidstaat van de Europese Unie of een andere verdragsluitende staat bij de Overeenkomst betreffende de Europese Economische Ruimte. Het doel van het Google-Analytics component is de bezoekersstroom op de Website te analyseren. Google gebruikt, onder andere, de verzamelde gegevens en informatie om het gebruik van de Website te analyseren om zo online rapporten voor ons aan te maken die de activiteiten op de Website tonen. Op basis van deze gegevens kunnen wij tevens aanvullende diensten bieden in relatie tot het gebruik van de Website.</p>
<p>Google Analytics gebruikt cookies, dat zijn tekstbestanden die op uw computer opgeslagen worden en analyse van uw gebruik van de website mogelijk maken. Elke keer dat &eacute;&eacute;n van de individuele pagina&rsquo;s van deze Website - beheerd door de controller verantwoordelijk voor de verwerking en waarin een Google-Analytics component in ge&iuml;ntegreerd is - bezocht wordt, wordt de internetbrowser op het IT-systeem van het Gegevenssubject automatisch geactiveerd door het respectievelijke Google-Analytics component om gegevens aan Google door te geven voor de online analyse. In het kader van dit technische proces zal Google kennis krijgen van persoonsgegevens - zoals het IP-adres van het Gegevenssubject - waarmee Google, onder andere, kan zien waar de bezoekers van en de kliks op de website vandaan komen. Zo kunnen commissies gefactureerd worden.</p>
<p>Door middel van de cookie worden persoonsgegevens opgeslagen; bijvoorbeeld de tijd van het bezoek, de plaats waar de Website werd bezocht en het aantal keren dat het Gegevenssubject onze Website bezocht. Elke keer dat onze Website bezocht wordt, worden deze persoonsgegevens, waaronder het IP-adres van de internetverbinding gebruikt door het Gegevenssubject, doorgestuurd naar Google in de USA. Deze persoonsgegevens worden door Google in de USA opgeslagen. Google kan deze persoonsgegevens, die via het technische proces werden verzameld, doorsturen aan derden. Zoals hierboven al werd uitgelegd kan het Gegevenssubject op elk moment het plaatsen van cookies door onze Website weigeren door de instellingen van de gebruikte internetbrowser te wijzigen en daardoor het plaatsen van cookies permanent te weigeren. Indien de instellingen van de gebruikte internetbrowser gewijzigd zijn, kan Google ook geen cookie plaatsen op het IT-systeem van het Gegevenssubject. Bovendien kan een cookie dat al door Google Analytics geplaatst is, op elk moment verwijderd worden via de internetbrowser of andere software. Bovendien heeft het Gegevenssubject de optie de verzameling van gegevens weigeren die door Google Analytics geproduceerd worden en gerelateerd zijn aan het gebruik van deze Website. Hij/zij kan tevens de verwerking van zulke gegevens door Google weigeren en zulke verzameling en verwerking beletten. Hiertoe dient het Gegevenssubject een browser add-on te downloaden via <a href="https://tools.google.com/dlpage/gaoptout">https://tools.google.com/dlpage/gaoptout</a> en deze installeren. Deze browser add-on laat Google Analytics weten via JavaScript dat geen gegevens en informatie over het bezoek aan de webpagina&rsquo;s aan Google Analytics doorgegeven mag worden. Google ziet de installatie van de browser add-on als een weigering. Indien het IT-systeem van het Gegevenssubject verwijderd, geformatteerd of op een latere datum opnieuw ge&iuml;nstalleerd wordt, dan moet het Gegevenssubject ook de browser add-on opnieuw installeren om Google Analytics te deactiveren. Indien de browser add-on gede&iuml;nstalleerd of gedeactiveerd is door het Gegevenssubject of door een andere persoon die voor het Gegevenssubject kan beslissen, dan is er een optie om de browser add-on opnieuw te installeren of te activeren. Voor verdere informatie en de toepasselijke gegevensbeschermingsbepalingen van Google, raadpleeg <a href="https://www.google.de/intl/de/policies/privacy/">https://www.google.de/intl/de/policies/privacy/</a> en <a href="http://www.google.com/analytics/terms/de.html">http://www.google.com/analytics/terms/de.html</a>. Google Analytics wordt uitgebreid uitgelegd in <a href="https://www.google.com/intl/de_de/analytics/">https://www.google.com/intl/de_de/analytics/ </a>. De rechtsgrondslag voor deze verwerking is Art. 6(1) (f) AVG.</p>
<h5>7. Hotjar</h5>
<p>We gebruiken Hotjar om de behoeften van onze gebruikers beter te begrijpen en deze service en ervaring te optimaliseren. Hotjar is een technologieservice die ons helpt de gebruikerservaring van onze gebruikers beter te begrijpen (bijvoorbeeld hoeveel tijd ze doorbrengen op welke pagina's, op welke links ze klikken, wat gebruikers wel en niet leuk vinden, enz.) En dit stelt ons in staat om te bouwen en onze service onderhouden met gebruikersfeedback. Hotjar gebruikt cookies en andere technologie&euml;n om gegevens te verzamelen over het gedrag van onze gebruikers en hun apparaten. Dit omvat het IP-adres van een apparaat (verwerkt tijdens uw sessie en opgeslagen in een niet-ge&iuml;dentificeerde vorm), schermgrootte van apparaat, apparaattype (unieke apparaat-ID's), browserinformatie, geografische locatie (alleen land) en de voorkeurstaal die wordt gebruikt om weer te geven onze website. Hotjar slaat deze informatie namens ons op in een gepseudonimiseerd gebruikersprofiel. Hotjar is contractueel verboden om de namens ons verzamelde gegevens te verkopen.</p>
<p>&nbsp;</p>
<p>Raadpleeg het gedeelte 'Over Hotjar' op de ondersteuningssite van Hotjar voor meer informatie.</p>
<p>.</p>
<p>&nbsp;</p>
<h5>8. Rechten van het Gegevenssubject</h5>
<p>Indien u een of meerdere rechten uit deze clausule wenst uit te oefenen, kunt u op elk moment een bericht sturen aan de contacten die in clausule 1 of 2 worden weergegeven (bijv. per e-mail of per brief).</p>
<h4>a. Recht op bevestiging</h4>
<p>U hebt het recht bevestiging te vragen van het feit of persoonsgegevens die u betreffen, worden verwerkt.</p>
<h4>b. Recht van toegang</h4>
<p>U hebt het recht informatie te verkrijgen over de volgende elementen:</p>
<ul>
<li>De opgeslagen persoonsgegevens u betreffend;</li>
<li>de doeleinden van de verwerking;</li>
<li>de categorie&euml;n persoonsgegevens die worden verwerkt;</li>
<li>de ontvangers of categorie&euml;n van ontvangers aan wie de persoonsgegevens zijn of zullen worden bekend gemaakt;</li>
<li>de voorgenomen opslagperiode van de persoonsgegevens of, indien dit niet mogelijk is, de criteria die gebruikt zijn om die periode te bepalen;</li>
<li>het recht een klacht in te dienen bij een toezichthoudend orgaan;</li>
<li>het bestaan van geautomatiseerde besluitname;</li>
<li>of persoonsgegevens aan een derde land of een internationale organisatie worden doorgegeven.</li>
</ul>
<h4>e. Recht op beperkte verwerking</h4>
<p>U hebt het recht om beperkte verwerking te vragen indien</p>
<ul>
<li>u de juistheid van de persoonsgegevens betwist, met name voor een periode waarvoor <?php echo $company_name; ?> de juistheid van de persoonsgegevens kan controleren;</li>
<li>de verwerking illegaal is en in plaats van het wissen van persoonsgegevens u vraagt om beperkt gebruik van de persoonsgegevens;</li>
<li>de persoonsgegevens niet langer nodig zijn voor de doeleinden van de verwerking maar u de persoonsgegevens nodig hebt voor het bepalen, uitoefenen of verdedigen van rechtsvorderingen;</li>
<li>u verwerking geweigerd hebt en het nog niet duidelijk is of uw weigering zal leiden tot het stoppen van de gegevensverwerking.</li>
</ul>
<h4>f. Recht op gegevensportabiliteit</h4>
<p>U hebt het recht de persoonsgegevens die u betreffen in een gestructureerd, algemeen en machine leesbaar formaat te ontvangen. Bovendien hebt u het recht de persoonsgegevens direct naar een andere controller te laten sturen, voor zover dit technisch mogelijk is en het geen negatief effect heeft op de rechten en vrijheden van anderen.</p>
<h4>g. Recht op weigering</h4>
<p>U hebt het recht, op basis van uw specifieke situatie, de verwerking te weigeren van persoonsgegevens die u betreffen indien de verwerking gebaseerd is op de volgende reden:</p>
<ul>
<li>verwerking nodig is voor de doeleinden van wettelijk belang nagestreefd door <?php echo $company_name; ?> of door een derde.</li>
</ul>
<p>In geval van weigering zal <?php echo $company_name; ?> de persoonsgegevens niet langer verwerken behalve als er dwingende, wettelijke redenen zijn voor deze verwerking die uw belang, rechten en vrijheden opheffen of indien het doel van de verwerking het bepalen, uitvoeren van of verweren tegen rechtsvorderingen inhoudt. Indien u het recht op weigering wenst uit te oefenen, kunt u op elk moment een bericht sturen aan de contacten die in clausule 1 of 2 worden weergegeven (bijv. per e-mail of per brief).</p>
<p>&nbsp;</p>
<p>Door bepaalde onderdelen van deze site te gebruiken, door je in te schrijven op de nieuwsbrief of de formulieren te gebruiken geef je informatie door die toelaat jou als persoon te identificeren. Dit gebeurt enkel voor onze dienstverlening en informatieverstrekking en als jij daar toestemming voor geeft.</p>
<p>Jouw persoonsgegevens worden verwerkt conform de bepalingen van de Europese Algemene Verordening Gegevensbescherming (AVG) (ook bekend als General Data Protection Regulation of &lsquo;GDPR&rsquo;).</p>
<p>Dit privacybeleid is van toepassing op de diensten van &lt;naam organisatie&gt;. Wij zijn niet verantwoordelijk voor het privacybeleid van andere sites en bronnen die verbonden zijn met onze website, maar we verwijzen er wel naar zodat je de nodige informatie kan vinden.</p>
<p>Door gebruik te maken van deze website accepteer je dit privacybeleid.</p>
<h3>Je hebt altijd het recht om jouw bewaarde persoonsgegevens:</h3>
<ul>
<li>op te vragen en in te kijken,</li>
<li>te (laten) wijzigen,</li>
<li>te (laten) schrappen.</li>
</ul>
<p>Dit kan voor &eacute;&eacute;n of meerdere vermeldingen in<em> verschillende databases</em>.</p>
<p>Je kan ook vragen om<em> uit alle databases</em> te worden verwijderd. Je wordt dan &lsquo;vergeten&rsquo; en op geen enkele manier nog gecontacteerd.</p>
<p>Als je de wijzigingen of schrapping zelf doorvoert, dan is dit meteen effectief. Als je een aanvraag indient om wijzigingen te doen, dan gebeurt dit zo snel mogelijk en ten minste binnen 30 dagen.</p>
<h3>Hoe laat je je rechten gelden?</h3>
<p>Door een eenvoudig verzoek te mailen naar <?php echo $company_email; ?>. Je kan ook het contactformulier gebruiken.</p>
<p>Vermeld steeds:</p>
<ul>
<li>Voor- en achternaam van de persoon die je wil schrappen of wijzigen.</li>
<li>E-mailadres van de persoon die je wil schrappen of wijzigen.</li>
<li>Welke wijzigingen je wil doorvoeren of je wil dat de persoon geschrapt wordt.</li>
</ul>
<h3>Zo verwerken we jouw gegevens</h3>
<p>De verwerkingsverantwoordelijke is:</p>
<ul>
<li><?php echo $company_name; ?></li>
<li><?php echo $company_address; ?></li>
<li><?php echo $company_email; ?></li>
</ul>
<p>Jouw persoonsgegevens worden verwerkt door volgende gegevensverwerkers (die ook de GDPR-regels naleven).</p>
<ul>
<li><?php echo $company_name; ?></li>
<li><?php echo $company_address; ?></li>
<li><?php echo $company_email; ?></li>
</ul>
<p>Voor het versturen van e-nieuwsbrieven is de gegevensverwerker <em>Mailchimp met basis in de U.S.A. Door in te schrijven op onze nieuwsbrief ga je akkoord met de </em><a href="https://mailchimp.com/legal/privacy/"><em>voorwaarden van Mailchimp</em></a><em>. Met deze gegevensverwerker is een overeenkomst gesloten om jouw persoonsgegevens te beschermen.</em></p>
<p><em>Voor gebruiksanalyse van onze website schakelen wij Google Analytics in. Hiervoor wordt anoniem informatie over het gebruik van onze website verzameld. Deze gegevens worden niet doorgegeven aan Google en niet gebruikt voor marketing- en reclamedoeleinden.</em></p>
<h3>Welke gegevens worden verzameld?</h3>
<p>Enkel die persoonsgegevens worden verzameld die nodig zijn om aan een bepaald deel van onze dienstverlening te voldoen of om jou informatie door te sturen.</p>
<p>Dat kan zijn:</p>
<ul>
<li>Voornaam en naam</li>
<li>E-mailadres</li>
<li>Woonadres</li>
<li>Werkadres</li>
<li>Telefoonnummer</li>
<li>Btw-nummer</li>
</ul>
<p>In formulieren is sommige informatie verplicht (meestal aangeduid met een *), deze gegevens zijn nodig om jou de gewenste dienst te kunnen leveren.</p>
<p>Andere informatie &ndash; niet aangeduid met * &ndash; kan nuttig zijn, maar is niet absoluut nodig. Jij kiest of je hier gegevens invult.</p>
<p>Op basis van ingevulde gegevens of geplaatste cookies (zie verder) worden geen marketingprofielen aangemaakt.</p>
<h3>Waarom worden jouw persoonsgegevens bijgehouden?</h3>
<p>Jouw persoonsgegevens worden gebruikt voor een specifiek doel (en alleen maar voor dat doel) met volgende rechtsgronden:</p>
<ul>
<li><em>Contactformulier: om aan je vraag te voldoen, een antwoord te geven (uitvoeren opdracht).</em></li>
<li><em>Inschrijving op nieuwsbrief: om je af en toe een nieuwsbrief toe te sturen met aanbiedingen of informatie die je kan interesseren (toestemming betrokkene) Deze nieuwsbrief wordt enkel verstuurd als er voor u interessante informatie is, die kan gaan om nieuws uit de koffiewereld, tips over zetten en kopen van koffie en prijspromoties.</em></li>
<li><em>Aankoopformulier: om je aankoop te kunnen verwerken, de gewenste producten te leveren en je andere producten te kunnen tonen die je misschien interesseren (uitvoeren opdracht en gerechtvaardigd belang)</em></li>
<li><em>Aanvraag brochure: om je de brochure op te sturen (uitvoeren opdracht)</em></li>
</ul>
<p>Een uitzondering hierop kan enkel met jouw expliciete toestemming.</p>
<h3>Hoe lang worden je gegevens bijgehouden?</h3>
<p>Persoonsgegevens worden bewaard zo lang dat nodig is om jou de dienst te verlenen die je zelf activeerde of waarvoor je toestemming gaf. Je persoonsgegevens worden maximaal tot 5 jaar na het laatste gebruik bijgehouden.</p>
<p>Doorgifte aan derden</p>
<p>Je persoonsgegevens worden niet doorgegeven aan derden. Wij maken enkel gebruik van diensten die persoonsgegevens verwerken als we er een verwerkingsovereenkomst&nbsp; mee hebben, als zij nodig zijn voor onze dienstverlening en informatieverstrekking en als zij kunnen instaan voor de beveiligde opslag van persoonsgegevens met garantie voor jouw privacy.</p>
<p>Je persoonsgegevens worden enkel doorgegeven als dit nodig is voor het doel waarvoor jij toestemming gaf en de persoonsgegevens verstrekte (nieuwsbrief versturen, product aankopen, dienst boeken &hellip;) of als dit wettelijk verplicht en toegestaan is (bijvoorbeeld in het kader van een gerechtelijk onderzoek).</p>
<h3>Minderjarigen</h3>
<p><em>Wij verwerken enkel en alleen persoonsgegevens van </em><em>minderjarigen </em><em>(personen jonger dan 16 jaar) indien daarvoor schriftelijke toestemming is gegeven door de ouder of wettelijke vertegenwoordiger.</em></p>
<p>of</p>
<p><em>Wij hebben absoluut niet de intentie om gegevens te verzamelen over websitebezoekers die minderjarig zijn, ook niet als zij hiervoor toestemming hebben van ouders of voogd. Wij kunnen echter niet controleren of een bezoeker minderjarig is. Zorg daarom dat je betrokken bent bij de online activiteiten van je minderjarige kinderen om te voorkomen dat hun gegevens door ons of onze partners worden verwerkt.</em></p>
<h3>Beveiliging van gegevens</h3>
<p>De computers en internetverbindingen waarop jouw persoonsgegevens worden bewaard en getransporteerd zijn zo goed mogelijk beveiligd tegen hacken, installeren van malware en ander oneigenlijk gebruik.Op de computers en het netwerk kan enkel worden ingelogd met een gebruikersnaam en paswoord.</p>
<p>Iedereen die namens &lt;naam bedrijf of organisatie&gt; jouw persoonsgegevens kan inkijken of kennen is gebonden aan geheimhouding van die informatie.</p>
<p>Er wordt een back-up gemaakt van de persoonsgegevens om die te kunnen herstellen bij fysieke of technische incidenten.</p>
<p>Alle medewerkers van &lt;naam organisatie&gt; zijn ge&iuml;nformeerd over het belang van de bescherming van persoonsgegevens en privacy.</p>
<p>Als het nodig is worden persoonsgegevens gepseudonimiseerd en ge&euml;ncrypteerd. De systemen worden geregeld getest en ge&euml;valueerd.</p>
<h3>Automatische opslag van niet-persoonlijke gegevens</h3>
<p>Tijdens een bezoek aan deze website worden automatisch gegevens opgeslagen over het gebruik van de website. Dit zijn enkel en alleen <em>niet-persoonlijke en anonieme gegevens</em><em> (je IP-adres wordt bijvoorbeeld niet bijgehouden). </em>We analyseren die informatie met Google Analytics (lees het privacybeleid van Google en Google Analytics voor meer info) om onze website te kunnen verbeteren, er wordt echter geen persoonlijke informatie bijgehouden of doorgegeven aan Google en aan andere derden.</p>
<h3>Cookies</h3>
<p>Deze website maakt gebruik van functionele en analytische cookies. Dit gebeurt anoniem. Lees hierover meer in ons cookiebeleid.</p>
<p>Kort samengevat: functionele cookies laten onze website beter werken, analytische cookies vertellen ons iets over hoe de website wordt gebruikt. Er worden hierbij geen persoonsgegevens verzameld of doorgegeven. De cookies worden niet gebruikt voor marketing of reclame.</p>
<p>Je kan cookies uit- en inschakelen in je browserinstellingen en ook wissen.</p>
<p>&nbsp;</p>
<h3>Facebook, Twitter en andere sociale media</h3>
<p>Op deze site staan deelknoppen voor sociale medianetwerken. De code achter deze knoppen plaatst &ndash; bij gebruik &ndash; een cookie op je computer. Hier omtrent gelden de privacyregels van de sociale netwerken. Wij hebben geen invloed op&nbsp; en dragen geen verantwoordelijkheid voor wat deze netwerken met jouw persoonsgegevens doen.</p>
<p>Wij hebben ook geen controle over hoe andere gebruikers van sociale media met jouw informatie omspringen nadat je iets hebt gedeeld dat op onze website staat.</p>
<h3>Wijzigingen</h3>
<p>Deze Privacyverklaring kan wijzigen. Wij passen de regels en voorwaarden aan om jouw privacy zo goed mogelijk te beschermen en op een transparante manier met jouw persoonsgegevens om te gaan. Neem dus geregeld opnieuw een kijkje.&nbsp;&nbsp;</p>
<p>Als het misgaat &hellip;</p>
<p>We springen zo zorgvuldig mogelijk om met jouw persoonsgegevens en houden die beveiligd bij. Gaat er toch iets mis, dan zullen we jou zo snel mogelijk op de hoogte brengen en er alles aan doen om de schade te beperken.</p>
<p>Het verspreid geraken van jouw persoonsgegevens door gegevensdiefstal of datalekken kan geen aanleiding geven tot schadeclaims ten aanzien van ons.</p>
<h3>Klachten</h3>
<p>Heb je ondanks onze voorzorgsmaatregelen toch klachten over ons gebruik van jouw persoonsgegevens, contacteer dan <?php echo $company_email; ?> en we zoeken een oplossing.</p>
<p>Meer informatie over klachtenprocedures vind je op volgende websites: <a href="http://www.privacycommission.be/nl">privacycommissie, </a><a href="http://www.vlaamsetoezichtcommissie.be/">Vlaamse Toezichtcommissie.</a></p>
<p>&nbsp;</p>
</div>