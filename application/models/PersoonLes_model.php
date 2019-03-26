<?php
    /**
     * @class PersoonLes_model
     * @brief Model-klasse voor de associatie tussen personen en lessen
     * Model-klasse die alle methodes bevat om te intrageren met de database-tabel team22_persoonLes
     * @property Persoon_model $persoon_model
	 * @property Les_model $les_model
     */
    class PersoonLes_model extends CI_Model
    {

		// +---------------------------------------------------------+ \\
		// | ISP Project team22 - PersoonLes_model.php				 | \\
		// +---------------------------------------------------------+ \\
		// | 2 ITF - 2018-2019										 | \\
		// +---------------------------------------------------------+ \\
		// | PersoonLes model 										 | \\
		// +---------------------------------------------------------+ \\
		// | T.Ingelaere, S. Kempeneer, J. Michiels, M. Michiels	 | \\
		// +---------------------------------------------------------+ \\
        /**
         * Constructor
         */
        function __construct()
        {
            parent::__construct();
        }

        /**
         * Retourneert het record met id=$id uit de tabel team22_persoonLes
         * @param $id de id van het record  dat opgevraagd wordt
         * @return Het opgevraagde record
         */
        function get($id)
        {
            $this->db->where('persoonLesId', $id);
            $query = $this->db->get('persoonLes');
            return $query->row();
        }

        /**
         * Retourneert alle records met persoonIdStudent=$persoonIdStudent uit de tabel team22_persoonLes
         * @param $persoonIdStudent de id van de persoon waarvan de records opgevraagd worden
         * @return Array met alle opgevraagde records
         */
        function getAllWherePersoonId($persoonIdStudent){
            $this->db->where('persoonIdStudent',$persoonIdStudent);
            $query =$this->db->get('persoonLes');
            return  $query->result();
            //OK returnt alle persoonLESSEN van een persoonID
        }

        /**
         * Retourneert het record met persoonLesId=$persoonLesId uit de tabel team22_persoonLes en bijhorende records uit de tabel team22_vak en tabel team22_les
         * @param $persoonLesId de id van het record  dat opgevraagd wordt
         * @return Het opgevraagde record en bijhorende records
         */
		function getWithLesAndVak($persoonLesId){
        	$persoonLes = $this->get($persoonLesId);
        	//model laden + lesWithVak toevoegen
			$this->load->model('les_model');
        	$persoonLes->lesWithVak = $this->les_model->getLesWithVak($persoonLes->lesId);

        	return $persoonLes;
		}

        /**
         * Retourneert alle records met persoonIdStudent=$persoonIdStudent uit de tabel team22_persoonLes en bijhorende records uit de tabel team22_vak en tabel team22_les
         * @param $persoonIdStudent de persoonIdStudent van de records  die opgevraagd worden
         * @return Array met alle opgevraagde records en bijhorende records
         */
		function getAllWithLesAndVak($persoonIdStudent){
        	$persoonLessen = $this->getAllWherePersoonId($persoonIdStudent);

			$this->load->model('les_model');


        	foreach ($persoonLessen as $persoonLes){
				$persoonLes->lesWithVak =  $this->les_model->getLesWithVak($persoonLes->lesId);
			}
			return $persoonLessen;
        	//OK Return alle persoonlessen met les en vak bij van een gegeven persoonID

		}

        /**
         * Retourneert alle records met persoonIdStudent=$persoonIdStudent uit de tabel team22_persoonLes en bijhorende records uit de tabel team22_vak, de tabel team22_les en de tabel team22_klas
         * @param $persoonIdStudent de persoonIdStudent van de records  die opgevraagd worden
         * @return Array met alle opgevraagde records en bijhorende records
         */
        function getAllWithLesAndVakAndKlas($persoonIdStudent){
            $persoonLessen = $this->getAllWherePersoonId($persoonIdStudent);

            $this->load->model('les_model');
            $this->load->model('klas_model');

            foreach ($persoonLessen as $persoonLes){
                $persoonLes->lesWithVak = $this->les_model->getLesWithVak($persoonLes->lesId);
                $persoonLes->lesWithVak->klas = $this->klas_model->get($persoonLes->lesWithVak->klasId);
            }
            return $persoonLessen;
        }
    }
