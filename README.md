######  dds-tools


# Form attributen:

VB shortcodes (aankoop):

## dds form attributes (style,name,type)
___________________

#### style: classic, modern
#### type: aankoop,afspraak,beschikbaarheid,caralert,mail_level2

[dds_form style="classic" name="aankoop"  type="aankoop"] 

## dds select attributes (name,ph,lb,hide,*)
_____________________

#### dynamic selects (name): merk,model,datum,tijd

[dds_select name="merk" ph="Selecteer merk" lb="Merk"]<br>
[dds_select name="model" ph="Selecteer model" lb="Model"]<br>
[dds_select name="brandstof" ph="Selecteer brandstof" lb="Brandstof"]<br>
[dds_select name="bouwjaar" ph="Selecteer bouwjaar" lb="Bouwjaar"]<br>

## dds input attributes (name,len,ph,lb,hide,ty,*)
_____________________

#### ty (type): email,tel

[dds_input name="Kilometerstand" len="20" ph="Kilometerstand" lb="Kilometerstand" hide]<br>
[dds_input name="telefoonnummer" len="20" ph="Telefoonnummer" lb="Telefoonnummer" hide]<br>
[dds_input name="emailadres" ph="E-mailadres" lb="E-mailadres" ty="email" hide]<br>

[dds_submit]
[close_dds_form]

<br>


## dds form2 attributes (style)
_____________________
[dds_form2  style="modern"]


## dds dropzone attributes (lb)
_____________________

[dds_dropzone lb="Upload foto's van je auto"]<br>
[dds_input ty="textarea" len="1000" name="opmerkingen" ph="Extra informatie over de auto" lb="Opmerkingen"]<br>
[dds_submit]<br>
[close_dds_form2]
