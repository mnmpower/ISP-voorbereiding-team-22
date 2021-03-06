<?php
/**
 * @file ispSamenstellen.php
 * Pagina waarin de combistudent zijn ISP voor semester 1 kan samenstellen
 */
?>
<?php $cookie_name = "walkthrough"; ?>
<script>

    function toggleCookie() {
        $.ajax({
            url: site_url + "/Student/haalAjaxOp_ToggleCookie/"
        });
    }

    function setLayoutButton() {
        if ("<?php echo $_COOKIE[$cookie_name]; ?>" == "aan"){
            $('#aanuit').html('Walkthrough ingeschakeld');
            $('#aanuit').addClass('btn-success');
        }
        else{
            $('#aanuit').html('Walkthrough uitgeschakeld');
            $('#aanuit').addClass('btn-danger');
        }
    }

    $(document).ready(function () {
        setLayoutButton();

        if ("<?php echo $_COOKIE[$cookie_name]; ?>" == "aan") {
            $('.modal').modal('show');
        }

        $('#aanuit').click(function () {
            if ($('#aanuit').html() == "Walkthrough uitgeschakeld"){
                $('#aanuit').html('Walkthrough ingeschakeld');
                $('#aanuit').removeClass('btn-danger');
                $('#aanuit').addClass('btn-success');
            }
            else{
                $('#aanuit').html('Walkthrough uitgeschakeld');
                $('#aanuit').removeClass('btn-success');
                $('#aanuit').addClass('btn-danger');
            }
            toggleCookie();
        });
    });

</script>
<div class="container container90 containerISP">
    <button id="openWalk" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">Open walkthrough</button>
    <button id="aanuit" class="btn"></button>
    <div class="row">
        <div class="container col-2 flex-column d-flex containersISP">
            <div class="flex-grow-1" id="klassenContainer">
                <?php
                echo "<div class='form-check'>";
                echo '<table class="table">';
                echo '<tbody>';
                $ignore = array('2 APP/BI A', '2 APP/BI B', '2 IOT', '2 CCS A', '2 CCS B');
                foreach ($klassen as $klas) {
                    if (in_array($klas->naam, $ignore) == false) {
                        echo '<tr class="list-group-item-action klasbutton" data-klas="' . $klas->id . '">';
                        echo '<td>' . $klas->naam . '</td>';
                        echo '<td><i class="fas fa-check invisible"></i></td>';
                        echo '</tr>';
                    }
                }
                echo '</tbody>';
                echo '</table>';
                echo "</div>";
                ?>
            </div>
        </div>
        <div class="container col-10 containersISP">
            <div id="carouselWarnings" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators indicatorsPad">
                    <li data-target="#carouselWarnings" data-slide-to="0" class="active"></li>
                </ol>
                <div class="carousel-inner">
                    <div id="#defaultAlert" class="carousel-item active">
                        <div class="alert alert-primary alertPad active" role="alert">
                        <i class="fas fa-info-circle"></i>
                        Geen meldingen
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselWarnings" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselWarnings" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <div id="uurrooster"></div>
    </div>
</div>
<div class="row alert alert-primary infoAlert" role="alert">
    <div class="col-1 center">
        <i class="fas fa-info-circle fa-2x"></i>
    </div>
    <div class="col">
        <p>Gebruik het keuzemenu om 2 klassen te vergelijken en een uurrooster op te stellen die bij je past.</p>
    </div>
</div>
<div class="row ScrollKlasParent">
    <div class="container col-6 flex-column d-flex containersISP">
        <div id="klaskeuze1Container" class="flex-grow-1">
            <div class="centered">
                <h5 id="klas1Titel" class="bg-primary text-white">Selecteer een klas..</h5>
            </div>
            <div id="klas1Tekst" class="ScrollChild"></div>
        </div>
    </div>
    <div class="container col-6 flex-column d-flex containersISP">
        <div id="klaskeuze2Container" class="flex-grow-1 ScrollParent">
            <div class="centered">
                <h5 id="klas2Titel" class="bg-primary text-white">Selecteer een klas..</h5>
            </div>
            <div id="klas2Tekst" class="ScrollChild">
            </div>
        </div>
    </div>
</div>
<div class="row alert alert-primary infoAlert" role="alert">
    <div class="col-1 center">
        <i class="fas fa-info-circle fa-2x"></i>
    </div>
    <div class="col">
        <p>Gebruik het fasemenu om vakken te vinden die je nog moet inhalen, of buiten de geselecteerde klassen
            vallen.</p>
    </div>
