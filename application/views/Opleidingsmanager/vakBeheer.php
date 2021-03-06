<?php
/**
 * @file vakBeheer.php
 * View waarin de vakken worden weergegeven afhankelijk van de geselecteerde keuzerichting en fase
 * Krijgt een $keuzerichtingobject binnen
 * Gebruikt ajax-call om de vakgegevens op te halen
 */
?>
    <script>
        function haalVakkenOp(keuzerichtingId, faseId) {
            $.ajax({
                type: "GET",
                url: site_url + "/Opleidingsmanager/haalAjaxOp_Vakken/",
                data: {keuzerichtingId: keuzerichtingId, faseId: faseId},
                success: function(output) {
                    $('#resultaat').html(output);
                },
                error: function (xhr, status, error) {
                    alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
                }
            });
        }

        function schrapVak(vakId) {
            $.ajax({
                type: "GET",
                url: site_url + "/Opleidingsmanager/schrapAjax_Vak",
                data: {vakId: vakId},
                success: function () {
                    var keuzerichtingId = $('#keuzerichtingkeuze').val();
                    var faseId = $('#fasekeuze').val();
                    haalVakkenOp(keuzerichtingId, faseId);
                },
                error: function (xhr, status, error) {
                    alert("-- ERROR IN AJAX (Opleidingsmanager/schrapAjax_Vak) --\n\n" + xhr.responseText);
                }
            });
        }

        function haalVakOp(vakId) {
            $.ajax({
                type: "GET",
                url: site_url + "/Opleidingsmanager/haalJsonOp_Vak",
                data: {vakId: vakId},
                success: function (vak) {
                    $("#vakId").val(vak.id);
                    $("#vakNaam").val(vak.naam);
                    $("#vakStudiepunten").val(vak.studiepunt);
                    $('input[name*="keuzerichtingcheckbox[]"]').each(function(index) {
                        if (vak.keuzerichting.includes(this.value)){
                            this.checked = true;
                        }
                        else{
                            this.checked = false;
                        }
                    });
                    $("#keuzerichtingkeuze2").val(vak.keuzerichting);
                    $("#fasekeuze2").val(vak.fase);
                    $("#semesterkeuze").val(vak.semester);
                    $("#vakOpmerking").val(vak.volgtijdelijkheidInfo);
                },
                error: function (xhr, status, error) {
                    alert("-- ERROR IN AJAX (haalJsonOp_Vak) --\n\n" + xhr.responseText);
                }
            });
        }

        $(document).ready(function () {

            $("#keuzerichtingkeuze").change(function () {
                var keuzerichtingId = $('#keuzerichtingkeuze').val();
                var faseId = $('#fasekeuze').val();
                if(keuzerichtingId == '0' || faseId == '0') {
                    $('#resultaat').html("");
                } else {
                    haalVakkenOp(keuzerichtingId, faseId);
                }
            });

            $("#fasekeuze").change(function () {
                var keuzerichtingId = $('#keuzerichtingkeuze').val();
                var faseId = $('#fasekeuze').val();
                if(keuzerichtingId == '0' || faseId == '0') {
                    $('#resultaat').html("");
                } else {
                    haalVakkenOp(keuzerichtingId, faseId);
                }
            });

            $("#voegtoe").click(function () {
                $('#modalTitle').html('Vak toevoegen');
                $("#vakId").val(0);
                $("#vakNaam").val("");
                $("#vakStudiepunten").val(0);

                $('input[name*="keuzerichtingcheckbox[]"]').each(function() {
                    this.checked = false;
                });
                $("#fasekeuze2").val("");
                $("#semesterkeuze").val("");
                $("#vakOpmerking").val("");
                $('#modal').modal();
            });


            $("#resultaat").on('click', ".wijzig", function () {
                $('#modalTitle').html('Vak bewerken');
                var vakId = $(this).data('vakid');
                haalVakOp(vakId);
                $('#modal').modal();
            });

            $("#resultaat").on('click', ".verwijder", function () {
                var vakId = $(this).data('vakid');
                schrapVak(vakId);
            });
        });

    </script>
<?php

$keuzerichtingOpties = array();
$keuzerichtingOpties[0] = 'Kies een keuzerichting..';

foreach ($keuzerichtingen as $keuzerichtingOptie) {
    $keuzerichtingOpties[$keuzerichtingOptie->id] = $keuzerichtingOptie->naam;
}

