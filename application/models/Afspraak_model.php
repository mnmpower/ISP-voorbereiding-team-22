<?php
/**
 * @class Afspraak_model
 * @brief Model-klasse voor de afspraken
 * Model-klasse die alle methodes bevat om te intrageren met de database-tabel team22_afspraak
 * @property Afspraak_model $afspraak_model
 * @property Persoon_model $persoon_model
 */

class Afspraak_model extends CI_Model
{
    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Retourneert het record met id=$id uit de tabel team22_afspraak
     * @param $id de id van het record  dat opgevraagd wordt
     * @return Het opgevraagde record
     */
    function get($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('afspraak');
        return $query->row();
    }

    /**
     * Voegt het record $persoon toe aan de tabel team22_persoon
     * @param $persoon het record dat toegevoegd wordt
     * @return int id
     */
    function insert($afspraak)
    {
        $this->db->insert('afspraak', $afspraak);
        return $this->db->insert_id();
    }

    /**
     * Update het record $afspraak uit de tabel team22_afspraak
     * @param $afspraak het record dat geüpdatet wordt
     */
    function update($afspraak)
    {
        $this->db->where('id', $afspraak->id);
        $this->db->update('afspraak', $afspraak);
    }

    /**
     * Verwijdert het record met id=$id uit de tabel team22_afspraak
     * @param $id de id van het record dat verwijderd wordt
     */
    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('afspraak');
    }

    /**
     * Retourneert alle records met persoonIdStudent=$id uit de tabel team22_afspraak en bijhorend record uit de tabel team22_persoon
     * @param $id de id van de persoon waarvan afsprekan opgevraagt worden
     * @return array met alle opgevraagde afspraak records met de naam van de student bij
     */
    function getAfsprakenWherePersoonIdDocent($id){
        $this->db->where('persoonIdDocent', $id);
        $query = $this->db->get('afspraak');
        $afspraken = $query->result();

        $this->load->model('persoon_model');

        foreach ($afspraken as $afspraak) {
            $afspraak->persoon =
                $this->persoon_model->getStudentnaam($afspraak->persoonIdStudent);
        }

        return $afspraken;
    }

    /**
     * Update het record met id=$id uit de tabel team22_afspraak
     * @param $description de nieuwe extraOpmerking van het record
     * @param $studentId het nieuwe persoonIdStudent van het record
     * @param $id de id van het record dat geüpdatet wordt
     */
    function updateAfspraakReserveer($description, $studentId, $id) {
        $data = array(
            'beschikbaar' => 0,
            'persoonIdStudent' => $studentId,
            'extraOpmerking' => $description
        );

        $this->db->where('id', $id);
        $this->db->update('afspraak', $data);
    }

	/**
	 * Insert een nieuw record met de gegevens van de parameter in de tabel team22_afspraak
	 * @param $docentId  de id van de persoon als docent
	 * @param $startuur het het uur waarop de afspraak zal starten
	 * @param $einduur het het uur waarop de afspraak zal uindigen
	 * @param $datum het de datum van de afspraak
	 * @param $plaats het lokaal waar de afspraak doorgaat
	 */
    function addMoment($docentId, $startuur, $einduur, $datum, $plaats) {
        $data = array(
            'persoonIdDocent' => $docentId,
            'persoonIdStudent' => null,
            'extraOpmerking' => null,
            'startuur' => $startuur,
            'einduur' => $einduur,
            'datum' => $datum,
            'plaats' => $plaats,
            'beschikbaar' => 1
        );

        $this->db->insert('afspraak', $data);
    }

	/**
	 * Update een afspraak record met de gegevens van de parameter in de tabel team22_afspraak
	 * @param $id de id de afspraak
	 * @param $startuur het het uur waarop de afspraak zal starten
	 * @param $einduur het het uur waarop de afspraak zal uindigen
	 * @param $datum het de datum van de afspraak
	 * @param $plaats het lokaal waar de afspraak doorgaat
	 * @param $description een eventuele beschrijving over de afspraak
	 */
    function updateAfspraak($id, $startuur, $einduur, $datum, $plaats, $description) {
        $data = array(
            'extraOpmerking' => $description,
            'startuur' => $startuur,
            'einduur' => $einduur,
            'datum' => $datum,
            'plaats' => $plaats,
        );

        $this->db->where('id', $id);
        $this->db->update('afspraak', $data);
    }

	/**
	 * Update een afspraak record met de gegevens van de parameter in de tabel team22_afspraak
	 * @param $id de id de afspraak
	 * @param $beschikbaar maakt een afspraak terug beschikbaar of bezet
	 */
    function updateAfspraakBeschikbaarheid($id, $beschikbaar) {
        $data = array(
            'beschikbaar' => $beschikbaar,
            'extraOpmerking' => null,
            'persoonIdStudent' => null
        );

        $this->db->where('id', $id);
        $this->db->update('afspraak', $data);
    }

    /**
     * Ontkoppelt de student van het record met persoonIdStudent=$persoonIdStudent uit de tabel team22_afspraak
     * @param $persoonIdStudent de persoonIdStudent van het record dat geupdate wordt
     */
    function updateAfspraakOntkoppelStudent($persoonIdStudent)
    {
        $data = array(
            'persoonIdStudent' => null
        );

        $this->db->where('persoonIdStudent', $persoonIdStudent);
        $this->db->update('afspraak', $data);
    }
}
