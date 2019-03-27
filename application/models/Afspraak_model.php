<?php
/**
 * @property Afspraak_model $afspraak_model
 */

class Afspraak_model extends CI_Model
{
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
     * @param $id de id van het record  dat opgevraagd wordt
     * @return Array met alle opgevraagde records en bijhorende records
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
    function updateAfspraak($description, $studentId, $id) {
        $data = array(
            'beschikbaar' => 0,
            'persoonIdStudent' => $studentId,
            'extraOpmerking' => $description
        );

        $this->db->where('id', $id);
        $this->db->update('afspraak', $data);
    }
}