</div>
<div class="row">
    <div class="container col-10 flex-column d-flex containersISP paddingR20">
        <div id="vakkenkeuzeContainer" class="flex-grow-1">
            <div class="row ScrollParent rowTabList">
                <div class="btn activeButton" id="backButtonFase">
                    <i class="fas fa-chevron-left"></i>
                </div>
                <div class="col-4 faseList padding0">
                    <div class="list-group" id="list-tab" role="tablist">
                        <a class="list-group-item list-group-item-action active" id="list-fase1-list"
                           data-toggle="list" href="#list-fase1" role="tab" aria-controls="home">Fase 1</a>
                        <a class="list-group-item list-group-item-action" id="list-fase2-list" data-toggle="list"
                           href="#list-fase2" role="tab" aria-controls="profile">Fase 2</a>
                        <a class="list-group-item list-group-item-action" id="list-fase3-list" data-toggle="list"
                           href="#list-fase3" role="tab" aria-controls="messages">Fase 3</a>
                    </div>
                </div>
                <div class="col-8 ScrollChild padding0" id="vakkenList">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="list-fase1" role="tabpanel"
                             aria-labelledby="list-fase1-list">
                            <?php foreach ($vakken as $vak) {
                                if ($vak->fase == 1) {
                                    echo "<div>";
                                    echo "<button type='button' class='btn list-group-item list-group-item-action vakButton' data-vakId='" . $vak->id . "' data-vak='" . $vak->naam . "'>" . $vak->naam . "</button>";
                                    echo "</div>";
                                }
                            }
                            ?>
                        </div>
                        <div class="tab-pane fade" id="list-fase2" role="tabpanel"
                             aria-labelledby="list-fase2-list">
                            <?php foreach ($vakken as $vak) {
                                if ($vak->fase == 2) {
                                    echo "<div>";
                                    echo "<button type='button' class='btn list-group-item list-group-item-action vakButton' data-vakId='" . $vak->id . "' data-vak='" . $vak->naam . "'>" . $vak->naam . "</button>";
                                    echo "</div>";
                                }
                            }
                            ?>
                        </div>
                        <div class="tab-pane fade h-25" id="list-fase3" role="tabpanel"
                             aria-labelledby="list-fase3-list">
                            <?php foreach ($vakken as $vak) {
                                if ($vak->fase == 3) {
                                    echo "<div>";
                                    echo "<button type='button' class='btn list-group-item list-group-item-action vakButton' data-vakId='" . $vak->id . "' data-vak='" . $vak->naam . "'>" . $vak->naam . "</button>";
                                    echo "</div>";
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col padding0 ScrollChild" id="klassenLijstFaseContainer">
                </div>
            </div>
        </div>
    </div>
    <div class="container col-2 flex-column d-flex containersISP">
        <div id="semesterkeuzeContainer" class="flex-grow-1 centered activeButton">
            <p>Semester 2</p>
            <i class="fas fa-chevron-right fa-5x"></i>
        </div>
    </div>
</div>
</div>
<form id="gotoSemester2" action="ispSamenstellen2">
<input type="hidden" value="null" id="ispString"/>
</form>

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div id="carouselWalkthrough" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselWalkthrough" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselWalkthrough" data-slide-to="1"></li>
                    <li data-target="#carouselWalkthrough" data-slide-to="2"></li>
                    <li data-target="#carouselWalkthrough" data-slide-to="3"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <?php echo toonAfbeelding('assets/images/walkthrough/stap1.png', 'title="Stap 1" class="d-block w-100"');?>
                        <div class="carousel-caption d-none d-md-block">
                            <div class="row alert alert-primary infoAlert" role="alert">
                                <div class="col-1 center">
                                    <i class="fas fa-info-circle fa-2x"></i>
                                </div>
                                <div class="col">
                                    <h5>Stap 1</h5>
                                    <p>Selecteer 2 klassen uit het keuzemenu. De uurroosters van deze klassen zullen weergeven worden.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <?php echo toonAfbeelding('assets/images/walkthrough/stap2.png', 'title="Stap 2" class="d-block w-100"');?>
                        <div class="carousel-caption d-none d-md-block">
                            <div class="row alert alert-primary infoAlert" role="alert">
                                <div class="col-1 center">
                                    <i class="fas fa-info-circle fa-2x"></i>
                                </div>
                                <div class="col">
                                    <h5>Stap 2</h5>
                                    <p>Vergelijk de uurroosters van de klassen en beslis in welke klas je elk vak opneemt.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <?php echo toonAfbeelding('assets/images/walkthrough/stap3.png', 'title="Stap 3" class="d-block w-100"');?>
                        <div class="carousel-caption d-none d-md-block">
                            <div class="row alert alert-primary infoAlert" role="alert">
                                <div class="col-1 center">
                                    <i class="fas fa-info-circle fa-2x"></i>
                                </div>
                                <div class="col">
                                    <h5>Stap 3</h5>
                                    <p>Kies eventueel nog vakken uit andere fases/klassen die je wilt opnemen.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <?php echo toonAfbeelding('assets/images/walkthrough/stap4.png', 'title="Stap 4" class="d-block w-100"');?>
                        <div class="carousel-caption d-none d-md-block">
                            <div class="row alert alert-primary infoAlert" role="alert">
                                <div class="col-1 center">
                                    <i class="fas fa-info-circle fa-2x"></i>
                                </div>
                                <div class="col">
                                    <h5>Stap 4</h5>
                                    <p>Kijk nog een laatste keer na of je voldoet aan de volgtijdelijkheidsinfo en probeer overlappende vakken te vermijden. Vervolgens herhaal je de stappen voor semester 2. </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselWalkthrough" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselWalkthrough" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            </div>
        </div>
    </div>
</div>

<script src='<?php echo base_url() ?>assets/js/ispSamenstellen.js'></script>