$faseOpties = array("" => "Kies een fase..", 1 => "Fase 1", 2 => "Fase 2", 3 => "Fase 3");
$semesterOpties = array("" => "Kies een semester..", 1 => "Semester 1", 2 => "Semester 2");
?>
<div class="container70 row">
    <h1 class="col-12 mt-3"><?php echo $title ?></h1>
    <div class="col-12">
        <?php
            $knop = array("class" => "btn btn-warning text-white", "id" => "voegtoe", "data-toggle" => "tooltip", "title" => "Vak toevoegen");
            echo "<p>" . form_button('nieuwVak', "<i class='fas fa-plus'></i> Voeg toe", $knop) . "</p>";
            $keuzerichtingattributes = array('id' => 'keuzerichtingkeuze', 'class' => 'form-control');
            echo form_dropdown('keuzerichting', $keuzerichtingOpties, '0', $keuzerichtingattributes);
            $faseattributes = array('id' => 'fasekeuze', 'class' => 'form-control');
            echo form_dropdown('fase', $faseOpties, "", $faseattributes);
        ?>
        <div id="resultaat"></div>
    </div>

    <!-- Invoervenster TOEVOEGEN-->
    <div class="modal fade" id="modal" role="dialog">
        <div class="modal-dialog">
            <!-- Inhoud invoervenster-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Vakken beheren</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <?php
                $attributenFormulier = array('id' => 'formInvoer');
                echo form_open('Opleidingsmanager/voegVakToe', $attributenFormulier);
                ?>
                <div class="modal-body">
                    <table class="table table-hover table-borderless table-responsive-lg">
                        <tr>
                            <th id="modalTitle" colspan="2">Vak toevoegen</th>
                        </tr>
                        <tr>
                            <td><?php echo form_label("Vak:", "VakLabel"); ?></td>
                            <td>
                                <?php
                                    echo form_input(array('name' => 'vakNaam',
                                    'id' => 'vakNaam',
                                    'class' => 'form-control',
                                    'placeholder' => 'Naam',
                                    'required' => 'required'
                                    ));
                                 ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo form_label("Studiepunten:", "StudiepuntenLabel"); ?></td>
                            <td>
                                <?php
                                    echo form_input(array('name' => 'vakStudiepunten',
                                    'id' => 'vakStudiepunten',
                                    'class' => 'form-control',
                                    'type' => 'number',
                                    'required' => 'required',
                                    ));
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo form_label("Keuzerichting:", "KeuzerichtingLabel"); ?></td>
                            <td>
                                <?php
                                foreach ($keuzerichtingOpties as $keuzerichtingOptie){
                                    if ($keuzerichtingOptie != 'Kies een keuzerichting..'){
                                        $keuzerichtingattributes = array('id' => $keuzerichtingOptie);
                                        echo form_checkbox('keuzerichtingcheckbox[]', array_search($keuzerichtingOptie, $keuzerichtingOpties), false, $keuzerichtingattributes);
                                        echo $keuzerichtingOptie;
                                        echo '<br />';
                                    }
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo form_label("Fase:", "FaseLabel"); ?></td>
                            <td>
                                <?php
                                    $faseattributes = array('id' => 'fasekeuze2', 'class' => 'form-control', 'required' => 'required');
                                    echo form_dropdown('fase2', $faseOpties, "", $faseattributes);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo form_label("Semester:", "SemesterLabel"); ?></td>
                            <td>
                                <?php
                                $semesterattributes = array('id' => 'semesterkeuze', 'class' => 'form-control', 'required' => 'required');
                                echo form_dropdown('semester', $semesterOpties, "", $semesterattributes);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo form_label("Volgtijdelijkheidinfo:", "OpmerkingLabel"); ?></td>
                            <td>
                                <?php
                                    echo form_textarea(array('name' => 'vakOpmerking',
                                    'id' => 'vakOpmerking',
                                    'class' => 'form-control',
                                    'placeholder' => 'Vul hier de volgtijdelijkheidsinfo in',
                                    ));
                                    echo form_input(array('type'=>'hidden', 'id' =>'vakId', 'name'=> 'vakId'));
                                ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <?php
                    $annuleerButton = array('class' => 'btn btn-secundary annuleren mr-3',  'data-toggle' => 'tooltip',
                        "title" => "Vak annuleren", 'id' => 'annuleernPopUp', 'data-dismiss' => 'modal');
                    echo form_button("knopAnnuleer", ' Annuleren', $annuleerButton);
                    $opslaanButton = array('id' => 'opslaanPopUp', 'class' => 'btn btn-primary opslaan ',  'data-toggle' => 'tooltip',
                        "title" => "Vak opslaan");
                    echo form_submit("knopOpslaan", ' Opslaan', $opslaanButton);
                    ?>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>