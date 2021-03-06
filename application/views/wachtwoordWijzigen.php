<div class="container70">
    <div class="row">
        <div class="col-12">
            <h1><i class="fas fa-question-circle"></i> Wachtwoord vergeten</h1>
        </div>
        <div class="col-md-6">
            <?php
            $attributes = array('name' => 'editPasswordForm');
            echo form_open();
            ?>
            <div class="form-group">
                <?php echo form_label('Loginnummer', 'nummer') . "\n"; ?>
                <?php echo form_input(array('name' => 'nummer', 'id' => 'nummer', 'class' => "form-control", 'placeholder' => "Studentennummer / Personeelsnummer")); ?>
            </div>
            <div class="form-group">
                <?php echo form_button(array('id' => 'editPasswordButton', 'content' => 'Wijzigen', 'class' => 'form-control btn-outline-dark btn menuButton loginButtons')); ?>
            </div>
        </div>
    </div>
</div>

<script>
    $('#editPasswordButton').click(function () {
        var nummer = $('#nummer').val();
        console.log(nummer);
        $.ajax({
            type: "GET",
            url: site_url + "/home/editPassword/",
            data: {nummer: nummer},
            success: function (output) {
                console.log(output);
                alert('MAIL SIMULATIE: Nieuw wachtwoord: ' + output);
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        });
    })
</script>