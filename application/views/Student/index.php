<h1>
    Wat voor traject volg je?
</h1>
<p>Indien je een standaard traject volgt (alle vakken van het jaar in kwestie, dus 60 studiepunten), betekent dit dat je een model-student bent. Indien je nog vakken meenement van een van de vorige fases of reeds vakken van een volgend jaar opneemt ben je een combi-student.</p>
<p>Wens je om een andere reden zelf je uurrooster samen te stellen kies je ook voor combi-student. </p>
<?php
    $attributen = array(    'name'  => 'mijnFormulier',
                            'id'    => 'mijnFormulier',
                            'role'  => 'form');

    echo form_open('student/home_student', $attributen);
    echo "<h3>Gelieve een keuze te maken</h3>";
    $modelattributen = array('name' => 'model', "id" => "model");
    echo form_submit('model', 'Model-student', $modelattributen);
    $combiattributen = array('name' => 'combi', "id" => "combi");
    echo form_submit('combi', 'Combi-student', $combiattributen);
    echo form_close();